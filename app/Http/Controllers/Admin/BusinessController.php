<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Business::first(); // Solo habrá una empresa
        return view('admin.business.index', compact('business'));
    }

    public function update(Request $request)
    {
        $business = Business::firstOrFail(); // Aseguramos que la empresa existe

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'email' => "required|email|unique:businesses,email,{$business->id}",
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'shipping_enabled' => 'required|boolean',
            'cost_per_km' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'cashback_percentage' => 'nullable|numeric|min:0|max:100',
        ], $this->messages());

        $business->update($validated);

        return redirect()->route('business.index')->with('success', 'Empresa actualizada correctamente.');
    }

    private function messages()
    {
        return [
            'business_name.required' => 'El nombre de la empresa es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'phone.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'website.url' => 'El sitio web debe ser una URL válida.',
            'logo.image' => 'El archivo debe ser una imagen.',
            'logo.max' => 'El logo no debe superar los 2MB.',
            'shipping_enabled.required' => 'El costo base de envío es obligatorio.',
            'shipping_enabled.numeric' => 'El costo base de envío debe ser un número.',
            'shipping_enabled.required' => 'Debe indicar si el envío está habilitado o no.',
            'shipping_enabled.boolean' => 'El valor debe ser verdadero o falso.',
            'tax_percentage.numeric' => 'El porcentaje de impuestos debe ser un número.',
            'tax_percentage.min' => 'El porcentaje de impuestos no puede ser menor a 0.',
            'tax_percentage.max' => 'El porcentaje de impuestos no puede ser mayor a 100.',
        ];
    }
}
