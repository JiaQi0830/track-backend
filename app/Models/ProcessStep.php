<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessStep extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'completed_by', 'completed_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function step(): BelongsTo
    {
        return $this->belongsTo(Step::class);
    }

}
