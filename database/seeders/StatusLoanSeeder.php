<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusLoanSeeder extends Seeder
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
		// 			'status_loan' => 'Permohonan Diluluskan',
		// 		], [
		// 			'status_loan' => 'Permohonan Tidak Diluluskan',
		// 		], [
		// 			'status_loan' => 'Permohonan Sedang Diproses',
		// ]]);

		// or
		\App\Models\StatusLoan::create(['status_loan' => 'Permohonan Diluluskan']);
		\App\Models\StatusLoan::create(['status_loan' => 'Permohonan Tidak Diluluskan']);
		\App\Models\StatusLoan::create(['status_loan' => 'Permohonan Sedang Diproses']);
	}
}
