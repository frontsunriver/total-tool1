<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Countries;
use App\Models\Core\Setting;
use App\Models\Core\Tax_class;
use App\Models\Core\Tax_rate;
use App\Models\Core\Zones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;

class CountriesController extends Controller
{
    //

    public function __construct(Countries $countries, Zones $zone, Tax_class $tax_class, Tax_rate $tax_rate, Setting $setting)
    {
        $this->Countries = $countries;
        $this->Zone = $zone;
        $this->Tax_class = $tax_class;
        $this->Tax_rate = $tax_rate;
        $this->Setting = $setting;
    }

    public function index(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingCountries"));
        $countryData = array();
        $message = array();
        $errorMessage = array();
        $countries = $this->Countries->paginator();
        $countryData['message'] = $message;
        $countryData['countries'] = $countries;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.countries.index", $title)->with('result', $result)->with('countryData', $countryData);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddCountry"));
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.countries.add", $title)->with('result', $result);
    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditCountry"));
        $countryData = array();
        $categories_id = $this->Countries->insert($request);
        $message = Lang::get("labels.CountryAddedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function edit($id)
    {
        $title = array('pageTitle' => Lang::get("labels.EditCountry"));
        $country = $this->Countries->edit($id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.countries.edit", $title)->with('result', $result)->with('country', $country);
    }

    public function update(Request $request)
    {
        $this->Countries->updaterecord($request);
        $message = Lang::get("labels.CountryUpdatedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function delete(Request $request)
    {
        $this->Countries->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.CountryDeletedMessage")]);
    }

    public function filter(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingCountries"));
        $name = $request->FilterBy;
        $param = $request->parameter;

        $countryData = array();
        $message = array();
        $errorMessage = array();
        $countries = $this->Countries->filter($request);
        $countryData['message'] = $message;
        $countryData['countries'] = $countries;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.countries.index", $title)->with('result', $result)->with('countryData', $countryData)->with('name', $name)->with('param', $param);
    }

    public function listingZones(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingZones"));

        $result = array();
        $message = array();
        $errorMessage = array();

        $zones = Zone::sortable()
            ->LeftJoin('countries', 'zones.zone_country_id', '=', 'countries.countries_id')
            ->paginate(60);

        $result['message'] = $message;
        $result['zones'] = $zones;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.listingZones", $title)->with('result', $result);
    }

    //addcountry
    public function addZone(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddZone"));

        $result = array();
        $message = array();

        $countries = $this->Zone->getcountries();
        $result['countries'] = $countries;
        $result['message'] = $message;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.addZone", $title)->with('result', $result);
    }

    //addNewZone
    public function addNewZone(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddCountry"));
        $result = array();

        $zone_id = $this->Zone->getzoneid($request);

        $countries = $this->Zone->getcountries();
        $result['countries'] = $countries;
        $result['commonContent'] = $this->Setting->commonContent();

        $result['message'] = Lang::get("labels.ZoneAddedMessage");
        return view('admin.addZone', $title)->with('result', $result);
    }

    //editZone
    public function editZone(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditZone"));
        $result = array();
        $result['message'] = array();

        $zones = $this->Zone->editzone($request);
        $countries = $this->Zone->getcountries();
        $result['countries'] = $countries;
        $result['zones'] = $zones;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.editZone", $title)->with('result', $result);
    }

    //updateZone
    public function updateZone(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.EditCountry"));

        $countryData = array();
        $countryData['message'] = 'Zone has been updated successfully!';

        $countryUpdate = $this->Zone->zoneupdate($request);

        $country = $this->Zone->getcountry($request);
        $countryData['country'] = $country;

        return redirect()->back()->withErrors([Lang::get("labels.ZoneUpdatedTax")]);
    }

    //deleteZone
    public function deleteZone(Request $request)
    {
        DB::table('zones')->where('zone_id', $request->id)->delete();
        return redirect()->back()->withErrors([Lang::get("labels.ZoneDeletedTax")]);
    }

    public function filterzones(Request $request)
    {

        $name = $request->FilterBy;
        $param = $request->parameter;

        $title = array('pageTitle' => Lang::get("labels.ListingZones"));

        $result = array();
        $message = array();
        $errorMessage = array();

        switch ($name) {
            case 'Zone':

                $zones = Zone::sortable()->where('zone_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('countries', 'zones.zone_country_id', '=', 'countries.countries_id')
                    ->paginate(30);

                break;

            case 'Code':

                $zones = Zone::sortable()->where('zone_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('countries', 'zones.zone_country_id', '=', 'countries.countries_id')
                    ->paginate(30);

                break;
            case 'Country':

                $zones = Zone::sortable()->where('zone_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('countries', 'zones.zone_country_id', '=', 'countries.countries_id')
                    ->paginate(30);

                break;

            default:

                $zones = Zone::sortable()
                    ->LeftJoin('countries', 'zones.zone_country_id', '=', 'countries.countries_id')
                    ->paginate(30);

                break;

        }

        $result['message'] = $message;
        $result['zones'] = $zones;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.listingZones", $title)->with('result', $result)->with('name', $name)->with('param', $param);

    }

    //taxclass
    public function taxclass(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingTaxClasses"));

        $result = array();
        $message = array();

        $tax_class = $this->Tax_class->fetchtax();

        $result['message'] = $message;
        $result['tax_class'] = $tax_class;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.taxclass", $title)->with('result', $result);
    }

    //addtaxclass
    public function addtaxclass(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddTaxClass"));

        $result = array();
        $message = array();

        $result['message'] = $message;

        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.addtaxclass", $title)->with('result', $result);
    }

    //addNewZone
    public function addnewtaxclass(Request $request)
    {

        $this->Tax_class->addTaxes($request);

        $message = Lang::get("labels.TaxClassAddedTax");
        return redirect()->back()->withErrors([$message]);
    }

    //edittaxclass
    public function edittaxclass(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditCountry"));
        $result = array();
        $result['message'] = array();

        $taxClass = $this->Tax_class->edittaxclass($request);
        $result['taxClass'] = $taxClass;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.edittaxclass", $title)->with('result', $result);
    }

    //updatetaxclass
    public function updatetaxclass(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.EditCountry"));

        $countryData = array();
        $message = Lang::get("labels.TaxClassUpdatedTax");

        $countryUpdate = $this->Tax_class->updatetaxclass($request);

        return redirect()->back()->withErrors([$message]);
    }

    //deletetaxclass
    public function deletetaxclass(Request $request)
    {
        $this->Tax_class->deletetaxclass($request);
        return redirect()->back()->withErrors([Lang::get("labels.TaxClassDeletedTax")]);
    }

    public function taxclassfilter(Request $request)
    {

        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.ListingTaxClasses"));

        $result = array();
        $message = array();

        switch ($name) {
            case 'Title':

                $tax_class = Tax_class::sortable()->where('tax_class_title', 'LIKE', '%' . $param . '%')->paginate(40);
                break;

            case 'Description':

                $tax_class = Tax_class::sortable()->where('tax_class_description', 'LIKE', '%' . $param . '%')->paginate(40);

                break;

            default:

                $tax_class = Tax_class::sortable()->paginate(40);

                break;

        }

        $result['message'] = $message;
        $result['tax_class'] = $tax_class;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.taxclass", $title)->with('result', $result)->with('name', $name)->with('param', $param);

    }

    //listingTaxRates
    public function taxrates(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingTaxRates"));

        $result = array();
        $message = array();

        $tax_rates = Tax_rate::sortable()
            ->LeftJoin('zones', 'zones.zone_id', '=', 'tax_rates.tax_zone_id')
            ->LeftJoin('tax_class', 'tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
            ->select('tax_rates.tax_rates_id', 'tax_rates.tax_zone_id', 'tax_rates.tax_class_id', 'tax_rates.tax_priority', 'tax_rates.tax_rate', 'tax_description',
                'tax_rates.created_at', 'tax_rates.updated_at', 'zones.zone_id', 'zones.zone_country_id', 'zones.zone_code', 'zones.zone_name', 'tax_class.tax_class_title', 'tax_class.tax_class_description')
            ->paginate(20);

        $result['tax_rates'] = $tax_rates;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.taxrates", $title)->with('result', $result);
    }

    //addTaxRate
    public function addtaxrate(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddTaxClass"));

        $result = array();
        $message = array();

        $result['message'] = $message;

        $zones = $this->Tax_rate->getZone();
        $tax_class = $this->Tax_rate->gettaxclass();
        $result['zones'] = $zones;
        $result['tax_class'] = $tax_class;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.addtaxrate", $title)->with('result', $result);
    }

    //addNewTaxRate
    public function addnewtaxrate(Request $request)
    {

        $this->Tax_rate->insettaxrate($request);

        $message = Lang::get("labels.TaxRateAddededTax");
        return redirect()->back()->withErrors([$message]);
    }

    //editTaxRate
    public function edittaxrate(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditTaxRate"));
        $result = array();
        $result['message'] = array();

        $taxClass = $this->Tax_rate->edittaxclass($request);
        $result['taxClass'] = $taxClass;

        $zones = $this->Tax_rate->getZone();
        $tax_class = $this->Tax_rate->gettaxclass();
        $result['zones'] = $zones;
        $result['tax_class'] = $tax_class;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.edittaxrate", $title)->with('result', $result);
    }

    //updateTaxRate
    public function updatetaxrate(Request $request)
    {
        $this->Tax_rate->updatetaxrates($request);

        $message = Lang::get("labels.TaxRateUpdatedTax");
        return redirect()->back()->withErrors([$message]);
    }

    //deleteTaxRate
    public function deletetaxrate(Request $request)
    {
        $this->Tax_rate->deletetaxrate($request);
        return redirect()->back()->withErrors([Lang::get("labels.TaxRateDeletedTax")]);
    }

    public function taxratesfilters(Request $request)
    {

        $name = $request->FilterBy;
        $param = $request->parameter;

        $title = array('pageTitle' => Lang::get("labels.ListingTaxRates"));

        $result = array();
        $message = array();

        switch ($name) {
            case 'Zone':

                $tax_rates = Tax_rate::sortable()
                    ->LeftJoin('zones', 'zones.zone_id', '=', 'tax_rates.tax_zone_id')
                    ->LeftJoin('tax_class', 'tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
                    ->select('tax_rates.tax_rates_id', 'tax_rates.tax_zone_id', 'tax_rates.tax_class_id', 'tax_rates.tax_priority', 'tax_rates.tax_rate', 'tax_description',
                        'tax_rates.created_at', 'tax_rates.updated_at', 'zones.zone_id', 'zones.zone_country_id', 'zones.zone_code', 'zones.zone_name', 'tax_class.tax_class_title', 'tax_class.tax_class_description')
                    ->where('zones.zone_name', 'LIKE', '%' . $param . '%')
                    ->paginate(20);

                break;

            case 'TaxRates':

                $tax_rates = Tax_rate::sortable()
                    ->LeftJoin('zones', 'zones.zone_id', '=', 'tax_rates.tax_zone_id')
                    ->LeftJoin('tax_class', 'tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
                    ->select('tax_rates.tax_rates_id', 'tax_rates.tax_zone_id', 'tax_rates.tax_class_id', 'tax_rates.tax_priority', 'tax_rates.tax_rate', 'tax_description',
                        'tax_rates.created_at', 'tax_rates.updated_at', 'zones.zone_id', 'zones.zone_country_id', 'zones.zone_code', 'zones.zone_name', 'tax_class.tax_class_title', 'tax_class.tax_class_description')
                    ->where('tax_rates.tax_rate', 'LIKE', '%' . $param . '%')
                    ->paginate(20);

                break;
            case 'TaxClass':

                $tax_rates = Tax_rate::sortable()
                    ->LeftJoin('zones', 'zones.zone_id', '=', 'tax_rates.tax_zone_id')
                    ->LeftJoin('tax_class', 'tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
                    ->select('tax_rates.tax_rates_id', 'tax_rates.tax_zone_id', 'tax_rates.tax_class_id', 'tax_rates.tax_priority', 'tax_rates.tax_rate', 'tax_description',
                        'tax_rates.created_at', 'tax_rates.updated_at', 'zones.zone_id', 'zones.zone_country_id', 'zones.zone_code', 'zones.zone_name', 'tax_class.tax_class_title', 'tax_class.tax_class_description')
                    ->where('tax_class.tax_class_title', 'LIKE', '%' . $param . '%')
                    ->paginate(20);

                break;

            default:

                $tax_rates = Tax_rate::sortable()
                    ->LeftJoin('zones', 'zones.zone_id', '=', 'tax_rates.tax_zone_id')
                    ->LeftJoin('tax_class', 'tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
                    ->select('tax_rates.tax_rates_id', 'tax_rates.tax_zone_id', 'tax_rates.tax_class_id', 'tax_rates.tax_priority', 'tax_rates.tax_rate', 'tax_description',
                        'tax_rates.created_at', 'tax_rates.updated_at', 'zones.zone_id', 'zones.zone_country_id', 'zones.zone_code', 'zones.zone_name', 'tax_class.tax_class_title', 'tax_class.tax_class_description')
                    ->paginate(20);

                break;

        }

        $result['tax_rates'] = $tax_rates;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.taxrates", $title)->with('result', $result)->with('name', $name)->with('param', $param);

    }

}
