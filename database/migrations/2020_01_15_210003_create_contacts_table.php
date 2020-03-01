<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->text('message');
			$table->enum('type', array('suggestion', 'complaint', 'inquiry'));
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}