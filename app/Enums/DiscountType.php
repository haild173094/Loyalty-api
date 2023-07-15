<?php

namespace App\Enums;

enum DiscountType: string
{
    case Amount = "amount";
    case Percentage = "percentage";
}
