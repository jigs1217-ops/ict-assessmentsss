<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'department',      
    'division',        
    'name',            
    'care_of',         
    'equipment_type',
    'model',
    'date_acquired',
    'date_assessed',   
    'motherboard',
    'processor',
    'memory',
    'harddisk_capacity',
    'lan_connected',
    'internet_connected',
    'os',
    'ms_office',
    'condition',
    'analysis',
    'recommendation',
    'remarks',
    'assessed_by',
];
}

