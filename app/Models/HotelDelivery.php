<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class HotelDelivery extends Model
{
    use HasFactory;
    protected $table = 'hotel_deliveries';

    protected $fillable = ['room', 'name_hotel', 'output_date_time', 'output_date'];

    protected $dates = ['output_date_time', 'output_date'];

    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }

    public function budgetItem(){
        return $this->MorphMany(BudgetItem::class, 'delivery', 'delivery_type', 'delivery_id', 'id');
    }
}
