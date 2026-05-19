<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DokumenSurvei extends Model {
    protected $table = 't_dokumen_survei';
    protected $primaryKey = 'id_dokumen';
    
    public $timestamps = false;
    protected $guarded = [];
}
