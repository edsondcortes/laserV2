<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BudgetStatus extends Enum implements LocalizedEnum
{
    const Edition = 0;
    const Engraving = 1;
    const finished = 2;
    const canceled = 3;
}
