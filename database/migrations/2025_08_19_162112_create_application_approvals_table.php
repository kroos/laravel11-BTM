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
		Schema::connection('mysql3')->create('application_approvals', function (Blueprint $table) {
			$table->id();
			$table->foreignId('application_id')->constrained()->cascadeOnDelete();
			$table->foreignId('approver_id')->constrained('users')->cascadeOnDelete();
			$table->enum('role_at_approval', ['hod', 'admin']);
			$table->enum('decision', ['approved', 'rejected', 'partial']);
			$table->text('remarks')->nullable();
			$table->softDeletes();
			$table->timestamp('decided_at')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('application_approvals');
	}
};
