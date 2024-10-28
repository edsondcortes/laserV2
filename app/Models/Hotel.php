<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $tables = 'hotels';

    protected $fillable = ['name', 'street', 'number', 'city', 'fone', 'district'];

    public function hotelDelivery(){
        return $this->hasMany(HotelDelivery::class, 'hotel_id', 'id');
    }
}
