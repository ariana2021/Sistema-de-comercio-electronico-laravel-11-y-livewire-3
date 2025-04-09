<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Attributes\On;
use Livewire\Component;

class ServiceComponent extends Component
{
    public $name, $description, $icon;
    public $services = [];
    public $serviceId = null;

    public function mount()
    {
        $this->services = Service::all();
    }

    #[On('icon-selected')]
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'icon' => 'required|string',
        ]);

        if ($this->serviceId) {
            $service = Service::find($this->serviceId);
            $service->update([
                'name' => $this->name,
                'description' => $this->description,
                'icon' => $this->icon,
            ]);
        } else {
            Service::create([
                'name' => $this->name,
                'description' => $this->description,
                'icon' => $this->icon,
            ]);
        }

        $this->reset(['name', 'description', 'icon']);
        $this->services = Service::all();
        $this->serviceId = null; 
        session()->flash('success', 'Servicio guardado con éxito.');
    }

    public function edit($id)
    {
        $service = Service::find($id);
        $this->name = $service->name;
        $this->description = $service->description;
        $this->icon = $service->icon;
        $this->serviceId = $service->id;
    }

    public function delete($id)
    {
        Service::find($id)->delete();

        $this->services = Service::all();
        session()->flash('success', 'Servicio eliminado.');
    }

    public function render()
    {
        return view('livewire.admin.service-component')->extends('admin.layouts.app');
    }
}
