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

            <button wire:click="saveAndReturn" class="w-full py-3.5 rounded-xl font-medium text-sm text-white transition-all duration-200" style="font-family: 'Manrope', sans-serif; background: #42B574;" onmouseover="this.style.background='#3DA367'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(66,181,116,0.3)'" onmouseout="this.style.background='#42B574'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <i class="fas fa-save mr-2"></i>Sauvegarder et retour
            </button>
        </div>

        <!-- PREVIEW -->
        <div class="w-[42%]">
            @include('livewire.profile.partials.preview')
        </div>

    </div>

    @include('livewire.profile.partials.modal-add-band')
    @include('livewire.profile.partials.modal-delete')
    @include('livewire.profile.partials.sortable-script')

</div>
