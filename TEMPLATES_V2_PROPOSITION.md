# TEMPLATES V2 — PROPOSITION COMPLÈTE

**Date:** 17 février 2026
**Statut:** BRAINSTORM — À valider avant de coder

---

## LE PROBLÈME

Actuellement, un "template" change le **header** (la forme du haut). En dessous, tous les profils sont identiques : fond blanc, boutons pareils, même typo, même style de cartes. Résultat : le "wow" dure 2 secondes puis disparaît.

## LA SOLUTION

Chaque template devient un **système visuel complet** qui contrôle TOUT le profil de haut en bas :

| Propriété | Actuellement | V2 |
|---|---|---|
| Header (forme/gradient) | ✅ Différent par template | ✅ Gardé |
| Transition | ✅ Différent par template | ✅ Gardé |
| Photo style | ✅ Différent par template | ✅ Gardé |
| **Fond du profil** | ❌ Toujours blanc | ✅ Unique par template |
| **Style des boutons** | ❌ Toujours pareil | ✅ Couleur + forme + effet |
| **Style des cartes/sections** | ❌ Toujours fond gris | ✅ Fond, bordure, ombre, radius |
| **Typo** | ❌ Toujours Manrope | ✅ Police par mood |
| **Couleur du texte** | ❌ Toujours noir | ✅ Adapté au fond |
| **Style des liens sociaux** | ✅ pills/circles/list | ✅ Gardé + couleurs adaptées |
| **Ambiance globale** | ❌ Aucune | ✅ Mood cohérent partout |

---

## NOUVELLES PROPRIÉTÉS PAR TEMPLATE

```php
'body_bg' => '#FFFFFF',           // Fond du profil entier
'body_text' => '#2C2A27',         // Couleur texte principal
'card_bg' => '#F9FAFB',           // Fond des sections/cartes
'card_border' => '#E5E7EB',       // Bordure des cartes
'card_radius' => '12px',          // Rayon des cartes
'card_shadow' => 'sm',            // none, sm, md, lg, glow
'button_bg' => 'secondary',       // Couleur bouton (secondary = couleur secondaire du user)
'button_text' => '#FFFFFF',       // Texte bouton
'button_effect' => 'shadow',      // shadow, glow, outline, glass, none
'font' => 'Manrope',              // Police du template
'social_icon_color' => 'brand',   // brand (couleur officielle) | mono-light | mono-dark | accent
'accent_color' => null,           // Couleur accent fixe (null = suit primary du user)
```

---

## LES TEMPLATES PROPOSÉS

### Catégorisation

**GRATUIT (3)** — Essentiels, propres, fonctionnels
**PRO (6)** — Identités marquées, visuellement distinctes
**PREMIUM (3)** — Expériences uniques, wow factor maximum
**SPÉCIALISÉS (3)** — Widgets spéciaux (vidéo, galerie, CTA) — PRO+
**CUSTOM (1)** — Liberté totale — PREMIUM

**Total : 16 templates**

---

### 🟢 GRATUIT — "Les Essentiels"

#### T1 : Classique (classic)
> *Le standard professionnel. Propre, fiable, pour tout le monde.*

