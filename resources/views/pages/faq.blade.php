@extends('layouts.public')

@section('title', 'FAQ — LinkCard')

@section('content')
<section class="pt-32 pb-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
        <div style="background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 16px; padding: 48px 32px;">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-6" style="background-color: #F0F9F4;">
                <svg class="w-8 h-8" fill="none" stroke="#42B574" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384-3.27M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zm6 0a9.75 9.75 0 11-19.5 0 9.75 9.75 0 0119.5 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold mb-4" style="color: #2C2A27;">FAQ</h1>
            <p class="text-lg mb-8" style="color: #4B5563;">Cette page arrive bientôt. En attendant, créez votre profil gratuitement!</p>
            <a href="/register" class="btn btn-primary" style="padding: 14px 28px; font-size: 16px; border-radius: 12px;">
                Commencer gratuitement
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>
@endsection
