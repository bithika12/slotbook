<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
//use Input;
use Validator;
//use Redirect;
use App\Slot;
use App\User;
use Response;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Pagination\Paginator;

class SlotController extends Controller {

	/*
	 *   To display Slot Creation Form
	*/
	public function index() {

        $slot_action=0;
		return view('slots.new')->with('slotAction', $slot_action);
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
		             ->join('users', 'slots.created_by', 'users.id')
					 ->orderBy('slots.slot_fromtime', 'asc')
				     ->select(DB::raw('DATE_FORMAT(`slots`.`slot_fromtime`, "%h : %i %p") as slot_fromtime'),DB::raw('DATE_FORMAT(`slots`.`slot_totime`, "%h : %i %p") as slot_totime'),'slots.slot_duration','slots.prior_status','slots.status','slots.id','users.department')
          -> get();
          $today_slots=$today_slots->toArray();
          return view('slots.view', compact('calendar_dates', $calendar_dates,'today_slots'));
	}

	/*
	 *   To save a new slot
	 */
	public function saveSlot(Request $request) {
		$start_time = trim($request->input('slot_from_time'));
		$end_time = trim($request->input('slot_to_time'));
		$slot_action=trim($request->input('slot_action'));
		if(strtotime($end_time) <= time()+300 || strtotime($start_time) <= time()+300 ){
			$arr['slot_time'] = false;
		}
		else{
			//12 hours format
			$start_time_12  = date("g : i a", strtotime($start_time));
			$end_time_12  = date("g : i a", strtotime($end_time));
			$slot_date = date('Y-m-d', strtotime(trim($request -> input('slot_date'))));
			$prior_status = $request->input('prior_status');

			$hid_slot_id=trim($request->input('hid_slot_id'));
			$slot_action=trim($request->input('slot_action'));
			$created_by=Auth::user() -> id;
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
				$arr['slot_status'] = false;
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

					if($slot_action==0 || $slot_action==2){
					$slot_id = DB::table('slots')->insertGetId($booking_data);
				    }
					elseif($slot_action==1)
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
				$json_date=date("jS F", strtotime($request -> input('slot_date')));
				$slotencode_id=base64_encode(urlencode($slot_id));

				$arr['start_time'] = $start_time_12;
				$arr['end_time'] = $end_time_12;
				$arr['duration'] = $abs_time_interval;
				$arr['department'] = Auth::user()->department;
				$arr['slot_date'] = $json_date;
				$arr['prior_status'] = $prior_status;
				$arr['auth_user_id'] = Auth::user() -> id;
				$arr['auth_user_role'] = Auth::user() -> role;
				$arr['slot_desc'] = $request -> input('description');
				$arr['created_by']   =$created_by;
				$arr['encodeslot_id']   =$slotencode_id;
				$arr['slot_id']   =$slot_id;
				}
			}
		return Response::json($arr);
	}

	/*
	*   To show a list of slots
	*/
	public function showSlotList(Request $request) {
	  	$currentdate = date('Y-m-d');
	  	$currenttime = date("H:i:s");

	  $users = DB::table('users')->select( DB::raw('DISTINCT(department)') )->groupBy('department')->get();
	  if($request->input('btn_sub')){
       $slot_date = date('Y-m-d', strtotime(trim($request -> input('slot_date'))));
			 $slot_date_frm=$request -> input('slot_date');
			 $prior_status=$request -> input('prior_status');
			 $slot_status = $request->input('slot_status');

      if ($request->input('department') != '') {
			 $department=$request->input('department');
			 }
		 else{
              $department='';
              }
						if(filter_var($prior_status, FILTER_VALIDATE_BOOLEAN)){
								$prior_status = TRUE;
						}
						else{
							 $prior_status=intval($prior_status);
						}
						if($department!='' && $slot_status!=''){
                        $matchThese = ['slot_date' => $slot_date, 'department' => $department,'prior_status' => $prior_status,'status' => $slot_status];
						}
						elseif($department=='' && $slot_status==''){
							$matchThese = ['slot_date' => $slot_date,'prior_status' => $prior_status];
						}
                        elseif($department!='' && $slot_status==''){
							$matchThese = ['slot_date' => $slot_date,'prior_status' => $prior_status, 'department' => $department];
						}
						elseif($department=='' && $slot_status!=''){
							$matchThese = ['slot_date' => $slot_date,'prior_status' => $prior_status,'status' => $slot_status];
						}

					 $fliter_slot = array(
					 'slot_date' => $slot_date_frm,
					 'department' => $department,
					 'prior_status' => $prior_status,
					 'slot_status' => $slot_status
					 );
               Session::push('filter_slot', $fliter_slot);
		       if (Auth::user() -> role == 1) {
									 $slots = Slot::where($matchThese)
									 ->join('status', 'slots.status', '=', 'status.id')
									 ->join('users', 'slots.created_by', '=', 'users.id')
									 ->select('slots.*', 'status.short_name','users.department')
									 ->orderBy('slots.slot_date', 'desc')
									 ->orderBy('slots.slot_fromtime', 'desc')
									 ->limit(5)
									 -> get();
		         }
	         else if (Auth::user() -> role == 0) {
	              $slots = Slot::where($matchThese)
	              ->where('slots.created_by',Auth::user() -> id)
	              ->join('status', 'slots.status', '=', 'status.id')
				        ->join('users', 'slots.created_by', '=', 'users.id')
				        ->select('slots.*', 'status.short_name','users.department')
				        ->orderBy('slots.slot_date', 'desc')
				        ->orderBy('slots.slot_fromtime', 'desc')
						->limit(5)
				        -> get();
	              }
              }
		else{
	        if (Auth::user() -> role == 1) {

				$slots = Slot::join('users', 'slots.created_by', '=', 'users.id')
			    ->join('status', 'slots.status', '=', 'status.id')
				->select('slots.*','status.short_name','users.department')
				->orderBy('slots.slot_date', 'desc')
				->orderBy('slots.slot_fromtime', 'desc')
				->limit(5)
	      ->get();

	            }
	       else if (Auth::user() -> role == 0) {
			    $slots = Slot::where('slots.created_by', Auth::user() -> id)
				->where('slots.status','!=','7')
				->join('status', 'slots.status', '=', 'status.id')
				->join('users', 'slots.created_by', '=', 'users.id')
				->select('slots.*', 'status.short_name','users.department')
				->orderBy('slots.slot_date', 'desc')
				->orderBy('slots.slot_fromtime', 'desc')
				->limit(5)
	      -> get();
	          }
	          $fliter_slot='';
          }
            $slots=$slots->toArray();
			return view('slots.list', compact('slots','users','fliter_slot'));

}

	/*
	 *   To destroy a list of slots
	*/
	public function cancel(Request $request) {
			$slot_id = trim($request->input('slot_id'));
			$slot_comment=trim($request->input('comment'));
			$slot = Slot::find($slot_id);
		    $slot->status = '4';
		    $slot->save();
			$trans_data = array("slot_id" => $slot_id, "created_by" => Auth::user() -> id, "status" => 4,'comments' =>$slot_comment);
			DB::table('slots_trans') -> insert(array($trans_data));
			
		}
			/*
			 *   To edit a slot
			 */
			public function edit($id){
	            $id=base64_decode(urldecode($id));
			    $slot = Slot::find($id);
			    $slot_action=1;
		        return view('slots.new')->with('slotToUpdate', $slot)->with('slotAction', $slot_action);
	    }
			/*
			 *   To repeat a slot
			 */
			public function repeat($id){
		    	$id=base64_decode(urldecode($id));
			    $slot = Slot::find($id);
				$slot_action=2;
		        return view('slots.new')->with('slotToUpdate', $slot)->with('slotAction', $slot_action);
	    }
	    /*
		*   Load datewise data through ajax
		*/
	    public function load(Request $request){
	        $slot_date = $request->input('slot_date');
	        $today_slots = Slot::where('slots.slot_date', $slot_date)
			             ->where('slots.status','2')
			             ->join('users', 'slots.created_by', 'users.id')
						 ->orderBy('slots.slot_fromtime', 'asc')
					     ->select(DB::raw('DATE_FORMAT(`slots`.`slot_fromtime`, "%h : %i %p") as slot_fromtime'),DB::raw('DATE_FORMAT(`slots`.`slot_totime`, "%h : %i %p") as slot_totime'),'slots.slot_duration','slots.prior_status','slots.status','slots.id','users.department')
	           -> get();
	        $today_slots=$today_slots->toArray();
	        $today_slots1=json_encode($today_slots);
        	return Response::json($today_slots1);
	    }

	 /*
	 *   To slot status approve update
	 */
	public function approve(Request $request) {

		$slot_id = trim($request->input('hid_slot_id'));
		$slot = Slot::find($slot_id);

		$start_time = $slot->slot_fromtime;
		$end_time = $slot->slot_totime;
		$created_by= $slot->created_by;
		$slot_desc = $slot->slot_desc;

		$auth_user_id= Auth::user() -> id;
		$auth_user_role= Auth::user() -> role;

		$slot_date=$slot->slot_date;

		//12 hours format
		$start_time_12  = strtoupper(date("g : i a", strtotime($start_time)));
		$end_time_12  = strtoupper(date("g : i a", strtotime($end_time)));

		$slot_date = $slot_date;
		$prior_status = $slot->prior_status;

		$hid_slot_id=trim($request->input('hid_slot_id'));
		$department=Auth::user() -> department;

			$interval = strtotime($end_time) - strtotime($start_time);
			$abs_time_interval = (abs($interval) / 3600) * 60;
			if ($interval <= 0 || $abs_time_interval > 450) {
				$arr['status'] = false;
			} else {
                    DB::table('slots')
				   ->where('id', $hid_slot_id)
				   ->update(['status' => 2,'updated_by' =>Auth::user()->id]);
		            /*
		            *slot trans table insert
		            */
		            $trans_data = array("slot_id" => $hid_slot_id, "created_by" => Auth::user() -> id, "status" => 2);
				 DB::table('slots_trans') -> insert(array($trans_data));

				$arr['status'] = TRUE;
			}
			
			$slotencode_id=base64_encode(urlencode($hid_slot_id));

			$arr['start_time']     = $start_time_12;
			$arr['end_time']       = $end_time_12;
			$arr['duration']       = $abs_time_interval;
			$arr['department']     = $department;
			$arr['slot_date']      = date("jS F",strtotime($slot_date));
			$arr['prior_status']   = $prior_status;
			$arr['slot_desc']      = $slot_desc;
			$arr['created_by']     =$created_by;
			$arr['status']         =2;
			$arr['auth_user_id']   = $auth_user_id;
			$arr['auth_user_role'] = $auth_user_role;
			$arr['encodeslot_id']  =$slotencode_id;
			$arr['slot_id']        =$hid_slot_id;

		return Response::json($arr);
	}

	/*
	* Ajax scroll fetch slot list
	*/

	public function fetchListSlot(Request $request){
		$limitCount = 5;
		$limitStart = $request->input('limitStart');
		if(isset($limitStart ) || !empty($limitStart)) {
	      if (Auth::user() -> role == 1) {
		$slots = Slot::join('users', 'slots.created_by', '=', 'users.id')
		         ->where('slots.status','!=','7')
			    ->join('status', 'slots.status', '=', 'status.id')
				->select(DB::raw('DATE_FORMAT(`slots`.`slot_fromtime`, "%h : %i %p") as slot_fromtime'),DB::raw('DATE_FORMAT(`slots`.`slot_totime`, "%h : %i %p") as slot_totime'),DB::raw('DATE_FORMAT(`slots`.`slot_date`, "%D %M") as slot_date'),
'slots.slot_duration','slots.prior_status','slots.status','slots.slot_desc','slots.id','users.department','slots.created_by')
				//->select('slots.*','status.short_name','users.department')
				->orderBy('slots.slot_date', 'desc')
				->orderBy('slots.slot_fromtime', 'desc')
				//->limit($limitCount,$limitStart)
				->skip($limitStart)->take($limitCount)
	      -> get();

		}
		     else if (Auth::user() -> role == 0) {
			    $slots = Slot::where('slots.created_by', Auth::user() -> id)
				->where('slots.status','!=','7')
				->join('status', 'slots.status', '=', 'status.id')
				->join('users', 'slots.created_by', '=', 'users.id')
				->select(DB::raw('DATE_FORMAT(`slots`.`slot_fromtime`, "%h : %i %p") as slot_fromtime'),DB::raw('DATE_FORMAT(`slots`.`slot_totime`, "%h : %i %p") as slot_totime'),DB::raw('DATE_FORMAT(`slots`.`slot_date`, "%D %M") as slot_date'),
'slots.slot_duration','slots.prior_status','slots.status','slots.slot_desc','slots.id','users.department','slots.created_by')
				//->select('slots.*', 'status.short_name','users.department')
				->orderBy('slots.slot_date', 'desc')
				->orderBy('slots.slot_fromtime', 'desc')
				->skip($limitStart)->take($limitCount)
	      -> get();
	          }
			  return Response::json($slots);
		}

	}

}
