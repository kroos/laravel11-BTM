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
		Schema::connection('mysql3')->create('dept_approval', function (Blueprint $table) {
			$table->id();
			$table->string('nostaf')->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->string('kod_jabatan')->charset('utf8mb4')->collation('utf8mb4_general_ci');
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
		Schema::dropIfExists('dept_approval');
	}
};
