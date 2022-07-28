<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Ramsey\Uuid\Uuid;

class User extends Model {

	protected $table = 'users';

	protected $fillable = [
	    'firstname',
        'lastname',
        'email',
        'avatar'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
