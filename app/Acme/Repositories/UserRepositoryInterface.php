<?php   namespace Acme\Repositories;

interface UserRepositoryInterface
{
	public function saveUser($user);
	public function getAccessTokenByUser($id);
	public function getemailid($id);

}