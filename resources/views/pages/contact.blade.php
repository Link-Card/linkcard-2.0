@extends('layouts.public')

@section('title', 'Contact — Link-Card')
@section('meta_description', 'Contactez l\'équipe Link-Card. Question, problème technique, partenariat — nous répondons en moins de 24 heures.')

@section('content')

{{-- HERO --}}
<section class="pt-28 sm:pt-36 pb-12 sm:pb-16" style="background: linear-gradient(165deg, #F7F8F4 0%, #F0F9F4 40%, #F7F8F4 100%);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center fade-up">
        <h1 class="text-4xl sm:text-5xl font-bold" style="color: #2C2A27;">Une question? <span style="color: #42B574;">On est là.</span></h1>
        <p class="mt-4 text-lg" style="color: #4B5563;">Notre équipe répond habituellement en moins de 24 heures.</p>
    </div>
</section>

{{-- FORMULAIRE + INFOS --}}
<section class="py-12 sm:py-20" style="background-color: #FFFFFF;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
            {{-- Formulaire --}}
            <div class="lg:col-span-3 fade-up">
                <form action="mailto:support@linkcard.ca" method="GET" enctype="text/plain" id="contactForm">
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium mb-1.5" style="color: #2C2A27;">Nom</label>
                                <input type="text" name="name" required placeholder="Votre nom" style="width: 100%; padding: 10px 14px; border: 1px solid #E5E7EB; border-radius: 8px; font-size: 14px; color: #2C2A27; background: #FFFFFF; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#E5E7EB'">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1.5" style="color: #2C2A27;">Email</label>
                                <input type="email" name="email" required placeholder="votre@email.com" style="width: 100%; padding: 10px 14px; border: 1px solid #E5E7EB; border-radius: 8px; font-size: 14px; color: #2C2A27; background: #FFFFFF; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#E5E7EB'">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #2C2A27;">Sujet</label>
                            <select name="subject" required style="width: 100%; padding: 10px 14px; border: 1px solid #E5E7EB; border-radius: 8px; font-size: 14px; color: #2C2A27; background: #FFFFFF; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#E5E7EB'">
                                <option value="">Choisir un sujet...</option>
                                <option value="question">Question générale</option>
                                <option value="technique">Problème technique</option>
                                <option value="carte">Ma carte NFC</option>
                                <option value="abonnement">Mon abonnement</option>
                                <option value="partenariat">Partenariat</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #2C2A27;">Message</label>
                            <textarea name="body" rows="5" required placeholder="Comment pouvons-nous vous aider?" style="width: 100%; padding: 10px 14px; border: 1px solid #E5E7EB; border-radius: 8px; font-size: 14px; color: #2C2A27; background: #FFFFFF; outline: none; resize: vertical; transition: border-color 0.2s;" onfocus="this.style.borderColor='#42B574'" onblur="this.style.borderColor='#E5E7EB'"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 14px; border-radius: 10px;">
                                Envoyer
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Infos directes --}}
            <div class="lg:col-span-2 fade-up" style="transition-delay: 0.1s;">
                <div style="background: #F7F8F4; border-radius: 16px; padding: 28px 24px;">
                    <h3 class="text-lg font-bold mb-6" style="color: #2C2A27;">Autres façons de nous joindre</h3>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl flex-shrink-0" style="background-color: #F0F9F4;">
                                <svg class="w-5 h-5" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold" style="color: #2C2A27;">Email</p>
                                <a href="mailto:support@linkcard.ca" class="text-sm" style="color: #42B574;">support@linkcard.ca</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl flex-shrink-0" style="background-color: #F0F9F4;">
                                <svg class="w-5 h-5" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold" style="color: #2C2A27;">Basé au Québec</p>
                                <p class="text-sm" style="color: #4B5563;">Mauricie, QC</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl flex-shrink-0" style="background-color: #F0F9F4;">
                                <svg class="w-5 h-5" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold" style="color: #2C2A27;">Temps de réponse</p>
                                <p class="text-sm" style="color: #4B5563;">Moins de 24 heures</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6" style="border-top: 1px solid #E5E7EB;">
                        <p class="text-sm font-semibold mb-3" style="color: #2C2A27;">Problème avec votre carte?</p>
                        <p class="text-sm leading-relaxed" style="color: #4B5563;">Si votre carte NFC est défectueuse, contactez-nous. Nous la remplacerons gratuitement.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
