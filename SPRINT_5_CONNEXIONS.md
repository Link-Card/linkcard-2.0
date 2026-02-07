# SPRINT 5 — CONNEXIONS (SYSTÈME COMPLET)

## Objectif
Implémenter le système de connexions entre utilisateurs LinkCard : demandes, acceptation, liste de contacts, préférences de notification, et programme de référence pour le lancement.

## Concept clé
Le bouton **"Ajouter au contact"** sur le profil public devient un hub à 2 options :
1. 📥 **Télécharger la vCard** — Download direct (unidirectionnel, pas besoin de compte)
2. 🔗 **Ajouter sur LinkCard** — Connexion mutuelle dans l'app (compte requis)

La connexion est **mutuelle** : les deux personnes voient le profil de l'autre. Si une personne retire l'autre, c'est coupé des deux côtés. Pas de connexion unidirectionnelle — la vCard existe pour ça.

Il n'y a **pas de recherche d'utilisateurs**. La seule façon de se connecter est via le bouton sur un profil public (après scan NFC, QR code, ou lien partagé). Ça garantit de vraies connexions physiques.

## Architecture

### Base de données
```sql
CREATE TABLE connections (
    id BIGINT PRIMARY KEY,
    sender_id BIGINT NOT NULL,          -- Celui qui a cliqué "Ajouter sur LinkCard"
    receiver_id BIGINT NOT NULL,        -- Propriétaire du profil visité
    status ENUM('pending', 'accepted', 'declined') DEFAULT 'pending',
    accepted_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(sender_id, receiver_id),     -- Pas de doublon
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE referrals (
    id BIGINT PRIMARY KEY,
    referrer_id BIGINT NOT NULL,        -- Celui qui a le profil
    referred_user_id BIGINT NOT NULL,   -- Nouveau compte créé
    source VARCHAR(50) DEFAULT 'profile_button',  -- D'où vient le referral
    rewarded BOOLEAN DEFAULT false,     -- Déjà compté pour une récompense ?
    created_at TIMESTAMP,
    UNIQUE(referred_user_id),           -- Un user ne peut être référé qu'une fois
    FOREIGN KEY (referrer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (referred_user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Ajouts table users
ALTER TABLE users ADD COLUMN referral_code VARCHAR(8) UNIQUE NULL;
ALTER TABLE users ADD COLUMN referred_by BIGINT NULL;
ALTER TABLE users ADD COLUMN premium_bonus_months INT DEFAULT 0;    -- Mois gratuits accumulés
ALTER TABLE users ADD COLUMN premium_bonus_used INT DEFAULT 0;      -- Mois gratuits utilisés

-- Préférences notification (ajout table users ou table séparée)
ALTER TABLE users ADD COLUMN notify_connection_request BOOLEAN DEFAULT true;
ALTER TABLE users ADD COLUMN notify_connection_accepted BOOLEAN DEFAULT true;
```

### Relations Eloquent
```php
// User.php
public function sentConnections() {
    return $this->hasMany(Connection::class, 'sender_id');
}
public function receivedConnections() {
    return $this->hasMany(Connection::class, 'receiver_id');
}
public function connections() {
    // Toutes les connexions acceptées (envoyées + reçues)
}
public function referrals() {
    return $this->hasMany(Referral::class, 'referrer_id');
}
```

## Fonctionnalités à implémenter

### Phase 1 : Bouton "Ajouter au contact" (profil public)
- [ ] Modifier le bouton existant → popup 2 options
- [ ] Option 1 : "📥 Télécharger la vCard" (comportement actuel)
- [ ] Option 2 : "🔗 Ajouter sur LinkCard"
  - Si connecté → envoie demande directement → toast "Demande envoyée !"
  - Si pas connecté → redirect `/login?ref={profile_username}&action=connect`
  - Après login/register → demande envoyée automatiquement → redirect profil avec toast
