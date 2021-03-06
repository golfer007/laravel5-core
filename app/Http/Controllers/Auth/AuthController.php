<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\BackendBaseController;
use Redirect;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends BackendBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath, $redirectTo, $redirectAfterLogout;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->redirectPath = route('backend.dashboard.index.get');
        $this->redirectTo = route('backend.dashboard.index.get');
        $this->redirectAfterLogout = route('auth.login.get');

        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogin()
    {
        $data = array();
        $data['error'] = \Session::get('error');
        return $this->theme->scope('auth.login', $data)->render();
    }

    public function getRegister()
    {
        $data = array();
        $data['error'] = \Session::get('error');
        return $this->theme->scope('auth.register', $data)->render();
    }

    public function authenticated(Request $request)
    {
        if (\Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password'), 'active' => 1])) {
            return redirect()->route('backend.dashboard.index.get');
        } else {
            \Auth::logout();
            return redirect()->route('auth.login.get')->withErrors(['Your account is not active, please contact administrator.']);
        }
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());

        return redirect()->route('auth.login.get')->withMessages(['success' => ['You has bees successfully registered, please wait administrator to activate your account']]);
    }
}
