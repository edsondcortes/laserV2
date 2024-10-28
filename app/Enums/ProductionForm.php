<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProductionForm extends Enum
{
    const standard = 1;
    const express = 2;
    const conversion = 3;
}
