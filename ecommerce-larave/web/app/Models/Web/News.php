<?php

namespace App\Models\Web;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Core\Categories;
use App\Models\Web\Cart;
use Illuminate\Support\Facades\Lang;
use Session;


class News extends Model
{
  public function getAllNews($data){

		if(empty($data['page_number']) or $data['page_number'] == 0 ){
			$skip								=   $data['page_number'].'0';
		}else{
			$skip								=   $data['limit']*$data['page_number'];
		}

		$currentDate 							=   time();
		$type									=	$data['type'];
		$take									=   $data['limit'];

		if($type=="atoz"){
			$sortby								=	"news_name";
			$order								=	"ASC";
		}elseif($type=="ztoa"){
			$sortby								=	"news_name";
			$order								=	"DESC";
		}elseif($type=="asc"){
			$sortby								=	"news.news_id";
			$order								=	"ASC";
		}else{
			$sortby = "news.news_id";
			$order = "desc";
		}

		$categories = DB::table('news_to_news_categories')
			->LeftJoin('news', 'news.news_id', '=', 'news_to_news_categories.news_id')
			->LeftJoin('image_categories', 'news.news_image', '=', 'image_categories.image_id')
			->LeftJoin('news_categories', 'news_categories.categories_id', '=', 'news_to_news_categories.categories_id')
			->LeftJoin('news_categories_description', 'news_categories_description.categories_id', '=', 'news_to_news_categories.categories_id');
			$categories->leftJoin('news_description','news_description.news_id','=','news.news_id');
			$categories->select('news.*','image_categories.path as image_path','news_description.*', 'news_to_news_categories.categories_id', 'news_categories_description.categories_name');

		//get single category news
		if(!empty($data['categories_id'])){
			$categories->where('news_to_news_categories.categories_id','=', $data['categories_id']);
		}

		//get single news
		if(!empty($data['news_id']) && $data['news_id']!=""){
			$categories->where('news.news_id','=', $data['news_id']);
		}

		//get featured news
    	if($data['is_feature']==1){
			$categories->where('news.is_feature','=', 1);
		}

		$categories->where('news_description.language_id','=',Session::get('language_id'))
		->where('news_categories_description.language_id','=',Session::get('language_id'))
		->where('news_categories.categories_status','=',1)
		->where('news.news_status','=',1)	
		
		->orderBy($sortby, $order)->groupBy('news.news_id');

		//count
		$total_record = $categories->groupBy('news.news_id')->get();

		$data  = $categories->skip($skip)->take($take)->groupBy('news.news_id')->get();
		$result = array();
		$index = 0;
		foreach($data as $news_data){
			array_push($result,$news_data);

			$news_description =  $news_data->news_description;
			$result[$index]->news_description = stripslashes($news_description);

			$index++;
		}

		//check if record exist
		if(count($data)>0){
				$responseData = array('success'=>'1', 'news_data'=>$result,  'message'=>"Returned all news.", 'total_record'=>count($total_record));
			}else{
				$responseData = array('success'=>'0', 'news_data'=>array(),  'message'=>"Empty record.", 'total_record'=>count($total_record));
			}

		return ($responseData);
	}

  public function getNewsCategories(){

		$data 		=	array();
		$categories = DB::table('news_categories')
			->LeftJoin('news_categories_description', 'news_categories_description.categories_id', '=', 'news_categories.categories_id')
			->LeftJoin('image_categories', 'news_categories.categories_image', '=', 'image_categories.image_id')
			->select('news_categories.categories_id as id',
				 'news_categories.categories_image as image',
				 'news_categories.news_categories_slug as slug',
				 'news_categories_description.categories_name as name',
				 'image_categories.path as news_image'
				 )
				 
			->where('news_categories_description.language_id','=', Session::get('language_id'))
			->groupby('news_categories.categories_id')->get();

		if(count($categories)>0){
			foreach($categories as $categories_data){
				$categories_id = $categories_data->id;
				$news = DB::table('news_categories')
						->LeftJoin('news_to_news_categories', 'news_to_news_categories.categories_id', '=', 'news_categories.categories_id')
						->LeftJoin('news', 'news.news_id', '=', 'news_to_news_categories.news_id')
						->select('news_categories.categories_id', DB::raw('COUNT(DISTINCT news.news_id) as total_news'))
						->where('news_categories.categories_id','=', $categories_id)
						->get();

				$categories_data->total_news = $news[0]->total_news;
				array_push($data,$categories_data);
			}
		}
		return($data);
	}

  public function getCategories($category){
    $categories = DB::table('news_categories')
    ->leftJoin('news_categories_description','news_categories_description.categories_id','=','news_categories.categories_id')
    ->where('news_categories_slug',$category)
    ->where('news_categories_description.language_id',Session::get('language_id'))
    ->groupBY('news_categories.categories_id')
    ->get();
    return $categories;
  }

  public function newsdetail($request){
    $news = DB::table('news')
          ->leftjoin('news_description','news_description.news_id','=','news.news_id')
          ->leftjoin('news_to_news_categories','news_to_news_categories.news_id','=','news.news_id')
          ->leftjoin('news_categories','news_categories.categories_id','=','news_to_news_categories.categories_id')
          ->LeftJoin('image_categories', 'news.news_image', '=', 'image_categories.image_id')
          ->leftjoin('news_categories_description','news_categories_description.categories_id','=','news_categories.categories_id')
          ->where([
            ['news.news_slug','=',$request->slug],
            ['news_description.language_id','=',Session::get('language_id')],
            ['news_categories_description.language_id','=',Session::get('language_id')]
          ])
          ->select('news.*','news_description.*','image_categories.path as image', 'news_categories_description.categories_name')
          ->groupBy('news.news_id')
          ->get();
          return $news;
  }




}
