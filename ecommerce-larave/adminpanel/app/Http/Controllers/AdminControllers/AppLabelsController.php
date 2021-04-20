<?php
namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use DB;
//for password encryption or hash protected
use Illuminate\Http\Request;

//for authenitcate login data
use Lang;
use Mail;
use App\Models\Core\Setting;

//for requesting a value

class AppLabelsController extends Controller
{
	public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }

    //listingAppLabels
    public function listingAppLabels(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.ListingLabels"));

        $language_id = '1';

        $result = array();
        $message = array();

        $labels = DB::table('labels')
            ->leftJoin('label_value', 'label_value.label_id', '=', 'labels.label_id')
            ->where('language_id', '=', $language_id)
            ->paginate(20);

        $result['message'] = $message;
        $result['labels'] = $labels;  
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.settings.app.labels.listingAppLabels", $title)->with('result', $result);

    }

    //addAppLabel
    public function manageAppLabel(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ManageLabel"));

        $result = array();
        $message = array();

        //get function from other controller
        $myVar = new SiteSettingController();
        $result['languages'] = $myVar->getLanguages();

        $alllabels = DB::table('labels')->get();
        $totalRecord = count($alllabels);

        $rem = $totalRecord / 50;

        $arr = explode('.', trim($rem));

        if (is_float($rem)) {
            $numberVal = $arr[0];
            $numberVal += 1;
        } else {
            $numberVal = $arr[0];
        }

        $i = 1;
        $start = 0;
        $end = 49;
        $data = array();
        while ($i <= $numberVal) {
            $labels = DB::table('labels')->skip($start)->take(50)->orderby('label_id', 'ASC')->get();

            $myVal = array();
            $index = 0;
            foreach ($labels as $labels_data) {
                array_push($myVal, $labels_data);

                $values = DB::table('label_value')
                    ->Join('languages', 'languages.languages_id', '=', 'label_value.language_id')
                    ->select('languages.name', 'label_value.*')
                    ->where('label_id', '=', $labels_data->label_id)
                    ->orderBy('label_value.language_id', 'ASC')
                    ->get();

                $myVal[$index++]->values = $values;
            }
            $start += 50;
            $data[$i] = $myVal;
            $i++;
        }

        $result['labels'] = $data;  
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.settings.app.labels.manageAppLabel", $title)->with('result', $result);

    }

    //addAppKey
    public function addappkey(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddKeyLabel"));

        $result = array();
        $message = array();  
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.settings.app.labels.addappkey", $title)->with('result', $result);

    }

    //addNewAppLabel
    public function addNewAppLabel(Request $request)
    {

        $label_name = $request->label_name;

        $checkExist = DB::table('labels')->where('label_name', '=', $label_name)->get();

        //get function from other controller
        $myVar = new SiteSettingController();
        $languages = $myVar->getLanguages();

        if (count($checkExist) > 0) {

            $message = Lang::get("labels.Labelkeyalreadyexist");
            return redirect()->back()->withErrors([$message]);

        } else {

            DB::table('labels')->insert([
                'label_name' => $request->label_name,
            ]);

            return redirect()->back()->with('message', Lang::get("labels.LabelkeyAddedMessage"));

        }

    }

    //editTaxClass
    public function editAppLabel(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditLabel"));

        $result = array();
        $message = array();

        //get function from other controller
        $myVar = new SiteSettingController();
        $result['languages'] = $myVar->getLanguages();

        $labels = DB::table('labels')->get();
        $result['labels'] = $labels;

        $labels_value = DB::table('labels')
            ->leftJoin('label_value', 'label_value.label_id', '=', 'labels.label_id')
            ->where('labels.label_id', '=', $request->id)
            ->orderBy('label_value.label_id', 'ASC')
            ->get();

        $result['labels_value'] = $labels_value;  
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.settings.app.labels.editAppLabel", $title)->with('result', $result);
    }

    //updateAppLabel
    public function updateAppLabel(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditLabel"));
        $last_modified = date('y-m-d h:i:s');

        $result = array();

        //get function from other controller
        $myVar = new SiteSettingController();
        $languages = $myVar->getLanguages();

        $labels = DB::table('labels')->get();

        foreach ($labels as $labels_data) {

            $label = 'label_id_' . $labels_data->label_id;
            $label_id = $request->$label;

            foreach ($languages as $languages_data) {

                $label_id = $request->$label;
                $label_value = 'label_value_' . $languages_data->languages_id . '_' . $label_id;

                $checkexist = DB::table('label_value')->where('label_id', '=', $label_id)->where('language_id', '=', $languages_data->languages_id)->get();

                if (count($checkexist) > 0) {
                    DB::table('label_value')
                        ->where('label_id', $label_id)
                        ->where('language_id', $languages_data->languages_id)
                        ->update([
                            'label_value' => $request->$label_value,
                        ]);
                } else {
                    DB::table('label_value')->insert([
                        'label_value' => $request->$label_value,
                        'label_id' => $label_id,
                        'language_id' => $languages_data->languages_id,
                    ]);
                }
            }

        }

        return redirect()->back()->with('message', Lang::get("labels.LabelkeyUpdatedMessage"));
    }

}
