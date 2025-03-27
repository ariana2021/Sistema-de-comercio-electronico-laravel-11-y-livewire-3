<?php

namespace App\Livewire\Admin;

use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class OrderComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $order_id, $new_status, $note;
    public $isOpen = false;
    public $selectedOrder;
    protected $queryString = ['search'];
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $orders = Order::where('id', 'LIKE', "%{$this->search}%")
            ->orWhere('status', 'LIKE', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.order-component', compact('orders'))
            ->extends('admin.layouts.app');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal($id)
    {
        $this->order_id = $id;
        $this->selectedOrder = Order::with('user', 'statusHistory')->findOrFail($id);
        $this->new_status = optional($this->selectedOrder->statusHistory->last())->status ?? $this->selectedOrder->status;
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->reset(['order_id', 'new_status', 'note']);
        $this->isOpen = false;
    }

    public function updateStatus()
    {
        $this->validate([
            'new_status' => 'required|string',
            'note' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($this->order_id);

        $order->update(['status' => $this->new_status]);

        OrderStatusHistory::create([
            'order_id' => $this->order_id,
            'status' => $this->new_status,
            'note' => $this->note,
        ]);

        // Enviar correo al usuario
        //Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $this->status, $this->note));

        session()->flash('message', 'Estado de pedido actualizado y notificado.');
        $this->closeModal();
    }
}
