<?php

namespace App\Enums;


use Spatie\Enum\Enum;

/**
 * @method static self pending()
 * @method static self processing()
 * @method static self completed()
 * @method static self error()
 */
class StatusUploadsEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'pending' => 'pending',
            'processing' => 'processing',
            'completed' => 'completed',
            'error' => 'error',
        ];
    }
}
