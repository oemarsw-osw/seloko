<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model {
    protected $table = 'm_kegiatan';
    protected $primaryKey = 'id_kegiatan';
    
    public $timestamps = false;
    protected $guarded = [];
}
