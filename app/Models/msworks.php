<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class msworks extends Model
{
    public $timestamps = false;
    protected $fillable = ['Tag','Link','Type','Category','Source'];
    protected $primaryKey = 'WorkID';
    use HasFactory;
}
