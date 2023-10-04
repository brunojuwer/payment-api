<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Operation;

class Transaction extends Model
{
    use HasFactory;

    public Operation $operation;

    public function Accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class);
    }
}
