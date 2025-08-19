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
		Schema::connection('mysql3')->create('applications', function (Blueprint $table) {
			$table->id();
			$table->foreignId('nostaf')->constrained()->cascadeOnDelete(); // requester
			// $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
			$table->date('start_date');
			$table->date('end_date');
			$table->enum('status', ['pending_hod', 'pending_admin', 'approved', 'rejected', 'cancelled', 'returned', 'overdue'])->default('pending_hod');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('applications');
	}
};
