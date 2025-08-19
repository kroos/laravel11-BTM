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
		Schema::connection('mysql3')->create('item_status_history', function (Blueprint $table) {
			$table->id();
			$table->foreignId('item_id')->constrained()->cascadeOnDelete();
			$table->enum('status', ['available', 'reserved', 'borrowed', 'damaged', 'maintenance', 'lost']);
			$table->foreignId('changed_by')->constrained('users')->cascadeOnDelete();
			$table->timestamp('changed_at')->useCurrent();
			$table->softDeletes();
			$table->text('remarks')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('item_status_history');
	}
};
