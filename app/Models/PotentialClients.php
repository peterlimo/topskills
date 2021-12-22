<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotentialClients extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'email',
        'assigned_to',
        'status',
        'remarks'
    ];
}
