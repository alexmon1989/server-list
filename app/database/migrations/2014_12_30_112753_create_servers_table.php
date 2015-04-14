<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('servers', function ($table) {
                // Поля таблицы
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('ip', 15)->nullable();
                $table->timestamp('start_date')->nullable();
                $table->integer('type_id')->unsigned();
                $table->integer('physical_server_id')->nullable()->unsigned();
                $table->string('doc_name')->nullable();
                $table->timestamps();
                
                // Внешний ключ к полю id
                $table->foreign('physical_server_id')
                        ->references('id')
                        ->on('servers')                        
                        ->onDelete('cascade');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::dropIfExists('servers');
	}

}
