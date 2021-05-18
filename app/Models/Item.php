<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperItem
 */
class Item extends Model
{
    use HasFactory;

    public $incrementing = false;

    public function owner(): BelongsToMany
    {
        return $this->belongsToMany(Character::class)->withPivot('quantity');
    }
}
