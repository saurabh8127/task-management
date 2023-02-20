<?php

namespace App\Repositories;

use App\Models\Board;

class BoardRepository
{
    public function addBoard($data)
    {
        $board_data = Board::create($data);

        return $board_data;
    }

    public function show($id)
    {
        //get board with task(using reletion)
        $board = Board::find($id)->with('tasks')->get()->toArray()[0];
        if ($board) {
            return $board;
        } else {
            return [];
        }
    }

    public function deleteBoard($id)
    {
        $board = Board::findOrFail($id);
        if (!$board) {
            return false;
        }
        $board->delete();
        return true;

    }

    public function editBoard($data, $id)
    {
        $board_data = Board::where('id', $id)->first();
        if (!empty($board_data)) {

            $board_data->board_name = $data['board_name'];
            $board_data->description = $data['description'];
            $board_data->board_end_at = $data['board_end_at'];
            $board_data->board_start_at = $data['board_start_at'];
            $board_data->created_by = $data['created_by'];

            $board_data->update();
            return $board_data;
        } else {
            return $board_data = [];
        }

    }

    //check User Has Board
    public function checkUserHasBoard(int $boardId)
    {
        return Board::where([
            'created_by' => auth()->user()->id,
            'id' => $boardId,
        ])->first();
    }
}
