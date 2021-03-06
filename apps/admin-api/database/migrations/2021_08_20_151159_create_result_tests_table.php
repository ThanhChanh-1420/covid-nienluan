<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_tests', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['positive', 'negative']);

            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('create_by')
                ->references('id')
                ->on('users')
                ->constrained()
                ->onUpdate('cascade');
                // ->onDelete('cascade');
                
            //Default famework columns
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
        Schema::dropIfExists('result_tests');
    }
}
