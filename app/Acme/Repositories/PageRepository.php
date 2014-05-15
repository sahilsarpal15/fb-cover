<?php namespace Acme\Repositories;

use DB;

class PageRepository implements PageRepositoryInterface{

	public function getpages($id)
	{
		$pages = DB::table('pages')
		->where('uid', '=', $id)
		->get();
		
		if($pages) return $pages;
		return false;
	}

	public function savepages($pages)
	{

		foreach ($pages['data'] as $index => $page) {

			$pid = DB::table('pages')->insertGetId(array(
				'name' => $page['name'],
				'access_token' => $page['access_token'],				
				'pid' => $page['id'],
				'uid' => Session::get('uid'),
				'created_at' => DB::raw('now()'),
				'updated_at' => DB::raw('now()')
				));
		}

		return $pid;
	}

	public function getPageAccessToken($id)
	{
		$page = DB::table('pages')->where('pid', '=', $id)
		->select()
		->first();

		if($page) return $page->access_token;


	}

}