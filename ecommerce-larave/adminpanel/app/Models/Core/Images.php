<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;
use Image;

class Images extends Model
{
    //
use Sortable;
public $sortable =['id','name'];

    public function image_category(){

        return $this->hasMany('App\Image_category');
    }

    public function getimages(){


       $allimagesth = DB::table('images')
            ->leftJoin('image_categories', 'images.id', '=', 'image_categories.image_id')
            ->select('path','images.id','image_type')
            ->where('image_categories.image_type','THUMBNAIL')
            ->orderby('images.id','DESC')
            ->get();
        $allimages = DB::table('images')
            ->leftJoin('image_categories', 'images.id', '=', 'image_categories.image_id')
            ->select('path','images.id','image_type')
            ->where('image_categories.image_type','ACTUAL')
            ->orderby('images.id','DESC')

            ->get();

         $result =$allimages->merge($allimagesth)->keyBy('id');

       return $result;

    }


    public function getimagedetail($id){

        $imagesdetail = DB::table('images')
            ->leftJoin('image_categories', 'images.id', '=', 'image_categories.image_id')
            ->where('images.id',$id)
            ->get();

        return $imagesdetail;



    }


    public function imagedata($filename, $Path, $width, $height, $user_id = null){

        if(Auth::user()){
            $user_id = Auth::user()->id;
        }else{
            $user_id = $user_id;
        }

        $imagedata = DB::table('images')->insert([
            ['name' => $filename, 'user_id' => $user_id]
        ]);
        $getimage_id =  DB::table('images')->where('name', $filename)->first();

        $image_id = $getimage_id->id;

        $imagecatedata = DB::table('image_categories')->insert([
            ['image_id' => $image_id, 'image_type' => '1', 'height' =>$height,'width' =>$width,'path' =>$Path]
        ]);
        return $image_id;

    }

    public function thumbnailrecord($filename,$Path,$width,$height){
      $getimage_id =  DB::table('images')->where('name', $filename)->first();
      $image_id = $getimage_id->id;

      $imagecatedata = DB::table('image_categories')->insert([
        ['image_id' => $image_id, 'image_type' => '2', 'height' =>$height,'width' =>$width,'path' =>$Path]
      ]);
    }


    public function Mediumrecord($filename,$Path,$width,$height){
        $getimage_id =  DB::table('images')->where('name', $filename)->first();
        $image_id = $getimage_id->id;
        $imagecatedata = DB::table('image_categories')->insert([
            ['image_id' => $image_id, 'image_type' => '4', 'height' =>$height,'width' =>$width,'path' =>$Path]
        ]);

    }

    public function Largerecord($filename,$Path,$width,$height){


        $getimage_id =  DB::table('images')->where('name', $filename)->first();

        $image_id = $getimage_id->id;

        $imagecatedata = DB::table('image_categories')->insert([
            ['image_id' => $image_id, 'image_type' => '3', 'height' =>$height,'width' =>$width,'path' =>$Path, 
            'updated_at'     => date('y-m-d h:i:s')]
        ]);



    }

    public function thumbnailHeightWidth()
    {
        $Thumbnail_height = DB::table('settings')->where('name','Thumbnail_height')->get();
        $Thumbnail_width = DB::table('settings')->where('name','Thumbnail_width')->get();
        $thumbnailsetting = array($Thumbnail_height[0],$Thumbnail_width[0]);
        return $thumbnailsetting;
    }

    public function MediumHeightWidth()
    {
        $Medium_height = DB::table('settings')->where('name','Medium_height')->get();
        $Medium_width = DB::table('settings')->where('name','Medium_width')->get();


        $Mediumsetting = array($Medium_height[0],$Medium_width[0]);




        return $Mediumsetting;
    }

    public function LargeHeightWidth()
    {
        $Large_height = DB::table('settings')->where('name','Large_height')->get();
        $Large_width = DB::table('settings')->where('name','Large_width')->get();


        $Largesetting = array($Large_height[0],$Large_width[0]);




        return $Largesetting;
    }

    public function AllimagesHeightWidth()
    {
        $Thumbnail_height = DB::table('settings')->where('name','Thumbnail_height')->get();
        $Thumbnail_width = DB::table('settings')->where('name','Thumbnail_width')->get();
        $Medium_height = DB::table('settings')->where('name','Medium_height')->get();
        $Medium_width = DB::table('settings')->where('name','Medium_width')->get();
        $Large_height = DB::table('settings')->where('name','Large_height')->get();
        $Large_width = DB::table('settings')->where('name','Large_width')->get();
        $AllImagessetting = array($Thumbnail_height[0],$Thumbnail_width[0],$Medium_height[0],$Medium_width[0],$Large_height[0],$Large_width[0]);
        return $AllImagessetting;
    }

    public function imagedelete($id){
        $imagesdetail = DB::table('images')

            ->where('images.id',$id)
             ->delete();

        $imagesdetailcategories = DB::table('image_categories')

            ->where('image_categories.image_id',$id)
            ->delete();
        return  $imagesdetailcategories;
    }


