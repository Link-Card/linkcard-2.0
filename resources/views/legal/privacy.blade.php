@extends('layouts.legal')

@section('title', 'Politique de confidentialité')
@section('date', '8 février 2026')

@section('content')

<h2>1. Introduction</h2>
<p>Link-Card inc. (« nous », « notre ») s'engage à protéger la vie privée de ses utilisateurs conformément à la Loi sur la protection des renseignements personnels dans le secteur privé du Québec (Loi 25), à la Loi sur la protection des renseignements personnels et les documents électroniques (LPRPDE/PIPEDA) et à la Loi canadienne anti-pourriel (LCAP/CASL).</p>
<p>Cette politique explique quels renseignements personnels nous recueillons, pourquoi, comment nous les utilisons et quels sont vos droits.</p>

<h2>2. Responsable de la protection des renseignements personnels</h2>
<p>Pour toute question ou demande relative à vos renseignements personnels :</p>
<p><strong>Responsable :</strong> Mathieu Corbeil<br>
<strong>Courriel :</strong> <a href="mailto:privacy@linkcard.ca">privacy@linkcard.ca</a><br>
<strong>Adresse :</strong> Link-Card inc., Saint-Pierre-les-Becquets, QC, Canada</p>

<h2>3. Renseignements recueillis</h2>

<h3>3.1 Renseignements fournis directement</h3>
<ul>
    <li><strong>Création de compte :</strong> nom, adresse courriel, mot de passe (chiffré)</li>
    <li><strong>Profil :</strong> nom complet, titre de poste, entreprise, localisation, téléphone, site web, biographie, photo de profil</li>
    <li><strong>Commande de cartes NFC :</strong> adresse de livraison, numéro de téléphone</li>
    <li><strong>Liens sociaux :</strong> URLs de vos réseaux sociaux</li>
</ul>

<h3>3.2 Renseignements recueillis automatiquement</h3>
<ul>
    <li><strong>Données d'utilisation :</strong> vues de profil, clics sur liens, sources de trafic, type d'appareil</li>
    <li><strong>Données techniques :</strong> adresse IP (anonymisée par hachage), type de navigateur, système d'exploitation</li>
    <li><strong>Journaux :</strong> activité de connexion, horodatage</li>
</ul>

<h3>3.3 Renseignements de paiement</h3>
<p>Les paiements sont traités par <strong>Stripe Inc.</strong> Nous ne stockons aucun numéro de carte de crédit. Seuls l'identifiant Stripe, le type de carte et les 4 derniers chiffres sont conservés pour référence. Consultez la <a href="https://stripe.com/privacy" target="_blank" rel="noopener">politique de confidentialité de Stripe</a>.</p>

<h2>4. Finalités du traitement</h2>
<p>Nous utilisons vos renseignements uniquement pour :</p>
<ul>
    <li>Fournir, maintenir et améliorer nos services</li>
    <li>Créer et afficher votre profil public tel que vous l'avez configuré</li>
    <li>Traiter vos paiements et livrer vos cartes NFC</li>
    <li>Vous envoyer des communications relatives au service (confirmations, notifications de compte)</li>
    <li>Produire des statistiques d'utilisation de vos profils (vues, clics)</li>
    <li>Assurer la sécurité de la plateforme et prévenir les abus</li>
    <li>Respecter nos obligations légales</li>
</ul>

<h2>5. Consentement</h2>
<p>En créant un compte et en acceptant nos conditions d'utilisation, vous consentez à la collecte et à l'utilisation de vos renseignements tels que décrits dans la présente politique.</p>
<p>Vous pouvez retirer votre consentement à tout moment en fermant votre compte. Le retrait du consentement n'affecte pas la légalité du traitement effectué avant le retrait.</p>

<h2>6. Partage des renseignements</h2>
<p>Nous ne vendons jamais vos renseignements personnels. Nous les partageons uniquement avec :</p>
<ul>
    <li><strong>Stripe Inc.</strong> — traitement des paiements</li>
    <li><strong>Mailgun (Sinch)</strong> — envoi de courriels transactionnels</li>
    <li><strong>WHC (Web Hosting Canada)</strong> — hébergement des données au Canada</li>
