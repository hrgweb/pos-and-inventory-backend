<?php

namespace Inventory\Order\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case VOID = 'void';
}