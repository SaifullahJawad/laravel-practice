<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    //protected $guarded = []; you can also mass assign application wide by setting up the unguard() method in AppServiceProvider

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Eloquent Mutator
    //Whenever a field is set in database, first eloquent will automatically pipe the field through this mutator function
    public function setPasswordAttribute($password)  //has to follow the naming convetion: set[Fieldname]Attribute()
    {
        //whatever is set as the password within this function will be saved to the database
        $this->attributes['password'] = bcrypt($password); //Hashing the password

    }


    //The inverse of Mutator is Accessor
    //When a field value is being fetched, first eloquent will automatically pipe the filed through the accessor function
    /* public function getUsernameAttribute($username)  //has to follow the naming convetion: get[Fieldname]Attribute()
    {
        //whatever is set as the fieldname within this function will be shown as the field value
        return ucwords($username);

    } */

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
