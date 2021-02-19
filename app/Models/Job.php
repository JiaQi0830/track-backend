<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'created_by'
    ];

    public function processes()
    {
        return $this->belongsToMany(Process::class, 'job_processes')->withPivot('expected_date', 'completed_date', 'completed_by');
    }

    public function jobProcesses()
    {
        return $this->hasMany(JobProcess::class, 'job_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
