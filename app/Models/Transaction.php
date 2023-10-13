<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;

    public const DEPOSIT = 'DEPOSIT';
    public const WITHDRAW = 'WITHDRAW';


    protected $fillable = [
        'amount',
        'account_code',
        'foreign_account',
        'type',
        'operation'
    ];

    public function Accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class);
    }

    public static function createDepositTransaction($data, $operation): Transaction
    {
        return Transaction::create([
            'amount' => $data['amount'],
            'account_code' => $data['toAccount'],
            'foreign_account' => $data['fromAccount'],
            'type' => Transaction::DEPOSIT,
            'operation' => $operation,
        ]);
    }
    public static function createWithdrawTransaction($data, $operation): Transaction
    {
        return Transaction::create([
            'amount' => $data['amount'],
            'account_code' => $data['fromAccount'],
            'foreign_account' => $data['toAccount'],
            'type' => Transaction::WITHDRAW,
            'operation' => $operation,
        ]);
    }

}
