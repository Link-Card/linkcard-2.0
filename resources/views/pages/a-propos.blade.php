@extends('layouts.public')

@section('title', 'À propos — Link-Card')
@section('meta_description', 'Découvrez l\'histoire de Link-Card. Basée au Québec, notre mission est de transformer chaque rencontre en connexion durable.')

@section('content')

{{-- HERO --}}
<section class="pt-28 sm:pt-36 pb-16 sm:pb-20" style="background: linear-gradient(165deg, #F7F8F4 0%, #F0F9F4 40%, #F7F8F4 100%);">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center fade-up">
        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium mb-6" style="background-color: #F0F9F4; color: #42B574;">
            Notre histoire
        </div>
        <h1 class="text-4xl sm:text-5xl font-bold leading-tight" style="color: #2C2A27;">
            Transformer chaque rencontre<br>en connexion <span style="color: #42B574;">durable</span>
        </h1>
    </div>
</section>

{{-- LE CONSTAT --}}
<section class="py-16 sm:py-24" style="background-color: #FFFFFF;">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="fade-up">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6" style="color: #2C2A27;">Le constat</h2>
            <p class="text-lg leading-relaxed mb-6" style="color: #4B5563;">
                Link-Card est née d'un constat simple : les rencontres professionnelles ne manquent pas, mais les connexions durables sont rares.
            </p>
            <p class="text-lg leading-relaxed mb-6" style="color: #4B5563;">
                Les cartes d'affaires se perdent. Les contacts s'oublient. Les opportunités disparaissent souvent pour une seule raison : le lien n'a pas été conservé.
            </p>
            <p class="text-lg leading-relaxed" style="color: #4B5563;">
                On s'est dit qu'il devait y avoir une meilleure façon de faire. Une façon <strong style="color: #2C2A27;">simple, claire et durable</strong> de connecter les professionnels entre eux.
            </p>
        </div>
    </div>
</section>

{{-- LA MISSION --}}
<section class="py-16 sm:py-24" style="background-color: #F7F8F4;">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="fade-up">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6" style="color: #2C2A27;">Notre mission</h2>
            <p class="text-lg leading-relaxed mb-6" style="color: #4B5563;">
                Link-Card existe pour une seule raison : ne pas laisser une bonne rencontre disparaître.
            </p>
            <p class="text-lg leading-relaxed mb-6" style="color: #4B5563;">
                On croit que la technologie devrait simplifier les choses, pas les compliquer. C'est pour ça que Link-Card a été conçue autour d'un seul principe : <strong style="color: #2C2A27;">un geste simple, une connexion immédiate</strong>.
            </p>
            <p class="text-lg leading-relaxed" style="color: #4B5563;">
                Pas d'application compliquée. Pas de processus long. Juste une expérience fluide qui respecte le moment de la rencontre.
            </p>
        </div>
    </div>
</section>

{{-- NOS VALEURS --}}
<section class="py-16 sm:py-24" style="background-color: #FFFFFF;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14 fade-up">
            <h2 class="text-2xl sm:text-3xl font-bold" style="color: #2C2A27;">Ce qui nous guide</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <div class="text-center fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 28px 24px;">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl mb-4" style="background-color: #F0F9F4;">
                    <svg class="w-6 h-6" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                </div>
                <h3 class="text-lg font-bold mb-2" style="color: #2C2A27;">Simplicité</h3>
                <p class="text-sm leading-relaxed" style="color: #4B5563;">Si ce n'est pas simple, on ne le fait pas. Chaque fonctionnalité doit respecter le moment de la rencontre.</p>
            </div>
            <div class="text-center fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 28px 24px; transition-delay: 0.1s;">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl mb-4" style="background-color: #F0F9F4;">
                    <svg class="w-6 h-6" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold mb-2" style="color: #2C2A27;">Continuité</h3>
                <p class="text-sm leading-relaxed" style="color: #4B5563;">Une bonne rencontre a de la valeur. Mais cette valeur disparaît si le contact se perd. On s'assure qu'il reste.</p>
            </div>
            <div class="text-center fade-up" style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 28px 24px; transition-delay: 0.2s;">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl mb-4" style="background-color: #F0F9F4;">
                    <svg class="w-6 h-6" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036"/></svg>
                </div>
                <h3 class="text-lg font-bold mb-2" style="color: #2C2A27;">Durabilité</h3>
                <p class="text-sm leading-relaxed" style="color: #4B5563;">Moins de papier, moins de gaspillage. Une carte pour des centaines de connexions. Adapté à la réalité d'aujourd'hui.</p>
            </div>
        </div>
    </div>
</section>

{{-- LOCAL --}}
<section class="py-16 sm:py-20" style="background-color: #F7F8F4;">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center fade-up">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-6" style="background-color: #F0F9F4; font-size: 28px;">
            🇨🇦
        </div>
        <h2 class="text-2xl sm:text-3xl font-bold mb-4" style="color: #2C2A27;">Basé au Québec, fabriqué au Québec</h2>
        <p class="text-lg leading-relaxed max-w-xl mx-auto" style="color: #4B5563;">
            Link-Card est conçue et opérée depuis la Mauricie, au Québec. Nos cartes NFC sont imprimées et programmées localement. Vos données sont hébergées au Canada, conformément à la Loi 25.
        </p>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 sm:py-20" style="background: linear-gradient(135deg, #2C2A27 0%, #1A1918 100%); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(66,181,116,0.15) 0%, transparent 70%); pointer-events: none;"></div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center relative z-10 fade-up">
        <h2 class="text-3xl sm:text-4xl font-bold text-white">Prêt à faire le <span style="color: #42B574;">premier geste</span>?</h2>
        <p class="mt-4 text-base" style="color: #9CA3AF;">Créez votre profil gratuitement et découvrez une nouvelle façon de connecter.</p>
        <div class="mt-8">
            <a href="{{ route('pages.forfaits') }}" class="btn btn-primary" style="padding: 14px 28px; font-size: 16px; border-radius: 12px;">
                Commencer gratuitement
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

@endsection
