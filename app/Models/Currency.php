<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 *
 * @package App\Models
 */
class Currency extends Model {

    protected $table = 'currency';
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = ['code', 'name'];

    /**
     * Get currency rates
     *
     * @return mixed
     */
    public function rates() {
        return $this->hasMany(Rate::class);
    }
}
