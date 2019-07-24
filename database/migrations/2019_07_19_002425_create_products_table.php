<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->string('name');
            $table->string('category');
            $table->string('description');
            $table->decimal('price', 10, 2);
            $table->json('images')->nullable();
            $table->json('kit')->nullable();
            $table->timestamps();

            /*
                Nome do produto
                Categoria (A categoria terá de ser exatamente alguma categoria final do Mercado Livre, ou seja, você precisará utilizar a API de categorias do Mercado Livre e navegar até o seu último nível.)
                Descrição
                Preço
                Imagens
                KIT
                https://api.mercadolibre.com/categories/MLB114675
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
