<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ICMSModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ICMSModule::create(['icms_module' => 'Ketua Di Jabatan/Pusat (Head Of Department/Center)']);
        \App\Models\ICMSModule::create(['icms_module' => 'Setiausaha Jabatan/Pusat (Secretary Department/Center)']);
        \App\Models\ICMSModule::create(['icms_module' => 'Pengurusan Pentadbiran Jabatan/Pusat (Administrative Management)']);
        \App\Models\ICMSModule::create(['icms_module' => 'Pengurusan Akademik Kulliyyah (Admin Academic)']);
        \App\Models\ICMSModule::create(['icms_module' => 'Dekan (Dean)']);
        \App\Models\ICMSModule::create(['icms_module' => 'Ketua Program (Head Of Programme)']);
        \App\Models\ICMSModule::create(['icms_module' => 'Pensyarah (Lecturer)']);
        \App\Models\ICMSModule::create(['icms_module' => 'Jurulatih Ko-Kurikulum (Co-Qurriculum Trainer)']);
        \App\Models\ICMSModule::create(['icms_module' => 'Lain-lain, Sila Nyatakan. (Others, Please Specify)']);
    }
}
