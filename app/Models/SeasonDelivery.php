<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonDelivery extends Model
{
    use HasFactory;
    protected $table = 'season_deliveries';

    protected $fillable = ['city', 'street', 'number', 'district',
                            'complement', 'delivery_date_time', 'output_date'];

    protected $dates = ['delivery_date_time', 'output_date'];

    public function budgetItem(){
        return $this->morphMany(BudgetItem::class, 'delivery', 'delivery_type', 'delivery_id', 'id');
    }
}
