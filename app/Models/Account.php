<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Type\Decimal;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'balance',
        'user_id',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    private function setCode(): string
    {
        $generator = "0123456789";
        $result = "";

        for ($i= 0; $i < 10; $i++) {
            $result .= substr($generator, rand() % strlen($generator), 1);
        }
        return $result;
    }

    public function createUserAccount(int $userId, string $type)
    {
        Account::create([
            'code' => $this->setCode(),
            'balance' => new Decimal("0"),
            'user_id' => $userId,
            'type' => $type
        ]);
    }
}
