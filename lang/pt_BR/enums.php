<?php

use App\Enums\BudgetStatus;
use App\Enums\ProductionForm;

return [
    BudgetStatus::class => [
        BudgetStatus::Engraving => "em Gravação",
        BudgetStatus::Edition => 'em Edição',
        BudgetStatus::finished => 'Finalizado',
        BudgetStatus::canceled => 'Cancelado'
    ],

    ProductionForm::class => [
        ProductionForm::standard => 'Padrão',
        ProductionForm::express => 'Expressa',
        ProductionForm::conversion => 'Conversão'
    ],
];
