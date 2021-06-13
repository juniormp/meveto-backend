<?php

namespace App\Domain\Auth;

use App\Domain\Encryption\Key;
use App\Domain\Storage\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $username
 * @property Key $key
 * @property Collection $storages
 */
class User extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username'
    ];

    public function key(): HasOne
    {
        return $this->hasOne(Key::class);
    }

    public function storages(): HasMany
    {
        return $this->hasMany(Storage::class);
    }
}
