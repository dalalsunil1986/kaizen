<?php namespace Acme\User;

use Acme\Core\CrudableTrait;
use Acme\User\Validators\AdminCreateValidator;
use Acme\User\Validators\AdminUpdateValidator;
use Acme\Users\Validators\UserCreateValidator;
use Acme\Users\Validators\UserResetValidator;
use Acme\Users\Validators\UserUpdateValidator;
use DB;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\AbstractRepository;

use User;


class UserRepository extends AbstractRepository  {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Acme\Users\User|\Illuminate\Database\Eloquent\Model|\User $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(User $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;

    }

    public function create(array $data)
    {
        $data['confirmation_code'] = md5(uniqid(mt_rand(), true));
        if ( ! $user = $this->model->create($data) ) {

            $this->addError('could not create user');

            return false;
        }
        return $user;
    }

    public function getRoleByName($roleName) {
        $query=  $this->model->with('roles')->whereHas('roles', function($q) use ($roleName)
        {
            $q->where('name', '=', $roleName);

        })->get();
        return $query;
    }

    public function getPasswordResetForm()
    {
        return new UserResetValidator();
    }

    public function findByToken($token){
        return $this->model->whereConfirmationCode($token)->first();
    }

    public function findByEmail($email) {
        return $this->model->whereEmail($email)->first();
    }

    public function findUsersForIndex(){
        $users = DB::table('users')->leftjoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')
            ->leftjoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
            ->select(array('users.id', 'users.username','users.email', 'roles.name as rolename', 'users.active', 'users.created_at'))
            ->groupBy('users.email')->get();
        return $users;
    }

    public function getAdminEditForm($id){
        return new AdminUpdateValidator($id);
    }
    public function getAdminCreateForm(){
        return new AdminCreateValidator();
    }
}