<?php

namespace App\Http\Controllers\Api\TaskPoint;

use App\Models\TaskAssign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskPointController extends Controller
{
    //create task point
    public function create(Request $request){
		//validate value
		$validated = Validator::make($request->all(),[
			'task_id'		=> 'required|integer',
			'sub_task' 		=> 'required|string',
			'created_by' 	=> 'required|integer',
		]);
		if($validated->fails()){
			return response()->json(array(
				'data' => array(),
				'status' => false,
				'message' => array('Enter valid data.')
			), 400);
		}else{
			
			$data = [
				'task_id'		=> $request->task_id,
				'sub_task' 		=> $request->sub_task,
				'created_by'	=> $request->created_by,
			];
			//create point
			$task_point_data = TaskAssign::create($data);
			return response()->json(array(
				'data' => $task_point_data,
				'status' => true,
				'message' => array('Task added successfully.')
			), 200);
		}
	}

	//delete point
	public function delete(Request $request){

		$validated = Validator::make($request->all(),[
			'task_point_id' => 'required|integer',
		]);
		if($validated->fails()){
			return response()->json(array(
				'data' => array(),
				'status' => false,
				'message' => array('Task data not found. ')
			), 400);
		}else{
			$task_data = TaskAssign::where('id',$request->task_point_id)->delete();
			return response()->json(array(
				'data' => " ",
				'status' => true,
				'message' => array('Data deleted successfully.')
			), 200);
		}
	}

	//edit point
	public function edit(Request $request){
		$validated = Validator::make($request->all(),[
			'task_point_id' => 'required|integer',
			'task_id' 		=> 'required|integer',
			'task' 			=> 'required|string',
			'created_by' 	=> 'required|integer',
		]);
		
		if($validated->fails()){
			return response()->json(array(
				'data'=> '',
				'status'=> false,
				'massage'=> array('Enter valid value')
			),400);
		}else{
			$task_point_data = TaskAssign::where('id', $request->task_point_id)->first();
			if(!empty($task_point_data)){
				$task_point_data->task_id 		= $request->task_id ;
				$task_point_data->task_point 	= $request->task_point ;
				$task_point_data->created_by 	= $request->created_by ;

				$task_point_data->update();
				return response()->json(array(
					'data' => $task_point_data,
					'status' => true,
					'message' => array('Data update successfully.')
				), 200);
			}else{
				return response()->json(array(
					'data'=> '',
					'status'=> false,
					'massage'=> array('Task data not found')
				),404);
			}
		}
	}
}
