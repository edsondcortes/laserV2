<?php

namespace App\Models;

use App\Enums\BudgetStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets';

    protected $fillable = ['adderi_budget', 'status'];

    protected $casts = [
        'status' => BudgetStatus::class
    ];

    public function itemBudget(){
        return $this->hasMany(BudgetItem::class, 'budget_id', 'id');
    }

    protected $cast = [
        'budgetStatus' => BudgetStatus::class
    ];
}
