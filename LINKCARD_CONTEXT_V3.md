# LINKCARD 2.0 — CONTEXTE PROJET
**Mise à jour:** 10 février 2026

## État actuel
- **Sprint 1 (Auth):** 100% ✅
- **Sprint 2 (Profils + Éditeur v2):** 100% ✅
- **Sprint 3 (Abonnements Stripe):** 100% ✅
- **Sprint 4 (Cartes NFC):** 100% ✅
- **Sprint 5 (Connexions):** 100% ✅
- **Sprint 6 (Stats + URLs custom):** 100% ✅
- **Sprint 7 (Templates):** ~80% (Phase 1-4 done, Phase 5 Custom TODO, formulaires nouvelles bandes TODO)
- **Analyse personas (Phases 1-5):** 100% ✅ (Quick fixes UI, contact rapide, email bienvenue, sécurité, UX)
- **Phase 6 (Post-MVP):** Planification complétée, document PHASE_6_POST_MVP.md créé
- **Legal:** 100% ✅ (Conditions, Confidentialité, Remboursement — conformes Québec/Canada)
- **Branding:** 95%
- **Mobile responsive:** 90%
- **Progression globale:** ~87% MVP

## Stack technique
- **Backend:** Laravel 11 + Livewire 3 + Alpine.js
- **Frontend:** Tailwind CSS 3 + SVG inline (pas Font Awesome)
- **Serveur:** WHC (~/public_html/app) — app.linkcard.ca
- **DB:** MySQL linkcard2_main
- **Email:** Mailgun (linkcard.ca vérifié)
- **Paiement:** Stripe (mode test configuré, LIVE pour production)
- **Git:** GitHub repository linkcard-2.0
- **QR:** simplesoftwareio/simple-qrcode
- **Cron:** WHC cPanel (archivage auto 30j, emails différés 24h, email bienvenue hourly)

## Base de données
**Tables actives:**
- users (+ plan ENUM free/pro/premium, stripe_id, role, email_verified_at, welcome_email_sent_at, onboarding_completed_at [à venir])
- profiles (username, full_name, job_title, company, location, email, phone, website, bio, photo_path, primary_color, secondary_color, template_id, template_config JSON, text_color, button_color, is_public, view_count)
- content_bands (profile_id, type ENUM('social_link','image','text_block','contact_button','video_embed','image_carousel','cta_button'), data JSON, order, is_hidden, hidden_reason)
- subscriptions (Cashier), subscription_items
- cards (card_code, user_id, profile_id, is_active, order_id, programmed_at, shipped_at, activated_at)
- card_orders (user_id, order_number, quantity, design_type, logo_path, stripe_payment_id, status, shipping_address JSON, tracking_number, amount_cents, items JSON, is_archived)
- email_verification_codes (user_id, code, expires_at)
- connections (sender_id, receiver_id, status, card_id, source)
- username_redirects (old_username, profile_id, expires_at)
- plan_overrides (user_id, granted_plan, previous_plan, granted_by, reason, note, starts_at, expires_at, status)
- impersonation_requests (admin_id, user_id, reason, status, expires_at)
- profile_views (profile_id, viewed_at, ip, user_agent)
- link_clicks (content_band_id, clicked_at, ip)

## Forfaits confirmés
| | GRATUIT | PRO 5$/mois | PREMIUM 8$/mois |
|---|---|---|---|
| Profils | 1 | 1 (+5$/mois par extra) | 1 (+8$/mois par extra) |
| Code | 8 car aléatoire | Username custom possible | Username custom obligatoire |
| Social links | **3** | 5 | 10 |
| Images | 2 (sans liens) | 5 (avec liens) | 10 (avec liens) |
| Sections texte | 1 | 2 | 5 |
| QR Code popup | ❌ | ✅ | ✅ |
| Annuel | — | 50$/an | 80$/an |
| Carte NFC | 49.99$ | 49.99$ | 37.49$ (-25%) |
| Templates | 3 gratuits | + 4 PRO | + 2 PREMIUM + Custom |

**Changement 10 fév:** Social links gratuit passé de 2 → 3.
**Terminologie:** "bande" → "section", "bloc texte" → "section texte" partout dans l'interface.

## Sprint 7 — Templates (EN COURS)

