<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable; // Cambia de Model a Authenticatable

use Illuminate\Database\Eloquent\Model;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';
    // protected $primaryKey = 'idalumno';
    public $timestamps = false;
}