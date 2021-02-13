<?php

namespace App\Models;

use App\Models\ProcessStep;
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
        return $this->belongsToMany(Step::class, 'process_steps')->withPivot('expected_date', 'completed_date', 'completed_by');
    }

    public function processSteps()
    {
        return $this->hasMany(ProcessStep::class, 'process_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