### 13 Templates définis dans TemplateService
**Généraux (9):**
1. **Classique** (classic) — Gradient + wave animée, photo ronde, pills socials [FREE]
2. **Vague v1** (wave) — Gradient + double wave animée [FREE]
3. **Minimal** (minimal) — Barre accent 5px, fond blanc, shadow colorée [FREE]
4. **Diagonal** (diagonal) — Coupe en angle 135deg [PRO]
5. **Arche** (arch) — Courbe élégante ellipse [PRO]
6. **Split** (split) — Photo gauche 38%, info droite 62% [PRO]
7. **Banner** (banner) — Bannière courte + photo overlap -56px [PRO]
8. **Géométrique** (geometric) — Formes décoratives + chevron + photo carrée [PREMIUM]
9. **Bold** (bold) — Fond #2C2A27 sombre + accent gradient 4px [PREMIUM]

**Spécialisés (3):**
10. **Vidéaste** (videaste) — Video embed YouTube/TikTok/Vimeo [PRO: 1 vidéo, PREMIUM: 2]
11. **Artiste** (artiste) — Carrousel images auto-scroll + swipe [PRO: 1 carrousel/6 imgs, PREMIUM: 2/12]
12. **Entrepreneur** (entrepreneur) — Boutons CTA pleine largeur [PRO: 3 CTA, PREMIUM: 6]

