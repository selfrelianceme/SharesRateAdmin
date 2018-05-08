<?php

namespace Selfreliance\SharesRateAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shares;
use Carbon\Carbon;
class SharesRateAdminController extends Controller
{
	public function index(){
		$shares = Shares::getSharesListSingle();
		$available_at = Carbon::now()->format('Y-m-d H:i:s');
		return view('sharesrateadmin::create')->with(compact('shares', 'available_at'));
	}

	public function store(Request $request){
		$this->validate($request, [
            'share_id' => 'required',
            'price_per_share' => 'required',
            'available_at' => 'date'
        ]);

        Shares::new_rate($request->all());
        \Session::flash('success', 'Новый курс успешно добавлен');
        return redirect()->back();
	}
}