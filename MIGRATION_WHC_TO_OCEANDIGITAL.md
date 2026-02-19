# MIGRATION LINKCARD 2.0 — WHC → OceanDigital

**Date:** 19 février 2026  
**Raison:** RAM insuffisante (1.45/1.5 GB utilisé sur WHC) → 8 GB sur OceanDigital  
**Domaines:** app.linkcard.ca (v2) + linkcard.ca (v1)

---

## TABLE DES MATIÈRES

1. [Pré-requis serveur](#1-pré-requis-serveur)
2. [Variables d'environnement (.env)](#2-variables-denvironnement-env)
3. [Base de données MySQL](#3-base-de-données-mysql)
4. [Fichiers applicatifs (code)](#4-fichiers-applicatifs-code)
5. [Storage (uploads utilisateurs)](#5-storage-uploads-utilisateurs)
6. [Assets publics](#6-assets-publics)
7. [Cron Jobs](#7-cron-jobs)
8. [DNS & Domaines](#8-dns--domaines)
9. [Stripe (Webhooks)](#9-stripe-webhooks)
10. [Mailgun](#10-mailgun)
11. [SSL/HTTPS](#11-sslhttps)
12. [LinkCard v1 (si applicable)](#12-linkcard-v1)
13. [Checklist de migration](#13-checklist-de-migration)
14. [Validation post-migration](#14-validation-post-migration)

---

## 1. PRÉ-REQUIS SERVEUR

### Versions requises

| Composant | Version requise | Notes |
|-----------|----------------|-------|
| **PHP** | 8.2+ | Laravel 11 exige 8.2 minimum |
| **MySQL** | 8.0+ | ou MariaDB 10.5+ |
| **Composer** | 2.x | Gestionnaire dépendances PHP |
| **Node.js** | 18+ | Pour npm (build Tailwind futur) |
| **Git** | 2.x | Déploiement via GitHub |

### Extensions PHP requises

```
php-mbstring
php-xml
php-curl
php-mysql (PDO)
php-json
php-openssl
php-tokenizer
php-zip
php-gd (pour QR codes + images)
php-bcmath (pour Stripe/Cashier)
php-fileinfo
php-dom
```

### Modules Apache requis

```
mod_rewrite (obligatoire — routes Laravel)
mod_ssl (HTTPS)
mod_headers (optionnel mais recommandé)
```

### Limites PHP recommandées (php.ini)

```ini
memory_limit = 256M          # Actuellement limité sur WHC
upload_max_filesize = 50M    # Images utilisateurs (max 50MB par image)
post_max_size = 55M
max_execution_time = 120
max_input_vars = 3000        # Livewire avec formulaires complexes
```

---

## 2. VARIABLES D'ENVIRONNEMENT (.env)

### Template complet à recréer sur OceanDigital

```env
# ========== APPLICATION ==========
APP_NAME=LinkCard
APP_ENV=production
APP_KEY=                          # ⚠️ COPIER EXACTEMENT depuis WHC!
APP_DEBUG=false
APP_TIMEZONE=America/Toronto
APP_URL=https://app.linkcard.ca
APP_LOCALE=fr

# ========== BASE DE DONNÉES ==========
DB_CONNECTION=mysql
DB_HOST=127.0.0.1                 # ou IP du serveur MySQL OceanDigital
DB_PORT=3306
DB_DATABASE=linkcard2_main        # Recréer avec ce nom
DB_USERNAME=                      # Créer user sur OceanDigital
DB_PASSWORD=                      # Nouveau mot de passe

# ========== SESSION ==========
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_DOMAIN=.app.linkcard.ca

# ========== CACHE & QUEUE ==========
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

# ========== STRIPE (MODE TEST) ==========
STRIPE_KEY=pk_test_...            # ⚠️ Copier depuis WHC
STRIPE_SECRET=sk_test_...         # ⚠️ Copier depuis WHC
STRIPE_WEBHOOK_SECRET=whsec_...   # ⚠️ SERA DIFFÉRENT — voir section 9
CASHIER_CURRENCY=cad

# Stripe Price IDs (ne changent pas)
STRIPE_PRICE_PRO_MONTHLY=price_1StJ36J8RoOvVTJ7cQNB0GyY
STRIPE_PRICE_PRO_YEARLY=price_1StJ36J8RoOvVTJ7XBneZpsI
STRIPE_PRICE_PREMIUM_MONTHLY=price_1StJ5zJ8RoOvVTJ7My7U5X2v
STRIPE_PRICE_PREMIUM_YEARLY=price_1StJ60J8RoOvVTJ7Ua4NkiPW

# ========== MAILGUN ==========
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=linkcard.ca
MAILGUN_SECRET=                   # ⚠️ Copier depuis WHC
MAILGUN_ENDPOINT=api.mailgun.net
MAIL_FROM_ADDRESS=noreply@linkcard.ca
MAIL_FROM_NAME=LinkCard
MAIL_ADMIN_ADDRESS=mathieu.corbeil@outlook.fr

# ========== REFERRAL ==========
REFERRAL_ENABLED=true
```

### ⚠️ POINTS CRITIQUES .env

1. **APP_KEY** — Doit être **identique** à WHC sinon les sessions, cookies et données chiffrées seront invalides
2. **STRIPE_WEBHOOK_SECRET** — Devra être regénéré car l'URL webhook changera (voir section 9)
3. **DB credentials** — Nouveaux pour OceanDigital
4. **Ne jamais committer le .env** — Il est dans .gitignore

---

## 3. BASE DE DONNÉES MYSQL

### Nom de la base

```
linkcard2_main
```

### Tables existantes (17 tables + tables Laravel système)

#### Tables applicatives

| Table | Description | Données critiques |
|-------|-------------|-------------------|
| `users` | Utilisateurs + plan + stripe_id + role | ⚠️ Contient stripe_id — lien Stripe |
| `profiles` | Profils publics | Photos, couleurs, templates |
| `content_bands` | Sections de contenu (JSON) | Liens sociaux, images, texte, vidéos, CTA |
| `cards` | Cartes NFC physiques | card_code, profile_id, statuts |
| `card_orders` | Commandes de cartes | Adresses, paiements, tracking |
| `connections` | Connexions entre users | sender_id, receiver_id, status |
| `subscriptions` | Abonnements Stripe (Cashier) | stripe_id, stripe_status |
| `subscription_items` | Items abonnement (Cashier) | stripe_price |
| `profile_views` | Statistiques vues | ip, user_agent, date |
| `link_clicks` | Statistiques clics | content_band_id, ip |
| `username_redirects` | Anciennes URLs custom | old_username, expires_at |
| `plan_overrides` | Plans offerts manuellement | granted_plan, expires_at |
| `impersonation_requests` | Demandes accès admin | admin_id, user_id, status |
| `email_verification_codes` | Codes vérification email | code, expires_at |
| `referrals` | Système de parrainage | referrer_id, referred_id |
| `profile_reports` | Signalements profils | reporter_id, reason |

#### Tables système Laravel

| Table | Description |
|-------|-------------|
| `cache` | Cache applicatif |
| `cache_locks` | Verrous cache |
| `sessions` | Sessions utilisateurs |
| `jobs` | Queue de jobs |
| `job_batches` | Lots de jobs |
| `failed_jobs` | Jobs échoués |
| `password_reset_tokens` | Tokens reset password |

### Procédure d'export/import

```bash
# === SUR WHC (EXPORT) ===

# Export complet avec structure + données
mysqldump -u USERNAME -p linkcard2_main > linkcard2_main_backup_$(date +%Y%m%d).sql

# Vérifier la taille
ls -lh linkcard2_main_backup_*.sql

# === SUR OCEANDIGITAL (IMPORT) ===

# Créer la base
mysql -u root -p -e "CREATE DATABASE linkcard2_main CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Créer l'utilisateur
mysql -u root -p -e "CREATE USER 'linkcard_user'@'localhost' IDENTIFIED BY 'MOT_DE_PASSE_FORT';
GRANT ALL PRIVILEGES ON linkcard2_main.* TO 'linkcard_user'@'localhost';
FLUSH PRIVILEGES;"

# Importer
mysql -u linkcard_user -p linkcard2_main < linkcard2_main_backup_XXXXXXXX.sql

# Vérifier
mysql -u linkcard_user -p linkcard2_main -e "SHOW TABLES;"
mysql -u linkcard_user -p linkcard2_main -e "SELECT COUNT(*) FROM users;"
```

---

## 4. FICHIERS APPLICATIFS (CODE)

### Structure sur WHC actuel

```
~/public_html/app/              ← Racine du projet Laravel
├── app/                        ← Code PHP (controllers, models, services...)
├── bootstrap/                  ← Bootstrap Laravel
├── config/                     ← Configuration
├── database/                   ← Migrations, seeders, factories
├── public/                     ← Document root Apache
│   ├── index.php              ← Point d'entrée
│   ├── .htaccess              ← Rewrite rules
│   ├── css/                   ← design-system.css
│   ├── images/                ← Logos, landing images
│   ├── vendor/livewire/       ← Assets Livewire
│   └── storage -> ../storage/app/public  ← Symlink!
├── resources/                  ← Views Blade, CSS, JS
├── routes/                     ← web.php, console.php
├── storage/                    ← Uploads, logs, cache
├── vendor/                     ← Dépendances Composer (pas dans Git)
├── .env                        ← Config environnement (pas dans Git)
├── composer.json
├── composer.lock
├── artisan
└── ...
```

### Déploiement sur OceanDigital

```bash
# === Option A: Via Git (RECOMMANDÉ) ===

cd /home/VOTRE_USER/     # ou ~/public_html/ selon config OceanDigital
git clone https://github.com/Link-Card/linkcard-2.0.git app

cd app

# Installer dépendances
composer install --no-dev --optimize-autoloader

# Copier .env et le configurer
cp .env.example .env
nano .env   # Remplir avec les valeurs (voir section 2)

# Générer clé (OU copier l'existante de WHC)
# Si migration avec données existantes: COPIER APP_KEY de WHC
# Si nouvelle install: php artisan key:generate

# Créer le symlink storage
php artisan storage:link

# Cache config pour production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Vérifier que les migrations sont à jour
php artisan migrate --force
```

### Fichiers critiques — NE PAS OUBLIER

| Fichier | Pourquoi c'est critique |
|---------|------------------------|
| `.env` | Toute la config sensible |
| `storage/app/public/profiles/` | Photos et images des utilisateurs |
| `storage/app/public/card-logos/` | Logos personnalisés des cartes NFC |
| `public/images/` | Logos LinkCard, images landing |
| `public/css/design-system.css` | CSS custom du design system |
| `public/vendor/livewire/` | Assets Livewire (régénérés par `composer install`) |

---

## 5. STORAGE (UPLOADS UTILISATEURS)

### ⚠️ LE PLUS CRITIQUE — NE PAS PERDRE

Le dossier `storage/app/public/` contient toutes les données uploadées par les utilisateurs.

```
storage/app/public/
├── profiles/
│   ├── {user_id}/
│   │   ├── photo.jpg              ← Photo de profil
│   │   ├── image_1.jpg            ← Images sections
│   │   ├── image_2.jpg
│   │   └── ...
│   └── ...
├── card-logos/
│   ├── order_{id}_logo.png        ← Logos custom cartes NFC
│   └── ...
└── livewire-tmp/                  ← Fichiers temporaires (peut être vidé)
```

### Procédure de transfert

```bash
# === SUR WHC ===

# Compresser le storage
cd ~/public_html/app/
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public/

# Vérifier la taille
ls -lh storage_backup_*.tar.gz

# Transférer vers OceanDigital (via SCP, SFTP, ou rsync)
scp storage_backup_*.tar.gz user@oceandigital:/home/user/app/

# === SUR OCEANDIGITAL ===

cd /home/user/app/
tar -xzf storage_backup_*.tar.gz

# Vérifier les permissions
chmod -R 775 storage/
chown -R www-data:www-data storage/    # ou le user Apache

# Recréer le symlink
php artisan storage:link
# Crée: public/storage -> storage/app/public
```

### Vérification

```bash
# Le symlink doit exister
ls -la public/storage
# Devrait afficher: public/storage -> /chemin/vers/storage/app/public

# Tester qu'une image est accessible
curl -I https://app.linkcard.ca/storage/profiles/1/photo.jpg
# Devrait retourner 200 OK
```

---

## 6. ASSETS PUBLICS

### Fichiers dans public/ (dans le repo Git)

```
public/
├── index.php                    ← Point d'entrée Laravel
├── .htaccess                    ← Rewrite rules Apache
├── robots.txt
├── favicon.ico
├── css/
│   └── design-system.css        ← CSS custom LinkCard (386 lignes)
├── images/
│   ├── logo.png                 ← Logo couleur (131 KB)
│   ├── logo-blanc.png           ← Logo blanc (65 KB)
│   ├── logo-noir.png            ← Logo noir (65 KB)
│   ├── favicon.png
│   ├── favicon-32.png
│   ├── apple-touch-icon.png
│   └── landing/                 ← Images page d'accueil
│       ├── cartes-1-blanche.jpg
│       ├── bande_linkcard001.jpg
│       ├── bande_linkcard002.jpg
│       ├── bande_linkcard003.jpg
│       ├── bande_linkcard004.jpg
│       ├── LINKCARD-CONTACT.png
│       ├── link_card_formulaire.png
│       ├── linkcard-promo.jpg
│       ├── linkcard_logo_final_noir.png
│       └── logo_final_blanc.png
└── vendor/
    └── livewire/                ← Régénéré par composer install
        ├── livewire.js
        ├── livewire.min.js
        └── manifest.json
```

### CDN utilisé (chargé depuis les vues)

```
Tailwind CSS 3 — CDN (pas encore compilé localement)
Google Fonts — Manrope (wght@400;500;600;700)
SortableJS — CDN (drag & drop éditeur)
```

---

## 7. CRON JOBS

### 3 tâches planifiées (définies dans `routes/console.php`)

```bash
# Commande unique pour le cron cPanel/OceanDigital:
* * * * * cd /chemin/vers/app && php artisan schedule:run >> /dev/null 2>&1
```

### Détail des tâches

| Fréquence | Commande | Description |
|-----------|----------|-------------|
| `hourly` | `emails:send-welcome` | Envoi emails de bienvenue 24h après inscription |
| `daily` | `orders:archive-delivered` | Archive commandes livrées depuis +30 jours |
| `hourly` | `plans:expire-overrides` | Expire les plan overrides et impersonation requests |

### Configuration sur OceanDigital

Si cPanel: Ajouter dans Cron Jobs:
```
* * * * * /usr/local/bin/php /home/USER/app/artisan schedule:run >> /dev/null 2>&1
```

Si accès SSH direct:
```bash
crontab -e
# Ajouter:
* * * * * cd /home/USER/app && php artisan schedule:run >> /dev/null 2>&1
```

---

## 8. DNS & DOMAINES

### Configuration actuelle

| Domaine | Pointe vers | Usage |
|---------|-------------|-------|
| `linkcard.ca` | WHC (v1) | Version 1.0 — garder 12 mois |
| `app.linkcard.ca` | WHC (v2) | Version 2.0 — à migrer |

### Procédure DNS

```
1. Sur le registraire DNS (où le domaine est géré):
   - Modifier le A record de app.linkcard.ca → nouvelle IP OceanDigital
   - OU modifier le CNAME si applicable

2. TTL recommandé: 300 secondes (5 min) pendant la migration
   puis remonter à 3600 (1h) après validation

3. ⚠️ NE PAS toucher aux records de linkcard.ca si la v1 reste sur WHC
```

### Si les deux (v1 + v2) migrent vers OceanDigital

```
linkcard.ca     → A record → IP OceanDigital
app.linkcard.ca → A record → IP OceanDigital (ou CNAME → linkcard.ca)
```

Configuration Apache VirtualHost:
```apache
# app.linkcard.ca (v2 — Laravel)
<VirtualHost *:443>
    ServerName app.linkcard.ca
    DocumentRoot /home/USER/app/public
    
    <Directory /home/USER/app/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

# linkcard.ca (v1 — si migré aussi)
<VirtualHost *:443>
    ServerName linkcard.ca
    DocumentRoot /home/USER/public_html
    # ou le chemin vers v1
</VirtualHost>
```

---

## 9. STRIPE (WEBHOOKS)

### ⚠️ ÉTAPE CRITIQUE — L'URL webhook change

Stripe envoie des webhooks à une URL spécifique. Si le domaine reste `app.linkcard.ca`, l'URL ne change pas et il n'y a rien à faire côté Stripe.

**Si l'URL reste la même:**
```
https://app.linkcard.ca/webhook/stripe
→ Rien à changer dans Stripe
→ Le STRIPE_WEBHOOK_SECRET reste le même
```

**Si l'URL change (nouveau domaine temporaire pendant migration):**
1. Aller sur https://dashboard.stripe.com/webhooks
2. Modifier l'endpoint existant OU en créer un nouveau
3. URL: `https://NOUVEAU_DOMAINE/webhook/stripe`
4. Événements requis:
   - `customer.subscription.created`
   - `customer.subscription.updated`
   - `customer.subscription.deleted`
   - `checkout.session.completed` (pour les cartes NFC)
5. Copier le nouveau `whsec_...` dans `.env` → `STRIPE_WEBHOOK_SECRET`

### Clés Stripe (ne changent pas)

```
STRIPE_KEY=pk_test_...          ← Même clé
STRIPE_SECRET=sk_test_...       ← Même clé
STRIPE_WEBHOOK_SECRET=whsec_... ← Potentiellement nouveau
```

### Vérification post-migration

```bash
# Vérifier que le webhook fonctionne
tail -f storage/logs/laravel.log | grep -i webhook
# Puis faire un test depuis Stripe Dashboard → "Send test webhook"
```

---

## 10. MAILGUN

### Configuration actuelle

| Paramètre | Valeur |
|-----------|--------|
| Domaine vérifié | `linkcard.ca` |
| API Key | Dans `.env` (MAILGUN_SECRET) |
| Endpoint | `api.mailgun.net` |
| From | `noreply@linkcard.ca` |

### Rien à changer si

- Le domaine `linkcard.ca` reste le même
- Les DNS records Mailgun (SPF, DKIM, MX) ne changent pas

### Si les DNS changent

Vérifier que les records Mailgun sont toujours présents:
```
# Records DNS requis pour Mailgun:
TXT   linkcard.ca          v=spf1 include:mailgun.org ~all
TXT   k1._domainkey.linkcard.ca  (clé DKIM Mailgun)
MX    linkcard.ca          mxa.mailgun.org (prio 10)
MX    linkcard.ca          mxb.mailgun.org (prio 10)
```

### Test email post-migration

```bash
php artisan tinker --execute="
\Illuminate\Support\Facades\Mail::raw('Test migration OceanDigital', function(\$m) {
    \$m->to('mathieu.corbeil@outlook.fr')->subject('Test LinkCard Migration');
});
echo 'Email envoyé!';
"
```

---

## 11. SSL/HTTPS

### Requis

- Certificat SSL pour `app.linkcard.ca`
- Certificat SSL pour `linkcard.ca` (si v1 migre aussi)

### Options

1. **Let's Encrypt** (gratuit, recommandé):
```bash
# Si certbot est installé
sudo certbot --apache -d app.linkcard.ca
sudo certbot --apache -d linkcard.ca
```

2. **cPanel AutoSSL** (si OceanDigital offre cPanel)
3. **SSL OceanDigital** (vérifier leur offre)

### Force HTTPS dans Laravel

Déjà géré par `.htaccess` et/ou le middleware `TrustProxies`.

---

## 12. LINKCARD V1 (SI APPLICABLE)

### Ce que je sais de la v1 (basé sur les documents projet)

| Aspect | Détails connus |
|--------|----------------|
| **URL** | `linkcard.ca` (pas de sous-domaine) |
| **Page login** | `linkcard.ca/login` — reste active 12 mois |
| **Hébergement actuel** | WHC (même serveur que v2) |
| **Stack probable** | Laravel aussi (ou PHP natif) |
| **Base de données** | Probablement séparée de `linkcard2_main` |

### Si la v1 migre aussi vers OceanDigital

Tu devras:

1. **Identifier la base de données v1** — probablement un autre nom que `linkcard2_main`
2. **Exporter le code v1** — tout le dossier de la v1
3. **Exporter le storage v1** — uploads utilisateurs v1
4. **Configurer un VirtualHost séparé** — `linkcard.ca` → dossier v1
5. **Reconfigurer le .env v1** (si Laravel) avec les nouvelles credentials DB

### Si la v1 reste sur WHC temporairement

- Ne toucher à rien côté WHC
- S'assurer que les DNS de `linkcard.ca` pointent toujours vers WHC
- Seul `app.linkcard.ca` change de pointage DNS

### ⚠️ RECOMMANDATION

Si tu migres les deux en même temps:
```
OceanDigital
├── /home/user/app/          ← v2 (app.linkcard.ca)
├── /home/user/v1/           ← v1 (linkcard.ca)
```

Si tu gardes v1 sur WHC temporairement:
```
WHC (ancien)
└── linkcard.ca → v1

OceanDigital (nouveau)
└── app.linkcard.ca → v2
```

---

## 13. CHECKLIST DE MIGRATION

### Phase 1 — Préparation (AVANT la migration)

- [ ] Commander/configurer le serveur OceanDigital (8 GB RAM)
- [ ] Vérifier PHP 8.2+, MySQL 8.0+, extensions PHP
- [ ] Installer Composer sur OceanDigital
- [ ] Installer Git sur OceanDigital
- [ ] Sauvegarder le `.env` actuel de WHC (copie locale sécurisée)
- [ ] Copier la `APP_KEY` du `.env` WHC (CRITIQUE)
- [ ] Copier les clés Stripe du `.env` WHC
- [ ] Copier la clé Mailgun du `.env` WHC
- [ ] Baisser le TTL DNS à 300 secondes (24h avant migration)

### Phase 2 — Sauvegarde WHC

- [ ] Export base de données: `mysqldump linkcard2_main > backup.sql`
- [ ] Compresser storage: `tar -czf storage.tar.gz storage/app/public/`
- [ ] Vérifier taille et intégrité des backups
- [ ] Transférer les fichiers vers OceanDigital (SCP/SFTP)

### Phase 3 — Installation OceanDigital

- [ ] Cloner le repo Git: `git clone ... app`
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] Créer et configurer `.env` (voir section 2)
- [ ] Créer la base MySQL + utilisateur
- [ ] Importer la base de données
- [ ] Extraire le storage au bon endroit
- [ ] Créer le symlink: `php artisan storage:link`
- [ ] Permissions: `chmod -R 775 storage/ bootstrap/cache/`
- [ ] Cache: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- [ ] Configurer le VirtualHost Apache (DocumentRoot → `/app/public`)
- [ ] Installer SSL (Let's Encrypt)
- [ ] Configurer le cron job

### Phase 4 — Basculement DNS

- [ ] Mettre l'app WHC en maintenance: `php artisan down`
- [ ] Faire un DERNIER export de la base (pour capturer les dernières données)
- [ ] Réimporter sur OceanDigital
- [ ] Changer le DNS: `app.linkcard.ca` → IP OceanDigital
- [ ] Attendre propagation DNS (5-30 min avec TTL 300)

### Phase 5 — Validation (voir section 14)

- [ ] Tester toutes les fonctionnalités
- [ ] Si tout OK: remonter TTL DNS à 3600

### Phase 6 — Nettoyage

- [ ] Supprimer les backups temporaires sur OceanDigital
- [ ] Garder WHC actif quelques jours en fallback
- [ ] Si v1 reste sur WHC: vérifier qu'elle fonctionne toujours

---

## 14. VALIDATION POST-MIGRATION

### Tests fonctionnels obligatoires

| # | Test | URL/Action | Résultat attendu |
|---|------|-----------|-----------------|
| 1 | Page d'accueil | `https://app.linkcard.ca` | Landing page s'affiche |
| 2 | Login | `/login` | Formulaire fonctionne |
| 3 | Register | `/register` | Inscription + email vérification |
| 4 | Dashboard | `/dashboard` | Accessible après login |
| 5 | Éditeur profil | `/dashboard/profiles/{id}/edit` | Drag & drop fonctionne |
| 6 | Profil public | `/{username}` | Template s'affiche correctement |
| 7 | Images | Profil avec photos | Images visibles (storage symlink OK) |
| 8 | QR Code | Télécharger QR | Fichier PNG généré |
| 9 | vCard | Télécharger vCard | Fichier .vcf généré |
| 10 | Carte NFC redirect | `/c/{card_code}` | Redirige vers profil |
| 11 | Page abonnements | `/dashboard/subscription` | Plans affichés |
| 12 | Stripe Checkout | Cliquer "Commencer" sur un plan | Redirect vers Stripe |
| 13 | Webhook Stripe | Envoyer test webhook | Log "Plan updated" |
| 14 | Email test | Reset password | Email reçu via Mailgun |
| 15 | Admin dashboard | `/admin/dashboard` | Accessible avec compte admin |
| 16 | Connexions | `/dashboard/connections` | Liste connexions |
| 17 | Stats | `/dashboard/stats` | Statistiques visibles |
| 18 | Pages légales | `/conditions`, `/confidentialite` | S'affichent |
| 19 | Cron jobs | Vérifier après 1h | Logs de `schedule:run` |
| 20 | Mobile | Tester sur téléphone | Responsive OK |

### Commandes de vérification rapide

```bash
# Vérifier que Laravel fonctionne
php artisan --version

# Vérifier la connexion DB
php artisan tinker --execute="echo App\Models\User::count() . ' users';"

# Vérifier le storage symlink
ls -la public/storage

# Vérifier les cron
php artisan schedule:list

# Vérifier les routes
php artisan route:list --compact

# Vérifier les logs
tail -20 storage/logs/laravel.log
```

---

## RÉSUMÉ DES FICHIERS À TRANSFÉRER

| Quoi | Source WHC | Destination OceanDigital | Méthode |
|------|-----------|-------------------------|---------|
| **Code** | `~/public_html/app/` | `/home/user/app/` | Git clone |
| **Vendor** | (pas dans Git) | (régénéré) | `composer install` |
| **.env** | `~/public_html/app/.env` | `/home/user/app/.env` | Copie manuelle |
| **Base de données** | `linkcard2_main` | `linkcard2_main` | mysqldump + import |
| **Storage uploads** | `storage/app/public/` | `storage/app/public/` | tar + SCP |
| **V1 (optionnel)** | `~/public_html/` (?) | `/home/user/v1/` | SCP/rsync |

### Taille estimée à transférer

| Élément | Taille estimée |
|---------|---------------|
| Code (Git) | ~15 MB |
| Vendor (composer) | ~100-150 MB (régénéré) |
| Base de données | Variable (selon nombre d'utilisateurs) |
| Storage uploads | Variable (photos, images) |
| Total sans vendor | Probablement < 500 MB |

---

## NOTES IMPORTANTES

1. **Temps d'arrêt minimal** — Fais le gros du travail AVANT de basculer le DNS. Seul le moment entre le dernier export DB et la propagation DNS sera "down".

2. **Fallback** — Garde WHC actif quelques jours. Si problème sur OceanDigital, rebascule le DNS vers WHC.

3. **Stripe en mode test** — Puisque tu es encore en mode test Stripe, le risque est limité. En production, il faudra être plus prudent avec les webhooks.

4. **Pas de Redis/Memcached** — L'app utilise `database` pour cache/session/queue, donc pas besoin de configurer Redis.

5. **Pas de Node.js en production (pour l'instant)** — Tailwind est chargé via CDN. Le build Tailwind est prévu en Phase 6 post-MVP.
