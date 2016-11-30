<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
//use Input;
use Validator;
//use Redirect;
use App\Slot;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

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
			$calendar_dates[$i]['date_value'] = date('Y-m-d', strtotime(str_replace('-', '/', $today) . "-" . $i . " days"));

			if ($calendar_dates[$i]['wk_day'] == date('D')) {
				$calendar_dates[$i]['status'] = TRUE;
			} else {
				$calendar_dates[$i]['status'] = FALSE;
			}
		}
		 
		 $today_slots = Slot::where('slots.slot_date', date("Y-m-d"))
		             ->where('slots.status','2')
				     ->join('status', 'slots.status', '=', 'status.id')
					 ->join('slots_trans', 'slots.id', '=', 'slots_trans.slot_id')
					 ->select('slots.*', 'slots_trans.comments', 'status.short_name')
           -> get();
          $today_slots=$today_slots->toArray();
           //dd($today_slots);die;
		
		return view('slots.view', compact('calendar_dates', $calendar_dates,'today_slots'));
	}

	/*
	 *   To save a new slot
	 */
	public function saveSlot(Request $request) {

		$start_time = trim($request->input('slot_from_time'));
		$end_time = trim($request->input('slot_to_time'));

		//12 hours format
		$start_time_12  = date("g:i a", strtotime($start_time));
		$end_time_12  = date("g:i a", strtotime($end_time));

		$slot_date = date('Y-m-d', strtotime(trim($request -> input('slot_date'))));
		$prior_status = $request->input('prior_status');

		$hid_slot_id=trim($request->input('hid_slot_id'));

        if($prior_status == "true"){

			$prior_status = TRUE;

		}else{
			 $prior_status=intval($prior_status);
		}
		$count_records = DB::table('slots as s')
				-> where('s.slot_date', $slot_date)
				-> where('s.status', 2)
				-> where(function($q) use ($start_time, $end_time) {
			$q -> where(function($query) use ($start_time, $end_time) {
				$query -> whereBetween('s.slot_fromtime', array($start_time, $end_time)) -> orWhereBetween('s.slot_totime', array($start_time, $end_time));
			}) -> orWhere(function($query) use ($start_time, $end_time) {
				$query -> where('s.slot_fromtime', '<=', $start_time) -> where('s.slot_totime', '>=', $end_time);
			});
		}) -> count();
		if ($count_records >= 1) {
			$arr['status'] = false;
		} else {
			$interval = strtotime($end_time) - strtotime($start_time);
			$abs_time_interval = (abs($interval) / 3600) * 60;
			if ($interval <= 0 || $abs_time_interval > 450) {
				$arr['status'] = false;
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

				if(empty($hid_slot_id)){
				$slot_id = DB::table('slots')->insertGetId($booking_data);
			    }
			    else
			    {
			    	DB::table('slots')
		            ->where('id', $hid_slot_id)
		            ->update($booking_data);
			    	$slot_id=$hid_slot_id;
			    }
				$trans_data = array("slot_id" => $slot_id, "created_by" => Auth::user() -> id, "status" => 1);
				DB::table('slots_trans') -> insert(array($trans_data));
				$arr['status'] = TRUE;
			}
			$arr['start_time'] = $start_time_12;
			$arr['end_time'] = $end_time_12;
			$arr['duration'] = $abs_time_interval;
			$arr['department'] = Auth::user()->department;
			$arr['slot_date'] = $request -> input('slot_date');
			$arr['prior_status'] = $prior_status;
		}
		return Response::json($arr);
	}

/*
	 *   To show a list of slots
	 */
	public function showSlotList() {
		if (Auth::user() -> role_id == 1) {
         $slots = Slot::all();
		} else if (Auth::user() -> role_id == 0) {
          $slots = Slot::where('slots.created_by', Auth::user() -> id)
				   ->where('slots.status','!=','7')
					 ->join('status', 'slots.status', '=', 'status.id')
					 ->join('slots_trans', 'slots.id', '=', 'slots_trans.slot_id')
					 ->select('slots.*', 'slots_trans.comments', 'status.short_name')
           -> get();
           $slots=$slots->toArray();
           //dd($slots);die;
				}
return view('slots.list', compact('slots'));
}
/*
 *   To destroy a list of slots
 */
			public function destroy($id) {
		    $id=base64_decode(urldecode($id));		
            $slot = Slot::find($id);
		    $slot->status = '7';
		    $slot->save();
		    return Redirect::to('/slot/list');

			}
			/*
			 *   To edit a slot
			 */
			public function edit($id)
	    {

	    	$id=base64_decode(urldecode($id));
		    $slot = Slot::find($id);
	        return view('slots.new')->with('slotToUpdate', $slot);
	    }
			/*
			 *   To repeat a slot
			 */
			public function repeat($id)
	    {
	    	$id=base64_decode(urldecode($id));
		    $slot = Slot::find($id);
	        return view('slots.new')->with('slotToUpdate', $slot);
	    }

	    public function fetch(Request $request){
        $slot_date = $request->input('slot_date');

        $today_slots = Slot::where('slots.slot_date', $slot_date)
		             ->where('slots.status','2')
				     ->join('status', 'slots.status', '=', 'status.id')
					 ->join('slots_trans', 'slots.id', '=', 'slots_trans.slot_id')
					 ->select('slots.*', 'slots_trans.comments', 'status.short_name')
           -> get();
          //$today_slots=$today_slots->toArray();
          $today_slots=json_encode($today_slots);
          $today_slots['slot_fromtime'] = strtoupper(date("g:i a", strtotime($today_slots['slot_fromtime'])));
          $today_slots['slot_totime'] = strtoupper(date("g:i a", strtotime($today_slots['slot_totime'])));
          return Response::json($today_slots);

	    }

}
