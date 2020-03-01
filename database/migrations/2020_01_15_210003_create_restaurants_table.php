<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->string('address');
			$table->decimal('minimum_order');
			$table->decimal('delivery_cost');
			$table->string('whats_num');
			$table->string('phone_contact');
			$table->string('image');
			$table->enum('activation', array('active', 'deactive'));
			$table->string('pin_code');
			$table->integer('district_id')->unsigned();
			$table->integer('rate');
			$table->string('api_token',60)->unique()->nullable();

		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
