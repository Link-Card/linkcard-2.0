# PHASE 6 — POST-MVP (DOCUMENT COMPLET)

**Créé:** 10 février 2026
**Statut:** Planification complétée — Prêt à exécuter

---

## Vue d'ensemble

Phase 6 regroupe tout ce qui est nécessaire entre la fin du Sprint 7 et le lancement public.
6 chantiers, estimés à ~3-4 semaines de travail total.

| # | Chantier | Priorité | Effort estimé |
|---|----------|----------|---------------|
| 1 | Landing page + pages publiques | 🔴 Critique | 8-10 jours |
| 2 | Build Tailwind production | 🟡 Important | 2-3 heures |
| 3 | Tests automatisés | 🟡 Important | 3-4 jours |
| 4 | Onboarding guidé | 🟠 Élevé | 2-3 jours |
| 5 | Analytics par plan | 🟠 Élevé | 3-4 jours |
| 6 | Nettoyage Storage | 🟢 Mineur | 3-4 heures |

**Ordre recommandé:** 1 → 4 → 5 → 3 → 6 → 2 (Tailwind en dernier, quand le code est stable)

---

## 1. LANDING PAGE + PAGES PUBLIQUES

### Architecture des URLs

```
app.linkcard.ca/                → Landing page (accueil)
app.linkcard.ca/fonctionnalites → Page fonctionnalités
app.linkcard.ca/carte-nfc       → Page dédiée carte NFC
app.linkcard.ca/forfaits        → Forfaits + bundles lancement
app.linkcard.ca/faq             → FAQ complète
app.linkcard.ca/a-propos        → Notre mission
app.linkcard.ca/contact         → Formulaire contact
app.linkcard.ca/login           → Connexion (existe déjà)
app.linkcard.ca/register        → Inscription (existe déjà)

linkcard.ca/login               → V1 (reste intacte 12 mois)
```

### Navigation publique

```
[Logo LinkCard]  Fonctionnalités  Carte NFC  Forfaits  FAQ  [Se connecter]  [Commencer →]
```

Footer commun sur toutes les pages :
```
─────────────────────────────────────────────
LinkCard                    Produit              Ressources           Légal
Transformer chaque          Fonctionnalités      FAQ                  Conditions
rencontre en connexion      Carte NFC            Centre d'aide        Confidentialité
durable.                    Forfaits             Nous contacter       Remboursement
                            À propos
[icônes réseaux sociaux LinkCard]

© 2026 LinkCard · Saint-Pierre-les-Becquets, QC
─────────────────────────────────────────────
```

---

### Page 1 — Accueil (Landing)

**Objectif:** Convertir visiteurs → inscription en <30 secondes de lecture.

**Structure:**

```
┌─────────────────────────────────────────┐
│  HERO                                    │
│  "Votre carte de visite.                │
│   Repensée."                            │
│                                          │
│  Sous-titre: La carte NFC qui connecte  │
│  votre monde professionnel en un geste. │
│                                          │
│  [Commencer gratuitement]  [Voir la carte] │
│                                          │
│  Mockup: téléphone avec profil LinkCard │
│  + carte NFC physique flottante         │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  SOCIAL PROOF (si disponible)            │
│  "Déjà X professionnels connectés"      │
│  Logos entreprises ou avatars users     │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  3 PILIERS (icônes + texte court)       │
│                                          │
│  🔗 Profil digital     📱 Carte NFC     🤝 Connexions │
│  Créez votre carte     Un geste suffit   Votre réseau  │
│  de visite digitale    pour partager     professionnel  │
│  en 2 minutes.         votre profil.     qui grandit.   │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  DÉMO EXPÉRIENCE NFC                     │
│  Animation/vidéo: scan carte → profil   │
│  "Touchez. Connectez. C'est tout."      │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  BUNDLES LANCEMENT (aperçu)             │
│  3 cards avec prix barrés               │
│  [Voir tous les forfaits →]             │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  CTA FINAL                               │
│  "Prêt à faire une première             │
│   impression durable?"                   │
│  [Créer mon profil gratuitement]        │
└─────────────────────────────────────────┘
```

**Ton:** Professionnel mais humain. Pas de jargon tech. Phrases courtes. Focus sur le bénéfice, pas la feature.

**Éléments visuels requis:**
- Mockup téléphone avec profil LinkCard (à créer ou capturer)
- Photo/render carte NFC physique LinkCard
- Animation ou vidéo du scan NFC → ouverture profil
- Icônes SVG inline (cohérent avec le brand)

