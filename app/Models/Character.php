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

    protected $fillable = ['name', 'currency'];

    public function inventory(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    public function formatCurrency()
    {
        $g = (int) ($this->currency / 10000);
        $s = (int) (($this->currency - $g *10000) / 100);
        $c = (int) ($this->currency - $g *10000 - $s * 100);
        return [
            'gold' => $g,
            'silver' => $s,
            'copper' => $c
        ];
    }
}
