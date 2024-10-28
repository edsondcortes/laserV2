<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Delivery extends Model
{
    use HasFactory;
    protected $table = 'deliveries';

    protected $fillable = ['address_id'];

    public function budgetItem(){
        return $this->morphMany(BudgetItem::class, 'delivery', 'delivery_type', 'delivery_id', 'id');
    }
}
