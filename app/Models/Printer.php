<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;
    protected $tables = 'printers';

    protected $fillable = ['printer_name', 'printer_ip', 'printer_port'];
}