- **Header :** Gradient vertical doux
- **Transition :** Aucune (coupe nette)
- **Fond profil :** Blanc (#FFFFFF)
- **Cartes :** Fond gris clair, bordure subtile, radius 12px
- **Boutons :** Couleur secondaire, arrondis, ombre légère
- **Typo :** Manrope
- **Social :** Pills (badges avec nom)
- **Photo :** Ronde centrée
- **Mood :** "Carte de visite digitale" — pas de wow, juste fiable

#### T2 : Vague (wave)
> *L'original LinkCard. Mouvement vivant, 4 vagues parallax.*

- **Header :** Gradient diagonal + 4 vagues animées
- **Transition :** Double wave parallax
- **Fond profil :** Blanc cassé (#F7F8F4)
- **Cartes :** Fond blanc, ombre douce, radius 16px
- **Boutons :** Couleur secondaire, très arrondis (24px), ombre
- **Typo :** Manrope
- **Social :** Pills
- **Photo :** Ronde centrée
- **Mood :** "Fluide et vivant" — le profil de Marie-Pier en est la preuve

#### T3 : Épuré (minimal)
> *Presque rien. Le contenu parle de lui-même.*

- **Header :** Barre accent 5px + fond quasi-blanc teinté
- **Transition :** Aucune
- **Fond profil :** Blanc pur (#FFFFFF)
- **Cartes :** Pas de fond, juste une ligne de séparation fine
- **Boutons :** Outline seulement (transparent + bordure), compact
- **Typo :** Manrope
- **Social :** Cercles (icônes seulement, petits)
- **Photo :** Ronde avec ombre colorée
- **Mood :** "Galerie blanche" — maximum de respiration

---

### 🔵 PRO — "Les Identités"

#### T4 : Élan (diagonal)
> *Dynamique, audacieux, en mouvement constant.*

- **Header :** Gradient diagonal 135°
- **Transition :** Diagonale
- **Fond profil :** Gris très clair (#F8F9FA)
- **Cartes :** Fond blanc, ombre nette, radius 8px (plus carré)
- **Boutons :** Couleur primaire, carrés (radius 8px), ombre portée
- **Typo :** Manrope semi-bold
- **Social :** Pills
- **Photo :** Ronde centrée
- **Mood :** "Startup qui bouge" — énergie corporate

#### T5 : Arche (arch)
> *Élégant, organique. Courbes douces et cercles flottants.*

- **Header :** Gradient radial avec cercles décoratifs
- **Transition :** Arche (ellipse douce)
- **Fond profil :** Crème très subtil (#FEFDFB)
- **Cartes :** Fond blanc, bordure couleur primaire très diluée, radius 20px
- **Boutons :** Couleur secondaire, très arrondis, léger glow
- **Typo :** ??? (voir question police plus bas)
- **Social :** Cercles
- **Photo :** Ronde centrée
- **Mood :** "Spa haut de gamme" — douceur premium

#### T6 : Duo (split)
> *Corporate structuré. Photo gauche, infos droite.*

- **Header :** Layout 2 colonnes (38/62)
- **Transition :** Vague
- **Fond profil :** Blanc (#FFFFFF)
- **Cartes :** Fond gris, bordure gauche accent 3px, radius 8px
- **Boutons :** Couleur secondaire, carrés, pas d'effet
- **Typo :** Manrope
- **Social :** Pills (pleine largeur, style LinkedIn)
- **Photo :** Dans le header à gauche
- **Mood :** "CV en ligne" — hyper structuré

#### T7 : Vitrine (banner)
> *Style réseau social. Bannière + photo qui déborde.*

- **Header :** Bannière courte 120px + photo overlap
- **Transition :** Au choix (dans le header)
- **Fond profil :** Blanc (#FFFFFF)
- **Cartes :** Fond blanc, ombre portée md, radius 16px
- **Boutons :** Couleur primaire, arrondis, ombre
- **Typo :** Manrope
- **Social :** Cercles (style réseau social)
- **Photo :** Ronde débordante
- **Mood :** "Profil Instagram/LinkedIn" — familier et pro

#### T8 : Néon (NEW — remplace geometric)
> *Effet lumineux sur fond sombre. Le profil qui brille.*

- **Header :** Gradient sombre vers la couleur primaire (glow)
- **Transition :** Vague (avec couleurs néon transparentes)
- **Fond profil :** Noir bleuté (#0F0F1A)
- **Cartes :** Fond transparent/dark glass, bordure néon (couleur primaire à 30%), radius 16px, **glow effect** sur hover
- **Boutons :** Transparent + bordure néon + glow, texte clair
- **Typo :** Manrope (ou mono?)
- **Social :** Cercles avec glow couleur primaire
- **Photo :** Ronde avec anneau néon (glow)
- **Mood :** "Gaming/Tech/Night" — le profil de Marie-Pier mais poussé à fond
- **Note :** C'est le "Cyber-Stream" de ton document, adapté pour être utilisable par tout le monde (pas juste les gamers)

#### T9 : Luxe (NEW — remplace bold, intègre "Midnight Gold")
> *Mode sombre premium. Élégance absolue.*

- **Header :** Fond noir profond (#1A1A2E) + accent doré/couleur primaire
- **Transition :** Aucune (coupe nette = luxe)
- **Fond profil :** Anthracite (#1E1E2E)
- **Cartes :** Fond légèrement plus clair (#2A2A3E), bordure fine dorée/accent, radius 12px
- **Boutons :** Fond doré/couleur primaire, texte noir, effet "shimmer" subtil
- **Typo :** ??? (Serif pour le luxe? Voir question plus bas)
- **Social :** Liste détaillée, icônes en couleur accent
- **Photo :** Ronde avec anneau fin doré/accent
- **Mood :** "Bijouterie Tiffany" — premium business, VIP
- **Note :** Fusionne l'ancien "Bold/Contraste" et le "Midnight Gold" du document

---

### 👑 PREMIUM — "Les Expériences"

#### T10 : Glass (NEW — "Glassmorphism")
> *Style Apple/iOS. Tout est translucide et flou.*

- **Header :** Gradient coloré vif
- **Transition :** Arche
- **Fond profil :** Gradient doux (couleur primaire → secondaire, très dilué ~10%)
- **Cartes :** **Glass effect** — fond blanc 20% opacité + backdrop-blur 12px, bordure blanche 30%, radius 20px
- **Boutons :** Glass effect aussi, texte foncé
- **Typo :** Manrope
- **Social :** Pills glass
- **Photo :** Ronde avec ombre portée colorée floue
- **Mood :** "Interface Apple" — moderne, premium, futuriste
- **Note :** Le backdrop-filter est supporté par 97%+ des browsers modernes

#### T11 : Prisme (geometric — amélioré)
> *Formes abstraites, géométrie, tech/design.*

- **Header :** Gradient + formes géométriques animées lentes
- **Transition :** Chevron
- **Fond profil :** Gris froid (#F0F2F5)
- **Cartes :** Fond blanc, **bordure gauche 4px couleur primaire**, radius 4px (très carré)
- **Boutons :** Couleur primaire, carrés (0 radius), ombre portée nette (pas floue)
- **Typo :** Manrope (ou JetBrains Mono pour le côté tech?)
- **Social :** Liste détaillée (style dashboard)
- **Photo :** Carrée arrondie (seul template photo carrée)
- **Mood :** "Dashboard tech" — développeur, designer, ingénieur

#### T12 : Canvas (custom — amélioré)
> *100% personnalisable. Mix & match tout.*

- **Tout est configurable :**
  - Header style (tous les 11)
  - Transition (toutes les 6)
  - Photo style
  - Social style
  - Button style
  - Fond du profil (clair ou sombre)
  - Style des cartes
  - Police
- **Mood :** "C'est VOTRE mood"
- **Features :** Toutes (vidéo, carrousel, CTA)

---

### 🎯 SPÉCIALISÉS — "Les Métiers" (PRO+)

#### T13 : Vidéaste (videaste)
> *Créateur vidéo. La vidéo est la star.*

- **Reprend le style de :** Néon (T8) — fond sombre cinématique
- **Header :** Particules animées + gradient sombre
- **Fond profil :** Noir (#0F0F1A)
- **Widget spécial :** video_embed en vedette
- **Cartes :** Dark glass
- **Mood :** "Écran de cinéma" — le profil EST un écran

#### T14 : Artiste (artiste)
> *Portfolio visuel. Les images sont la star.*

- **Reprend le style de :** Épuré (T3) — fond blanc maximal
- **Header :** Formes organiques abstraites (blobs)
- **Fond profil :** Blanc pur (#FFFFFF)
- **Widget spécial :** image_carousel galerie swipe
- **Cartes :** Sans fond, images bord à bord
- **Mood :** "Galerie d'art" — rien ne distrait des images

#### T15 : Entrepreneur (entrepreneur)
> *Conversion. Chaque pixel pousse vers l'action.*

- **Reprend le style de :** Élan (T4) — dynamique et structuré
- **Header :** Business accent lines + logo secondaire
- **Fond profil :** Blanc (#FFFFFF)
- **Widget spécial :** cta_button pleine largeur (titre + sous-titre + icône)
- **Cartes :** Fond blanc, ombre forte, radius 8px
- **Boutons :** GROS, pleine largeur, couleur primaire vive
- **Mood :** "Landing page" — tout est un funnel

---

## QUESTIONS À TRANCHER AVANT DE CODER

### 1. Polices différentes par template?

**Option A : Manrope partout** (simple, rapide, cohérent)
- Avantage : Pas de chargement extra, brand LinkCard uniforme
- Inconvénient : Tous les profils ont la même "voix" typographique

**Option B : 3-4 polices max** (ex: Manrope, une Serif, une Mono)
- Manrope → Classique, Vague, Élan, Duo, Vitrine, Épuré, Artiste
- Serif (Playfair Display?) → Arche, Luxe, Glass
- Mono (JetBrains Mono?) → Néon, Prisme, Vidéaste
- Custom → L'utilisateur choisit parmi les 3

**Option C : Plus de polices** (grosse variété)
- Risque : Performance, testing, combinaisons imprévisibles

**Ma recommandation :** Option B. 3 polices = 3 moods distincts sans exploser la complexité.

### 2. Couleurs fixes vs couleurs du client?

Certains templates (Néon, Luxe) ont des fonds sombres fixes. La couleur du client (primary/secondary) devrait-elle :

**Option A :** Devenir la couleur d'ACCENT sur le template (bordures néon, boutons, icônes)
**Option B :** Être ignorée — le template a ses propres couleurs fixes

**Ma recommandation :** Option A. Le client garde le contrôle de SA couleur, mais le template décide comment elle est utilisée (accent vs fond vs texte).

### 3. Les templates existants — on garde le nom?

Certains templates changent beaucoup de personnalité. Proposition :
- "Geometric" → "Prisme" (même nom, mais visuellement différent)
- "Bold" → **SUPPRIMÉ**, remplacé par "Luxe" (plus premium)
- NOUVEAU : "Néon" et "Glass"

### 4. Le profil de Marie-Pier (screenshot)

Ce profil utilise quel template actuellement? Wave? Custom? Je veux comprendre pourquoi il est déjà "beau" — c'est probablement grâce au choix de couleurs (violet/magenta vif). Ça veut dire que la couleur fait 80% du wow et le template fait 20%. Donc les templates doivent amplifier le choix de couleur, pas le remplacer.

### 5. Combien de templates au lancement bêta?

**Option A :** Les 16 (complet mais long à développer)
**Option B :** 10-12 essentiels + le reste après feedback bêta
**Option C :** Prioriser les 3-4 templates les plus "wow" d'abord, puis compléter

**Ma recommandation :** Option B. Lancer avec les essentiels solides, ajouter Néon/Glass/Luxe comme "wow" d'upgrade, et finir le reste selon le feedback.

### 6. Le template Custom (#12)

Actuellement il permet de choisir header/transition/photo/social/button. Avec V2, il devrait aussi permettre :
- Choisir fond clair ou sombre
- Choisir la police (parmi les 3)
- Choisir le style de cartes

C'est faisable mais c'est plus de UI dans l'éditeur. OK pour toi?

---

## ORDRE D'IMPLÉMENTATION SUGGÉRÉ

### Phase 1 : Infrastructure (1-2 jours)
- Ajouter les nouvelles propriétés dans TemplateService
- Modifier show.blade.php pour utiliser body_bg, card_bg, etc. du template
- Modifier preview.blade.php pareil
- Tester avec les templates existants (doit rien casser)

### Phase 2 : Templates existants améliorés (2-3 jours)
- Classic, Wave, Épuré → Ajuster les nouvelles props de body
- Élan, Arche, Duo, Vitrine → Pareil
- Prisme → Refonte visuelle complète

### Phase 3 : Nouveaux templates (3-5 jours)
- Néon (le plus impactant visuellement)
- Luxe (le plus premium)
- Glass (le plus moderne)

### Phase 4 : Spécialisés + Custom (2-3 jours)
- Vidéaste, Artiste, Entrepreneur → Héritent du style de leur template parent
- Custom → Ajouter les nouveaux contrôles

### Phase 5 : Polish (1-2 jours)
- Thumbnails/aperçus dans le sélecteur de templates
- Transitions fluides quand on change de template
- Tests sur mobile

**Estimation totale : 10-15 jours**

---

## RÉSUMÉ VISUEL RAPIDE

| # | Template | Fond | Mood | Plan |
|---|----------|------|------|------|
| 1 | Classique | Blanc | Pro fiable | FREE |
| 2 | Vague | Blanc cassé | Vivant | FREE |
| 3 | Épuré | Blanc pur | Galerie blanche | FREE |
| 4 | Élan | Gris clair | Startup | PRO |
| 5 | Arche | Crème | Spa premium | PRO |
| 6 | Duo | Blanc | CV structuré | PRO |
| 7 | Vitrine | Blanc | Réseau social | PRO |
| 8 | **Néon** | **Noir** | **Tech/Night** | **PRO** |
| 9 | **Luxe** | **Anthracite** | **VIP** | **PRO** |
| 10 | **Glass** | **Gradient dilué** | **Apple/iOS** | **PREMIUM** |
| 11 | Prisme | Gris froid | Dashboard tech | PREMIUM |
| 12 | Canvas | Au choix | Custom | PREMIUM |
| 13 | Vidéaste | Noir | Cinéma | PRO (spé) |
| 14 | Artiste | Blanc pur | Galerie d'art | PRO (spé) |
| 15 | Entrepreneur | Blanc | Landing page | PRO (spé) |
