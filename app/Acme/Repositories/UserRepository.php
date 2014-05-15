<?php namespace Acme\Repositories;

use DB;
use Image;

class UserRepository implements UserRepositoryInterface{
	public function saveUser($user){
		$uid = DB::table('users')->insertGetId(array(
			'email' => $user['email'],
			'oauth_uid' => $user['id'],
			'oauth_provider' => $user['oauth_provider'],
			'username' => $user['username'],
			'access_token' => $user['user_accesstoken'],
			'created_at' => DB::raw('now()'),
			'updated_at' => DB::raw('now()')
			));

		return $uid;
	}

	public function getAccessTokenByUser($id)
	{

		$user = DB::table('users')->where('id', '=', $id)
		->where('deleted_at', '=', '0000-00-00 00:00:00')
		->select()
		->first();

		if($user) return $user->access_token;
		return false;
	}

	public function getemailid($id)
	{
		$page = DB::table('pages')->where('pid', '=', $id)
		->select()
		->first();

		$uid=$page->uid;


		$user=DB::table('users')->where('oauth_uid', '=', $uid)
		->where('deleted_at', '=', '0000-00-00 00:00:00')
		->select()
		->first();

		if($user) return $user->email;
		return false;

	}


}