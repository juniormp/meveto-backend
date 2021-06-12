<?php


namespace App\Domain\Encryption;


use App\Domain\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $public_key
 * @property string $private_key
 */
class Key extends Model
{
    protected $fillable = [
        'user_id',
        'public_key',
        'private_key'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
