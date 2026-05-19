<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KabKota extends Model {
    protected $table = 'm_kabkota';
    protected $primaryKey = 'id_kabkota';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}
