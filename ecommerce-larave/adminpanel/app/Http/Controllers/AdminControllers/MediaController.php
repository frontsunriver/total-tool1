<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Setting;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Image;
use Lang;

class MediaController extends Controller
{
    //
    public function __construct(Images $images, Setting $setting)
    {
        $this->Images = $images;
        $this->Setting = $setting;

    }

    public function refresh()
    {
        $Images = new Images();
        $allimage = $Images->getimages();
        return view("admin.media.loadimages")->with('allimage', $allimage);
    }

    public function display()
    {
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.media.index")->with('result', $result);
    }

    public function updatemediasetting(Request $request)
    {
        $messages = "Content has been updated successfully!";

        try {
            $setting = new Setting;
            $mediasetting = $setting->settingmedia($request);

            if(isset($request->regenrate) and $request->regenrate=='yes'){
                $Images = new Images();
                $regenrate = $Images->regenrateAll($request);
                $messages =  Lang::get("labels.Setting and Sizes are updated now");
            }    

            return redirect()->back()->with('update', $messages);

        } catch (Exception $e) {
            return \Illuminate\Support\Facades\Redirect::back()->withErrors($messages)->withInput($request->all());
        }

    }

    public function add()
    {
        $Images = new Images();
        $images = $Images->getimages();
        $result['commonContent'] = $this->Setting->commonContent();

        return view('admin.media.addimages')->with('images', $images)->with('result', $result);
    }

    public function fileUpload(Request $request)
    {

        // Creating a new time instance, we'll use it to name our file and declare the path
        $time = Carbon::now();
        // Requesting the file from the form
        $image = $request->file('file');
        $extensions = Setting::imageType();
        if ($request->hasFile('file') and in_array($request->file->extension(), $extensions)) {

            // getting size
            $size = getimagesize($image);
            list($width, $height, $type, $attr) = $size;
            // Getting the extension of the file
            $extension = $image->getClientOriginalExtension();
            // Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
            $directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
            // Creating the file name: random string followed by the day, random number and the hour
            $filename = str_random(5) . date_format($time, 'd') . rand(1, 9) . date_format($time, 'h') . "." . $extension;
            // This is our upload main function, storing the image in the storage that named 'public'
            $upload_success = $image->storeAs($directory, $filename, 'public');

            //store DB
            $Path = 'images/media/' . $directory . '/' . $filename;
            $Images = new Images();
            $imagedata = $Images->imagedata($filename, $Path, $width, $height);

            $AllImagesSettingData = $Images->AllimagesHeightWidth();

            switch (true) {
                case ($width >= $AllImagesSettingData[5]->value || $height >= $AllImagesSettingData[4]->value):
                    $tuhmbnail = $this->storeThumbnial($Path, $filename, $directory, $filename);
                    $mediumimage = $this->storeMedium($Path, $filename, $directory, $filename);
                    $largeimage = $this->storeLarge($Path, $filename, $directory, $filename);
                    break;
                case ($width >= $AllImagesSettingData[3]->value || $height >= $AllImagesSettingData[2]->value):
                    $tuhmbnail = $this->storeThumbnial($Path, $filename, $directory, $filename);
                    $mediumimage = $this->storeMedium($Path, $filename, $directory, $filename);
                    //                $storeLargeImage = $Images->Largerecord($filename,$Path,$width,$height);
                    break;
                case ($width >= $AllImagesSettingData[0]->value || $height >= $AllImagesSettingData[1]->value):
                    $tuhmbnail = $this->storeThumbnial($Path, $filename, $directory, $filename);
                    //                $storeLargeImage = $Images->Largerecord($filename,$Path,$width,$height);
                    //                $storeMediumImage = $Images->Mediumrecord($filename,$Path,$width,$height);

                    break;
                    //            default:
                    //                $tuhmbnail = $this->storeThumbnial($Path,$filename,$directory,$filename);
                    //                $storeLargeImage = $Images->Largerecord($filename,$Path,$width,$height);
                    //                $storeMediumImage = $Images->Mediumrecord($filename,$Path,$width,$height);
            }

        } else {
            return "Invalid Image";
        }

    }