---

### Page 2 — Fonctionnalités

**Objectif:** Détailler ce que LinkCard fait pour les indécis.

**Sections:**

1. **Profil digital professionnel**
   - Photo, infos, liens sociaux, texte, images
   - 13 templates au choix
   - Personnalisation couleurs et style
   - Capture d'écran de l'éditeur + résultat
   - "Créez votre profil en moins de 2 minutes"

2. **Carte NFC intelligente**
   - Tap → profil instantané
   - Changez de profil sans changer de carte
   - Design premium, fonctionne avec tous les téléphones
   - Lien vers page carte NFC dédiée

3. **QR Code intégré**
   - Pour ceux qui n'ont pas de carte NFC
   - Partageable partout (email, présentation, écran)
   - Disponible avec PRO/PREMIUM

4. **Connexions**
   - Scannez → demande de connexion
   - Réseau professionnel qui se construit naturellement
   - Accès rapide aux contacts (téléphone, email)

5. **Statistiques** (selon plan)
   - Voyez qui visite votre profil
   - Comprenez vos meilleures sources de trafic
   - "Bientôt: analytics avancés"

---

### Page 3 — Carte NFC (page dédiée)

**Objectif:** Vendre l'expérience de la carte. C'est le différentiateur #1.

**Structure:**

```
┌─────────────────────────────────────────┐
│  HERO CARTE                              │
│  Photo/render carte NFC grand format    │
│  "La dernière carte de visite que       │
│   vous aurez à imprimer."              │
│                                          │
│  [Commander ma carte]                   │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  COMMENT ÇA MARCHE (3 étapes)           │
│                                          │
│  1. Commandez    2. Recevez     3. Connectez │
│  votre carte     à la maison    en un geste  │
│  en ligne        sous 5-7 jours partout      │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  VIDÉO/ANIMATION DÉMO                    │
│  Le moment "wow": quelqu'un tape la     │
│  carte sur un téléphone, le profil      │
│  apparaît instantanément                │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  CARACTÉRISTIQUES                        │
│  - Compatible tous smartphones NFC      │
│  - PVC premium, résistante              │
│  - URL permanente (profil modifiable)   │
│  - Design standard ou personnalisé      │
│  - Fabriquée au Québec 🇨🇦              │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  COMPARAISON                             │
│  Carte papier vs Carte LinkCard         │
│  (tableau visuel côte à côte)           │
│                                          │
│  Papier:           LinkCard:            │
│  ❌ Jetée            ✅ Gardée           │
│  ❌ Info fixe         ✅ Toujours à jour  │
│  ❌ Pas de suivi      ✅ Stats de scan    │
│  ❌ Polluante         ✅ Réutilisable     │
│  ❌ 500 cartes = 80$  ✅ 1 carte = ∞     │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│  PRIX + BUNDLE                           │
│  [Commander →]                          │
└─────────────────────────────────────────┘
```

---

### Page 4 — Forfaits + Bundles lancement

**Objectif:** Convertir. Le client choisit, paie, et a son compte prêt.

#### Forfaits réguliers

Affichage: PREMIUM → PRO → GRATUIT (comme actuellement)

Toggle mensuel/annuel.

**Changement:** "3 liens sociaux" pour le gratuit (déjà fait côté code).

#### Bundles de lancement (section spéciale)

Bandeau: "🚀 Offre de lancement — Places limitées"

```
┌────────────────┐  ┌────────────────┐  ┌────────────────┐
│   DÉCOUVERTE   │  │      PRO       │  │      DUO       │
│                │  │   POPULAIRE ⭐  │  │  MEILLEUR DEAL │
│ 1 carte NFC    │  │ 1 carte NFC    │  │ 2 cartes NFC   │
│ 3 mois Premium │  │ 1 profil extra │  │ 2 profils      │
│                │  │ 6 mois Premium │  │ 6 mois Premium │
│                │  │                │  │                │
│  74$ → 59.99$  │  │ 128$ → 99.99$  │  │ 208$ → 149.99$ │
│  Économisez 19%│  │ Économisez 22% │  │ Économisez 28% │
│                │  │                │  │                │
│ [Choisir →]    │  │ [Choisir →]    │  │ [Choisir →]    │
└────────────────┘  └────────────────┘  └────────────────┘

Après la période incluse:
- Premium continue à 8$/mois (annulable en tout temps)
- Profil(s) extra: 8$/mois chacun
- Cartes supplémentaires disponibles à l'achat
```

