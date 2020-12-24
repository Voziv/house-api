<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Temperature;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DevDatabaseSeeder::class);
    }
}
