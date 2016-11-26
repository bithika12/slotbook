<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use Input;
use Validator;
use Redirect;

class SlotController extends Controller
{

    /*
    *   To display Slot Creation Form
    */
    public function index(){
        
    	return view('slots.new');
    }

    /*
    *   To display List of Slots
    */
    public function viewSlot(){
    	
    	return view('slots.view');
    }

    /*
    *   To save a new slot
    */
    public function saveSlot(Request $request){

        $title = trim($request->input('title'));
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
            DB::table('tasks')->insert(array($task_data));
            return Redirect::to('task/view')->with('success','Task Created Successfully');
        }

    }


    /*
    *   To show a list of slots
    */
    public function showSlotList(){

        return view('slots.list');
    }
}