**Profil supplémentaire gratuit au lancement:**
Tous les premiers inscrits (ex: les 50 premiers, ou pendant les 3 premiers mois) reçoivent un **2e profil gratuit**. Ça crée le besoin de carte NFC supplémentaire = revenu.

Bannière: "🎁 En ce moment: 2e profil offert pour tout nouveau compte"

#### Flow inscription + forfait + paiement

```
1. Client clique "Choisir" sur un bundle
        ↓
2. Formulaire inscription (nom, email, mot de passe)
   + Formulaire adresse livraison (pour la carte NFC)
   + Résumé du bundle choisi
        ↓
3. Bouton "Payer et créer mon compte"
        ↓
4. Stripe Checkout (paiement unique pour le bundle)
        ↓
5. Compte créé automatiquement:
   - Plan Premium activé (durée selon bundle)
   - Profil(s) créé(s)
   - Commande carte NFC enregistrée
   - Email de bienvenue envoyé
        ↓
6. Redirect vers dashboard avec onboarding
```

**Technique:** Un seul checkout Stripe combine:
- Paiement unique du bundle (produit Stripe)
- Après la période: subscription automatique (Stripe subscription schedule)

---

### Page 5 — FAQ

**Objectif:** Répondre à TOUTE question avant qu'elle devienne un frein à l'achat.

**Organisation par catégories:**

#### Général
- **C'est quoi LinkCard?**
  LinkCard est votre carte de visite digitale. Créez un profil professionnel en ligne, partagez-le avec une carte NFC ou un QR Code, et bâtissez votre réseau de contacts.

- **Est-ce que c'est gratuit?**
  Oui! Le forfait gratuit inclut 1 profil avec 3 liens sociaux, 2 images et 1 section texte. Les forfaits Pro (5$/mois) et Premium (8$/mois) débloquent plus de contenu et de fonctionnalités.

- **Comment ça fonctionne?**
  Créez votre compte → Personnalisez votre profil → Partagez-le via votre lien, QR Code ou carte NFC. C'est aussi simple que ça.

- **Est-ce que je peux annuler en tout temps?**
  Absolument. Aucun engagement. Vous pouvez annuler votre abonnement à tout moment via votre tableau de bord. Votre compte reste actif en mode gratuit.

#### Carte NFC
- **C'est quoi une carte NFC?**
  C'est une carte physique avec une puce intégrée. Quand quelqu'un approche son téléphone de votre carte, votre profil LinkCard s'ouvre automatiquement. Pas d'application à installer, ça fonctionne nativement sur iPhone et Android.

- **Est-ce que ça fonctionne avec tous les téléphones?**
  Oui, tous les iPhone depuis le 7 (2016) et la grande majorité des Android supportent le NFC. C'est plus de 95% des téléphones en circulation.

- **Combien de temps pour recevoir ma carte?**
  5 à 7 jours ouvrables après le paiement. Vous recevrez un email avec un numéro de suivi dès l'expédition.

- **Est-ce que la carte fonctionne sans internet?**
  La carte elle-même n'a pas besoin de batterie ni d'internet. Par contre, le téléphone qui la scanne a besoin d'une connexion pour afficher votre profil.

- **Je peux changer mon profil sans changer de carte?**
  Oui! Votre carte contient un lien permanent. Vous pouvez modifier votre profil, changer de template, ou même assigner un profil différent à votre carte — tout ça sans jamais changer la carte physique.

- **Je peux avoir plusieurs cartes?**
  Oui, vous pouvez commander autant de cartes que vous voulez. Chaque carte peut pointer vers un profil différent si vous le souhaitez.

- **La carte est-elle résistante?**
  Oui, elle est en PVC rigide, comme une carte bancaire. Résistante à l'eau, aux égratignures et à l'usure quotidienne.

- **Est-ce que je peux avoir un design personnalisé?**
  Oui! L'option de design personnalisé vous permet d'ajouter votre logo. Disponible lors de la commande.

#### Profil & Fonctionnalités
- **Combien de profils puis-je avoir?**
  1 profil avec tous les forfaits. Profils supplémentaires disponibles à 5$/mois (Pro) ou 8$/mois (Premium). Offre de lancement: 2e profil offert!

- **Pourquoi avoir plusieurs profils?**
  Un profil personnel et un professionnel. Un pour votre entreprise et un pour vos projets personnels. Chaque profil a son propre lien et peut être assigné à une carte NFC différente.

