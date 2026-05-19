<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProgressHistory extends Model {
    protected $table = 't_progress_history';
    protected $primaryKey = 'id_history';
    
    public $timestamps = false;
    protected $guarded = [];
}
