<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use App\Services\ConnectionService;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    /**
     * Envoie une demande de connexion (AJAX from profile page).
     */
    public function send(User $user)
    {
        $result = ConnectionService::sendRequest(auth()->id(), $user->id);

        if (request()->expectsJson()) {
            return response()->json($result);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Accepte une demande (depuis dashboard).
     */
    public function accept(Connection $connection)
    {
        $result = ConnectionService::acceptRequest($connection->id, auth()->id());

        if (request()->expectsJson()) {
            return response()->json($result);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Accepte une demande depuis le profil public (par user_id).
     */
    public function acceptFromProfile(User $user)
    {
        $connection = ConnectionService::getConnectionBetween(auth()->id(), $user->id);

        if (!$connection || $connection->status !== 'pending') {
            return back()->with('error', 'Demande introuvable.');
        }

        $result = ConnectionService::acceptRequest($connection->id, auth()->id());

        if (request()->expectsJson()) {
            return response()->json($result);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Refuse une demande.
     */
    public function decline(Connection $connection)
    {
        $result = ConnectionService::declineRequest($connection->id, auth()->id());

        if (request()->expectsJson()) {
            return response()->json($result);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Annule une demande envoyée.
     */
    public function cancel(Connection $connection)
    {
        $result = ConnectionService::cancelRequest($connection->id, auth()->id());

        if (request()->expectsJson()) {
            return response()->json($result);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Retire une connexion.
     */
    public function remove(Connection $connection)
    {
        $result = ConnectionService::removeConnection($connection->id, auth()->id());

        if (request()->expectsJson()) {
            return response()->json($result);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }
}
