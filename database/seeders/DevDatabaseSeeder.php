<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Temperature;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DevDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            'Basement Office',
            'Bedroom #1',
            'Bedroom #2',
            'Bedroom #3',
            'Dining Room',
            'Garage',
            'Laundry Room',
            'Living Room',
            'Shed',
            'TV Room',
            'Voziv Office',
        ];

        $user = User::factory()->create(
            [
                'name' => 'Voziv',
                'api_token' => 'voziv_dev_token',
                'is_admin' => true,
            ]
        );

        foreach ($rooms as $room) {
            $slug = Str::slug($room);
            Room::factory(['name' => $room, 'slug' => $slug])
                ->for($user, 'user')
                ->create();
        }
    }
}
