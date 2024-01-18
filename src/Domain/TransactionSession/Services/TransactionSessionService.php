<?php

namespace Inventory\TransactionSession\Services;

use App\Models\TransactionSession;

class TransactionSessionService
{
    protected static function generator()
    {
        return str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    }

    public static function create(): TransactionSession
    {
        return TransactionSession::create(['session_no' => static::generator()]);
    }
}
