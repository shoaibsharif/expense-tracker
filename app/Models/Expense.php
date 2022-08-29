<?php

namespace App\Models;

use App\Events\ExpenseDeletedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * The event map for the model
     *
     * @var array
     */
    protected $dispatchesEvents = [
        "deleting" => ExpenseDeletedEvent::class,
    ];
}