    public function storeThumbnial($Path, $filename, $directory, $input)
    {
        $Images = new Images();
        $thumbnail_values = $Images->thumbnailHeightWidth();

        $originalImage = $Path;

        $destinationPath = public_path('images/media/' . $directory . '/');
        $thumbnailImage = Image::make($originalImage, array(

            'width' => $thumbnail_values[1]->value,

            'height' => $thumbnail_values[0]->value,

            'grayscale' => false));
        $namethumbnail = $thumbnailImage->save($destinationPath . 'thumbnail' . time() . $filename);

        $Path = 'images/media/' . $directory . '/' . 'thumbnail' . time() . $filename;
        $destinationFile = public_path($Path);
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;
        $Images = new Images();
        $storethumbnail = $Images->thumbnailrecord($input, $Path, $width, $height);

        return $namethumbnail;
    }

    public function storeMedium($Path, $filename, $directory, $input)
    {
        $Images = new Images();
        $Medium_values = $Images->MediumHeightWidth();

        $originalImage = $Path;

        $destinationPath = public_path('images/media/' . $directory . '/');
        $thumbnailImage = Image::make($originalImage, array(

            'width' => $Medium_values[1]->value,

            'height' => $Medium_values[0]->value,

            'grayscale' => false));
        $namemedium = $thumbnailImage->save($destinationPath . 'medium' . time() . $filename);
        $Path = 'images/media/' . $directory . '/' . 'medium' . time() . $filename;

        $destinationFile = public_path($Path);
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;

        $storeMediumImage = $Images->Mediumrecord($input, $Path, $width, $height);

        return $namemedium;
    }

    public function storeLarge($Path, $filename, $directory, $input)
    {
        $Images = new Images();
        $Large_values = $Images->LargeHeightWidth();

        $originalImage = $Path;

        $destinationPath = public_path('images/media/' . $directory . '/');
        $thumbnailImage = Image::make($originalImage, array(

            'width' => $Large_values[1]->value,

            'height' => $Large_values[0]->value,

            'grayscale' => false));
//        $upload_success = $thumbnailImage->save($directory, $filename, 'public');
        $namelarge = $thumbnailImage->save($destinationPath . 'large' . time() . $filename);

        $Path = 'images/media/' . $directory . '/' . 'large' . time() . $filename;
        $destinationFile = public_path($Path);
        $size = getimagesize($destinationFile);
        list($width, $height, $type, $attr) = $size;

        $storeLargeImage = $Images->Largerecord($input, $Path, $width, $height);

        return $namelarge;
    }

    public function detailimage($id)
    {
        $Images = new Images();
        $images = $Images->getimagedetail($id);
        //dd($imageDetail);
        //$returnHTML = view('admin.modal-body-view')->with('imageDetail', $imageDetail);
        $result['images'] = $images;
        $result['commonContent'] = $this->Setting->commonContent();
        $returnHTML = view('admin.media.detail')->with('result', $result);

        return ($returnHTML);

    }

    public function regenerateimage(Request $request)
    {
        $Images = new Images();
        $images = $Images->regenerate($request->image_id, $request->id, $request->width, $request->height);
        //dd($imageDetail);
        //$returnHTML = view('admin.modal-body-view')->with('imageDetail', $imageDetail);
        $result['images'] = $images;
        $result['commonContent'] = $this->Setting->commonContent();
        return redirect()->back()->with('success', Lang::get("labels.imageresizedmsg"));
    }

    public function deleteimage(Request $request)
    {
        $images = explode(",", $request->images);
        foreach ($images as $image) {
            $Images = new Images();
            $imagedelete = $Images->imagedelete($image);
        }
        return 'success';

    }

}
