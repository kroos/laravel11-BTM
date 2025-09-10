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
		Schema::connection('mysql3')->table('icms_applicant_modules', function (Blueprint $table) {
			$table->renameColumn('icms_requester_module_id', 'icms_applicant_module_id')->change();
			$table->integer('icms_applicant_module_id')->change();
			$table->dropColumn('icms_module_id');
			// $table->foreign('icms_module_id')->references('id')->on('icms_modules');
			$table->foreignId('icms_module_id')->constrained()->after('icms_applicant_module_id');

		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('icms_applicant_modules', function (Blueprint $table) {
			$table->renameColumn('icms_applicant_module_id', 'icms_requester_module_id')->change();
			$table->unsignedBigInteger('icms_requester_module_id')->change();
			$table->dropForeign('icms_applicant_modules_icms_module_id_foreign');
		});
	}
};
