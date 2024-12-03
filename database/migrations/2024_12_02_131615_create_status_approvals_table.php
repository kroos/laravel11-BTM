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
		Schema::create('status_approvals', function (Blueprint $table) {
			$table->id();
			$table->string('status_approval')->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->text('remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('status_approvals');
	}
};
