@extends('layouts.public')

@section('title', 'FAQ — LinkCard')
@section('meta_description', 'Questions fréquentes sur LinkCard : carte NFC, profil digital, forfaits, paiement, confidentialité. Trouvez toutes les réponses ici.')

@section('styles')
<style>
    .faq-item { border-bottom: 1px solid #E5E7EB; }
    .faq-item:last-child { border-bottom: none; }
    .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
    .faq-answer.open { max-height: 300px; }
    .faq-chevron { transition: transform 0.2s ease; }
    .faq-chevron.open { transform: rotate(180deg); }
</style>
@endsection

@section('content')

{{-- HERO --}}
<section class="pt-28 sm:pt-36 pb-12 sm:pb-16" style="background: linear-gradient(165deg, #F7F8F4 0%, #F0F9F4 40%, #F7F8F4 100%);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center fade-up">
        <h1 class="text-4xl sm:text-5xl font-bold" style="color: #2C2A27;">Questions <span style="color: #42B574;">fréquentes</span></h1>
        <p class="mt-4 text-lg" style="color: #4B5563;">Tout ce que vous devez savoir avant de commencer.</p>
    </div>
</section>

{{-- FAQ --}}
<section class="py-12 sm:py-20" style="background-color: #FFFFFF;">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        @php
        $categories = [
            ['title' => 'Général', 'questions' => [
                ['q' => 'C\'est quoi LinkCard?', 'a' => 'LinkCard est votre carte de visite digitale. Créez un profil professionnel en ligne, partagez-le avec une carte NFC ou un QR Code, et bâtissez votre réseau de contacts.'],
                ['q' => 'Est-ce que c\'est gratuit?', 'a' => 'Oui! Le forfait gratuit inclut 1 profil avec 3 liens sociaux, 2 images et 1 section texte. Les forfaits Pro (5$/mois) et Premium (8$/mois) débloquent plus de contenu et de fonctionnalités.'],
                ['q' => 'Comment ça fonctionne?', 'a' => 'Créez votre compte → Personnalisez votre profil → Partagez-le via votre lien, QR Code ou carte NFC. C\'est aussi simple que ça.'],
                ['q' => 'Est-ce que je peux annuler en tout temps?', 'a' => 'Absolument. Aucun engagement. Vous pouvez annuler votre abonnement à tout moment via votre tableau de bord. Votre compte reste actif en mode gratuit.'],
            ]],
            ['title' => 'Carte NFC', 'questions' => [
                ['q' => 'C\'est quoi une carte NFC?', 'a' => 'C\'est une carte physique avec une puce intégrée. Quand quelqu\'un approche son téléphone de votre carte, votre profil LinkCard s\'ouvre automatiquement. Pas d\'application à installer, ça fonctionne nativement sur iPhone et Android.'],
                ['q' => 'Est-ce que ça fonctionne avec tous les téléphones?', 'a' => 'Oui, tous les iPhone depuis le 7 (2016) et la grande majorité des Android supportent le NFC. C\'est plus de 95% des téléphones en circulation.'],
                ['q' => 'Combien de temps pour recevoir ma carte?', 'a' => '5 à 10 jours ouvrables après le paiement. Votre carte est imprimée et programmée localement au Québec.'],
                ['q' => 'La carte fonctionne sans internet?', 'a' => 'La carte n\'a pas besoin de batterie ni d\'internet. Par contre, le téléphone qui la scanne a besoin d\'une connexion pour afficher votre profil.'],
                ['q' => 'Je peux changer mon profil sans changer de carte?', 'a' => 'Oui! Votre carte contient un lien permanent. Vous pouvez modifier votre profil, changer de template, ou assigner un profil différent — tout ça sans jamais changer la carte physique.'],
                ['q' => 'La carte est résistante?', 'a' => 'Oui, elle est en PVC rigide, comme une carte bancaire. Résistante à l\'eau, aux égratignures et à l\'usure quotidienne.'],
            ]],
            ['title' => 'Profil & Fonctionnalités', 'questions' => [
                ['q' => 'Qu\'est-ce qui change entre les forfaits?', 'a' => 'Gratuit : l\'essentiel (3 liens, 2 images, 1 texte). Pro : plus de contenu + QR Code + templates pro + URL personnalisée. Premium : le maximum + templates exclusifs + vidéo + carrousel.'],
                ['q' => 'Comment fonctionne le QR Code?', 'a' => 'Un QR Code unique est généré pour votre profil. Partagez-le par email, dans vos présentations, ou affichez-le sur votre écran. Disponible avec Pro et Premium.'],
                ['q' => 'C\'est quoi le username personnalisé?', 'a' => 'Au lieu d\'un code aléatoire (ex: app.linkcard.ca/AB3KX92P), vous choisissez votre propre adresse (ex: app.linkcard.ca/jean-tremblay). Disponible avec Pro et Premium.'],
            ]],
            ['title' => 'Paiement & Abonnement', 'questions' => [
                ['q' => 'Quels moyens de paiement?', 'a' => 'Cartes Visa, Mastercard et American Express via Stripe, notre partenaire de paiement sécurisé certifié PCI DSS niveau 1. LinkCard ne stocke jamais vos informations bancaires.'],
                ['q' => 'Que se passe-t-il si j\'annule?', 'a' => 'Votre compte passe au forfait gratuit. Les sections excédentaires sont masquées (pas supprimées). Réabonnez-vous et tout revient!'],
                ['q' => 'Politique de remboursement?', 'a' => 'Les abonnements sont remboursables au prorata durant les 30 premiers jours. Les cartes NFC ne sont pas remboursables une fois imprimées. Détails dans notre politique de remboursement.'],
                ['q' => 'Les prix incluent les taxes?', 'a' => 'Les taxes applicables (TPS/TVQ) sont ajoutées au moment du paiement, conformément aux lois du Québec.'],
            ]],
            ['title' => 'Confidentialité & Sécurité', 'questions' => [
                ['q' => 'Qu\'est-ce que vous faites avec mes données?', 'a' => 'Vos données vous appartiennent. On ne les vend pas, on ne les partage pas. Consultez notre politique de confidentialité pour tous les détails.'],
                ['q' => 'LinkCard est conforme à la Loi 25?', 'a' => 'Oui. Conforme à la Loi 25 du Québec et à la LPRPDE fédérale. Vos données sont hébergées au Canada.'],
                ['q' => 'Les gens qui scannent ma carte voient mes infos?', 'a' => 'Seulement ce que vous avez choisi de rendre visible sur votre profil. Vous contrôlez tout.'],
            ]],
        ];
        @endphp

        @foreach($categories as $catIndex => $category)
        <div class="mb-10 fade-up" style="transition-delay: {{ $catIndex * 0.05 }}s;">
            <h2 class="text-xl font-bold mb-4" style="color: #2C2A27;">{{ $category['title'] }}</h2>
            <div style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 12px; overflow: hidden;">
                @foreach($category['questions'] as $faq)
                <div class="faq-item">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between px-5 py-4 text-left" style="color: #2C2A27;">
                        <span class="text-sm font-medium pr-4">{{ $faq['q'] }}</span>
                        <svg class="faq-chevron w-5 h-5 flex-shrink-0" fill="none" stroke="#9CA3AF" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div class="faq-answer">
                        <div class="px-5 pb-4 text-sm leading-relaxed" style="color: #4B5563;">{{ $faq['a'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="text-center mt-12 fade-up" style="background: #F7F8F4; border-radius: 16px; padding: 32px 24px;">
            <p class="text-lg font-semibold mb-2" style="color: #2C2A27;">Vous ne trouvez pas votre réponse?</p>
            <p class="text-sm mb-4" style="color: #4B5563;">Notre équipe répond habituellement en moins de 24 heures.</p>
            <a href="{{ url('/contact') }}" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px; border-radius: 10px;">
                Nous contacter
            </a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
function toggleFaq(btn) {
    const answer = btn.nextElementSibling;
    const chevron = btn.querySelector('.faq-chevron');
    answer.classList.toggle('open');
    chevron.classList.toggle('open');
}
</script>
@endsection
