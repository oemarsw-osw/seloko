<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, Notifiable;
    protected $table = 'm_user';
    protected $primaryKey = 'id_user';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];
}
