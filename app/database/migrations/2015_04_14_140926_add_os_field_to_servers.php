<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOsFieldToServers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('servers', function($table) {
                $table->text('os')->after('ram')->nullable();
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
             Schema::table('servers', function($table) {
                $table->dropColumn('os');
            });
	}

}
