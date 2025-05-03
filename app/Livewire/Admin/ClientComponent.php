<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ClientComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $opcional = '';
    public $name, $email, $password, $password_confirmation, $address, $user_id;
    public $isOpen = 0;

    protected $queryString = ['search'];

    protected $listeners = ['delete'];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';

        $users = User::with('cashbacks')->whereDoesntHave('roles')
            ->where('name', 'like', $searchTerm)
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('livewire.admin.client-component', compact('users'))->extends('admin.layouts.app');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->resetValidation();
        $this->isOpen = false;
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->address = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->opcional = '';
        $this->user_id = null;
    }

    public function store()
    {
        // Validación condicional
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ];

        if (!$this->user_id) {
            $rules['password'] = 'required|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        $this->validate($rules);

        // Data para actualizar o crear
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'status' => 'Activo'
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        User::updateOrCreate(['id' => $this->user_id], $data);

        session()->flash('message', $this->user_id ? 'Cliente Actualizado.' : 'Cliente Creado.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->address = $usuario->address;
        $this->password = '';
        $this->opcional = '(Opcional)';
        // Abrir el modal
        $this->openModal();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    public function delete($valor)
    {
        User::find($valor['id'])->delete();

        session()->flash('message', 'Cliente Eliminada.');
    }
}
