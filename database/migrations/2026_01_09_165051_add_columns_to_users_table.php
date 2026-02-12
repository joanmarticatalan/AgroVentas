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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('localizacion_id')->nullable()->constrained('localizaciones');
            $table->string('telefono', 14);
            $table->enum('tipoCliente', ['comprador', 'vendedor', 'compraventa', 'admin'])->default('comprador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('localizacion_id');
            $table->dropColumn(['telefono', 'tipoCliente']);
        });
    }
};
