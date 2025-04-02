<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('business_name'); // Nombre de la empresa
            $table->string('legal_name')->nullable(); // Razón social
            $table->string('tax_id')->nullable(); // Identificación fiscal
            $table->string('email')->unique(); // Correo de contacto
            $table->string('phone')->nullable(); // Teléfono
            $table->string('website')->nullable(); // Sitio web
            $table->string('logo')->nullable(); // Logo de la empresa
            $table->decimal('cashback_percentage', 10, 2)->default(0); //
            $table->text('description')->nullable(); // Descripción de la empresa

            // Dirección
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();

            // Ubicación geográfica
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Configuración de envíos
            $table->boolean('shipping_enabled')->default(true);
            $table->decimal('cost_per_km', 8, 2)->default(2.00); // Costo por kilómetro

            // Configuración fiscal
            $table->decimal('tax_percentage', 5, 2)->default(0.00); // Impuesto aplicado
            $table->boolean('tax_included')->default(false); // Si el precio incluye impuestos
            $table->string('invoice_series')->nullable(); // Serie de facturación

            // Redes sociales
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
