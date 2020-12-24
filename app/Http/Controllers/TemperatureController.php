<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Temperature;
use Illuminate\Http\Request;

class TemperatureController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function addReading(Request $request, string $slug)
    {
        /** @var Room $room */
        $room = Room::query()->where('slug', $slug)->first();

        if (!$room) {
            return $this->buildFailedValidationResponse(
                $request,
                ['slug' => sprintf('Invalid room slug: \'%s\'', $slug)]
            );
        }

        $temperature = $request->input('temperature');
        $humidity = $request->input('humidity');

        if (!$temperature && !$humidity) {
            return $this->buildFailedValidationResponse(
                $request,
                [
                    'temperature' => 'You must at least provide one of the following: [temperature, humidity]',
                    'humidity' => 'You must at least provide one of the following: [temperature, humidity]',
                ]
            );
        }

        $room->temperatures()->save(
            new Temperature(
                [
                    'temperature' => $temperature,
                    'humidity' => $humidity,
                ]
            )
        );
    }
}
