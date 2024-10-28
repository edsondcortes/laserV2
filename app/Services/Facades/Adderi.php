<?php

namespace App\Services\Facades;

use App\Services\Adderi\Budget;
use App\Services\Adderi\BudgetItem;
use App\Services\Adderi\People;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Budget budget()
 * @method static BudgetItem budgetItem()
 * @method static People people()
 * @method static int reduceNumber($number)
 */

class Adderi extends Facade {
    protected static function getFacadeAccessor(): string
    { return 'adderiService'; }
}
