<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
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
    //Create task
    public function create(Request $request)
    {
        $data = $request->all();
        //validate value
        $validated = Validator::make($request->all(), [
            'task' => 'required|string',
            'task_start_at' => 'date',
            'task_end_at' => 'date',
            'description' => 'required|string',
            'board_id' => 'required|integer',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'data' => '',
                'status' => false,
                'message' => 'Enter valid data.',
            ], 400);
        }

        //Create Task Repository
        $task_data = $this->task->addTask($data);

        if (!empty($task_data)) {
            return response()->json([
                'data' => $task_data,
                'status' => true,
                'message' => 'Task added successfully.',
            ], 200);
        } else {
            return response()->json([
                'data' => '',
                'status' => true,
                'message' => 'Data not added..',
            ], 200);
        }

    }

    //Delete task
    public function delete(Request $request, $id)
    {
        //Delete Task Repository
        $this->task->deleteTask($id);

        return response()->json([
            'data' => '',
            'status' => true,
            'message' => 'Data deleted successfully.',
        ], 200);
    }
    public function show($id)
    {
        $task_data = $this->task->show($id);
        return response()->json([
            'data' => $task_data,
            'status' => true,
            'massage' => 'Data found',
        ], 200);
    }

    //Edit task
    public function edit(Request $request, $id)
    {
        $data = $request->all();
        $validated = Validator::make($request->all(), [
            'task' => 'required|string',
            'task_start_at' => 'date',
            'task_end_at' => 'date',
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
            //Edit Task Repository
            $task_data = $this->task->editTask($data, $id);

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
