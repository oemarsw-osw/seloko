<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubTim extends Model {
    protected $table = 'm_sub_tim';
    protected $primaryKey = 'id_sub_tim';
    
    public $timestamps = false;
    protected $guarded = [];
}
