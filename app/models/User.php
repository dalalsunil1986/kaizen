<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\UserInterface;
use McCool\LaravelAutoPresenter\PresenterInterface;
use Zizaco\Entrust\HasRole;
use Carbon\Carbon;

class User extends BaseModel implements UserInterface, RemindableInterface, PresenterInterface {

    use HasRole;

    protected $guarded = array(
        'id', 'confirmation_code', 'password_confirmation', 'remember_token', 'active', '_method', '_token'
    );

    protected $hidden = array('password');


    protected $table = 'users';

    protected static $name = 'user';

    public function getUserByUsername($username)
    {
        return $this->where('username', '=', $username)->first();
    }

    /**
     * Save roles inputted from multiselect
     * @param $inputRoles
     */
    public function saveRoles($inputRoles)
    {
        if ( ! empty($inputRoles) ) {
            $this->roles()->sync($inputRoles);
        } else {
            $this->roles()->detach();
        }
    }

    /**
     * Returns user's current role ids only.
     * @return array|bool
     */
    public function currentRoleIds()
    {
        $roles   = $this->roles;
        $roleIds = false;
        if ( ! empty($roles) ) {
            $roleIds = array();
            foreach ( $roles as &$role ) {
                $roleIds[] = $role->id;
            }
        }

        return $roleIds;
    }

    /**
     * get all comments by the user
     */
    public function comments()
    {
        return $this->morphMany('Comment', 'commentable');
    }

    public function events()
    {
        return $this->hasMany('EventModel');
    }

    public function followings()
    {
        return $this->belongsToMany('EventModel', 'followers', 'user_id', 'event_id');
    }

    public function subscriptions()
    {
        return $this->belongsToMany('EventModel', 'subscriptions', 'user_id', 'event_id');
    }

    public function favorites()
    {
        return $this->belongsToMany('EventModel', 'favorites', 'user_id', 'event_id');
    }

    public function statuses()
    {
        return $this->belongsToMany('EventModel', 'statuses', 'user_id', 'event_id');
    }

    public function country()
    {
        return $this->belongsTo('Country');
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenter()
    {
        return 'Acme\Users\UserPresenter';
    }

    /**
     * check if is the user admin
     * @return bool
     * @todo
     */
    public function isAdmin()
    {
        return false;
    }

    /**
     * Check if the User is owner of the profile, post etc
     */
    public function isOwner()
    {
        if ( Auth::check() ) {
            if (! ($this->isAdmin() || Auth::user()->id == $this->id )) return false;

            return true;
        }

        return false;
    }

    public function setMobileAttribute($value)
    {
        $this->attributes['mobile'] = (int)($value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = (int)($value);
    }

    /**
     * @param $password
     * Auto Has the Password
     */
    public function setPasswordAttribute($password){

        $this->attributes['password'] = Hash::make($password);

    }
}
