<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomsController extends Controller
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

    public function listRooms(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        return $user->rooms()->with('latest_reading')->get();
    }

    public function getRoom(Request $request, string $slug)
    {
        /** @var Room $room */
        $room = Room::query()->where('slug', $slug)->first();

        if (!$room) {
            return $this->buildFailedValidationResponse(
                $request,
                ['slug' => sprintf('Invalid room slug: \'%s\'', $slug)]
            );
        }
        return $room->load('latest_reading');
    }

    public function createRoom(Request $request)
    {
        $name = $request->input('name');
        $slug = Str::slug($name);

        /** @var Room $room */
        $room = Room::query()->where('slug', $slug)->first();

        if ($room) {
            return $this->buildFailedValidationResponse(
                $request,
                ['slug' => sprintf('Room name must generate a unique slug: \'%s\' => \'%s\'', $name, $slug)]
            );
        }
        $room = new Room(['name' => $name, 'slug' => $slug]);
        $request->user()->rooms()->save($room);
        return $room;
    }

    public function saveRoom(Request $request, string $slug)
    {
        /** @var Room $room */
        $room = Room::query()->where('slug', $slug)->first();

        if ($room) {
            return $this->buildFailedValidationResponse(
                $request,
                ['slug' => sprintf('Invalid room slug: \'%s\'', $slug)]
            );
        }

        $name = $request->input('name');
        $newSlug = Str::slug($name);


        if (Room::query()->where('slug', $newSlug)->exists()) {
            return $this->buildFailedValidationResponse(
                $request,
                ['slug' => sprintf('Room name must generate a unique slug: \'%s\' => \'%s\'', $name, $slug)]
            );
        }

        $room->name = $name;
        $room->slug = $newSlug;

        $room->save();

        return $room;
    }
}
