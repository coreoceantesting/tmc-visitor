<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Export;

class ExportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Export::factory()->count(10)->create();
    }
}
