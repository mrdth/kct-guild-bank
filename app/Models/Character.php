<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperCharacter
 */
class Character extends Model
{
    use HasFactory;

    public function inventory(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }
}
