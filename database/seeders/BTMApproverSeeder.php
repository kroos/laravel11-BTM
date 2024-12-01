<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BTMApproverSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// DB::table('btm_approval')->insert([
		// 		[
		// 			// 'name' => Str::random(10),
		// 			// 'email' => Str::random(10).'@example.com',
		// 			// 'password' => Hash::make('password'),
		// 			'nostaf' => '2262007',
		// 			'active' => 1,
		// 		], [
		// 			'nostaf' => '10432014',
		// 			'active' => 1,
		// ]]);

		// or (complete with timestamp)
		\App\Models\Settings\BTMApprover::create(['nostaf' => '2262007', 'active' => 1]);
		\App\Models\Settings\BTMApprover::create(['nostaf' => '10432014', 'active' => 1]);
	}
}
