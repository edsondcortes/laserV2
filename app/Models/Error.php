<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    use HasFactory;

    protected $table = 'errors';

    protected $fillable = ['error'];

    public function budgetItem(){
        return $this->belongsTo(BudgetItem::class);
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
