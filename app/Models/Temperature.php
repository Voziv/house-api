<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $temperature
 * @property string $humidity
 * @property Room $room
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Temperature extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'temperature',
        'humidity',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
