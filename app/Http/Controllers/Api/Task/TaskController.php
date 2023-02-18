<?php

namespace App\Http\Controllers\Api\Task;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
	//create task
    public function create(Request $request){
		//validate value
		$validated = Validator::make($request->all(),[
			'task' 			=> 'required|string',
			'created_by' 	=> 'required|integer',
		]);
		if($validated->fails()){
			return response()->json(array(
				'data' => array(),
				'status' => false,
				'message' => array('Enter valid data.')
			), 400);
		}else{
			//create task
			$data = [
				'task' 			=> $request->task,
				'created_by'	=> $request->created_by,
			];
			$task_data = Task::create($data);
			return response()->json(array(
				'data' => $task_data,
				'status' => true,
				'message' => array('Task added successfully.')
			), 200);
		}
	}

	//delete task
	public function delete(Request $request){

		$validated = Validator::make($request->all(),[
			'task_id' => 'required|integer',
		]);
		if($validated->fails()){
			return response()->json(array(
				'data' => array(),
				'status' => false,
				'message' => array('Task data not found. ')
			), 400);
		}else{
			$task_data = Task::where('id',$request->task_id)->delete();
			return response()->json(array(
				'data' => " ",
				'status' => true,
				'message' => array('Data deleted successfully.')
			), 200);
		}
	}

	//edit task
	public function edit(Request $request){
		$validated = Validator::make($request->all(),[
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
			$task_data = Task::where('id', $request->task_id)->first();
			if(!empty($task_data)){
				$task_data->task 		= $request->task ;
				$task_data->created_by 	= $request->created_by ;

				$task_data->update();
				return response()->json(array(
					'data' => $task_data,
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
