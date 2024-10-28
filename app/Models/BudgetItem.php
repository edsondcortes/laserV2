<?php

namespace App\Models;

use App\Enums\ProductionForm;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;
    protected $table = 'budget_items';

    protected $fillable = ['adderi_budget_item', 
                            'description' ,
                            'item_code',
                            'position',
                            'type',
                            'background',
                            'note',
                            'cut',
                            'edition',
                            'layout',
                            'engraving',
                            'production_form',
                            'product_delivery'
                            ];

    protected $dates = ['cut',
                        'edition',
                        'layout'
                        ];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }

    protected $casts = [
        'productionForm' => ProductionForm::class
    ];

    public function delivery(){
        return $this->morphTo(__FUNCTION__, 'delivery_type', 'delivery_id', 'id');
    }

    protected function deliveryMethod(): Attribute
    {
        $deliveryName = '';
        switch ($this->delivery_type) {
            case ('App\Models\LocalDelivery'):
                $deliveryName = 'Vem buscar';
                break;
            case ('App\Models\HotelDelivery'):
                $deliveryName = 'Hotel';
                break;
            case('App\Models\SeasonDelivery');
                $deliveryName = 'Temporada';
                break;
            case('App\Models\Delivery');
                $deliveryName = 'Despachar';
                break;
            case('App\Models\DeliveryOnTime');
                $deliveryName = 'Entrega na hora';
                break;
        };

        return Attribute::make(
            get: fn () => $deliveryName
        );
    }

    public function error(){
        return $this->hasMany(Error::class, 'id_item');
    }

    public function usercut(){
        return $this->hasOne(User::class, 'id', 'user_cut');
    }

    public function useredition(){
        return $this->hasOne(User::class, 'id', 'user_edition');
    }

    public function userlayout(){
        return $this->hasOne(User::class, 'id', 'user_layout');
    }

    public function userengraving(){
        return $this->hasOne(User::class, 'id', 'user_engraving');
    }
}
