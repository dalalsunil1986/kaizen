<?php

use Acme\User\UserRepository;

class AdminUsersController extends AdminBaseController {


    /**
     * User Model
     * @var User
     */
    protected $userRepository;

    /**
     * Role Model
     * @var Role
     */
    protected $role;

    /**
     * Permission Model
     * @var Permission
     */
    protected $permission;
    /**
     * @var Acme\Mail\UserMailer
     */
    private $mailer;

    /**
     * Inject the models.
     * @param User $userRepository
     * @param Role $role
     * @param Permission $permission
     */
    public function __construct(UserRepository $userRepository, Role $role, Permission $permission)
    {

        $this->userRepository = $userRepository;
        $this->role = $role;
        $this->permission = $permission;
        $this->beforeFilter('Admin', array('except' => array('index','getIndex','view','getReport','postReport','getData')));
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Title
        $title = Lang::get('admin.users.title.user_management');

        // Grab all the users
        $users = $this->userRepository->findUsersForIndex();

        // Show the page
        return $this->render('admin.users.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // All roles
        $roles = $this->role->all();

        // Get all the available permissions
        $permissions = $this->permission->all();

        // Selected groups
        $selectedRoles = Input::old('roles', array());

        // Selected permissions
        $selectedPermissions = Input::old('permissions', array());

		// Title
		$title = Lang::get('admin/users/title.create_a_new_user');

		// Mode
		$mode = 'create';

		// Show the page
		$this->render('admin/users/create_edit', compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->userRepository->username = Input::get( 'username' );
        $this->userRepository->email = Input::get( 'email' );
        $this->userRepository->password = Input::get( 'password' );

        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        $this->userRepository->password_confirmation = Input::get( 'password_confirmation' );
        $this->userRepository->confirmed = Input::get( 'confirm' );

        // Permissions are currently tied to roles. Can't do this yet.
        //$user->permissions = $user->roles()->preparePermissionsForSave(Input::get( 'permissions' ));

        // Save if valid. Password field will be hashed before save
        $this->userRepository->save();

        if ( $this->userRepository->id )
        {
            // Save roles. Handles updating.
            $this->userRepository->saveRoles(Input::get( 'roles' ));

            // Redirect to the new user page
            return Redirect::to('admin/users/' . $this->userRepository->id . '/edit')->with('success', Lang::get('admin/users/messages.create.success'));
        }
        else
        {
            // Get validation errors (see Ardent package)
            $error = $this->userRepository->errors()->all();

            return Redirect::to('admin/users/create')
                ->withInput(Input::except('password'))
                ->with( 'error', $error );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @throws \Acme\Core\Exceptions\EntityNotFoundException
     * @return Response
     */
    public function edit($id)
    {
        $user  = $this->userRepository->findById($id);
        if ( $user )
        {
            $roles = $this->role->all();
            $permissions = $this->permission->all();

            // Title
        	$title = Lang::get('admin/users/title.user_update');
        	// mode
        	$mode = 'edit';

        	$this->render('admin.users.edit', compact('user', 'roles', 'permissions', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin.users')->with('error', Lang::get('admin.users.messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @throws \Acme\Core\Exceptions\EntityNotFoundException
     * @internal param $user
     * @return Response
     */
    public function update($id)
    {
        $user = $this->userRepository->findById($id);
        // Validate the inputs
        $validator = Validator::make(Input::all(), $user->getUpdateRules());

        if ($validator->passes())
        {
            $oldUser = clone $user;
            $user->username = Input::get( 'username' );
            $user->email = Input::get( 'email' );
            $user->confirmed = Input::get( 'confirm' );

            $password = Input::get( 'password' );
            $passwordConfirmation = Input::get( 'password_confirmation' );

            if(!empty($password)) {
                if($password === $passwordConfirmation) {
                    $user->password = $password;
                    // The password confirmation will be removed from model
                    // before saving. This field will be used in Ardent's
                    // auto validation.
                    $user->password_confirmation = $passwordConfirmation;
                } else {
                    // Redirect to the new user page
                    return Redirect::to('admin/users/' . $user->id . '/edit')->with('error', Lang::get('admin/users/messages.password_does_not_match'));
                }
            } else {
                unset($user->password);
                unset($user->password_confirmation);
            }
            
            if($user->confirmed == null) {
                $user->confirmed = $oldUser->confirmed;
            }

            $user->prepareRules($oldUser, $user);

            // Save if valid. Password field will be hashed before save
            $user->amend();

            // Save roles. Handles updating.
            $user->saveRoles(Input::get( 'roles' ));
        } else {
            return Redirect::to('admin/users/' . $user->id . '/edit')->with('error', Lang::get('admin/users/messages.edit.error'));
        }

        // Get validation errors (see Ardent package)
        $error = $user->errors()->all();

        if(empty($error)) {
            // Redirect to the new user page
            return Redirect::to('admin/users/' . $user->id . '/edit')->with('success', Lang::get('admin/users/messages.edit.success'));
        } else {
            return Redirect::to('admin/users/' . $user->id . '/edit')->with('error', Lang::get('admin/users/messages.edit.error'));
        }
    }

    /**
     * Remove user page.
     *
     * @param $user
     * @return Response
     */
    public function delete($id)
    {
        $user = $this->userRepository->findById($id);
        // Title
        $title = Lang::get('admin.users.title.user_delete');

        // Show the page
        $this->render('admin.users.delete', compact('user', 'title'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param $user
     * @return Response
     */
    public function postDelete($user)
    {
        // Check if we are not trying to delete ourselves
        if ($user->id === Confide::user()->id)
        {
            // Redirect to the user management page
            return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.delete.impossible'));
        }

        AssignedRoles::where('user_id', $user->id)->delete();

        $id = $user->id;
        $user->delete();

        // Was the comment post deleted?
        $user = User::find($id);
        if ( empty($user) )
        {
            // TODO needs to delete all of that user's content
            return Redirect::to('admin/users')->with('success', Lang::get('admin/users/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.delete.error'));
        }
    }

    /**
     * Show a list of all the users formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $users = User::leftjoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')
                    ->leftjoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
                    ->select(array('users.id', 'users.username','users.email', 'roles.name as rolename', 'users.confirmed', 'users.created_at'))
                    ->groupBy('users.email');

        return Datatables::of($users)
//         ->edit_column('created_at','{{{ Carbon::now()->diffForHumans(Carbon::createFromFormat(\'Y-m-d H\', $test)) }}}')

        ->edit_column('confirmed','@if($confirmed)
                            Yes
                        @else
                            No
                        @endif')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-default">{{{ Lang::get(\'button.edit\') }}}</a>
                                 <a href="{{{ URL::to(\'admin/users/\' . $id . \'/report\' ) }}}" class="btn btn-xs btn-default" >Report</a>
                                 <a href="{{{ URL::to(\'admin/users/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>

            ')

        ->remove_column('id')

        ->make();
    }

    public function getReport($id)
    {
        $title = 'Report This User to Admin';
        $user = $this->userRepository->find($id);
        $this->render('admin.users.report',compact('user','title'));
    }
    public function postReport($id) {
        $args = Input::all();
        $report_user = $this->userRepository->find($id);
        $user = Contact::first(); // admin
        $args['email'] = Auth::user()->email;
        $args['name'] = Auth::user()->username;
        $args['report_user_email'] = $report_user->email;
        $args['report_user_username'] = $report_user->username;
        $rules = array(
            'subject'=>'required',
            'body'=>'required|min:5'
        );
        $validate = Validator::make($args,$rules);
        if($validate->passes()) {
            if($this->mailer->sendMail($user,$args)) {
                return parent::redirectToAdmin()->with('success','Mail Sent');
            }
            return parent::redirectToUser()->with('error','Error Sending Mail');
        }
        return Redirect::back()->withInput()->with('error',$validate->errors()->all());
    }
}
