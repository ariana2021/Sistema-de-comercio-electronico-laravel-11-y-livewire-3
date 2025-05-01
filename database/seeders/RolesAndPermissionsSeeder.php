<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Crear permisos
        Permission::create(['name' => 'ver acerca de nosotros']);
        Permission::create(['name' => 'editar acerca de nosotros']);
        Permission::create(['name' => 'gestionar páginas']);
        Permission::create(['name' => 'ver configuración del negocio']);
        Permission::create(['name' => 'actualizar configuración del negocio']);
        Permission::create(['name' => 'gestionar permisos']);
        Permission::create(['name' => 'gestionar usuarios']);
        Permission::create(['name' => 'gestionar publicaciones']);
        Permission::create(['name' => 'gestionar comentarios']);
        Permission::create(['name' => 'gestionar valoraciones']);
        Permission::create(['name' => 'gestionar servicios']);
        Permission::create(['name' => 'gestionar sliders']);
        Permission::create(['name' => 'gestionar cupones']);
        Permission::create(['name' => 'gestionar marcas']);
        Permission::create(['name' => 'gestionar categorías']);
        Permission::create(['name' => 'gestionar productos']);
        Permission::create(['name' => 'subir imágenes de productos']);
        Permission::create(['name' => 'eliminar imágenes de productos']);
        Permission::create(['name' => 'gestionar pedidos']);

        // Crear rol admin
        $adminRole = Role::create(['name' => 'admin']);

        // Asignar permisos al rol admin
        $adminRole->givePermissionTo([
            'ver acerca de nosotros',
            'editar acerca de nosotros',
            'gestionar páginas',
            'ver configuración del negocio',
            'actualizar configuración del negocio',
            'gestionar permisos',
            'gestionar usuarios',
            'gestionar publicaciones',
            'gestionar comentarios',
            'gestionar valoraciones',
            'gestionar servicios',
            'gestionar sliders',
            'gestionar cupones',
            'gestionar marcas',
            'gestionar categorías',
            'gestionar productos',
            'subir imágenes de productos',
            'eliminar imágenes de productos',
            'gestionar pedidos'
        ]);

        // Crear rol soporte
        $soporteRole = Role::create(['name' => 'soporte']);

        // Asignar permisos al rol soporte
        $soporteRole->givePermissionTo([
            'gestionar comentarios',
            'gestionar publicaciones',
            'gestionar valoraciones',
            'gestionar pedidos',
            'ver acerca de nosotros'
        ]);

        // Crear rol asistente
        $asistenteRole = Role::create(['name' => 'asistente']);

        // Asignar permisos al rol asistente
        $asistenteRole->givePermissionTo([
            'gestionar productos',
            'gestionar categorías',
            'gestionar marcas',
            'gestionar pedidos',
            'ver acerca de nosotros'
        ]);

        // Crear rol trabajador
        $trabajadorRole = Role::create(['name' => 'trabajador']);

        // Asignar permisos al rol trabajador
        $trabajadorRole->givePermissionTo([
            'gestionar productos',
            'gestionar categorías',
            'gestionar marcas',
            'gestionar pedidos'
        ]);
    }
}
