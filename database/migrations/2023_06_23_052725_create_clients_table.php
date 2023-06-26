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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('asaas_id')->nullable();

            $table->string('cpf_cnpj',14)->unique();
            $table->string('name', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 11)->nullable();

            $table->string('postal_code',9)->nullable();
            $table->string('address',100)->nullable();
            $table->string('address_number',10)->nullable();
            $table->string('complement',50)->nullable();
            $table->string('province',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
