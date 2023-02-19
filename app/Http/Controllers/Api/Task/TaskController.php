<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    protected $task;
    public function __construct(TaskRepository $task)
    {
        $this->task = $task;
    }

    public function getTask(Request $request)
    {
        $user = Auth::guard('api')->user();
        $task_data = Task::where('board_id', $request->board_id)->get();

        if (!count($task_data) == 0) {
            return response()->json([
                'data' => $task_data,
                'status' => true,
                'message' => 'Data get successfully.',
            ], 200);
        } else {
            return response()->json([
                'data' => '',
                'status' => true,
                'message' => 'Data not found.',
            ], 404);
        }
    }
    //create task
    public function create(Request $request)
    {

        $user = Auth::guard('api')->user();
        $data = $request->all();
        //validate value
        $validated = Validator::make($request->all(), [
            'task' => 'required|string',
            'description' => 'required|string',
            'board_id' => 'required|integer',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'data' => '',
                'status' => false,
                'message' => 'Enter valid data.',
            ], 400);
        } else {

            $task_data = $this->task->addTask($data);

            return response()->json([
                'data' => $task_data,
                'status' => true,
                'message' => 'Task added successfully.',
            ], 200);
        }
    }

    //delete task
    public function delete(Request $request)
    {
        $data = $request->all();
        $validated = Validator::make($request->all(), [
            'task_id' => 'required|integer',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'data' => array(),
                'status' => false,
                'message' => 'Task data not found. ',
            ], 400);
        } else {
            $this->task->deleteTask($data);
            return response()->json([
                'data' => '',
                'status' => true,
                'message' => 'Data deleted successfully.',
            ], 200);
        }
    }

    //edit task
    public function edit(Request $request)
    {
        $data = $request->all();
        $validated = Validator::make($request->all(), [
            'task_id' => 'required|integer',
            'task' => 'required|string',
            'description' => 'required|string',
            'board_id' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'data' => '',
                'status' => false,
                'massage' => 'Enter valid value',
            ], 400);
        } else {
            $task_data = $this->task->editTask($data);

            if (!empty($task_data)) {
                return response()->json([
                    'data' => $task_data,
                    'status' => true,
                    'message' => 'Data update successfully.',
                ], 200);
            } else {
                return response()->json([
                    'data' => '',
                    'status' => true,
                    'message' => 'Data not found.',
                ], 404);
            }
        }
    }

}
