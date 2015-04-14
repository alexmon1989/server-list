<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToServers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('servers', function($table) {
                $table->text('cpu')->after('doc_name')->nullable();
                $table->text('hdd')->after('cpu')->nullable();
                $table->text('ram')->after('hdd')->nullable();
                $table->text('inventory_number')->after('ram')->nullable();
                $table->text('serial_number')->after('inventory_number')->nullable();
                $table->text('appointment')->after('serial_number')->nullable();
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
                $table->dropColumn('cpu');
                $table->dropColumn('hdd');
                $table->dropColumn('ram');
                $table->dropColumn('inventory_number');
                $table->dropColumn('serial_number');
                $table->dropColumn('appointment');
            });
	}

}
