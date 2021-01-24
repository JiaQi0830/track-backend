<?php

namespace App\Enums;

use BenSampo\Enum\Enum as BaseEnum;
use Illuminate\Support\Collection;

abstract class Enum extends BaseEnum
{
    public static function getCollection()
    {
        return Collection::make(self::asArray())->values()->map(function ($value) {
            return [
                "key" => self::getKey($value),
                "description" => self::getDescription($value),
                "value" => $value,
            ];
        });
    }
}
