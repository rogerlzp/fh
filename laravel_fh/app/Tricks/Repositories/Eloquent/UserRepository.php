<?php

namespace Tricks\Repositories\Eloquent;

use Tricks\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Tricks\Services\Forms\SettingsForm;
use Tricks\Services\Forms\RegistrationForm;
use Tricks\Services\Forms\UserForm;
use Tricks\Exceptions\UserNotFoundException;
use Tricks\Repositories\UserRepositoryInterface;
use League\OAuth2\Client\Provider\User as OAuthUser;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * Create a new DbUserRepository instance.
     *
     * @param  \Tricks\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Find all users paginated.
     *
     * @param  int  $perPage
     * @return Illuminate\Database\Eloquent\Collection|\Tricks\User[]
     */
    public function findAllPaginated($perPage = 200)
    {
        return $this->model
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * Find a user by it's username.
     *
     * @param  string $username
     * @return \Tricks\User
     */
    public function findByUsername($username)
    {
        return $this->model->whereUsername($username)->first();
    }

    /**
     * Find a user by it's email.
     *
     * @param  string $email
     * @return \Tricks\User
     */
    public function findByEmail($email)
    {
        return $this->model->whereEmail($email)->first();
    }

    /**
     * Require a user by it's username.
     *
     * @param  string $username
     * @return \Tricks\User
     * @throws \Tricks\Exceptions\UserNotFoundException
     */
    public function requireByUsername($username)
    {
        if (! is_null($user = $this->findByUsername($username))) {
            return $user;
        }

        throw new UserNotFoundException('The user "' . $username . '" does not exist!');
    }

    /**
     * Create a new user in the database.
     *
     * @param  array  $data
     * @return \Tricks\User
     */
    public function create(array $data)
    {
        $user = $this->getNew();

        $user->email    = e($data['email']);
        $user->username = e($data['username']);
        $user->password = Hash::make($data['password']);
        $user->photo    = isset($data['image_url']) ? $data['image_url'] : null;

        $user->save();

        return $user;
    }

    /**
     * Create a new user in the database using GitHub data.
     *
     * @param  \League\OAuth2\Client\Provider\User  $data
     * @return \Tricks\User
     */
    public function createFromGithubData(OAuthUser $data)
    {
        $user        = $this->getNew();

        $username    = $data->nickname;
        $isAvailable = is_null($this->findByUsername($username));
        $isAllowed   = $this->usernameIsAllowed($username);

        $user->username = $username;

        if (! $isAvailable or ! $isAllowed) {
            $user->username .= '_' . str_random(3);
            Session::flash('username_required', true);
        }

        $user->email = $data->email;
        $user->photo = $data->image_url ?: '';

        $user->save();

        Session::flash('password_required', true);

        return $user;
    }

    /**
     * Returns whether the given username is allowed to be used.
     *
     * @param  string  $username
     * @return bool
     */
    protected function usernameIsAllowed($username)
    {
        return ! in_array(strtolower($username), Config::get('config.forbidden_usernames'));
    }

    /**
     * Update the user's settings.
     *
     * @param  \Tricks\User  $user
     * @param  array $data
     * @return \Tricks\User
     */
    public function updateSettings(User $user, array $data)
    {
        $user->username = $data['username'];
        $user->password = ($data['password'] != '') ? Hash::make($data['password']) : $user->password;

        if ($data['avatar'] != '') {
            File::move(public_path().'/img/avatar/temp/'.$data['avatar'], public_path().'/img/avatar/'.$data['avatar']);

            if ($user->photo) {
                File::delete(public_path().'/img/avatar/'.$user->photo);
            }

            $user->photo = $data['avatar'];
        }

        return $user->save();
    }

    /**
     * Get the user registration form service.
     *
     * @return \Tricks\Services\Forms\RegistrationForm
     */
    public function getRegistrationForm()
    {
        return app('Tricks\Services\Forms\RegistrationForm');
    }

    /**
     * Get the user settings form service.
     *
     * @return \Tricks\Services\Forms\SettingsForm
     */
    public function getSettingsForm()
    {
        return app('Tricks\Services\Forms\SettingsForm');
    }
    

    public function doesFollowUser($id)
    {
    	return Auth::user()->follows->where('follow_id', '=', $id);
    }
    

    
    
    /**
     * Get a list of roles ids that are associated with the given role.
     *
     * @param  \Tricks\User $user
     * @return array
     */
    public function listRolesForUser(User $user)
    {
    	return $user->roles->lists('id');
    }
    
    /**
     * Find a user by id.
     *
     * @param  mixed  $id
     * @return \Tricks\User
     */
    public function findById($id)
    {
    	return $this->model->find($id);
    }
    
    /**
     * Update the specified user in the database.
     *
     * @param  mixed  $id
     * @param  array  $data
     * @return \Tricks\User
     */
    public function update($id, array $data)
    {
    	$user = $this->findById($id);
    
    //	$user->username = $data['username'];
    	$user->email    = e($data['email']);
    	$user->save();
    	
    	$profile = $user->profile;
    	Log::info($profile);
    	$profile->name = $data['username'];
    	Log::info( $data['username']);
    	$profile->company = $data['company'];
    	$profile->department = $data['department'];
    	$profile->title = $data['title'];
    	$profile->phone = $data['phone'];
    	$profile->address = $data['address'];
    	$profile->save();
    	Log::info($profile);
    	
    	
    	if(in_array("roles", $data))  {
    		$user->roles()->sync($data['roles']);
    	}
    	
    	return $user;
    }
    
    /**
     * Get the user create/update form service.
     *
     * @return \Tricks\Services\Forms\UserForm
     */
    public function getForm()
    {
    	return new UserForm;
    }
    
    /**
     * Find all users that match the given search term.
     *
     * @param  string $term
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\User[]
     * 
     */
    public function searchByTermPaginated($term, $perPage = 12)
    {
    	$users =  $this->model
    	->orWhere('username', 'LIKE', '%'.$term.'%')
    	->orWhere('email', 'LIKE', '%'.$term.'%')
    	->orWhere('mobile', 'LIKE', '%'.$term.'%')
    	->orWhereHas('profile', function ($query) use ($term) {
    		$query->where('name', 'LIKE', '%' . $term . '%')
    		->orWhere('title', 'LIKE', '%' . $term . '%');
    	//	->orWhere('company', 'LIKE', '%' . $term . '%')
    	//	->orWhere('department', 'LIKE', '%' . $term . '%')
    		//->orWhere('title', 'LIKE', '%' . $term . '%');
    	//	->orWhere('address', 'LIKE', '%' . $term . '%'); 
    	})
    	
    	->orWhereHas('roles', function ($query) use ($term) {
    		$query->where('name', 'LIKE', '%' . $term . '%');
    	})
    	->orderBy('created_at', 'desc')
    	->paginate($perPage);
    
    	return $users;
    }
    
}
