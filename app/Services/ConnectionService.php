<?php

namespace App\Services;

use App\Mail\ConnectionAccepted;
use App\Mail\ConnectionRequest;
use App\Models\Connection;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class ConnectionService
{
    /**
     * Envoie une demande de connexion.
     */
    public static function sendRequest(int $senderId, int $receiverId): array
    {
        if ($senderId === $receiverId) {
            return ['success' => false, 'message' => 'Vous ne pouvez pas vous ajouter vous-même.'];
        }

        // Vérifier si connexion existe déjà (dans les deux sens)
        $existing = self::getConnectionBetween($senderId, $receiverId);

        if ($existing) {
            if ($existing->status === 'accepted') {
                return ['success' => false, 'message' => 'Vous êtes déjà connectés.'];
            }
            if ($existing->status === 'pending') {
                // Si l'autre a déjà envoyé une demande → auto-accepter
                if ($existing->sender_id === $receiverId) {
                    return self::acceptRequest($existing->id, $senderId);
                }
                return ['success' => false, 'message' => 'Demande déjà envoyée.'];
            }
            if ($existing->status === 'declined') {
                // Relancer la demande
                $existing->update([
                    'sender_id' => $senderId,
                    'receiver_id' => $receiverId,
                    'status' => 'pending',
                    'accepted_at' => null,
                ]);
                self::notifyNewRequest($senderId, $receiverId);
                return ['success' => true, 'message' => 'Demande envoyée !'];
            }
        }

        Connection::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        self::notifyNewRequest($senderId, $receiverId);

        return ['success' => true, 'message' => 'Demande envoyée !'];
    }

    /**
     * Accepte une demande reçue.
     */
    public static function acceptRequest(int $connectionId, int $userId): array
    {
        $connection = Connection::find($connectionId);

        if (!$connection || $connection->receiver_id !== $userId) {
            return ['success' => false, 'message' => 'Demande introuvable.'];
        }

        if ($connection->status !== 'pending') {
            return ['success' => false, 'message' => 'Cette demande n\'est plus en attente.'];
        }

        $connection->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        self::notifyAccepted($connection);

        return ['success' => true, 'message' => 'Connexion acceptée !'];
    }

    /**
     * Refuse une demande reçue.
     */
    public static function declineRequest(int $connectionId, int $userId): array
    {
        $connection = Connection::find($connectionId);

        if (!$connection || $connection->receiver_id !== $userId) {
            return ['success' => false, 'message' => 'Demande introuvable.'];
        }

        $connection->update(['status' => 'declined']);

        return ['success' => true, 'message' => 'Demande refusée.'];
    }

    /**
     * Annule une demande envoyée (sender annule).
     */
    public static function cancelRequest(int $connectionId, int $userId): array
    {
        $connection = Connection::find($connectionId);

        if (!$connection || $connection->sender_id !== $userId || $connection->status !== 'pending') {
            return ['success' => false, 'message' => 'Demande introuvable.'];
        }

        $connection->delete();

        return ['success' => true, 'message' => 'Demande annulée.'];
    }

    /**
     * Retire une connexion acceptée (coupé des deux côtés).
     */
    public static function removeConnection(int $connectionId, int $userId): array
    {
        $connection = Connection::find($connectionId);

        if (!$connection) {
            return ['success' => false, 'message' => 'Connexion introuvable.'];
        }

        if ($connection->sender_id !== $userId && $connection->receiver_id !== $userId) {
            return ['success' => false, 'message' => 'Connexion introuvable.'];
        }

        $connection->delete();

        return ['success' => true, 'message' => 'Connexion retirée.'];
    }

    /**
     * Liste des contacts acceptés d'un user.
     */
    public static function getContacts(int $userId): Collection
    {
        return Connection::where('status', 'accepted')
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->with(['sender.profiles', 'receiver.profiles'])
            ->latest('accepted_at')
            ->get();
    }

    /**
     * Demandes reçues en attente.
     */
    public static function getPendingReceived(int $userId): Collection
    {
        return Connection::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->with(['sender.profiles'])
            ->latest()
            ->get();
    }

    /**
     * Demandes envoyées en attente.
     */
    public static function getPendingSent(int $userId): Collection
    {
        return Connection::where('sender_id', $userId)
            ->where('status', 'pending')
            ->with(['receiver.profiles'])
            ->latest()
            ->get();
    }

    /**
     * Statut entre deux users : null, 'pending', 'accepted', 'declined'.
     */
    public static function getStatus(int $userId, int $otherUserId): ?string
    {
        $connection = self::getConnectionBetween($userId, $otherUserId);
        return $connection?->status;
    }

    /**
     * Récupère la connexion entre deux users (dans les deux sens).
     */
    public static function getConnectionBetween(int $userA, int $userB): ?Connection
    {
        return Connection::where(function ($q) use ($userA, $userB) {
            $q->where('sender_id', $userA)->where('receiver_id', $userB);
        })->orWhere(function ($q) use ($userA, $userB) {
            $q->where('sender_id', $userB)->where('receiver_id', $userA);
        })->first();
    }

    /**
     * Nombre de contacts acceptés.
     */
    public static function getContactsCount(int $userId): int
    {
        return Connection::where('status', 'accepted')
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->count();
    }

    /**
     * Notifie le receiver d'une nouvelle demande.
     */
    private static function notifyNewRequest(int $senderId, int $receiverId): void
    {
        try {
            $receiver = User::find($receiverId);
            if ($receiver && $receiver->notify_connection_request) {
                $sender = User::find($senderId);
                Mail::to($receiver->email)->send(new ConnectionRequest($sender, $receiver));
            }
        } catch (\Exception $e) {
            \Log::warning('Email connexion request failed: ' . $e->getMessage());
        }
    }

    /**
     * Notifie le sender que sa demande a été acceptée.
     */
    private static function notifyAccepted(Connection $connection): void
    {
        try {
            $sender = User::find($connection->sender_id);
            $accepter = User::find($connection->receiver_id);
            if ($sender && $sender->notify_connection_accepted && $accepter) {
                Mail::to($sender->email)->send(new ConnectionAccepted($accepter, $sender));
            }
        } catch (\Exception $e) {
            \Log::warning('Email connexion accepted failed: ' . $e->getMessage());
        }
    }
}
