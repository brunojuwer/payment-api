<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;

class AccountService {

  public static function transferValue($data) {
    
    $value = floatval($data['amount']);

    try {
      DB::beginTransaction();

        DB::table('accounts')
          ->where('code', $data['fromAccount'])
          ->decrement('balance', $value);
  
        DB::table('accounts')
          ->where('code', $data['toAccount'])
          ->increment('balance', $value);

      DB::commit();

    } catch (Exception $exception) {
      DB::rollBack();
    }
  }
}
