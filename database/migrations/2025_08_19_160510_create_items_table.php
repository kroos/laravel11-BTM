<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	protected $connection = 'mysql3';
	public function up(): void
	{
		Schema::connection('mysql3')->create('items', function (Blueprint $table) {
			$table->id();
			$table->foreignId('category_id')->constrained()->cascadeOnDelete();
			$table->string('brand')->nullable();
			$table->string('model')->nullable();
			$table->string('serial_number')->unique();
			$table->enum('current_status', ['available', 'reserved', 'borrowed', 'damaged', 'maintenance', 'lost'])->default('available');
			$table->string('location')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('items');
	}
};
