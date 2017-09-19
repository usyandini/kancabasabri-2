<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Adldap\Laravel\Facades\Adldap;


class AuthController extends Controller
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

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dropping';
    protected $loginPath  = '/';
    protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function index()
    {
        
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
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
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $username = $credentials['username'];
        $password = $credentials['password'];
        
        if (!\App::environment('local-ilyas')) {
            if (Adldap::auth()->attempt($username, $password, $bindAsUser = true)) {
                if (strpos($username, '@') != false) {
                    $exp = explode('@', $username);
                    $username = $exp[0];
                } 

                $user = \App\User::where('username', $username)->first();
                if (!$user) {
                    $new = ['username' => $username, 'name' => $username, 'password' => bcrypt($password)];
                    $user = User::create($new);
                } 

                \Auth::login($user);
                return redirect()->intended('/');
            }
        } 

        if (\Auth::attempt(['username' => $username, 'password' => $password])) {
            $user = \App\User::where('username', $username)->first();
            \Auth::login($user);
            return redirect()->intended('/');
        }
        
        return redirect()->back()->withInput()->withErrors(['username' => '<b>Username atau password tidak cocok.</b> Silahkan coba lagi.']);
    }
}
