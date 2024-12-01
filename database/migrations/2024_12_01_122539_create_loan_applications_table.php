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
		Schema::create('loan_applications', function (Blueprint $table) {
			$table->id();
			$table->string('nostaf')->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->dateTime('date_loan_from')->nullable();
			$table->dateTime('date_loan_to')->nullable();
			$table->dateTime('equipment_pickup_date')->nullable();
			$table->text('loan_purpose')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->string('approver_staff')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->dateTime('approver_date')->nullable();
			$table->text('approver_remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->string('btm_approver')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->dateTime('btm_date')->nullable();
			$table->text('btm_remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->tinyInteger('status_loan_id')->nullable();
			$table->tinyInteger('active')->nullable();
			$table->text('remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('loan_applications');
	}
};
