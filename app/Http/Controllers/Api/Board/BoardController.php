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
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'data' => '',
                'status' => false,
                'message' => 'Eter valid data.',
            ], 400);
        } else {

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'member' => $request->member,
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
    }

    //Delete board
    public function delete(Request $request)
    {
        $data = $request->all();
        $validated = Validator::make($request->all(), [
            'board_id' => 'required|integer',
        ]);
        if ($validated->fails()) {
            return response()->json([
                'data' => '',
                'status' => false,
                'message' => 'Task data not found. ',
            ], 400);
        } else {
            //Delete Board Repository
            $this->board->deleteBoard($data);
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
        $user = Auth::guard('api')->user();

        $validated = Validator::make($request->all(), [
            'board_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'data' => '',
                'status' => false,
                'massage' => 'Enter valid value',
            ], 400);
        }

        // if user has not created board
        if (!$this->board->checkUserHasBoard($request->board_id)) {
            return response()->json([
                'status' => false,
                'message' => 'Data Not Found OR Unauthorized Access!',
            ], 401);

        }

        $data = [
            'board_id' => $request->board_id,
            'name' => $request->name,
            'description' => $request->description,
            'member' => $request->member,
            'created_by' => $user->id,
        ];

        //Edit Board Repository
        $board_data = $this->board->editBoard($data);

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
