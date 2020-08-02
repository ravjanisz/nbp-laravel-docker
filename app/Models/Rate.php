<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rate
 *
 * @package App\Models
 */
class Rate extends Model {

    protected $table = 'rate';
    protected $hidden = ['currency_id', 'created_at', 'updated_at'];
    protected $fillable = ['currency_id', 'number', 'date', 'price'];

    /**
     * Get currency for rate
     *
     * @return mixed
     */
    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Prepare scope for search function
     *
     * @param $query
     * @param integer $currencyId
     * @param string $search
     *
     * @return mixed
     */
    public function scopeOfSearch($query, $currencyId, $search) {
        if ($search) {
            $query
                ->where('currency_id', '=', $currencyId)
                ->where('date', 'LIKE', '%' . $search . '%');
        }

        return $query;
    }

    /**
     * Prepare scope for sort function
     *
     * @param string $query
     * @param string $sort
     *
     * @return mixed
     */
    public function scopeOfSort($query, $sort) {
        if (empty($sort)) {
            $query->orderBy('date');

            return $query;
        }

        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query;
    }
}
