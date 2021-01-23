<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'created_by'
    ];

    public function steps()
    {
        return $this->belongsToMany(Step::class, 'process_steps')->withPivot('expected_date', 'completed_date');
    }
}
