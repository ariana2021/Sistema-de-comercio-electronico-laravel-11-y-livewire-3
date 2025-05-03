<?php

namespace App\Livewire\Admin;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class SaleDetailComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $fromDate = null;
    public $toDate = null;
    protected $queryString = ['search'];
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';

        $sales = Sale::with(['client', 'paymentMethod'])
            ->where('status', 'Activo')
            ->when($this->fromDate, function ($query) {
                $query->whereDate('date', '>=', $this->fromDate);
            })
            ->when($this->toDate, function ($query) {
                $query->whereDate('date', '<=', $this->toDate);
            })
            ->where(function ($query) use ($searchTerm) {
                $query->where('date', 'like', $searchTerm)
                    ->orWhereHas('client', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', $searchTerm);
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('livewire.admin.sale-detail-component', compact('sales'))
            ->extends('admin.layouts.app');
    }


    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    public function delete($valor)
    {
        Sale::find($valor['id'])->update(['status' => 'Inactivo']);

        session()->flash('message', 'Venta Anulado');
    }
}
