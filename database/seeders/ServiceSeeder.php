<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Crear 4 servicios para una ferretería
        Service::create([
            'name' => 'Entrega a domicilio',
            'description' => 'Entrega rápida de productos directamente a tu hogar o empresa.',
            'icon' => 'fas fa-truck',
        ]);

        Service::create([
            'name' => 'Asesoría técnica gratuita',
            'description' => 'Recibe asesoría sobre el uso correcto de herramientas y productos.',
            'icon' => 'fas fa-cogs',
        ]);

        Service::create([
            'name' => 'Garantía extendida',
            'description' => 'Ofrecemos una garantía extendida en productos seleccionados.',
            'icon' => 'fas fa-shield-alt',
        ]);

        Service::create([
            'name' => 'Corte y personalización de materiales',
            'description' => 'Realizamos cortes y personalización de madera, metal y otros materiales.',
            'icon' => 'fas fa-cut',
        ]);
    }
}