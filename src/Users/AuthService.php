<?php namespace Acme\Users;

use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\AbstractRepository;
use Password;

class AuthService extends AbstractRepository {

    public $errors;
    public $repository;

    public function __construct(UserRepository $repository, MessageBag $errors)
    {
        $this->repository = $repository;
        $this->errors     = $errors;
    }

    /**
     * Create
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function register(array $data)
    {
        $data['password']          = Hash::make($data['password']);
        $data['confirmation_code'] = $this->getToken();

        if ( ! $user = $this->repository->create($data) ) {

            $this->addError('could not create user');

            return false;
        }

        return true;

    }


    /**
     * Update
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(array $data)
    {
        return $this->repository->update($data);
    }

    /**
     * Delete
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        $user = $this->find($id);

        if ( $user ) {
            return $user->delete();
        }
    }

    /**
     * Register / Activte a User
     * @param $token
     * @return string
     */
    public function activateUser($token)
    {
        $user = $this->findByToken($token);
        if ( $user ) {
            // valid token
            // check if user is active
            if ( $user->active == 1 ) {
                // Error: account already active
                $this->addError('Your Account is already active');

                return false;
            }

            if ( $user->created_at < Carbon::now()->subDay() ) {
                // link expired
                //@todo make link expired view
                $this->addError('Activation Link Expired');

                return false;
            }
            // activate user
            $user->active = 1;

            // set confirmation code to null
            $user->confirmation_code = '';

            $user->save();

            return true;

        }
        $this->addError('Invalid Token');

        return false;
    }

    /**
     * Find User By Confirmation Token
     * @param $token
     * @return mixed
     */
    private function findByToken($token)
    {
        $user = $this->repository->model->where('confirmation_code', $token)->first();

        return $user;
    }

    /**
     * Updated User Last Logged In Time
     */
    public function updateLastLoggedAt()
    {
        $user                 = Auth::user();
        $user->last_logged_at = Carbon::now();
        $user->save();
    }

    public function sendResetLink($email)
    {
        // check for valid user
        $user = $this->repository->model->where('email', $email['email'])->first();

        // Check if Valid User
        if ( $user ) {
            // Check if his Account is active
            if ( ! $user->active == 1 ) {
                $this->addError('Account Not Active');

                return false;
            }
            // new confirmation code
            $user->token = $this->getToken();
            $user->save();
            Event::fire('user.reset', $user);

            return true;
        }
        $this->addError('Not a Valid Email');

        return false;

    }

    /**
     * @return string
     */
    public function getToken()
    {
        return md5(uniqid(mt_rand(), true));
    }

    /**
     * @param $credentials
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(array $credentials)
    {
        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        return $response;

    }

    public function getRegistrationForm()
    {
        return $this->repository->getCreationForm();
    }

    public function getPasswordResetForm()
    {
        return $this->repository->getPasswordResetForm();
    }
}