<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOnTime extends Model
{
    use HasFactory;

    protected $table = 'delivery_on_times';

    public function budgetItem(){
        return $this->morphMany(BudgetItem::class, 'delivery', 'delivery_type', 'delivery_id', 'id');
    }
}
