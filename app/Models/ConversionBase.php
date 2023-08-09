<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConversionBase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conversion_bases';

    protected $with = [
        'conversionRates'
    ];

    protected $fillable = [
        'date',
        'base',
    ];

    public function conversionRates(): HasMany
    {
        return $this->hasMany(ConversionRate::class, 'conversion_base_id', 'id');
    }
}
