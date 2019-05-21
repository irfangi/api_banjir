<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TmStatus extends Model {

    protected $table = 'tm_status';

    protected $primaryKey = 'id';

    protected $fillable = ['status', 'description', 'min_level', 'max_level'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