- **Qu'est-ce qui change entre les forfaits?**
  Gratuit: l'essentiel (3 liens, 2 images, 1 texte). Pro: plus de contenu + QR Code + templates pro + URL personnalisée. Premium: le maximum + templates exclusifs + vidéo + carrousel.

- **Comment fonctionne le QR Code?**
  Un QR Code unique est généré pour votre profil. Partagez-le par email, dans vos présentations, ou affichez-le sur votre écran. Disponible avec Pro et Premium.

- **C'est quoi le username personnalisé?**
  Au lieu d'un code aléatoire (ex: app.linkcard.ca/AB3KX92P), vous choisissez votre propre adresse (ex: app.linkcard.ca/jean-tremblay). Disponible avec Pro et Premium.

- **Je peux changer mon template?**
  Oui, à tout moment. 3 templates gratuits, 4 supplémentaires avec Pro, 2 exclusifs avec Premium, et bientôt un mode 100% personnalisé.

#### Paiement & Abonnement
- **Quels moyens de paiement acceptez-vous?**
  Cartes Visa, Mastercard, American Express via Stripe, notre partenaire de paiement sécurisé.

- **Est-ce que mes paiements sont sécurisés?**
  Oui, tous les paiements passent par Stripe, certifié PCI DSS niveau 1. LinkCard ne stocke jamais vos informations de carte bancaire.

- **Que se passe-t-il si j'annule mon abonnement?**
  Votre compte passe automatiquement au forfait gratuit. Si vous aviez plus de contenu que ce que le gratuit permet, les sections excédentaires sont masquées (pas supprimées). Réabonnez-vous et tout revient!

- **Est-ce qu'il y a une politique de remboursement?**
  Oui. Consultez notre politique de remboursement complète [ici](/legal/refund). En résumé: les abonnements sont remboursables au prorata durant les 30 premiers jours. Les cartes NFC ne sont pas remboursables une fois imprimées.

- **Les prix incluent-ils les taxes?**
  Les taxes applicables (TPS/TVQ) sont ajoutées au moment du paiement, conformément aux lois du Québec.

#### Connexions & Réseau
- **Comment fonctionnent les connexions?**
  Quand quelqu'un scanne votre carte NFC ou QR Code, une demande de connexion est envoyée. Vous acceptez ou refusez. C'est un échange mutuel.

- **Est-ce que les gens qui scannent ma carte voient mon email/téléphone?**
  Seulement les informations que vous avez choisi de rendre visibles sur votre profil. Vous contrôlez tout.

#### Confidentialité & Sécurité
- **Qu'est-ce que vous faites avec mes données?**
  Vos données vous appartiennent. On ne les vend pas, on ne les partage pas avec des tiers. Consultez notre politique de confidentialité pour tous les détails.

- **Est-ce que LinkCard est conforme à la Loi 25 du Québec?**
  Oui. LinkCard est conforme à la Loi 25 du Québec et à la LPRPDE fédérale. Vos données sont hébergées au Canada.

- **Je peux supprimer mon compte?**
  Vous pouvez réinitialiser votre profil à tout moment. Pour une suppression complète de votre compte et de toutes vos données, contactez-nous.

#### Support
- **Comment vous contacter?**
  Via notre page de contact ou par email à support@linkcard.ca. Nous répondons habituellement en moins de 24 heures.

- **J'ai un problème avec ma carte NFC.**
  Contactez-nous. Si votre carte est défectueuse, nous la remplacerons gratuitement.

---

### Page 6 — Contact

**Structure:**

```
┌─────────────────────────────────────────┐
│  "Une question? On est là."             │
│                                          │
│  ┌──────────────────┐  ┌──────────────┐ │
│  │ Formulaire       │  │ Infos directes│ │
│  │                  │  │              │ │
│  │ Nom              │  │ 📧 Email:    │ │
│  │ Email            │  │ support@     │ │
│  │ Sujet ▼          │  │ linkcard.ca  │ │
│  │ - Question       │  │              │ │
│  │ - Problème tech. │  │ 📍 Basé au   │ │
│  │ - Partenariat    │  │ Québec, CA   │ │
│  │ - Autre          │  │              │ │
│  │ Message          │  │ ⏰ Réponse   │ │
│  │                  │  │ sous 24h     │ │
│  │ [Envoyer →]      │  │              │ │
│  └──────────────────┘  └──────────────┘ │
└─────────────────────────────────────────┘
```

**Technique:**
- Formulaire → envoi email via Mailgun à support@linkcard.ca
- Sauvegarde en DB (table `contact_messages`) pour historique
- Confirmation email automatique au client
- Rate limiting: max 3 messages/heure par IP

