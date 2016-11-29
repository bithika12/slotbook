<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use Input;
use Validator;
use Redirect;
use Response;

class SlotController extends Controller {

	/*
	 *   To display Slot Creation Form
	 */
	public function index() {

		return view('slots.new');
	}

	/*
	 *   To display List of Slots
	 */
	public function viewSlot() {

		$calendar_dates = array();
		for ($i = 2; $i >= -2; $i--) {
			$today = date('D jS F Y');
			$previous_day = date('l jS F Y', strtotime(str_replace('-', '/', $today) . "-" . $i . " days"));
			$calendar_dates[$i]['wk_day'] = date('D', strtotime($previous_day));
			$calendar_dates[$i]['day'] = date('F j, Y', strtotime($previous_day));
			$calendar_dates[$i]['date_value'] = date('Y-m-d', strtotime(str_replace('-', '/', $today) . "+" . $i . " days"));

			if ($calendar_dates[$i]['wk_day'] == date('D')) {
				$calendar_dates[$i]['status'] = TRUE;
			} else {
				$calendar_dates[$i]['status'] = FALSE;
			}
		}
		return view('slots.view', compact('calendar_dates', $calendar_dates));
	}

	/*
	 *   To save a new slot
	 */
	public function saveSlot(Request $request) {

		$start_time = trim($request->input('slot_from_time'));
		$end_time = trim($request->input('slot_to_time'));
		$slot_date = date('Y-m-d', strtotime(trim($request -> input('slot_date'))));
		$prior_status = $request->input('prior_status');
		if($prior_status == "on"){
			$prior_status = TRUE;
		}else{
			$prior_status = FALSE;
		}
		$count_records = DB::table('slots as s') -> where('s.slot_date', $slot_date) -> where('s.status', 2) -> where(function($q) use ($start_time, $end_time) {
			$q -> where(function($query) use ($start_time, $end_time) {
				$query -> whereBetween('s.slot_fromtime', array($start_time, $end_time)) -> orWhereBetween('s.slot_totime', array($start_time, $end_time));
			}) -> orWhere(function($query) use ($start_time, $end_time) {
				$query -> where('s.slot_fromtime', '<=', $start_time) -> where('s.slot_totime', '>=', $end_time);
			});
		}) -> count();
		if ($count_records >= 1) {
			$flag = false;
		} else {
			$interval = strtotime($end_time) - strtotime($start_time);
			$abs_time_interval = (abs($interval) / 3600) * 60;
			if ($interval <= 0 || $abs_time_interval > 450) {
				$flag = false;
			} else {
				$booking_data = array(
								"slot_date" => $slot_date,
								"no_of_joinee" => trim($request -> input('no_of_joinee')), 
								"slot_fromtime" => $start_time, 
								"slot_totime" => $end_time, 
								"slot_duration" => $abs_time_interval, 
								"slot_desc" => $request -> input('description'), 
								"prior_status" => $prior_status, 
								"created_by" => Auth::user()->id
				);
				$slot_id = DB::table('slots')->insertGetId($booking_data);
				$trans_data = array("slot_id" => $slot_id, "created_by" => Auth::user() -> id, "status" => 1);
				DB::table('slots_trans') -> insert(array($trans_data));
				$flag = TRUE;
			}
		}
		return Response::json($flag);
	}

	/*
	 *   To show a list of slots
	 */
	public function showSlotList() {

		return view('slots.list');
	}

}
