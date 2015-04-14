<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Изменяет таблицу `servers`
 * Назначет поле `type_id` внешним ключом, который ссылается на таблицу types
 */
class AddForeignKeyToServersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('servers', function ($table) {                
                // Внешний ключ к таблице `types`
                $table->foreign('type_id')
                        ->references('id')
                        ->on('types')
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
            Schema::table('servers', function($table){                
                // Внешний ключ к таблице `types`
                $table->dropForeign('servers_type_id_foreign');
            });            
	}

}
