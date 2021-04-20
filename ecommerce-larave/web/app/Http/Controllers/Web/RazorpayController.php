<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lang;
use App\Models\Web\Index;
use Session;



class RazorpayController  extends Controller
{
	public function __construct(Index $index)
	{
		$this->index = $index;

	}
		public function pay() {
			$title = array('pageTitle' => Lang::get("website.Home"));
			$this->theme = new ThemeController();
			$final_theme = $this->theme->theme();
			$result['commonContent'] = $this->index->commonContent();

			return view('web.pay',['title' => $title,'final_theme' => $final_theme])->with('result', $result);
	}

	public function dopayment(Request $request) {
			//Input items of form
			$input = $request->all();

			// Please check browser console.

	}

}
