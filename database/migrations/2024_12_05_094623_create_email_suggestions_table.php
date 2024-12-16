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
		Schema::connection('mysql3')->create('email_suggestions', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('email_application_id');
			$table->string('email_suggestion')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->string('temp_password')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->integer('approved_email')->nullable();
			$table->text('remarks')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('email_suggestions');
	}
};
