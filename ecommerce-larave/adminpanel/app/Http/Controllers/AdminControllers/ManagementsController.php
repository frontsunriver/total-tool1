<?php 
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\AdminControllers\AlertController;
use \RecursiveIteratorIterator;
use \RecursiveArrayIterator;
use \RecursiveDirectoryIterator;
use App\Models\Core\News;
use App\Models\Core\Images;
use App\Models\Core\Setting;
use App\Models\Core\Languages;
use App\Models\Core\NewsCategory;
use Illuminate\Http\Request;
use Validator;
use DB;
use Hash;
use Lang;
use Auth;
use ZipArchive;
use File;
use Artisan;
use Config;
class ManagementsController extends Controller
{
  private $ticketRepository;
  private $api_url = 'http://api.themes-coder.com';

  public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }

  protected function curl( $url ) {

      if ( empty( $url) ) return false;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$response = curl_exec($ch);
		curl_close($ch);
		return json_decode($response);

}

  public function merge(Request $request){
    $title = array('pageTitle' => Lang::get("labels.Merge Project"));
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.managements.merge", $title)->with('result',$result);
  }

  public function backup(Request $request){
    $title = array('pageTitle' => Lang::get("labels.Back Up / Restore"));
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.managements.backup", $title)->with('result',$result);
  }

  public function take_backup(Request $request){

    $purchase_id = '';

    $purchase_code = $request->purchase_code;
   // Check for empty fields
   if ( empty( $purchase_code ) ) {
     return false;
   }
   // Gets author data & prepare verification vars
   $purchase_code 	= urlencode( $purchase_code );
   $current_site_url = $_SERVER['REQUEST_URI'];
   $url = $this->api_url. '/api.php?code=' . $purchase_code."&url=".$current_site_url;
   $response = $this->curl( $url );
   if (isset($response->error) && $response->error == '404' ) {
     return redirect()->back()->with('error', $response->description);
   }elseif(isset($response->id) and !empty($response->id)){
     $purchase_id = $response->id;
   }
   $tables = array();
   $result = DB::select("SHOW TABLES");
   $var = 'Tables_in_'.Config::get('database.connections.mysql.database');
   foreach ($result as $results) {
     $tables[] = $results->$var;
   }
   $return = '';
  
   //$table ='users';
   foreach ($tables as $table) {
     $return .= 'TRUNCATE '.$table.'; ';
    
   	$result = DB::table($table)->get();
   		foreach ($result as $key => $value) {
        $return_fields = '';
        $return_values = '';

         $return_fields .= 'INSERT INTO '.$table.' (';
         $return_values .= ' VALUES (';
         $array = (array) $value;
         $i = 0;

          foreach ($array as $key => $value){
              $value = addslashes($value);
              if($i == 0){
                $return_values .= "'".$value."'";
                $return_fields .= "`".$key."`";
              }else{
                $return_values .= ", '".$value."'";
                $return_fields .= ", `".$key."`";
              }
              
              $i++;
          }
         $return_values .= ");";
         $return_fields .= ");";
         $return .= $return_fields.$return_values."\n\n\n";
       }
       
       
       
   }
   $handle = fopen('backup.sql', 'w+');
   fwrite($handle, $return);
   fclose($handle);
   $images = glob(public_path('images/'));
   \Madzipper::make(public_path('images.zip'))->add($images)->close();
   $image_zip = glob(public_path('images.zip'));
   $seeds_zip = glob(public_path('backup.sql'));
   \Madzipper::make(public_path('backup.zip'))->add($image_zip)->add($seeds_zip)->close();
   unlink(public_path('images.zip'));
   unlink(public_path('backup.sql'));
   return response()->download(public_path('backup.zip'));

  }

  public function import(Request $request){
    $title = array('pageTitle' => Lang::get("labels.Import Data"));
    
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.managements.import", $title)->with('result',$result);
  }

  public function importdata(Request $request){
    $whitelist = array(
        '127.0.0.1',
        '::1'
    );
    $date = date('m-d-Y');
    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
      $destination_path = public_path("backups/".$date);
    }else{
      $destination_path = public_path("backups/".$date);
    }

    //delete existing folders
    File::deleteDirectory($destination_path);

    if($request->hasFile('zip_file')) {
       $purchase_id = '';

       $purchase_code = $request->purchase_code;
      // Check for empty fields
      if ( empty( $purchase_code ) ) {
        return false;
      }
      // Gets author data & prepare verification vars
      $purchase_code 	= urlencode( $purchase_code );
      $current_site_url = $_SERVER['REQUEST_URI'];
      $url = $this->api_url. '/api.php?code=' . $purchase_code."&url=".$current_site_url;
      $response = $this->curl( $url );
      if (isset($response->error) && $response->error == '404' ) {
        return redirect()->back()->with('error', $response->description);
      }elseif(isset($response->id) and !empty($response->id)){
        $purchase_id = $response->id;
      }

      $filename = $request->file('zip_file')->getClientOriginalName();
      $source = $request->file('zip_file')->getPathName();
      $type = $request->file('zip_file')->getMimeType();

      $name = explode(".", $filename);
      //check valid file is uploaded
      $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
      if(!in_array($request->file('zip_file')->getMimeType(), $accepted_types)){
        return redirect()->back()->with('error', Lang::get('labels.The file you are trying to upload is not a .zip file. Please try again.'));
      }

      $continue = strtolower($name[1]) == 'zip' ? true : false;
      if(!$continue) {
        return redirect()->back()->with('error', Lang::get('labels.The file you are trying to upload is not a .zip file. Please try again.'));
      }

      $target_path = public_path('/'.$filename);   // change this to the correct site path
      $target_path = $source;
      if(move_uploaded_file($source, $target_path)) {
        $zip = new ZipArchive();
        $x = $zip->open($target_path);
        if ($x === true) {

          $zip->extractTo($destination_path); // change this to the correct site path
          $zip->close();

          unlink($target_path);
        }
           try{
                //replace files
                $source_path = $destination_path.'/images.zip';
                $source_target =  public_path().'/images';
                $zip = new ZipArchive();
                $x = $zip->open($source_path);
                if ($x === true) {
                  $zip->extractTo($source_target); // change this to the correct site path
                  $zip->close();
                }
                $source_path = $destination_path.'/backup.sql';
                DB::unprepared(file_get_contents($source_path));

          }
          catch (\Exception $e) {
            return redirect()->back()->with('error', Lang::get('Back Up Zip file is not valid.'));

          }

          return redirect()->back()->with('message', Lang::get('labels.Your backup file is uploaded and unpacked successfully.'));
      } else {
        return redirect()->back()->with('error', Lang::get('labels.There was a problem with the upload. Please try again.'));
      }
    }else{
      return redirect()->back()->with('error', Lang::get('labels.Please upload zip file.'));
    }

  }

  public function mergecontent(Request $request){

    $whitelist = array(
        '127.0.0.1',
        '::1'
    );
    $date = date('m-d-Y');
    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
      $destination_path = public_path("zip/".$date);
    }else{
      $destination_path = public_path("zip/".$date);
    }

    //delete existing folders
    File::deleteDirectory($destination_path);

    if($request->hasFile('zip_file')) {
       $purchase_id = '';

       $purchase_code = $request->purchase_code;
      // Check for empty fields
      if ( empty( $purchase_code ) ) {
        return false;
      }
      // Gets author data & prepare verification vars
      $purchase_code 	= urlencode( $purchase_code );
      $current_site_url = $_SERVER['REQUEST_URI'];
      $url = $this->api_url. '/api.php?code=' . $purchase_code."&url=".$current_site_url;
      $response = $this->curl( $url );
      if (isset($response->error) && $response->error == '404' ) {
        return redirect()->back()->with('error', $response->description);
      }elseif(isset($response->id) and !empty($response->id)){
        $purchase_id = $response->id;
      }

      $filename = $request->file('zip_file')->getClientOriginalName();
      $source = $request->file('zip_file')->getPathName();
      $type = $request->file('zip_file')->getMimeType();

      $name = explode(".", $filename);
      //check valid file is uploaded
      $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
      if(!in_array($request->file('zip_file')->getMimeType(), $accepted_types)){
        return redirect()->back()->with('error', Lang::get('labels.The file you are trying to upload is not a .zip file. Please try again.'));
      }

      $continue = strtolower($name[1]) == 'zip' ? true : false;
      if(!$continue) {
        return redirect()->back()->with('error', Lang::get('labels.The file you are trying to upload is not a .zip file. Please try again.'));
      }

      $target_path = public_path('/'.$filename);   // change this to the correct site path
      $target_path = $source;
      if(move_uploaded_file($source, $target_path)) {
        $zip = new ZipArchive();
        $x = $zip->open($target_path);
        if ($x === true) {

          $zip->extractTo($destination_path); // change this to the correct site path
          $zip->close();

          unlink($target_path);
        }

        //////////// check version file info //////////////////////
        $version_file = require_once ($destination_path.'/version_info.php');
        $version = str_replace('version ', '', $version_file);

        ////////////// check version compatibility is same as admin or web or app //////////////////////
        $settings = DB::table("settings")->get();

        $settings_data = array();
        foreach ($settings as $setting) {
          $settings_data[$setting->name] = $setting->value;
        }

        if($settings_data['admin_version'] == $version['version']){

          //replace files
          $source_path = $destination_path.'/source_code.zip';
          $source_target =  base_path();
          $zip = new ZipArchive();
          $x = $zip->open($source_path);
          if ($x === true) {
            $zip->extractTo($source_target); // change this to the correct site path
            $zip->close();
          }

           ///// enable purchase middlewares and update version field /////
          if($version['souce_file'] == 'application' ){
               if($purchase_id == "20952416" or $purchase_id == "31137293" or $purchase_id == "20757378" or $purchase_id == "27944998"){
                 $status_name = 'is_app_purchased';
                 $app_version_name = 'app_version';
               }else{
                 return redirect()->back()->with('error', Lang::get('labels.Your purchase code does not match to the uploaded Zip file source code.'));
               }
          }elseif($version['souce_file'] == 'website'){
            if( $purchase_id == "22334657"){
              $status_name = 'is_web_purchased';
              $app_version_name = 'web_version';
            }else{
              return redirect()->back()->with('error', Lang::get('labels.Your purchase code does not match to the uploaded Zip file source code.'));
            }
          }elseif($version['souce_file'] == 'pos'){
            $status_name = 'is_pos_purchased';
            $app_version_name = 'pos_version';
          }

          DB::table("settings")->where('name', $status_name)->
          update([
            'value'		 	=>   1
          ]);

          DB::table("settings")->where('name', $app_version_name)->
          update([
            'value'		 	=>   $version['version']
          ]);

          return redirect()->back()->with('message', Lang::get('labels.Your project file is uploaded and unpacked successfully.'));

        }else{
          return redirect()->back()->with('error', Lang::get('labels.Your admin version is '). $settings_data['admin_version'] .' '. Lang::get('labels.but your uploaded version is '). $version['version'] .'. '.   Lang::get('labels.Please update your admin version first.'));
        }


      } else {
        return redirect()->back()->with('error', Lang::get('labels.There was a problem with the upload. Please try again.'));
      }
    }else{
      return redirect()->back()->with('error', Lang::get('labels.Please upload zip file.'));
    }

  }

  public function updater(Request $request){
    $title = array('pageTitle' => Lang::get("labels.Merge Project"));
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.managements.updater", $title)->with('result',$result);
  }

  public function checkpassword(Request $request){
      print '1';

  }

  public function updatercontent(Request $request){
    $whitelist = array(
      '127.0.0.1',
      '::1'
    );
    $date = date('m-d-Y');
    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
      $destination_path = public_path("zip/".$date);
    }else{
      $destination_path = public_path("zip/".$date);
    }

    //delete existing folders
    File::deleteDirectory($destination_path);

    if($request->hasFile('zip_file')) {
      $purchase_id = '';

      $purchase_code = $request->purchase_code;
      // Check for empty fields
      if ( empty( $purchase_code ) ) {
        return false;
      }
      // Gets author data & prepare verification vars
      $purchase_code 	= urlencode( $purchase_code );
      $current_site_url = $_SERVER['REQUEST_URI'];
      $url = $this->api_url. '/api.php?code=' . $purchase_code."&url=".$current_site_url;
      $response = $this->curl( $url );
      if (isset($response->error) && $response->error == '404' ) {
        return redirect()->back()->with('error', $response->description);
      }elseif(isset($response->id) and !empty($response->id)){
        $purchase_id = $response->id;
      }


    $filename = $request->file('zip_file')->getClientOriginalName();
    $source = $request->file('zip_file')->getPathName();
    $type = $request->file('zip_file')->getMimeType();

    $name = explode(".", $filename);
    //check valid file is uploaded
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    if(!in_array($request->file('zip_file')->getMimeType(), $accepted_types)){
      return redirect()->back()->with('error', Lang::get('labels.The file you are trying to upload is not a .zip file. Please try again.'));
    }

    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if(!$continue) {
      return redirect()->back()->with('error', Lang::get('labels.The file you are trying to upload is not a .zip file. Please try again.'));
    }

    $target_path = public_path('/'.$filename);   // change this to the correct site path
    $target_path = $source;
    if(move_uploaded_file($source, $target_path)) {
      $zip = new ZipArchive();
      $x = $zip->open($target_path);
      if ($x === true) {

        $zip->extractTo($destination_path); // change this to the correct site path
        $zip->close();

        unlink($target_path);
    }

      //////////// check version file info //////////////////////
      $version_file = require_once ($destination_path.'/version_info.php');
      $version = str_replace('version ', '', $version_file);

      ////////////// check version compatibility is same as admin or web or app //////////////////////
      $settings = DB::table("settings")->get();

      $settings_data = array();
      foreach ($settings as $setting) {
        $settings_data[$setting->name] = $setting->value;
      }

      if($settings_data['admin_version'] == $version['version'] and $version['souce_file'] != 'admin'){

        //replace files
        $source_path = $destination_path.'/source_code.zip';
        $source_target =  base_path();
        $zip = new ZipArchive();
        $x = $zip->open($source_path);
        if ($x === true) {
          $zip->extractTo($source_target); // change this to the correct site path
          $zip->close();
        }

        ///// enable purchase middlewares and update version field /////
        $status_name = '';
        $app_version_name = '';

        if($version['souce_file'] == 'application' ){
          if($purchase_id == "20952416" or $purchase_id == "31137293" or $purchase_id == "20757378" or $purchase_id == "27944998"){
               $status_name = 'is_app_purchased';
               $app_version_name = 'app_version';
             }else{
               return redirect()->back()->with('error', Lang::get('labels.Your purchase code does not match to the uploaded Zip file source code.'));
             }
        }elseif($version['souce_file'] == 'website'){
          if( $purchase_id == "22334657"){
            $status_name = 'is_web_purchased';
            $app_version_name = 'web_version';
          }else{
            return redirect()->back()->with('error', Lang::get('labels.Your purchase code does not match to the uploaded Zip file source code.'));
          }
        }elseif($version['souce_file'] == 'pos'){
          $status_name = 'is_pos_purchased';
          $app_version_name = 'pos_version';
        }


        DB::table("settings")->where('name', $status_name)->
        update([
          'value'		 	=>   1
        ]);

        DB::table("settings")->where('name', $app_version_name)->
        update([
          'value'		 	=>   $version['version']
        ]);

        if($settings_data['admin_version']== '4.0' and $version['souce_file'] == 'application' or $settings_data['admin_version']== '4.0' and $version['souce_file'] == 'website'){

          DB::table("settings")->where('name', 'admin_version')->
          update([
            'value'		 	=>   '4.0.1'
          ]);
          DB::table("settings")->where('name', $app_version_name)->
          update([
            'value'		 	=>   '4.0.1'
          ]);

        }

        $sql_file = $destination_path.'/database.sql';
        if (file_exists($sql_file)) {
          DB::unprepared(file_get_contents($sql_file));
        }

        return redirect()->back()->with('message', Lang::get('labels.Your project file is uploaded and unpacked successfully.'));

      }elseif($version['souce_file'] == 'admin'){

        if($purchase_id == "26827707" or $purchase_id == "26840547" or $purchase_id == "28681648" or $purchase_id == "27944998"  or $purchase_id == "20952416" or $purchase_id == "31137293" or $purchase_id == "20757378" or $purchase_id == "22334657"){
          //$existing_version
          $status_name = '';
          $app_version_name = '';

          //replace files
          $source_path = $destination_path.'/source_code.zip';
          $source_target =  base_path();
          $zip = new ZipArchive();
          $x = $zip->open($source_path);
          if ($x === true) {
            $zip->extractTo($source_target); // change this to the correct site path
            $zip->close();
          }

          $app_version_name = 'admin_version';

          DB::table("settings")->where('name', $app_version_name)->
          update([
            'value'		 	=>   $version['version']
          ]);

          $sql_file = $destination_path.'/database.sql';
          if (file_exists($sql_file)) {
            DB::unprepared(file_get_contents($sql_file));
          }

          return redirect()->back()->with('message', Lang::get('labels.Your project file is uploaded and unpacked successfully.'));

        }else{
          return redirect()->back()->with('error', Lang::get('labels.Your purchase code does not match to the uploaded Zip file source code.'));
        }


      }else{
        return redirect()->back()->with('error', Lang::get('labels.Your admin version is '). $settings_data['admin_version'] .' '. Lang::get('labels.but your uploaded version is '). $version['version'] .'. '.   Lang::get('labels.Please update your admin version first.'));
      }


    } else {
      return redirect()->back()->with('error', Lang::get('labels.There was a problem with the upload. Please try again.'));
    }
    }else{
    return redirect()->back()->with('error', Lang::get('labels.Please upload zip file.'));
    }
  }


}
