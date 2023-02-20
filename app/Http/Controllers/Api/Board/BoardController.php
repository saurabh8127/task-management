<?php

namespace App\Http\Controllers\Api\Board;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Repositories\BoardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    protected $board;
    public function __construct(BoardRepository $board)
    {
        $this->board = $board;
    }

    //get data
    public function getData(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!empty($user)) {
            $board_data = Board::where('created_by', $user->id)->get();
            return response()->json([
                'data' => $board_data,
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
    //Create board
    public function create(Request $request)
    {

        $user = Auth::guard('api')->user();
        //validate value
        $validated = Validator::make($request->all(), [
            'board_name' => 'required|string',
            'description' => 'required|string',
            'board_start_at' => 'date',
            'board_end_at' => 'date',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'data' => $validated->errors()->all(),
                'status' => false,
                'message' => 'Eter valid data.',
            ], 400);
        }

        $data = [
            'board_name' => $request->board_name,
            'description' => $request->description,
            'board_end_at' => $request->board_end_at,
            'board_start_at' => $request->board_start_at,
            'created_by' => $user->id,
        ];
        //Create Board Repository
        $board_data = $this->board->addBoard($data);

        return response()->json([
            'data' => $board_data,
            'status' => true,
            'message' => 'Task added successfully.',
        ], 200);
    }

    //Delete board
    public function delete(Request $request, $id)
    {
        //Delete Board Repository
        $response = $this->board->deleteBoard($id);
        return response()->json([
            'status' => $response,
            'message' => 'Data deleted.',
        ], 200);
    }

    public function show($id)
    {
        $board_data = $this->board->show($id);
        return $board_data;
    }

    //edit task
    public function edit(Request $request, $id)
    {
        $user = Auth::guard('api')->user();

        $validated = Validator::make($request->all(), [
            'board_name' => 'required|string',
            'description' => 'required|string',
            'board_start_at' => 'date',
            'board_end_at' => 'date',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'data' => $validated->errors()->all(),
                'status' => false,
                'massage' => 'Enter valid value',
            ], 400);
        }

        // if user has not created board
        if (!$this->board->checkUserHasBoard($id)) {
            return response()->json([
                'status' => false,
                'message' => 'Data Not Found OR Unauthorized Access!',
            ], 401);

        }

        $data = [
            'board_name' => $request->board_name,
            'description' => $request->description,
            'board_end_at' => $request->board_end_at,
            'board_start_at' => $request->board_start_at,
            'created_by' => $user->id,
        ];
        //Edit Board Repository
        $board_data = $this->board->editBoard($data, $id);

        if (!empty($board_data)) {
            return response()->json([
                'data' => $board_data,
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
