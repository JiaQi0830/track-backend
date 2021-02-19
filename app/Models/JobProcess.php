<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobProcess extends Model
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

    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }

}
