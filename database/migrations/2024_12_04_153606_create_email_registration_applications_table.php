<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::connection('mysql3')->create('email_registration_applications', function (Blueprint $table) {
			$table->id();
			$table->string('nostaf')->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->tinyInteger('email_for_id');
			$table->string('approver_staff')->nullable();
			$table->dateTime('approver_date')->nullable();
			$table->text('approver_remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->tinyInteger('approver_status_id')->nullable();
			$table->string('btm_approver')->nullable();
			$table->dateTime('btm_date')->nullable();
			$table->text('btm_remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->tinyInteger('status_email_id')->nullable();
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
		Schema::dropIfExists('email_applications');
	}
};
