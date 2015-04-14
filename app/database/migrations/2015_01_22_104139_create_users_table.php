<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
        {
            Schema::create('users', function(Blueprint $table) {
                // ID пользователя
                $table->increments('id');

                // E-Mail (уникальный)
                $table->string('email')->unique();

                // Пароль. Для используемой в Laravel хэш-функции требуется не меньше 60 символов
                $table->string('password', 60);

                // Никнейм
                $table->string('username')->unique();

                // Токен для возможности запоминания пользователя
                $table->rememberToken(); // remember_token

                // created_at, updated_at
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
            Schema::dropIfExists('users');
	}

}
