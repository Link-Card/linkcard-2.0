@extends('layouts.legal')

@section('title', "Conditions d'utilisation")
@section('date', '8 février 2026')

@section('content')

<h2>1. Acceptation des conditions</h2>
<p>En créant un compte ou en utilisant les services de Link-Card (« la Plateforme »), exploitée par Link-Card inc., vous acceptez d'être lié par les présentes conditions d'utilisation (« Conditions »). Si vous n'acceptez pas ces Conditions, vous ne devez pas utiliser la Plateforme.</p>
<p>Link-Card se réserve le droit de modifier ces Conditions à tout moment. Les modifications prennent effet dès leur publication. L'utilisation continue de la Plateforme après modification constitue une acceptation des nouvelles Conditions.</p>

<h2>2. Description du service</h2>
<p>Link-Card est une plateforme de cartes de visite numériques permettant aux utilisateurs de créer des profils professionnels en ligne, de les partager via des liens, codes QR ou cartes NFC physiques, et de gérer leurs connexions professionnelles.</p>

<h2>3. Inscription et compte</h2>
<p>Pour utiliser la Plateforme, vous devez créer un compte en fournissant des informations exactes et complètes. Vous êtes responsable de la confidentialité de vos identifiants de connexion et de toute activité effectuée sous votre compte.</p>
<p>Vous devez avoir au moins 16 ans pour créer un compte. En vous inscrivant, vous déclarez avoir l'âge requis.</p>

<h2>4. Forfaits et paiements</h2>
<p>Link-Card offre des forfaits gratuits et payants (Pro, Premium). Les abonnements payants sont facturés mensuellement ou annuellement via Stripe. Les prix sont affichés en dollars canadiens (CAD). Les prix affichés sont les prix finaux.</p>
<p>Les abonnements se renouvellent automatiquement. Vous pouvez annuler à tout moment via votre portail d'abonnement. L'annulation prend effet à la fin de la période de facturation en cours.</p>

<h2>5. Cartes NFC physiques</h2>
<p>Les cartes NFC sont des produits physiques personnalisés. Consultez notre <a href="{{ route('legal.refund') }}">politique de remboursement</a> pour les conditions de retour et d'échange.</p>

<h2>6. Contenu de l'utilisateur — Règles et responsabilités</h2>
<p>Vous êtes seul responsable du contenu que vous publiez sur votre profil Link-Card, incluant textes, images, liens et informations personnelles. En publiant du contenu, vous déclarez en détenir les droits nécessaires.</p>

<h3>6.1 Contenu strictement interdit</h3>
<p>Il est formellement interdit de publier, afficher ou partager via la Plateforme tout contenu qui :</p>
<ul>
    <li><strong>Contenu sexuel ou explicite :</strong> pornographie, nudité à caractère sexuel, contenu sexuellement suggestif impliquant des mineurs (tolérance zéro)</li>
    <li><strong>Contenu illégal :</strong> promotion ou facilitation d'activités illégales, incluant la vente de drogues, d'armes, de biens volés, de faux documents</li>
    <li><strong>Liens dangereux :</strong> liens vers le dark web, sites malveillants, sites de phishing, marchés illégaux, logiciels malveillants</li>
    <li><strong>Violence et menaces :</strong> incitation à la violence, menaces, contenu glorifiant la violence, le terrorisme ou l'extrémisme</li>
    <li><strong>Discours haineux :</strong> contenu discriminatoire basé sur la race, l'ethnie, la religion, le genre, l'orientation sexuelle, le handicap ou toute autre caractéristique protégée</li>
    <li><strong>Harcèlement :</strong> intimidation, harcèlement, doxxing, divulgation d'informations personnelles sans consentement</li>
    <li><strong>Fraude et arnaque :</strong> contenu frauduleux, trompeur, fausses déclarations, usurpation d'identité</li>
    <li><strong>Propriété intellectuelle :</strong> violation de droits d'auteur, de marques de commerce ou de brevets de tiers</li>
    <li><strong>Spam :</strong> contenu promotionnel non sollicité, systèmes pyramidaux, marketing multi-niveaux abusif</li>
</ul>

<h3>6.2 Validation et modération</h3>
<p>Link-Card utilise un système de validation manuelle des profils. Chaque profil est examiné avant d'être rendu public. Link-Card se réserve le droit de refuser, suspendre ou retirer tout profil dont le contenu enfreint ces Conditions, sans préavis.</p>
<p>Si vous constatez un profil au contenu inapproprié, contactez-nous à <a href="mailto:abuse@linkcard.ca">abuse@linkcard.ca</a>.</p>

<h3>6.3 Conséquences des violations</h3>
<p>En cas de violation des présentes règles, Link-Card peut, à sa seule discrétion :</p>
<ul>
    <li>Supprimer le contenu en violation</li>
    <li>Suspendre temporairement le profil et/ou le compte</li>
    <li>Suspendre définitivement le compte sans remboursement</li>
    <li>Désactiver les cartes NFC associées au compte</li>
    <li>Signaler les activités illégales aux autorités compétentes</li>
</ul>
<p>Les violations graves (contenu impliquant des mineurs, activités criminelles) font l'objet d'un signalement immédiat aux forces de l'ordre.</p>

<h2>7. Propriété intellectuelle</h2>
<p>La Plateforme, son design, son code et sa marque sont la propriété de Link-Card inc. Vous ne pouvez pas copier, modifier, distribuer ou reproduire tout élément de la Plateforme sans autorisation écrite préalable.</p>
<p>En publiant du contenu, vous accordez à Link-Card une licence non exclusive, mondiale et libre de redevances pour afficher et distribuer votre contenu dans le cadre du fonctionnement de la Plateforme.</p>

<h2>8. Limitation de responsabilité</h2>
<p>La Plateforme est fournie « telle quelle » sans garantie d'aucune sorte. Link-Card ne garantit pas la disponibilité continue, l'exactitude ou l'exhaustivité du service.</p>
<p>Link-Card ne peut être tenu responsable de :</p>
<ul>
    <li>Tout dommage indirect, accessoire ou consécutif résultant de l'utilisation de la Plateforme</li>
    <li>Toute perte de données ou interruption de service</li>
    <li>Tout contenu publié par les utilisateurs</li>
    <li>Toute interaction entre utilisateurs résultant de l'utilisation de la Plateforme</li>
</ul>
<p>La responsabilité totale de Link-Card est limitée au montant payé par l'utilisateur au cours des 12 derniers mois.</p>

<h2>9. Indemnisation</h2>
<p>Vous acceptez d'indemniser et de dégager de toute responsabilité Link-Card inc., ses dirigeants, employés et partenaires contre toute réclamation, perte ou dommage résultant de votre utilisation de la Plateforme ou de la violation des présentes Conditions.</p>

<h2>10. Résiliation</h2>
<p>Vous pouvez résilier votre compte à tout moment. Link-Card peut suspendre ou résilier votre compte en cas de violation des Conditions, sans préavis et sans remboursement.</p>
<p>Après résiliation, vos profils publics seront désactivés et vos cartes NFC cesseront de rediriger vers vos profils.</p>

<h2>11. Droit applicable</h2>
<p>Les présentes Conditions sont régies par les lois de la province de Québec et les lois fédérales du Canada applicables. Tout litige sera soumis à la compétence exclusive des tribunaux du district judiciaire de Trois-Rivières, Québec.</p>

<h2>12. Contact</h2>
<p>Pour toute question concernant ces Conditions, contactez-nous à <a href="mailto:support@linkcard.ca">support@linkcard.ca</a>.</p>

@endsection
