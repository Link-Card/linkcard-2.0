<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('livewire:init', () => {
        function initSortable() {
            const el = document.getElementById('bands-list');
            if (!el) return;
            if (el._sortableInstance) el._sortableInstance.destroy();
            el._sortableInstance = Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'opacity-40',
                delay: 200,
                delayOnTouchOnly: true,
                touchStartThreshold: 5,
                onEnd: function () {
                    const items = el.querySelectorAll('[data-band-id]');
                    const orderedIds = Array.from(items).map(item => parseInt(item.dataset.bandId));
                    const wireEl = el.closest('[wire\\:id]');
                    if (wireEl) {
                        Livewire.find(wireEl.getAttribute('wire:id')).call('reorderBands', orderedIds);
                    }
                }
            });
        }
        initSortable();
        Livewire.hook('morph.updated', () => requestAnimationFrame(initSortable));
    });
</script>
