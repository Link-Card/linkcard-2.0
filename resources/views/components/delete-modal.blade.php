@props([
    'show' => false,
    'action' => 'reset', // 'reset' ou 'delete'
    'title' => null,
    'message' => null,
    'confirmText' => null,
    'cancelText' => 'Annuler',
])

@php
    $isDelete = $action === 'delete';
    $defaultTitle = $isDelete ? 'Supprimer' : 'Réinitialiser le profil';
    $defaultMessage = $isDelete 
        ? 'Cette action est irréversible. Êtes-vous sûr de vouloir continuer ?'
        : 'Cette action va réinitialiser votre profil à son état initial. Toutes vos modifications seront perdues. Cette action est irréversible.';
    $defaultConfirmText = $isDelete ? 'Supprimer' : 'Réinitialiser';
    
    $title = $title ?? $defaultTitle;
    $message = $message ?? $defaultMessage;
    $confirmText = $confirmText ?? $defaultConfirmText;
@endphp

<div
    x-data="{ open: @entangle($attributes->wire('model')) }"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        @click="open = false"
    ></div>

    <!-- Modal -->
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
        >
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <!-- Icon -->
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full {{ $isDelete ? 'bg-red-100' : 'bg-[#FEF3C7]' }} sm:mx-0 sm:h-10 sm:w-10">
                        @if($isDelete)
                            <svg class="h-6 w-6 text-[#EF4444]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        @else
                            <svg class="h-6 w-6 text-[#F59E0B]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-semibold leading-6 text-[#2C2A27]" id="modal-title" style="font-family: 'Manrope', sans-serif;">
                            {{ $title }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-[#4B5563]" style="font-family: 'Manrope', sans-serif;">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-[#F7F8F4] px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                <button
                    type="button"
                    {{ $attributes->whereStartsWith('wire:click') }}
                    @click="open = false"
                    class="inline-flex w-full justify-center rounded-lg px-4 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto transition-colors {{ $isDelete ? 'bg-[#EF4444] hover:bg-[#DC2626]' : 'bg-[#F59E0B] hover:bg-[#D97706]' }}"
                    style="font-family: 'Manrope', sans-serif;"
                >
                    {{ $confirmText }}
                </button>
                <button
                    type="button"
                    @click="open = false"
                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-[#4B5563] shadow-sm ring-1 ring-inset ring-[#D1D5DB] hover:bg-[#F3F4F6] sm:mt-0 sm:w-auto transition-colors"
                    style="font-family: 'Manrope', sans-serif;"
                >
                    {{ $cancelText }}
                </button>
            </div>
        </div>
    </div>
</div>
