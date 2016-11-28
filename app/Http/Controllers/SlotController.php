<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use Input;
use Validator;
use Redirect;

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

         $booking_data = array(
            "slot_date"=> $slot_datemod,
            "no_of_joinee"=> $no_of_joinee,
            "slot_fromtime"=> $slot_from_time,
            "slot_totime"=> $slot_to_time,
            "booking_desc"=>$desc,
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

		return view('slots.list');
	}

}
