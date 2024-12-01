<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusEquipmentsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// DB::table('status_equipments')->insert([
		// 		[
		// 			// 'name' => Str::random(10),
		// 			// 'email' => Str::random(10).'@example.com',
		// 			// 'password' => Hash::make('password'),
		// 			'status_item' => 'OK',
		// 		], [
		// 			'status_item' => 'Damage',
		// 		], [
		// 			'status_item' => 'Obsolete',
		// 		], [
		// 			'status_item' => 'Under Repair',
		// ]]);

		// or
		\App\Models\StatusEquipment::create(['status_item' => 'OK']);
		\App\Models\StatusEquipment::create(['status_item' => 'Damage']);
		\App\Models\StatusEquipment::create(['status_item' => 'Obsolete']);
		\App\Models\StatusEquipment::create(['status_item' => 'Under Repair']);
	}
}
