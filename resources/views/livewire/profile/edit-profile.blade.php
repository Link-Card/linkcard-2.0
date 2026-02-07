<div x-data="{ savedShow: false, showPreview: false }" @auto-saved.window="savedShow = true; setTimeout(() => savedShow = false, 2000)">

    @include('livewire.profile.partials.page-header')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 lg:flex lg:gap-6">

        <!-- EDITOR -->
        <div class="w-full lg:w-[58%] space-y-4">
            @include('livewire.profile.partials.editor-header')
            @include('livewire.profile.partials.editor-bands')

            @if(session()->has('error'))
                <div class="p-4 rounded-lg text-sm font-medium" style="font-family: 'Manrope', sans-serif; background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Mobile preview toggle --}}
            <button @click="showPreview = !showPreview" class="lg:hidden w-full py-3 rounded-xl font-medium text-sm transition-all duration-200 flex items-center justify-center space-x-2"
                    style="font-family: 'Manrope', sans-serif; border: 1.5px solid #42B574; color: #42B574;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span x-text="showPreview ? 'Masquer l\'aperçu' : 'Voir l\'aperçu'"></span>
            </button>

            <button wire:click="saveAndReturn" class="w-full py-3.5 rounded-xl font-medium text-sm text-white transition-all duration-200 flex items-center justify-center space-x-2" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(66,181,116,0.3)'" onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
                <span>Sauvegarder et retour</span>
            </button>
        </div>

        <!-- PREVIEW (hidden on mobile, toggle with button) -->
        <div class="w-full lg:w-[42%] mt-6 lg:mt-0" :class="{ 'hidden lg:block': !showPreview }">
            @include('livewire.profile.partials.preview')
        </div>

    </div>

    @include('livewire.profile.partials.modal-add-band')
    @include('livewire.profile.partials.sortable-script')
    
    <!-- Delete Modal (composant réutilisable) -->
    <x-delete-modal :show="$showDeleteModal" :name="$deletingItemName" :type="$deletingItemType" />

</div>
