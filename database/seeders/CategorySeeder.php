<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// this method no timestamp
		// DB::table('categories')->insert([
		// 		[
		// 			// 'name' => Str::random(10),
		// 			// 'email' => Str::random(10).'@example.com',
		// 			// 'password' => Hash::make('password'),
		// 			'category' => 'Network Peripheral',
		// 		], [
		// 			'category' => 'Audio Visual Apparatus',
		// 		], [
		// 			'category' => 'Computers And Notebooks',
		// ]]);

		// or (complete with timestamp)
		\App\Models\Settings\Category::create(['category' => 'Network Peripheral']);
		\App\Models\Settings\Category::create(['category' => 'Audio Visual Apparatus']);
		\App\Models\Settings\Category::create(['category' => 'Computers And Notebooks']);
	}
}
