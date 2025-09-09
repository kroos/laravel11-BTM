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
        Schema::connection('mysql3')->table('icms_requester_applicants', function (Blueprint $table) {
            $table->string('username')->after('menu_setting_only');   // change 'id' to whichever column you want it after
            $table->string('password')->after('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icms_requester_applicants', function (Blueprint $table) {
            $table->dropColumn(['username', 'password']);
        });
    }
};
