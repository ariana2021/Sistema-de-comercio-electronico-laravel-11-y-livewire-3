<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 2);
            $table->date('date');
            $table->enum('status', ['Activo', 'Inactivo'])->default('Activo');
            $table->decimal('paid_with', 10, 2);
            $table->decimal('use_cashback', 10, 2)->default(0);
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();

            $table->foreign('payment_method_id')
                ->references('id')->on('payment_methods')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('client_id')
                ->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
