<?php namespace App\Services;

use App\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'firstName' => 'required|max:255',
			'lastName' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:8',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$currentTime = Carbon::now();
		return User::create([
			'first_name' => $data['firstName'],
			'last_name' => $data['lastName'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'acc_creation_date' => $currentTime,
		]);
	}

}
