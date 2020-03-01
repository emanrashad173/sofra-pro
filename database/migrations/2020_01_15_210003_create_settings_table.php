<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('about_app');
			$table->decimal('commission');
			$table->text('commission_text');
			$table->text('head_text');
			$table->string('app_link');
			$table->string('payment_bank');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
