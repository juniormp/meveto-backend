<?php

namespace App\Domain\Auth;

use App\Domain\Encryption\Key;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $username
 * @property Key $key
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
}
