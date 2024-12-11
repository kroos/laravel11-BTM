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
		Schema::create('email_group_members', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('email_application_id');
			$table->string('department_id')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->string('email_staff')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->text('remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('email_group_members');
	}
};
