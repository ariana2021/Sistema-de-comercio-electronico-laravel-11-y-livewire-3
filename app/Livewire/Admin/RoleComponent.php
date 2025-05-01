<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $role_id, $selectedPermissions = [], $isOpen = false;

    protected $queryString = ['search'];
    protected $listeners = ['delete'];
    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role_id,
            'selectedPermissions' => 'required|array', // Los permisos deben ser seleccionados
        ];
    }

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $roles = Role::where('name', 'LIKE', $searchTerm)->orderBy('id', 'desc')->paginate(9);
        $permissions = Permission::all();

        return view('livewire.admin.role-component', compact('roles', 'permissions'))
            ->extends('admin.layouts.app');
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
        $this->selectedPermissions = [];
        $this->role_id = null;
    }

    public function store()
    {
        $validatedData = $this->validate();
        
        $role = Role::updateOrCreate(
            ['id' => $this->role_id],
            ['name' => $validatedData['name']]
        );

        // Asignamos permisos al rol
        $role->syncPermissions($this->selectedPermissions);

        session()->flash('message', $this->role_id ? 'Rol actualizado.' : 'Rol creado.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->role_id = $id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->openModal();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    public function delete($valor)
    {
        Role::find($valor['id'])->delete();
        session()->flash('message', 'Rol eliminado.');
    }
}
