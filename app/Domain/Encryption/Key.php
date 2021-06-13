<?php


namespace App\Domain\Encryption;


use App\Domain\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $public_key
 */
class Key extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'public_key'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
