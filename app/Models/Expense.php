<?php

namespace App\Models;

use App\Events\ExpenseCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    public $timestamps = true;

    protected $fillable = [
        'description',
        'date',
        'user_id',
        'amount',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}