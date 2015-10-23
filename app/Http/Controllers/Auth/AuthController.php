<?php

namespace App\Http\Controllers\Auth;

use Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
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
            'name'      => 'required|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|confirmed|min:4',
            'address'   => 'required|max:255',
            'residence' => 'required'
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
            'name'      => $data['name'],
            'surname'   => $data['surname'],
            'email'     => $data['email'],
            'ip'        => $data['ip'],
            'address'   => $data['address'],
            'residence' => $data['residence'],
            'password'  => bcrypt($data['password']),
        ]);
    }

    public function login(Request $request)
    {
        $password   = $request->input('password');
        $email      = $request->input('email');


        if(Auth::attempt(['password' => $password, 'email' => $email]))
        {
            return redirect()->route('competition');
        } else
        {
            return back()->withErrors('there was something wronk with the password or email adress');
        }
    }

    public function logout()
    {
        Auth::logout();
        // echo 'whut';
        return redirect()->back();
    }

    public function postRegister(Request $request)
    {
        $data = array(
                    'name'                  => $request->input('name'),
                    'surname'               => $request->input('surname'),
                    'email'                 => $request->input('email'),
                    'password'              => $request->input('password'),
                    'password_confirmation' => $request->input('password_confirmation'),
                    'ip'                    => $request->getClientIp(),
                    'address'               => $request->input('address'),
                    'residence'             => $request->input('residence')
            );

        $validator = $this->validator($data);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors()->all())->withInput();
        } 
        else
        {
            $user = $this->create($data);
            Auth::login($user);

            return redirect()->back();
        }
    }
}