    //regenerate section
    public function regenerate($image_id, $id, $width, $height)
    {
        $origianl_record = DB::table('image_categories')
            ->select('path')
            ->where('image_categories.image_id',$image_id)
            ->where('image_categories.image_type','ACTUAL')
            ->first();
        
        $required_record = DB::table('image_categories')
            ->select('path')
            ->where('image_categories.id',$id)
            ->first();

        
        $original_image_path = $origianl_record->path;
        $required_image_full_path = $required_record->path;

        //delete old size image
        if(file_exists($required_image_full_path)){
            unlink($required_image_full_path);
        }
        
        
        //get name and path of required image
        $total_string = strlen($required_image_full_path);
        $required_imag_path = substr($required_image_full_path, 0,21);
        $filename = substr($required_image_full_path, 21,$total_string);
        
        $destinationPath = public_path($required_imag_path);
        $saveimage = Image::make($original_image_path, array(

            'width' => $width,

            'height' => $height,

            'grayscale' => false));

        $namethumbnail = $saveimage->save($destinationPath . $filename);

        $Path = $required_image_full_path;
        $destinationFile = public_path($Path);
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;

       DB::table('image_categories')->where('id', $id)->update(
        [
            'width'   =>   $width,
            'height'          =>   $height,
            'updated_at'     => date('y-m-d h:i:s')
        ]);

        return $namethumbnail;
    }

    public function regenrateAll($request){
        //get settings
        $AllImagesSettingData = $this->AllimagesHeightWidth();

        $images = DB::table('images')
            ->leftJoin('image_categories', 'images.id', '=', 'image_categories.image_id')
            ->where('image_type', 'ACTUAL')
            //->where('image_categories.image_id',446)
            ->get();
        
        foreach($images as $image){
            $image_path = $image->path;
            $image_id = $image->image_id;

            $size = getimagesize($image_path);
            list($width, $height, $type, $attr) = $size;

            switch (true) {
                case ($width >= $AllImagesSettingData[5]->value || $height >= $AllImagesSettingData[4]->value):

                    $tuhmbnail = $this->regenerateimages($image_id, $AllImagesSettingData[0]->value, $AllImagesSettingData[1]->value, 'THUMBNAIL');
                    $mediumimage = $this->regenerateimages($image_id, $AllImagesSettingData[2]->value, $AllImagesSettingData[3]->value, 'MEDIUM');
                    $largeimage = $this->regenerateimages($image_id, $AllImagesSettingData[4]->value, $AllImagesSettingData[5]->value, 'LARGE');
                    break;
                case ($width >= $AllImagesSettingData[3]->value || $height >= $AllImagesSettingData[2]->value):
                    $tuhmbnail = $this->regenerateimages($image_id, $AllImagesSettingData[0]->value, $AllImagesSettingData[1]->value, 'THUMBNAIL');
                    $mediumimage = $this->regenerateimages($image_id, $AllImagesSettingData[2]->value, $AllImagesSettingData[3]->value, 'MEDIUM');
                    break;
                case ($width >= $AllImagesSettingData[0]->value || $height >= $AllImagesSettingData[1]->value):
                    $tuhmbnail = $this->regenerateimages($image_id, $AllImagesSettingData[0]->value, $AllImagesSettingData[1]->value, 'THUMBNAIL');
                    break;
            }

        }

        


    }

    //regenerate section
    public function regenerateimages($image_id, $width, $height, $image_type)
    {
        $origianl_record = DB::table('image_categories')
            ->select('path')
            ->where('image_categories.image_id',$image_id)  
            ->where('image_categories.image_type','ACTUAL')
            ->first();
        
        $required_record = DB::table('image_categories')
            //->where('image_categories.id',$id)
            ->where('image_categories.image_id',$image_id) 
            ->where('image_categories.image_type',$image_type)
            ->first();
        
        $original_image_path = $origianl_record->path;

        if($required_record){
            $required_image_full_path = $required_record->path;
            $id = $required_record->id;
            
            //delete old size image
            if(file_exists($required_image_full_path)){
                unlink($required_image_full_path);                
            }

            $total_string = strlen($required_image_full_path);
            $required_imag_path = substr($required_image_full_path, 0,21);
            $filename = substr($required_image_full_path, 21,$total_string); 

        }else{
            $required_image_full_path = $original_image_path;
            $total_string = strlen($original_image_path);
            $required_imag_path = substr($original_image_path, 0,21);
            $filename = substr($original_image_path, 21,$total_string);
            $filename = strtolower($image_type).time() . $filename;
        }
        
        $destinationPath = public_path($required_imag_path);
        $saveimage = Image::make($original_image_path, array(

            'width' => $width,

            'height' => $height,

            'grayscale' => false));

        $namethumbnail = $saveimage->save($destinationPath . $filename);
       
        $path = $required_imag_path . $filename;
        $destinationFile = $path;
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;
    
        //check insert or update
        if($required_record){
            
            DB::table('image_categories')->where('id', $id)->update(
                [
                    'width'   =>   $width,
                    'height'          =>   $height,
                    'updated_at'     => date('y-m-d h:i:s')
                ]);
        }else{
            DB::table('image_categories')->insert(
            [
                'width'   =>   $width,
                'height'     =>   $height,
                'created_at' => date('y-m-d h:i:s'),
                'image_id'  =>   $image_id,
                'path'  => $path,
                'image_type' => $image_type
            ]);
        }       

        return $namethumbnail;
    }

    
}
