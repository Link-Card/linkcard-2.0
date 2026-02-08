@extends('layouts.legal')

@section('title', 'Politique de remboursement')
@section('date', '8 février 2026')

@section('content')

<h2>1. Abonnements numériques (Pro / Premium)</h2>

<h3>1.1 Vente finale</h3>
<p>Tous les abonnements sont des ventes finales et ne sont pas remboursables. En souscrivant à un forfait, vous acceptez cette condition.</p>

<h3>1.2 Annulation</h3>
<p>Vous pouvez annuler votre abonnement à tout moment via votre portail d'abonnement. L'annulation prend effet à la fin de votre période de facturation en cours — vous conservez l'accès aux fonctionnalités payantes jusqu'à cette date. Aucun remboursement n'est accordé pour la période restante.</p>

<h3>1.3 Changement de forfait</h3>
<p>Vous pouvez passer d'un forfait à un autre à tout moment. Le changement de forfait est géré automatiquement par Stripe avec ajustement au prorata.</p>

<h2>2. Cartes NFC physiques</h2>

<h3>2.1 Vente finale</h3>
<p>Les cartes NFC Link-Card sont des produits physiques personnalisés, programmés avec un code unique lié à votre compte. <strong>Toute vente de carte NFC est finale et non remboursable.</strong></p>

<h3>2.2 Produit défectueux</h3>
<p>Si votre carte NFC est défectueuse à la réception (ne scanne pas, erreur de programmation, dommage physique), nous la remplacerons gratuitement. Contactez-nous dans les 30 jours suivant la réception avec une description du problème et une photo si applicable.</p>

<h3>2.3 Non-remboursable</h3>
<p>Les cartes NFC ne sont pas remboursables dans les cas suivants :</p>
<ul>
    <li>Changement d'avis après commande</li>
    <li>Carte fonctionnelle mais l'utilisateur ne souhaite plus l'utiliser</li>
    <li>Suspension du compte pour violation des conditions d'utilisation</li>
    <li>Erreur dans le choix du design après expédition</li>
</ul>

<h2>3. Délais de traitement</h2>
<p>Les remboursements approuvés sont traités dans un délai de 5 à 10 jours ouvrables via Stripe sur le mode de paiement original.</p>

<h2>4. Contact</h2>
<p>Pour toute demande de remboursement ou d'échange : <a href="mailto:support@linkcard.ca">support@linkcard.ca</a></p>
<p>Veuillez inclure votre numéro de commande (format LC-XXXX) et une description de la situation.</p>

@endsection
