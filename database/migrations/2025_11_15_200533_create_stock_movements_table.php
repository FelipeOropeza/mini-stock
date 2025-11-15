<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            // produto movimentado
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // entrada ou saída
            $table->enum('type', ['entrada', 'saida']);

            // quantidade movimentada
            $table->integer('quantity');

            // saldo antes da movimentação
            $table->integer('previous_stock');

            // saldo depois da movimentação
            $table->integer('final_stock');

            // usuário que realizou a ação
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
