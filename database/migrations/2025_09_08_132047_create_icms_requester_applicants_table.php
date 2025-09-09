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
		Schema::connection('mysql3')->create('icms_requester_applicants', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('icms_requester_id');
			$table->string('nostaf')->charset('utf8mb4')->collation('utf8mb4_general_ci');
			// $table->foreignId('nostaf')/*->references('nostaf')->on('portal_staf.users')*/->constrained();
			$table->string('position')->charset('utf8mb4')->collation('utf8mb4_general_ci');
			$table->boolean('menu_setting_only')->nullable();
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
		Schema::dropIfExists('icms_requester_applicants');
	}
};