- [ ] Si déjà connecté → afficher "✓ Connecté" (pas de bouton d'ajout)
- [ ] Si demande déjà envoyée → afficher "⏳ En attente"
- [ ] Aucun autre bouton de gestion sur le profil public

### Phase 2 : Page "Mes Connexions" (dashboard)
- [ ] Nouveau menu dans sidebar (entre "Mes Cartes" et "Abonnement")
- [ ] Icône : deux personnes ou lien
- [ ] Badge pastille avec nombre de demandes en attente

#### Sections de la page :
- [ ] **Demandes reçues** (en haut si > 0) — Accepter / Refuser
- [ ] **Demandes envoyées** (en attente) — Annuler
- [ ] **Mes contacts** — Cartes style "Mes Profils" :
  - Photo, nom, titre, entreprise
  - Boutons : "Voir profil" / "Retirer"
  - Retirer = coupé des deux côtés (confirmation requise)
- [ ] **Compteur fidélité** (en bas de page) :
  - Barre de progression "3/10 — Encore 7 pour 1 mois Premium gratuit !"
  - Historique des récompenses obtenues

### Phase 3 : Migrations + Models
- [ ] Migration `create_connections_table`
- [ ] Migration `create_referrals_table`
- [ ] Migration `add_referral_fields_to_users`
- [ ] Migration `add_notification_preferences_to_users`
- [ ] Model Connection (relations, scopes)
- [ ] Model Referral (relations)

### Phase 4 : Logique de connexion
- [ ] ConnectionService :
  - `sendRequest($senderId, $receiverId)` — Vérifie pas de doublon, crée pending
  - `acceptRequest($connectionId, $userId)` — Vérifie que c'est bien le receiver
  - `declineRequest($connectionId, $userId)`
  - `cancelRequest($connectionId, $userId)` — Sender annule sa demande
  - `removeConnection($connectionId, $userId)` — Supprime des deux côtés
  - `getContacts($userId)` — Liste contacts acceptés
  - `getPendingReceived($userId)` — Demandes reçues en attente
  - `getPendingSent($userId)` — Demandes envoyées en attente
  - `getConnectionStatus($userId, $otherUserId)` — null/pending/accepted

### Phase 5 : Programme de référence
- [ ] Génération `referral_code` automatique à la création du user (= username du profil ou code unique)
- [ ] Bouton "Ajouter sur LinkCard" contient `?ref={referral_code}` dans l'URL de register
- [ ] À la création de compte : stocker le referral dans `referrals` table
- [ ] ReferralService :
  - `checkAndReward($referrerId)` — Compte les referrals non-rewarded, si >= 10 → attribue 1 mois
  - `getProgress($userId)` — Retourne [current: 3, target: 10, totalRewarded: 2]
  - `getRemainingBonusMonths($userId)` — premium_bonus_months - premium_bonus_used
- [ ] Limite : max 12 mois cumulables (premium_bonus_months <= 12)
- [ ] Si user Free → upgrade auto à Premium pour 1 mois
- [ ] Si user Premium payant → mois suivant gratuit (pas débité)
- [ ] Toggle admin pour activer/désactiver le programme (config ou DB)

### Phase 6 : Préférences de notification
- [ ] Menu "Préférences" dans sidebar (avant Déconnexion, après le user info)
- [ ] Page avec toggles :
  - Nouvelle demande de connexion reçue → email oui/non
  - Demande acceptée → email oui/non
- [ ] Par défaut tout activé
- [ ] Emails brandés (même template que les autres emails)

### Phase 7 : Emails
- [ ] Email "Nouvelle demande de connexion" (si préférence activée)
- [ ] Email "Demande acceptée" (si préférence activée)
- [ ] Respecter les préférences du user avant d'envoyer

### Phase 8 : Dashboard updates
- [ ] Badge pastille rouge sur "Mes Connexions" dans sidebar (si demandes pending)
- [ ] Stat "Connexions" ajoutée aux stats du dashboard (optionnel)

## Routes à créer
```php
// Page connexions (dashboard)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/connections', [ConnectionController::class, 'index'])->name('connections.index');
    Route::post('/connections/send/{user}', [ConnectionController::class, 'send'])->name('connections.send');
    Route::post('/connections/{connection}/accept', [ConnectionController::class, 'accept'])->name('connections.accept');
    Route::post('/connections/{connection}/decline', [ConnectionController::class, 'decline'])->name('connections.decline');
    Route::post('/connections/{connection}/cancel', [ConnectionController::class, 'cancel'])->name('connections.cancel');
    Route::delete('/connections/{connection}', [ConnectionController::class, 'remove'])->name('connections.remove');
});

// Préférences
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/preferences', [PreferencesController::class, 'index'])->name('preferences.index');
    Route::post('/dashboard/preferences', [PreferencesController::class, 'update'])->name('preferences.update');
});
```

## Workflow complet — Connexion

```
1. User A visite profil public de User B
        ↓
2. Clique "Ajouter au contact"
        ↓
3. Popup : vCard ou LinkCard
        ↓
4. Clique "Ajouter sur LinkCard"
        ↓
5a. Si connecté → demande envoyée → toast "Demande envoyée !"
5b. Si pas connecté → redirect login?ref=username&action=connect
        ↓
6. Après login/register → demande envoyée auto → redirect profil
        ↓
7. User B reçoit email (si préférence activée)
        ↓
8. User B va dans "Mes Connexions" → voit demande
        ↓
9. User B accepte → connexion mutuelle active
        ↓
10. User A reçoit email "Demande acceptée" (si préférence activée)
        ↓
11. Les deux voient l'autre dans "Mes Connexions"
```

## Workflow — Programme de référence

```
1. User A a profil public
        ↓
2. Visiteur clique "Ajouter sur LinkCard" (pas de compte)
        ↓
3. Redirect /register?ref=CODE_USER_A
        ↓
4. Visiteur crée compte → referral stocké
        ↓
5. Compteur User A : 1/10
        ↓
... (répéter x10) ...
        ↓
6. Compteur atteint 10/10
        ↓
7. ReferralService::checkAndReward()
        ↓
8. User A reçoit 1 mois Premium gratuit
        ↓
9. Compteur repart à 0/10
        ↓
10. Max 12 mois cumulables au total
```

## Sidebar mise à jour
```
📊 Tableau de bord
👤 Mes Profils
💳 Mes Cartes
🤝 Mes Connexions  ← NOUVEAU (+ badge pastille si demandes)
💰 Abonnement
⚙️ Administration (si admin)
───────────────
[User info]
⚙️ Préférences     ← NOUVEAU
🚪 Déconnexion
```

## Décisions confirmées
1. Connexion mutuelle — retrait = coupé des deux côtés
2. Pas de recherche d'utilisateurs — scan/lien obligatoire
3. Pas de message avec la demande — rencontre physique implicite
4. Aucun bouton de gestion connexion sur profil public (juste "Connecté ✓" ou "En attente ⏳")
5. Connexions illimitées (tous les plans)
6. Compteur fidélité sur page Mes Connexions
7. Programme fidélité = temporaire (lancement), désactivable par admin
8. Si Free → auto Premium 1 mois ; si Premium payant → mois suivant gratuit
9. Max 12 mois cumulables
10. Préférences notification : email demande reçue + email acceptée (toggles)

## Notes pour le développement
- Le programme fidélité doit être facilement désactivable (flag admin ou config)
- Les emails respectent les préférences avant envoi
- Mobile-first pour toutes les nouvelles vues
- Réutiliser le style cartes de "Mes Profils" pour la liste de contacts
- Le badge sidebar doit être dynamique (Livewire ou count en layout)

## Après Sprint 5
→ Sprint 6 : Stats + URLs custom