**Table `contact_messages`:**
```sql
CREATE TABLE contact_messages (
    id BIGINT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255),
    subject VARCHAR(50),
    message TEXT,
    ip_address VARCHAR(45),
    is_read BOOLEAN DEFAULT false,
    replied_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

### Page 7 — À propos

**Structure courte et authentique:**
- L'histoire de LinkCard (pourquoi ça existe)
- La mission ("Transformer chaque rencontre en connexion durable")
- Basé au Québec, fabriqué au Québec
- Photo/nom du fondateur (optionnel mais pro)

---

### Design Landing — Directives

**Basé sur le brand book:**
- Police: Manrope (toutes les pages)
- Couleur principale: #42B574 (CTAs, accents)
- Fond: #F7F8F4 (blanc cassé LinkCard)
- Texte: #2C2A27 (gris foncé)
- Cards: blanc pur (#FFFFFF) avec shadow-md, radius 12px
- Pas de noir pur, pas de Font Awesome
- Icônes SVG inline
- Espacement généreux (brand = "respiration")
- Mobile-first (60%+ du trafic sera mobile)

**Animations subtiles:**
- Fade-in au scroll (sections apparaissent progressivement)
- Hover effects sur les cards de forfaits
- Animation carte NFC (tap → profil) sur la page dédiée

---

## 2. BUILD TAILWIND PRODUCTION

### Quoi
Remplacer le CDN Tailwind (~300KB) par un CSS compilé contenant uniquement les classes utilisées (~15-20KB).

### Quand
**En dernier.** Après que tout le code est stable et la landing page terminée.

### Comment
```bash
# 1. Installer Tailwind (localement ou en CI)
npm install -D tailwindcss

# 2. Configurer tailwind.config.js
# content: tous les fichiers blade + js

# 3. Compiler
npx tailwindcss -i ./resources/css/app.css -o ./public/css/app.min.css --minify

# 4. Remplacer le CDN par le fichier local dans les layouts

# 5. Commit + push le CSS compilé
```

### Impact
- Si on ajoute une nouvelle classe Tailwind après → recompiler (1 commande)
- Script dans package.json pour automatiser
- Le CSS compilé est commité dans le repo (pas besoin de npm sur le serveur WHC)

### Après chaque modification
```bash
npm run build:css  # Recompile le CSS
git add -A && git commit -m "rebuild css" && git push origin main
```

---

## 3. TESTS AUTOMATISÉS

### Priorité de test (par risque)

| Priorité | Quoi | Pourquoi |
|----------|------|----------|
| 🔴 P1 | Webhooks Stripe | Touche à l'argent |
| 🔴 P1 | PlanLimitsService | Masquage contenu = frustration client |
| 🟠 P2 | Auth (login/register) | Bloque l'accès si cassé |
| 🟠 P2 | Redirect carte NFC | Bloque l'expérience carte |
| 🟡 P3 | Connexions | Important mais pas critique |
| 🟡 P3 | Profil public | Visible par tous |

### Tests P1 — Stripe (exemples concrets)

```php
// Test: Webhook subscription.created met bien le plan à jour
public function test_webhook_creates_pro_subscription()
{
    $user = User::factory()->create(['plan' => 'free']);
    
    // Simuler webhook Stripe avec prix PRO
    $payload = $this->buildWebhookPayload('customer.subscription.created', [
        'price_id' => 'price_1StJ36J8RoOvVTJ7cQNB0GyY' // PRO monthly
    ]);
    
    $this->postJson('/stripe/webhook', $payload);
    
    $this->assertEquals('pro', $user->fresh()->plan);
}

// Test: Downgrade masque le contenu excédentaire
public function test_downgrade_hides_excess_content()
{
    $user = User::factory()->create(['plan' => 'premium']);
    $profile = Profile::factory()->for($user)->create();
    
    // Créer 8 liens sociaux (Premium permet 10)
    for ($i = 0; $i < 8; $i++) {
        ContentBand::factory()->socialLink()->for($profile)->create();
    }
    
    // Downgrade vers free (limite: 3)
    $user->update(['plan' => 'free']);
    PlanLimitsService::applyLimitsOnDowngrade($user);
    
    // 3 visibles, 5 masqués
    $this->assertEquals(3, $profile->contentBands()->visible()->count());
    $this->assertEquals(5, $profile->contentBands()->hidden()->count());
}
```

### Tests P2 — Auth & Cartes

```php
// Test: Carte NFC redirige vers le bon profil
public function test_card_redirects_to_profile()
{
    $profile = Profile::factory()->create(['username' => 'jeantest']);
    $card = Card::factory()->create([
        'card_code' => 'ABC123XY',
        'profile_id' => $profile->id,
        'is_active' => true,
    ]);
    
    $response = $this->get('/c/ABC123XY');
    
    $response->assertRedirect('/jeantest');
}