**Custom (#13):**
13. **Mon style** (custom) — Mix & match tout [PREMIUM only]

### Ce qui reste Sprint 7
- ⏳ Phase 5: UI Custom template (mix & match header/transition/photo/social style) — PREMIUM only
- ⏳ Formulaires éditeur pour ajouter sections video_embed, image_carousel, cta_button

## Analyse personas — Corrections appliquées (10 fév 2026)

### Phase 1 — Quick Fixes UI ✅
- Bouton partage: couleur responsive (suit primary_color du profil)
- Téléphone: auto-formatage XXX-XXX-XXXX (affichage + input éditeur)
- Barre impersonation: texte raccourci mobile + hauteur dynamique JS
- Pull-to-refresh mobile: layout corrigé (body scrollable sur mobile)
- Couleurs: validation regex hex #XXXXXX dans éditeur

### Phase 2 — Contact rapide connexions ✅
- Boutons téléphone (vert) et email (bleu) sur chaque carte de contact
- Affichage conditionnel (seulement si le contact a phone/email)

### Phase 3 — Email bienvenue 24h ✅
- Commande artisan `emails:send-welcome` + cron hourly
- Template 3 étapes (photo → liens → carte NFC)
- Envoi 24h après vérification email

### Phase 4 — Sécurité & Performance ✅
- stop-impersonation: vérifie que session pointe vers un vrai super_admin
- Admin dashboard: N+1 queries corrigé (withSum total_views)
- Admin dashboard: auto-archive retiré du render() (cron le fait déjà)
- Admin dashboard: pagination 50 users + resetPage sur search/sort
- Couleurs profil public: sanitization regex hex anti-injection CSS
- Split template: formatted_phone

### Phase 5 — UX améliorations ✅
- Forfait gratuit: 3 liens sociaux (était 2)
- Terminologie simplifiée: "bande" → "section", "bloc texte" → "texte"
- Messages limites: plus humains ("Vous avez utilisé tous vos..." au lieu de "Limite atteinte")
- "plan" → "forfait" dans les messages utilisateur
- Page forfaits: features mises à jour
- Fichier orphelin "," supprimé de la racine du repo

## Phase 6 — Post-MVP (PLANIFIÉ)

Document complet: `PHASE_6_POST_MVP.md` dans le repo.

### 6 chantiers planifiés:
1. **Landing page + pages publiques** (accueil, fonctionnalités, carte NFC, forfaits + bundles, FAQ, contact, à propos)
2. **Build Tailwind production** (compilation CSS, remplace CDN)
3. **Tests automatisés** (webhooks Stripe, PlanLimits, auth, cartes NFC)
4. **Onboarding guidé** (modal bienvenue + checklist persistante)
5. **Analytics par plan** (sources, géo, appareils — segmenté Gratuit/Pro/Premium)
6. **Nettoyage Storage** (commande artisan dry-run + déplacement sécuritaire)

### Bundles de lancement prévus:
| Bundle | Contenu | Prix |
|---|---|---|
| Découverte | 1 carte NFC + 3 mois Premium | 59.99$ |
| Pro | 1 carte NFC + 1 profil extra + 6 mois Premium | 99.99$ |
| Duo | 2 cartes NFC + 2 profils + 6 mois Premium | 149.99$ |

+ 2e profil offert pour tous les premiers inscrits au lancement

### Ordre d'exécution:
Landing page → Onboarding → Analytics → Tests → Storage cleanup → Tailwind build → **BETA**

## Pages légales
- ✅ Conditions d'utilisation (route: legal.terms)
- ✅ Politique de confidentialité (route: legal.privacy)
- ✅ Politique de remboursement (route: legal.refund)
- Conformes: Loi 25 Québec, LPRPDE, protection consommateur Québec

## Fonctionnalités complétées (Sprints 1-6)

### Sprint 1 - Auth
- Login/Register/Logout, Reset password (Mailgun), Remember me
- Vérification email par code 6 chiffres
- Branding login/register (Manrope, palette, logo)

### Sprint 2 - Éditeur v2
- Single page, drag & drop SortableJS, Preview WYSIWYG
- Gradient 2 couleurs, Multi-images (1-2 par section, max 50MB)
- Composant social-icon (18 réseaux SVG), Sauvegarde auto

### Sprint 3 - Abonnements Stripe
- Checkout Stripe, Portail Stripe, Webhooks automatiques
- PlanLimitsService, Masquage/démasquage automatique
- QR Code visible PRO/PREMIUM connectés seulement

### Sprint 4 - Cartes NFC
- Commande cartes Stripe (paiement unique), Numéros LC-XXXX
- Multi-profils par commande, Design standard/custom
- Redirect /c/{card_code}, Page activation, Gestion dashboard
- Admin: commandes, statuts, archivage, suppression users
- Emails brandés: confirmation, traitement, expédition, activation

### Sprint 5 - Connexions
- Scan carte/QR = demande connexion
- Accepter/refuser/annuler, Liste connexions dashboard
- ConnectionService, boutons contact rapide (phone/email)

### Sprint 6 - Stats + URLs custom
- Username personnalisable (PRO/PREMIUM)
- Redirections anciennes URLs (permanent ou 90j)
- Statistiques vues profil

### Profil public
- Templates dynamiques (9 headers), Vagues animées v1
- Gradient 2 couleurs, Bouton partage responsive (suit primary_color)
- QR Code popup (PRO/PREMIUM), Toast "Lien copié !"
- Open Graph meta tags, vCard download
- Video embed, Carrousel images, Boutons CTA
- Téléphone formaté automatiquement

## Décisions clés
1. Pas de suppression profil — Réinitialisation seulement
2. Codes profils: 8 caractères aléatoires
3. ContentBands: Table unifiée avec JSON flexible
4. Icônes: SVG inline (pas Font Awesome)
5. QR Code: Basé sur plan de l'utilisateur connecté
6. Stripe webhooks: parent() appelé AVANT notre code
7. Plans affichés Premium → Pro → Gratuit
8. Drag & drop mobile: delay 200ms + delayOnTouchOnly
9. Templates définis en code (TemplateService) pas en DB
10. Vagues animées v1: 4 couches parallax (7s, 10s, 13s, 20s)
11. Terminologie: "section" (pas "bande"), "forfait" (pas "plan") côté utilisateur
12. Forfait gratuit: 3 liens sociaux (pas 2)
13. Couleurs profil: sanitization regex hex obligatoire

## Fichiers critiques — NE JAMAIS ÉCRASER
- ProfileController.php : vCard + QR download
- show.blade.php : Profil public complet avec templates
- EditProfile.php : Logique éditeur v2 + changeTemplate()
- social-icon.blade.php : 18 icônes SVG
- WebhookController.php : Sync plan Stripe
- PlanLimitsService.php : Limites et masquage (3 liens gratuit)
- TemplateService.php : 13 templates avec configs
- Dashboard.php (Admin) : Pagination + withSum (pas de N+1)

## Roadmap révisée
1. ~~Sprint 1: Auth~~ ✅
2. ~~Sprint 2: Profils + Éditeur v2~~ ✅
3. ~~Sprint 3: Abonnements Stripe~~ ✅
4. ~~Sprint 4: Cartes NFC~~ ✅
5. ~~Sprint 5: Connexions~~ ✅
6. ~~Sprint 6: Stats + URLs custom~~ ✅
7. **Sprint 7: Templates** ← EN COURS (Phase 5 + formulaires)
8. **Phase 6: Post-MVP** ← PLANIFIÉ (landing, onboarding, analytics, tests, Tailwind)
9. Sprint Pré-launch: Légal ✅ + Branding final
10. **BETA (10-20 users)**
11. Sprint 8: Profils Entreprise
12. Sprint 9: Mode Affaire (BLE proximity)

## Domaines
- linkcard.ca → v1.0 (active, garde /login pendant 12 mois)
- app.linkcard.ca → v2.0 (développement, deviendra landing page)
