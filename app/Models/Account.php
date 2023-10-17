<?php

namespace App\Models;

use App\Exceptions\AccountNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;
use Throwable;

class Account extends Model
{
    use HasFactory;

    private $balance;

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

    private function withdraw($value) {
        $this->balance -= $value;
    }

    private function deposit($value) {
        $this->balance += $value;
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

    public static function findAccountByCodeOrFail(string $code): self
    {
        try {
            return Account::query()
                ->select()
                ->where('code', $code)
                ->firstOrFail();
        } 
        catch(Throwable) {
            throw new AccountNotFoundException($code);
        }
    }
}
