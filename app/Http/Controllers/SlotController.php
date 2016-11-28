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

        /*$title = trim($request->input('title'));
        $desc = trim($request->input('desc'));

    	$file = array('file' => Input::file('file'));
        $file_size = filesize(Input::file('file'));

        $task_data = array(
            "title"=>$title,
            "description"=>$desc,
            "data"=>$file,
            "created_by"=> Auth::user()->id,
            "updated_at"=> strtotime(date("Y-m-d H:i:s")),
        );
        if (!is_null($file)) {
            if($size > 2097152){
                return Redirect::to('task/new')->with('danger','Uploaded file size exceeds');
            }
        }
        else{
            DB::table('booking')->insert(array($task_data));
            return Redirect::to('task/view')->with('success','Task Created Successfully');
        }*/
        $slot_date = trim($request->input('slot_date'));
        $approx_joinee = trim($request->input('approx_joinee'));
        $slot_from_time =  trim($request->input('slot_from_time'));
        $slot_to_time =  trim($request->input('slot_to_time'));
        $desc =  trim($request->input('desc'));

        $booking_data = array(
            "slot_date"=>'2016-11-27',
            "no_of_joinee"=>$approx_joinee,
            "slot_fromtime"=>'10:42:00',
            "slot_totime"=>'11:42:00',
            "booking_desc"=>$desc,
            "user_id"=> Auth::user()->id,
            //"updated_at"=> strtotime(date("Y-m-d H:i:s")),
        );
        DB::table('booking')->insert(array($booking_data));
        return Redirect::to('slot/view')->with('success','Slot Booked Successfully');
    }

	/*
	 *   To show a list of slots
	 */
	public function showSlotList() {

		return view('slots.list');
	}

}
