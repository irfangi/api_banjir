<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LogSensor extends Model {

    protected $table = 'log_sensor';

    protected $primaryKey = 'id';

    protected $fillable = [ 'id_lokasi','id_status', 'waktu', 'ketinggian_air'];


    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships
    public function lokasi() {
        return $this->belongsTo('App\Model\TmLokasi', 'id_lokasi', 'id');
    }

    public function status(){
        return $this->belongsTo('App\Model\TmStatus', 'id_status', 'id');        
    }
}
