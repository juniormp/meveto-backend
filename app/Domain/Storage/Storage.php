<?php


namespace App\Domain\Storage;


use App\Domain\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $secret_name
 * @property string $encrypted_secret
 * @property User $user
 */
class Storage extends Model
{
    protected $fillable = [
        'user_id',
        'secret_name',
        'encrypted_secret'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
