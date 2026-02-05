<div x-data="{ savedShow: false }" @auto-saved.window="savedShow = true; setTimeout(() => savedShow = false, 2000)">

    @include('livewire.profile.partials.page-header')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 flex gap-6">

        <!-- EDITOR -->
        <div class="w-[58%] space-y-4">
            @include('livewire.profile.partials.editor-header')
            @include('livewire.profile.partials.editor-bands')

            @if(session()->has('error'))
                <div class="p-4 rounded-lg text-sm font-medium" style="font-family: 'Manrope', sans-serif; background: #FEF2F2; border: 1px solid #FCA5A5; color: #991B1B;">
                    {{ session('error') }}
                </div>
            @endif

            <button wire:click="saveAndReturn" class="w-full py-3.5 rounded-xl font-medium text-sm text-white transition-all duration-200 flex items-center justify-center space-x-2" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(66,181,116,0.3)'" onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
                <span>Sauvegarder et retour</span>
            </button>
        </div>

        <!-- PREVIEW -->
        <div class="w-[42%]">
            @include('livewire.profile.partials.preview')
        </div>

    </div>

    @include('livewire.profile.partials.modal-add-band')
    @include('livewire.profile.partials.sortable-script')
    
    <!-- Delete Modal (composant réutilisable) -->
    <x-delete-modal :show="$showDeleteModal" :name="$deletingItemName" :type="$deletingItemType" />

</div>
