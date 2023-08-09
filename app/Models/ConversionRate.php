<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConversionRate extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conversion_rates';

    protected $fillable = [
        'conversion_base_id',
        'currency',
        'rate',
    ];

    public function conversionBase(): HasOne
    {
        return $this->hasOne(ConversionBase::class, 'id', 'conversion_base_id');
    }
}
