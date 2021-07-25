<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProbeLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('probe_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('probe_instance_id');
            $table->foreign('probe_instance_id')->references('id')
                    ->on('probe_instances')->onDelete('cascade');
            $table->boolean('success');
            $table->string('outputs')->nullable();
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
        Schema::dropIfExists('probe_logs');
    }
}
