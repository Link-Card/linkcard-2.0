<?php

namespace App\Livewire\Traits;

trait WithDeleteConfirmation
{
    public $showDeleteModal = false;
    public $deletingItemId = null;
    public $deletingItemName = '';
    public $deletingItemType = '';

    public function confirmDeleteItem($id, $name, $type = 'item')
    {
        $this->deletingItemId = $id;
        $this->deletingItemName = $name;
        $this->deletingItemType = $type;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deletingItemId = null;
        $this->deletingItemName = '';
        $this->deletingItemType = '';
    }

    // La méthode deleteConfirmed() doit être implémentée dans chaque composant
}
