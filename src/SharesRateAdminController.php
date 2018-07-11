<?php

namespace Selfreliance\SharesRateAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Shares;
use Carbon\Carbon;
use App\Models\Shares\Share;
use ConvertingCourses;
class SharesRateAdminController extends Controller
{
	public function index(){
		$shares = Shares::getSharesListSingle();
		// $available_at = Carbon::now()->format('Y-m-d H:i:s');
		return view('sharesrateadmin::chose_shares')->with(compact('shares'));
	}

	public function rate_info(Request $request, Share $share_model){
		$share = Shares::getSharesListSingle()->where('id', $request->input('share_id'))->first();
		$share->full_rate = Shares::get_shares_rate($share);
		Carbon::setLocale('ru');
		$available_at = Carbon::now();
		$share->rate->price_in_dollar = ConvertingCourses::convert_amount($share->rate->price_per_share, $share->couple->currency, "USD");
		return view('sharesrateadmin::fill_rate')->with(compact('share', 'available_at'));
	}

	public function change_values(Request $request){
		if($request->input('type') == 'date'){
			$parse = Carbon::parse($request->input('value'));
			$res = Shares::update_rate($request->input('id'), 'available_at', $parse);
		}
		if($request->input('type') == 'rate'){
			$res = Shares::update_rate($request->input('id'), 'price_per_share', $request->input('value'));
		}
		$data = [
            "success"          => true,
        ];
        return response()->json($data, "200");
	}

	public function store(Request $request){
		$share = Shares::getSharesListSingle()->where('id', $request->input('share_id'))->first();
		foreach($request->input('available_at') as $key=>$value){
			$pm = $request['plus_minus'][$key];
			$percent = $request['percent'][$key];
			if($pm != '0' && $percent != '0'){
				$parse = Carbon::parse($value);
				$now_date = Carbon::now();
				if($now_date > $parse){
					\Session::flash('error', 'Нельзя добавлять курс для прошлого');
        			return redirect()->back();
					break;
				}
				if($pm == 'plus'){
					$new_price = number(($share->rate->price_per_share+($share->rate->price_per_share*$percent/100)),8);
				}elseif($pm == 'minus'){
					$new_price = number(($share->rate->price_per_share-($share->rate->price_per_share*$percent/100)),8);
				}
				Shares::new_rate([
					'share_id'        => $share->id,
					'price_per_share' => $new_price,
					'available_at'    => $parse,
				]);
			}
		}
        \Session::flash('success', 'Новый курс успешно добавлен');
        return redirect()->back();
	}

	public function destroy($id){
		Shares::destory_rate($id);
		\Session::flash('success', 'Курс валют успешно удален');
        return redirect()->back();
	}
}