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
		Schema::connection('mysql3')->create('application_items', function (Blueprint $table) {
			$table->id();
			$table->foreignId('application_id')->constrained()->cascadeOnDelete();
			$table->foreignId('item_id')->constrained()->cascadeOnDelete();
			$table->enum('requested_status', ['pending', 'approved', 'rejected'])->default('pending');
			$table->string('condition_before')->nullable();
			$table->string('condition_after')->nullable();
			$table->text('remarks')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('application_items');
	}
};
