<?php

use Zizaco\Entrust\HasRole;
use Carbon\Carbon;

class User extends BaseModel  {
    use HasRole;
    protected $guarded = array('confirmation_code','confirmed','id');

    protected $hidden = array('password');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Get user by username
     * @param $username
     * @return mixed
     */
    public function getUserByUsername( $username )
    {
        return $this->where('username', '=', $username)->first();
    }

    /**
     * Get the date the user was created.
     *
     * @return string
     */
    public function joined()
    {
        return Carbon::createFromFormat('Y-n-j G:i:s', $this->created_at);
    }

    /**
     * Save roles inputted from multiselect
     * @param $inputRoles
     */
    public function saveRoles($inputRoles)
    {
        if(! empty($inputRoles)) {
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
        $roles = $this->roles;
        $roleIds = false;
        if( !empty( $roles ) ) {
            $roleIds = array();
            foreach( $roles as &$role )
            {
                $roleIds[] = $role->id;
            }
        }
        return $roleIds;
    }

    /**
     * get all comments by the user
     */
    public function comments() {
        return $this->morphMany('Comment','commentable');
    }

    public function events() {
        return $this->hasMany('EventModel');
    }

    public function followings() {
        return $this->belongsToMany('EventModel', 'followers','user_id','event_id');

//        return $this->hasMany('Follower');
    }

    public function subscriptions() {
//        return $this->hasMany('Subscription');
        return $this->belongsToMany('EventModel', 'subscriptions','user_id','event_id');
        // the second query returns Events for the subscriptions
    }

    public function favorites() {
        return $this->belongsToMany('EventModel', 'favorites','user_id','event_id');
//        return $this->hasMany('Favorite');
    }

    public function statuses() {
        return $this->belongsToMany('EventModel', 'statuses','user_id','event_id');
//        return $this->hasMany('Favorite');
    }

    public function country() {
        return $this->belongsTo('Country');
    }

    /**
     * @param String $roleName
     * @return mixed users
     * get user by their role .. ex: Admin, Author, Moderator
     */




}
