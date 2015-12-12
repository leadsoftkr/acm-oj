<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thank extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'thanks';

    protected $fillable = [
        'id',
        'name'
    ];

    static public function getAuthorId() { return 1; }

    public function problems() {
        return $this->hasMany('App\Problem');
    }

    public function users() {
        return $this->hasMany('App\User');
    }

}
