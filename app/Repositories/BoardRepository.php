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

    public function deleteBoard($data)
    {
        $board_data = Board::where('id', $data['board_id'])->delete();
        return $board_data;
    }

    public function editBoard($data)
    {
        $board_data = Board::where('id', $data['board_id'])->first();
        if (!empty($board_data)) {

            $board_data->name = $data['name'];
            $board_data->description = $data['description'];
            $board_data->member = $data['member'];
            $board_data->created_by = $data['created_by'];

            $board_data->update();
            return $board_data;
        } else {
            return $board_data = [];
        }

    }

    public function checkUserHasBoard(int $boardId)
    {
        return Board::where([
            'created_by' => auth()->user()->id,
            'id' => $boardId,
        ])->first();
    }
}
