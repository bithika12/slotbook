<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use Input;
use Validator;
use Redirect;
use App\Slot;

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

            if($calendar_dates[$i]['wk_day'] == date('D')){
                $calendar_dates[$i]['status'] = TRUE;
            }
            else{
                $calendar_dates[$i]['status'] = FALSE;
            }
		}
		return view('slots.view',compact('calendar_dates',$calendar_dates));
	}

	/*
    *   To save a new slot
    */
    public function saveSlot(Request $request){
        $slot_date = trim($request->input('slot_date'));
        $slot_datemod=date('Y-m-d', strtotime($slot_date));
        $no_of_joinee = trim($request->input('no_of_joinee'));
        $slot_from_time =  trim($request->input('slot_from_time'));
        $slot_to_time =  trim($request->input('slot_to_time'));
        $desc =  trim($request->input('desc'));
				$slot_prior=trim($request->input('slot_prior'));

         $booking_data = array(
            "slot_date"=> $slot_datemod,
            "no_of_joinee"=> $no_of_joinee,
            "slot_fromtime"=> $slot_from_time,
            "slot_totime"=> $slot_to_time,
            "booking_desc"=>$desc,
						"prior_status"=>$slot_prior,
            "created_by"=> Auth::user()->id,

        );
        //DB::table('slots')->insert(array($booking_data));

	   $slot_id = DB::table('slots')->insertGetId($booking_data);

	     $trans_data = array(
            "slot_id"=> $slot_id,
            "created_by"=> Auth::user()->id,
            "status"=> 1
         );
        DB::table('slots_trans')->insert(array($trans_data));
        //return Redirect::to('slot/view')->with('success','Slot Booked Successfully');
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
				}
return view('slots.list', compact('slots'));
}
/*
 *   To destroy a list of slots
 */
			public function destroy($id) {
				$slot = Slot::find(Input::get('id'));
				if ($slot) {
					$slot -> delete();
					return Redirect::to('/slot');
				}
			}


}
