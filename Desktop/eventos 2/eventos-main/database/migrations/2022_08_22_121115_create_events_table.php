<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nomeEvento');
            $table->unsignedBigInteger('cep');
            $table->string('rua');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('uf');
            $table->text('complemento')->nullable();
            $table->text('descricao');
            $table->time('time');
            $table->String('imagem');
            $table->unsignedBigInteger('integranteQuantidade')->nullable();
            $table->unsignedBigInteger('integranteQuantidadePreenchidas')->nullable();
            $table->json('items')->nullable();
            $table->boolean('finalizada');
            $table->dateTime('date');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