</ul>
<p>Nous pouvons également divulguer vos renseignements si la loi l'exige ou pour protéger nos droits, notre sécurité ou celle d'autrui.</p>

<h2>7. Conservation des données</h2>
<ul>
    <li><strong>Compte actif :</strong> vos données sont conservées tant que votre compte est actif</li>
    <li><strong>Après suppression du compte :</strong> données supprimées dans un délai de 30 jours, sauf obligation légale de conservation</li>
    <li><strong>Données de paiement :</strong> conservées selon les exigences fiscales applicables (minimum 6 ans)</li>
    <li><strong>Journaux techniques :</strong> conservés 12 mois maximum</li>
    <li><strong>Signalements :</strong> conservés pendant la durée nécessaire au traitement et à la conformité légale</li>
</ul>

<h2>8. Sécurité</h2>
<p>Nous mettons en œuvre des mesures de sécurité appropriées pour protéger vos renseignements :</p>
<ul>
    <li>Chiffrement des mots de passe (bcrypt)</li>
    <li>Communication HTTPS (SSL/TLS)</li>
    <li>Hébergement des données au Canada</li>
    <li>Accès restreint aux données (principe du moindre privilège)</li>
</ul>

<h2>9. Vos droits</h2>
<p>Conformément à la Loi 25 et à la LPRPDE, vous avez le droit de :</p>
<ul>
    <li><strong>Accéder</strong> à vos renseignements personnels</li>
    <li><strong>Rectifier</strong> des renseignements inexacts ou incomplets</li>
    <li><strong>Supprimer</strong> vos renseignements (droit à l'effacement)</li>
    <li><strong>Retirer</strong> votre consentement au traitement</li>
    <li><strong>Obtenir</strong> une copie de vos renseignements dans un format technologique couramment utilisé (portabilité)</li>
    <li><strong>Déposer une plainte</strong> auprès de la Commission d'accès à l'information du Québec</li>
</ul>
<p>Pour exercer vos droits, contactez-nous à <a href="mailto:privacy@linkcard.ca">privacy@linkcard.ca</a>. Nous répondrons dans un délai de 30 jours.</p>

<h2>10. Cookies et technologies similaires</h2>
<p>La Plateforme utilise des cookies essentiels au fonctionnement du service (session, authentification, CSRF). Nous n'utilisons pas de cookies publicitaires ni de traceurs tiers.</p>

<h2>11. Communications électroniques (LCAP)</h2>
<p>Conformément à la Loi canadienne anti-pourriel, nous envoyons uniquement des courriels transactionnels liés au service (confirmations de compte, notifications de commande, changements de plan). Nous n'envoyons pas de courriels promotionnels sans votre consentement explicite.</p>

<h2>12. Transferts de données</h2>
<p>Vos données sont hébergées au Canada. Certains sous-traitants (Stripe, Mailgun) peuvent traiter des données aux États-Unis avec des garanties contractuelles appropriées.</p>

<h2>13. Mineurs</h2>
<p>La Plateforme n'est pas destinée aux personnes de moins de 16 ans. Nous ne collectons pas sciemment de renseignements personnels de mineurs.</p>

<h2>14. Modifications</h2>
<p>Nous pouvons modifier cette politique. En cas de changement substantiel, nous vous en informerons par courriel ou via la Plateforme. La date de mise à jour est indiquée en haut de cette page.</p>

<h2>15. Contact</h2>
<p>Pour toute question : <a href="mailto:privacy@linkcard.ca">privacy@linkcard.ca</a></p>
<p>Pour déposer une plainte :<br>
Commission d'accès à l'information du Québec<br>
<a href="https://www.cai.gouv.qc.ca" target="_blank" rel="noopener">www.cai.gouv.qc.ca</a></p>

@endsection