// Test: Carte désactivée retourne 404
public function test_inactive_card_returns_404()
{
    Card::factory()->create([
        'card_code' => 'DEAD0000',
        'is_active' => false,
    ]);
    
    $response = $this->get('/c/DEAD0000');
    
    $response->assertStatus(404);
}

// Test: Inscription avec email invalide échoue
public function test_register_rejects_invalid_email()
{
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'pas-un-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
    
    $response->assertSessionHasErrors('email');
}
```

### Commande pour rouler les tests
```bash
php artisan test                    # Tous les tests
php artisan test --filter=Stripe    # Juste Stripe
php artisan test --filter=Card      # Juste cartes NFC
```

---

## 4. ONBOARDING GUIDÉ (Option C: Modal + Checklist)

### Modal de bienvenue (première connexion)

**Déclencheur:** User se connecte ET `onboarding_completed_at IS NULL` dans la table users.

**3 slides:**

```
Slide 1:
┌─────────────────────────────┐
│  [Logo LinkCard]            │
│                             │
│  "Bienvenue sur LinkCard!"  │
│                             │
│  Votre profil digital       │
│  professionnel est prêt     │
│  à être créé.               │
│                             │
│  On vous guide en           │
│  3 étapes simples.          │
│                             │
│           ● ○ ○             │
│       [Suivant →]           │
└─────────────────────────────┘

Slide 2:
┌─────────────────────────────┐
│  [Capture éditeur]          │
│                             │
│  "Personnalisez votre       │
│   profil"                   │
│                             │
│  Ajoutez votre photo,       │
│  vos infos et vos liens     │
│  sociaux. Choisissez un     │
│  template qui vous          │
│  ressemble.                 │
│                             │
│           ○ ● ○             │
│   [← Retour]  [Suivant →]  │
└─────────────────────────────┘

