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
		Schema::connection('mysql3')->create('loan_equipments', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('application_id');
			$table->unsignedBigInteger('equipment_id');
			$table->dateTime('taken_on')->nullable();
			$table->dateTime('return_on')->nullable();
			$table->unsignedBigInteger('status_item_id')->nullable();
			$table->text('status_condition_remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->text('remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->timestamps();
			$table->foreign('application_id')->references('id')->on('loan_applications');
			$table->foreign('equipment_id')->references('id')->on('equipments');
			// $table->foreign('status_item_id')->references('id')->on('status_equipments');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('loan_equipments');
	}
};
