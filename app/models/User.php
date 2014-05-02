<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideEloquentRepository;
use Zizaco\Entrust\HasRole;
use Robbo\Presenter\PresentableInterface;
use Carbon\Carbon;

class User extends ConfideUser implements PresentableInterface {
    use HasRole;
    protected $guarded = array('confirmation_code','confirmed','id');

    protected $hidden = array('password');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    public static $rules = array(
        'username' => 'required|alpha_dash|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|between:4,11|confirmed',
        'password_confirmation' => 'between:4,11',
        'first_name' => 'between:3,30',
        'last_name' =>  'between:3,30',
        'mobile' =>   'numeric',
        'phone' =>    'numeric',
        'twitter' =>    'url',
        'instagram' =>   'url',
        'prev_event_comment' =>  'min:5'
    );

    public static $update_rules = array(
        'password' => 'between:4,11|confirmed',
        'password_confirmation' => 'between:4,11',
        'first_name' => 'between:3,30',
        'last_name' =>  'between:3,30',
        'mobile' =>   'numeric',
        'phone' =>    'numeric',
        'twitter' =>    'url',
        'instagram' =>   'url',
        'prev_event_comment' =>  'min:5'
    );

    public function getRules() {
        return self::$rules;
    }

    public function getUpdateRules() {
        return self::$update_rules;
    }

    public function getPresenter()
    {
        return new UserPresenter($this);
    }

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
        return String::date(Carbon::createFromFormat('Y-n-j G:i:s', $this->created_at));
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
     * Redirect after auth.
     * If ifValid is set to true it will redirect a logged in user.
     * @param $redirect
     * @param bool $ifValid
     * @return mixed
     */
    public static function checkAuthAndRedirect($redirect, $ifValid=false)
    {
        // Get the user information
        $user = Auth::user();
        $redirectTo = false;

        if(empty($user->id) && ! $ifValid) // Not logged in redirect, set session.
        {
            Session::put('loginRedirect', $redirect);
            $redirectTo = Redirect::to('user/login')
                ->with( 'notice', Lang::get('user/user.login_first') );
        }
        elseif(!empty($user->id) && $ifValid) // Valid user, we want to redirect.
        {
            $redirectTo = Redirect::to($redirect);
        }

        return array($user, $redirectTo);
    }

    public function currentUser()
    {
        return (new Confide(new ConfideEloquentRepository()))->user();
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

    /**
     * @param String $roleName
     * @return mixed users
     * get user by their role .. ex: Admin, Author, Moderator
     */
    public function getRoleByName($roleName) {
        $query=  $this->with('roles')->whereHas('roles', function($q) use ($roleName)
        {
            $q->where('name', '=', $roleName);

        })->get();
        return $query;
    }

    public function country() {
        return $this->belongsTo('Country');
    }

    public static function isSubscribed($id,$userId) {
        $query = Subscription::where('user_id', '=', $userId)->where('event_id', '=', $id)->count();
        return ($query >= 1 ) ? true : false;
    }
}
