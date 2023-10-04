<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Type\Decimal;

class Account extends Model
{
    use HasFactory;

    private string $code;
    private string $type;
    private Decimal $balance;

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getCode(): string 
    {
        return $this->code;
    }

    public function setCode(): void
    {
        $generator = "0123456789";
        $result = "";

        for ($i= 0; $i < 10; $i++) { 
            $result .= substr($generator, rand() % strlen($generator), 1);
        }
        $this->code = $result;
    }
}
