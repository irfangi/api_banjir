<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TmLokasi extends Model {

    protected $table = 'tm_lokasi';

    protected $primaryKey = 'id';

    protected $fillable = ['nama_lokasi', 'altitude', 'latitude', 'longitude', 'speed', 'heading'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
