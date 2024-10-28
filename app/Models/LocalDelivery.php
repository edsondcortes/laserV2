<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalDelivery extends Model
{
    use HasFactory;
    protected $table = 'local_deliveries';

    protected $fillable = ['date_time_delivery', 'output_date'];

    protected $dates = ['date_time_delivery', 'output_date'];

    public function budgetItem(){
        return $this->MorphMany(BudgetItem::class, 'delivery', 'delivery_type', 'delivery_id', 'id');
    }
}
