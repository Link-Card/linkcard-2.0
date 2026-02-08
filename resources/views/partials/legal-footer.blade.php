<footer class="py-8 mt-8" style="border-top: 1px solid #E5E7EB;">
    <div class="max-w-3xl mx-auto px-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo-noir.png') }}" alt="Link-Card" class="h-5 w-auto opacity-50">
                <span class="text-xs" style="color: #9CA3AF;">© {{ date('Y') }} Link-Card. Tous droits réservés.</span>
            </div>
            <nav class="flex items-center space-x-4 text-xs" style="color: #9CA3AF;">
                <a href="{{ route('legal.terms') }}" class="hover:underline" style="color: #9CA3AF;">Conditions d'utilisation</a>
                <a href="{{ route('legal.privacy') }}" class="hover:underline" style="color: #9CA3AF;">Confidentialité</a>
                <a href="{{ route('legal.refund') }}" class="hover:underline" style="color: #9CA3AF;">Remboursement</a>
                <a href="mailto:support@linkcard.ca" class="hover:underline" style="color: #9CA3AF;">Contact</a>
            </nav>
        </div>
    </div>
</footer>
