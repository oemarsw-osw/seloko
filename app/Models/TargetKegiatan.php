<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TargetKegiatan extends Model {
    protected $table = 't_target_kegiatan';
    protected $primaryKey = 'id_target';
    
    public $timestamps = false;
    protected $guarded = [];
}
