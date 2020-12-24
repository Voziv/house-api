<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property User $user
 * @property Temperature $latest_reading
 * @property Temperature[] $temperatures
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Room extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function temperatures()
    {
        return $this->hasMany(Temperature::class);
    }

    public function latest_reading()
    {
        return $this->hasOne(Temperature::class)->latest();
    }
}
