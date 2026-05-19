<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model {
    protected $table = 'm_periode';
    protected $primaryKey = 'id_periode';
    
    public $timestamps = false;
    protected $guarded = [];
}
