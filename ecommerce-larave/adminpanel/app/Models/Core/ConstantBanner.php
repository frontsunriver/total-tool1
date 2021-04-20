<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;



class constantBanner extends Model
{
    //
    use Sortable;

    public function images(){
        return $this->belongsTo('App\Images');
    }

    public function image_category(){
        return $this->belongsTo('App\Image_category');
    }

    public $sortable = ['banners_id','banners_title','created_at'];

    public static function paginator($request){
        $result = array();
        $message = array();
        $result['message'] = '';
        $result['banners'] = array();
        if($request->bannerType){
                $search = '';
                

                $banner = DB::table('constant_banners')
                ->join('languages','languages.languages_id','=','constant_banners.languages_id')
                ->leftJoin('image_categories','constant_banners.banners_image','=','image_categories.image_id')
                ->select('constant_banners.*','image_categories.path','languages.name as language_name');
                
                
                if($request->bannerType == 'banner1'){
                    $banner ->where('type', '3')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '4')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '5')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }

                if($request->bannerType == 'banner2' or $request->bannerType == 'banner3' or $request->bannerType == 'banner4'){
                    $banner ->where('type', '6')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '7')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '8')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '9')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }

                if($request->bannerType == 'banner5' or $request->bannerType == 'banner6'){
                    $banner ->where('type', '10')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '11')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '12')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '13')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '14')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }

                if($request->bannerType == 'banner7' or $request->bannerType == 'banner8'){
                    $banner ->where('type', '15')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '16')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '17')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '18')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }

                if($request->bannerType == 'banner9'){
                    $banner ->where('type', '19')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '20')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }

                if($request->bannerType == 'banner10' or $request->bannerType == 'banner11' or $request->bannerType == 'banner12'){
                    $banner ->where('type', '21')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '22')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '23')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '24')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }

                if($request->bannerType == 'banner13' or $request->bannerType == 'banner14' or $request->bannerType == 'banner15'){
                    $banner ->where('type', '25')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '26')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '27')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '28')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '29')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }

                if($request->bannerType == 'banner16' or $request->bannerType == 'banner17'){
                    $banner ->where('type', '30')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '31')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '32')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }

                if($request->bannerType == 'banner18' or $request->bannerType == 'banner19'){
                    $banner ->where('type', '33')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '34')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '35')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '36')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '37')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '38')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }

                if($request->bannerType == 'rightsliderbanner' or $request->bannerType == 'leftsliderbanner'){
                    $banner ->where('type', '1')
                    ->where('constant_banners.languages_id', $request->languages_id)
                    ->orwhere('type', '2')
                    ->where('constant_banners.languages_id', $request->languages_id);
                }                              

                $banners = $banner->groupBy('constant_banners.banners_id')
                ->orderBy('constant_banners.banners_id','ASC')
                ->get();

            $result['message'] = $message;
            $result['banners'] = $banners;
                    
        }
        return $result;
    }

    public static function existbanner($request){
        $exist = DB::table('constant_banners')->where([
            'type'					 =>	  $request->type,
            'languages_id'			 =>	  $request->languages_id
            ])->get();


        if(count($exist)>0){
            return 1;
        }else{
            return 0;
        }

    }

    public static function insert($request){

        if($request->image_id){
            $uploadImage = $request->image_id;
        }else{
            $uploadImage = '';
        }
        DB::table('constant_banners')->insert([
                'banners_title'  		 =>   $request->type,
                'date_added'	 		 =>   date('Y-m-d H:i:s'),
                'banners_image'			 =>	  $uploadImage,
                'banners_url'	 		 =>   $request->banners_url,
                'status'	 			 =>   $request->status,
                'type'					 =>	  $request->type,
                'languages_id'			 =>	  $request->languages_id
                ]);
    }


    public static function edit($request){

        $banners = DB::table('constant_banners')
            ->leftJoin('image_categories','constant_banners.banners_image','=','image_categories.image_id')
            ->where('banners_id', $request->id)
            ->select('constant_banners.*','image_categories.path')
            ->groupBy('constant_banners.banners_id')
            ->get();

        return $banners;

    }


    public static function existbannerforupdate($request){
        $exist = DB::table('constant_banners')->where([
            'type'					 =>	  $request->type,
            'languages_id'			 =>	  $request->languages_id
            ])->where('banners_id','!=',$request->id)->get();


        if(count($exist)>0){
            return 1;
        }else{
            return 0;
        }

    }

    public static function updatebanner($request){

        $type = $request->type;

		if($type=='category'){
			$banners_url = $request->categories_id;
		}else if($type=='product'){
			$banners_url = $request->products_id;
		}else{
			$banners_url = '';
        }

        if($request->image_id){
            $uploadImage = $request->image_id;
            DB::table('constant_banners')->where('banners_id', $request->id)->update([
                'banners_title'  		 =>   $request->type,
                'date_added'	 		 =>   date('Y-m-d H:i:s'),
                'banners_image'			 =>	  $uploadImage,
                'banners_url'	 		 =>   $request->banners_url,
                'status'	 			 =>   $request->status,
                'type'					 =>	  $request->type,
                'languages_id'			 =>	  $request->languages_id
                ]);
		}else{
            DB::table('constant_banners')->where('banners_id', $request->id)->update([
                'banners_title'  		 =>   $request->type,
                'date_added'	 		 =>   date('Y-m-d H:i:s'),
                'banners_url'	 		 =>   $request->banners_url,
                'status'	 			 =>   $request->status,
                'type'					 =>	  $request->type,
                'languages_id'			 =>	  $request->languages_id
                ]);
		}
    }

    public static function deletebanners($request){
        DB::table('constant_banners')->where('banners_id', $request->banners_id)->delete();
    }

}
