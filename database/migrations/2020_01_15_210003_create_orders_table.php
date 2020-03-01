<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->text('notes');
			$table->string('address');
			$table->enum('state', array('pending', 'accepted', 'rejected', 'delivered', 'declined','confirmed','cart'));
			$table->decimal('cost');
			$table->decimal('commission');
			$table->decimal('total');
			$table->integer('payment_method_id')->unsigned();
			$table->decimal('net');

		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
