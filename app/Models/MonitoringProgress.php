<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MonitoringProgress extends Model {
    protected $table = 't_monitoring_progress';
    protected $primaryKey = 'id_progress';
    
    public $timestamps = false;
    protected $guarded = [];
}