Slide 3:
┌─────────────────────────────┐
│  [Image carte NFC]          │
│                             │
│  "Connectez en personne"    │
│                             │
│  Commandez votre carte NFC  │
│  et partagez votre profil   │
│  d'un simple geste.         │
│                             │
│           ○ ○ ●             │
│   [← Retour]  [Commencer!] │
└─────────────────────────────┘
```

**"Commencer!" → ferme le modal, affiche la checklist.**

### Checklist persistante

**Position:** Bandeau en haut du dashboard (au-dessus du contenu, sous la nav).
**Disparaît:** Quand tout est complété OU clic "Masquer" (mais revient si incomplet au prochain login).

```
┌─────────────────────────────────────────────────────────┐
│  🚀 Complétez votre profil                    2/5 ✓    │
│  ━━━━━━━━━━━━━━░░░░░░░░░░░░░░░░░░░ 40%                │
│                                                         │
│  ✅ Créer votre compte                                  │
│  ✅ Vérifier votre email                                │
│  ⬜ Ajouter votre photo          [→ Modifier profil]    │
│  ⬜ Ajouter un lien social       [→ Modifier profil]    │
│  ⬜ Partager votre profil        [→ Voir mon profil]    │
│                                                         │
│  [Masquer pour l'instant]                               │
└─────────────────────────────────────────────────────────┘
```

### Table migration

```sql
ALTER TABLE users ADD COLUMN onboarding_completed_at TIMESTAMP NULL;
ALTER TABLE users ADD COLUMN onboarding_dismissed_at TIMESTAMP NULL;
```

### Logique de vérification

```php
// OnboardingService.php
public static function getSteps(User $user): array
{
    $profile = $user->profiles()->first();
    
    return [
        [
            'key' => 'account',
            'label' => 'Créer votre compte',
            'completed' => true, // Toujours vrai si on est ici
        ],
        [
            'key' => 'email_verified',
            'label' => 'Vérifier votre email',
            'completed' => $user->email_verified_at !== null,
            'action' => route('verification.notice'),
        ],
        [
            'key' => 'photo',
            'label' => 'Ajouter votre photo',
            'completed' => $profile && $profile->photo_path !== null,
            'action' => route('profile.edit', $profile),
        ],
        [
            'key' => 'social_link',
            'label' => 'Ajouter un lien social',
            'completed' => $profile && $profile->contentBands()
                ->where('type', 'social_link')->exists(),
            'action' => route('profile.edit', $profile),
        ],
        [
            'key' => 'shared',
            'label' => 'Partager votre profil',
            'completed' => $profile && $profile->view_count > 0,
            'action' => route('profile.public', $profile->username ?? ''),
        ],
    ];
}
```

---

## 5. ANALYTICS PAR PLAN

### Segmentation

| Fonctionnalité | Gratuit | Pro | Premium |
|---|---|---|---|
| Vues totales (chiffre) | ✅ | ✅ | ✅ |
| Vues par jour (graphe 30j) | ❌ | ✅ | ✅ |
| Clics par lien social | ❌ | ✅ | ✅ |
| Top liens (classement) | ❌ | ✅ | ✅ |
| Source de visite (NFC/QR/direct) | ❌ | ✅ | ✅ |
| Géolocalisation (ville/pays) | ❌ | ❌ | ✅ |
| Type d'appareil (mobile/desktop) | ❌ | ❌ | ✅ |
| Heures de pointe | ❌ | ❌ | ✅ |
| Taux de conversion (clic/vue) | ❌ | ❌ | ✅ |
| Export CSV | ❌ | ❌ | ✅ |

### Données à collecter (enrichir ProfileView et LinkClick)

```sql
-- Enrichir profile_views existant
ALTER TABLE profile_views ADD COLUMN source ENUM('direct','nfc','qr','link') DEFAULT 'direct';
ALTER TABLE profile_views ADD COLUMN country VARCHAR(2) NULL;
ALTER TABLE profile_views ADD COLUMN city VARCHAR(100) NULL;
ALTER TABLE profile_views ADD COLUMN device_type ENUM('mobile','desktop','tablet') NULL;
ALTER TABLE profile_views ADD COLUMN browser VARCHAR(50) NULL;

-- Enrichir link_clicks existant
ALTER TABLE link_clicks ADD COLUMN referrer_source ENUM('direct','nfc','qr','link') NULL;
```

### Comment détecter la source

```php
// Dans ProfileController@show ou middleware
$source = 'direct';

$referer = $request->header('referer');
$utmSource = $request->query('src');

if ($utmSource === 'nfc' || $request->query('nfc')) {
    $source = 'nfc';  // Carte NFC ajoute ?src=nfc à l'URL
} elseif ($utmSource === 'qr') {
    $source = 'qr';   // QR Code ajoute ?src=qr
} elseif ($referer) {
    $source = 'link';  // Vient d'un autre site
}
```

### Comment détecter géolocalisation

Deux options:
1. **GeoIP gratuit** — MaxMind GeoLite2 (base locale, gratuit, ~60MB)
2. **Service externe** — ip-api.com (gratuit jusqu'à 1000 req/jour)

**Recommandation:** MaxMind GeoLite2 car pas de dépendance externe et conforme Loi 25 (données restent locales).

```bash
composer require geoip2/geoip2
# Télécharger la base GeoLite2-City.mmdb
```

### Dashboard Stats (page existante enrichie)

**Vue Gratuit:**
```
┌──────────────────┐
│  Vues totales    │
│     147          │
│                  │
│  🔒 Débloquez    │
│  les stats       │
│  détaillées      │
│  avec Pro        │
│  [Voir forfaits] │
└──────────────────┘
```

**Vue Pro:**
```
┌────────────────────────────────────────┐
│  Vues: 147 (+12 cette semaine)         │
│  ▁▂▃▅▇▆▄▃▅▇█▅▃▂▁▂▃▄▅▆▅▃▂▁▃▄▅▆▇      │
│  ← 30 derniers jours                   │
├────────────────────────────────────────┤
│  Top liens                             │
│  1. LinkedIn ████████████ 45 clics     │
│  2. Instagram ██████ 23 clics          │
│  3. Site web ███ 12 clics              │
├────────────────────────────────────────┤
│  Sources                               │
│  NFC: 40% │ QR: 25% │ Direct: 35%     │
├────────────────────────────────────────┤
│  🔒 Géolocalisation, appareils,        │
│  heures de pointe → avec Premium       │
└────────────────────────────────────────┘
```

**Vue Premium:** Tout ce qui est au-dessus + géo, appareils, heures, conversion, export.

### Futur add-on stats (post-lancement, 6-12 mois)

Quand la base de clients est suffisante, possibilité d'un **forfait "Business"** ou add-on analytics:
- Analytics temps réel
- Rapports automatiques par email (hebdo/mensuel)
- Comparaison périodes
- Benchmarking vs moyenne de l'industrie
- API accès stats

Prix à déterminer selon la demande. Ne pas lancer avant d'avoir des données d'usage réelles.

---

## 6. NETTOYAGE STORAGE (SÉCURITAIRE)

### Commande artisan

```bash
# Mode aperçu (ne supprime RIEN)
php artisan storage:cleanup --dry-run

# Mode déplacement (déplace vers storage/orphans/)
php artisan storage:cleanup

# Mode suppression (seulement si confiant)
php artisan storage:cleanup --force
```

### Sortie du dry-run (ce que tu verras)

```
=== LinkCard Storage Cleanup ===
Mode: APERÇU (rien ne sera modifié)

Scanning storage/app/public/profiles/...

ORPHELINS TROUVÉS: 3 fichiers (2.4 MB)

┌──────┬────────────────────────────────┬────────┬─────────────┬──────────────────────┐
│  #   │ Fichier                        │ Taille │ Type        │ Raison               │
├──────┼────────────────────────────────┼────────┼─────────────┼──────────────────────┤
│  1   │ profiles/5/photo_old.jpg       │ 845 KB │ Photo       │ Profil #5 n'a plus   │
│      │                                │        │ profil      │ ce chemin en DB      │
│  2   │ profiles/2/img_temp_abc.jpg    │ 1.2 MB │ Image       │ Aucune bande ne      │
│      │                                │        │ section     │ référence ce fichier │
│  3   │ card-logos/order_99_logo.png   │ 350 KB │ Logo        │ Commande #99         │
│      │                                │        │ commande    │ n'existe plus        │
└──────┴────────────────────────────────┴────────┴─────────────┴──────────────────────┘

Pour déplacer ces fichiers vers storage/orphans/:
  php artisan storage:cleanup

Pour supprimer définitivement:
  php artisan storage:cleanup --force
```

### Logique de détection

```php
// Un fichier est "orphelin" si:
// 1. Photo profil → aucun Profile n'a ce photo_path
// 2. Image section → aucun ContentBand n'a ce path dans son JSON
// 3. Logo commande → aucun CardOrder n'a ce logo_path
// 4. Fichier temp → nom contient "tmp" ou "livewire-tmp"

// Un fichier N'EST PAS orphelin si:
// 1. Il est référencé quelque part en DB
// 2. Il a moins de 24h (peut être en cours d'upload)
// 3. C'est un fichier système (.gitkeep, etc.)
```

### Dossier orphans

```
storage/app/orphans/
├── 2026-02-10/           ← Date du nettoyage
│   ├── profiles_5_photo_old.jpg
│   ├── profiles_2_img_temp_abc.jpg
│   └── card-logos_order_99_logo.png
└── cleanup_log.json      ← Historique de tout ce qui a été déplacé
```

Si après 30 jours rien ne manque → `rm -rf storage/app/orphans/2026-02-10/`

---

## RÉSUMÉ CHRONOLOGIQUE

```
Semaine 1-2: Landing page (accueil + fonctionnalités + carte NFC)
Semaine 2-3: Landing page (forfaits + bundles + FAQ + contact + à propos)
Semaine 3:   Onboarding (modal + checklist)
Semaine 3-4: Analytics par plan (enrichir DB + dashboard stats)
Semaine 4:   Tests automatisés (Stripe + plans + cartes)
Semaine 4:   Storage cleanup (commande artisan)
Semaine 4:   Build Tailwind (compilation finale)

→ Prêt pour BETA
```

---

## QUESTIONS OUVERTES

1. **Visuels landing page:** As-tu des photos/renders de la carte NFC physique? Sinon, il faudra en créer (mockup 3D ou photo réelle).
2. **Bundles Stripe:** Les bundles combinent paiement unique + subscription. Il faut vérifier que Stripe Checkout supporte ce flow ou utiliser Stripe Payment Links.
3. **Profil gratuit #2 au lancement:** Combien de temps dure l'offre? (30 jours? 50 premiers inscrits? Permanent?)
4. **Géolocalisation:** MaxMind GeoLite2 nécessite un compte gratuit + mise à jour mensuelle de la DB. OK pour toi?
5. **Délai livraison cartes:** Tu confirmes 5-7 jours ouvrables?
6. **Email support:** support@linkcard.ca est déjà configuré dans Mailgun?
