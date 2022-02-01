<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssinaturaConsentimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assinatura_consentimentos', function (Blueprint $table) {
            $table->id();
            $table->string('ip_endereco', 60);
            $table->string('latitude', 20);
            $table->string('longitude', 20);
            $table->integer('dados_pessoas_id');
            $table->foreign('dados_pessoas_id')->references('id')->on('dados_pessoas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assinatura_consentimentos');
    }
}
