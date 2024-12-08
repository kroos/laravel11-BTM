<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * The database connection that should be used by the migration.
	 *
	 * @var string
	 */
	protected $connection = 'mysql3';

	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::connection('mysql3')->create('equipments', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('category_id');
			$table->string('item')->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->string('brand')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->string('model')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->string('serial_number')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->text('description')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->tinyInteger('status');
			$table->timestamps();
			$table->foreign('category_id')->references('id')->on('categories');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('equipments');
	}
};
