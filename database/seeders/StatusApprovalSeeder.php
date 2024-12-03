<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusApprovalSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// DB::table('status_loans')->insert([
		// 		[
		// 			// 'name' => Str::random(10),
		// 			// 'email' => Str::random(10).'@example.com',
		// 			// 'password' => Hash::make('password'),
		// 			'status_approval' => 'Permohonan Disokong',
		// 		], [
		// 			'status_approval' => 'Permohonan Tidak Disokong',
		// ]]);

		// or
		\App\Models\StatusApproval::create(['status_approval' => 'Permohonan Disokong']);
		\App\Models\StatusApproval::create(['status_approval' => 'Permohonan Tidak Disokong']);
	}
}
