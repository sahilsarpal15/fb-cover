<?php   namespace Acme\Repositories;

interface PageRepositoryInterface
{
	public function getpages($id);
	public function savepages($pages);
	public function getPageAccessToken($id);
}