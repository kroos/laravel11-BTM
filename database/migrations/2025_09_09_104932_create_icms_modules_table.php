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
        Schema::connection('mysql3')->create('icms_modules', function (Blueprint $table) {
            $table->id();
            $table->string('icms_module');
            $table->text('description')->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
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
        Schema::dropIfExists('icms_modules');
    }
};
