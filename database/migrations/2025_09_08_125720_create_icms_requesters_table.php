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
		Schema::connection('mysql3')->create('icms_requesters', function (Blueprint $table) {
			$table->id();
			$table->string('nostaf')->charset('utf8mb4')->collation('utf8mb4_general_ci');
			// $table->foreignId('nostaf')/*->references('nostaf')->on('portal_staf.users')*/->constrained();
			$table->string('approver_staff')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->dateTime('approver_date')->nullable();
			$table->text('approver_remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->tinyInteger('approver_status_id')->nullable();
			$table->string('btm_approver')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->dateTime('btm_date')->nullable();
			$table->text('btm_remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->tinyInteger('status_loan_id')->nullable();
			$table->text('remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('icms_requesters');
	}
};
