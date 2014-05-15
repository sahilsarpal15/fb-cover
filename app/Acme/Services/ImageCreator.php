<?php namespace Acme\Services;
use Acme\Services\CurlServices;

use Image;
class ImageCreator{
	protected $paths;
	protected $request;


	public function __construct(CurlServices $request)
	{
		$this->request=$request;
		$this->paths['uploads'] = 'uploads';
		$this->paths['cover'] = $this->paths['uploads'] . '/cover';
	}


	public function makeimage($text)
	{
		$color1[0]='#FF9966'; 
		$color2[0]='#FF0000';
		$color1[1]='#FFFF33';
		$color2[1]=	'#FF0000';
		$color1[2]='#ffffff';
		$color2[2]='#000000';
		$color1[3]='#FFCCFF';
		$color2[3]='#FF0000';
		$color1[4]='#CC0000';
		$color2[4]='#CCFFFF';
		$color1[5]='#993399';
		$color2[5]='#66FF00';
		$color1[6]='#FFFFFF'; 
		$color2[6]= '#99CC33';

		$i=rand(0, 6);

		$img = Image::canvas(851, 315, $color1[$i]);		

		$text1 =$text.' fans';
		$t2 = ++$text;
		$text2= 'Will it be '.$t2;
		$path = 'sahil1';


		$img->text($text1,280, 130,50,$color2[$i], 0,public_path('Handdrawn.ttf'));
		$img->text($text2, 270, 180,50,$color2[$i], 0,public_path('Handdrawn.ttf'));
		$img->save(public_path($this->paths['cover'].'/'.$path));



		return $img;
	}

	public function postimagefb($offset_y,$offset_x,$photo_access_token,$page_id)
	{
		$path = 'sahil1';

		$args= array(
			'no_story'=>true,
			'about'=>'Test about text',
			'hours' => '{\'mon_1_open\': \'12:00\',\'mon_1_close\': \'04:00\'}', 
			'source' =>'@'.public_path($this->paths['cover'].'/'.$path),
			'offset_y'=>$offset_y,
			'offset_x'  => $offset_x
			);


		$url = 'https://graph.facebook.com/'.$page_id.'/photos?access_token='.$photo_access_token;

		$id=$this->request->postimage($url,$args);
		return $id->id;		
	}

	public function postcoverfb($result,$offset_x,$offset_y,$photo_access_token)
	{
		$args= array(
			'cover'=>$result,
			'no_feed_story'=>true,
			'about'=>'Test about text',
			'hours' => '{\'mon_1_open\': \'12:00\',\'mon_1_close\': \'04:00\'}', 
			'offset_y'=>$offset_y,
			'offset_x'  => $offset_x
			);

		$url = 'https://graph.facebook.com/me?access_token='.$photo_access_token;

		$id=$this->request->postimage($url,$args);
		return;		
	}
}
