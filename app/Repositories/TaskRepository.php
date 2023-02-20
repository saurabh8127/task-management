<?php

namespace App\Repositories;

use App\Models\Board;
use App\Models\Task;

class TaskRepository
{

    public function addTask($data)
    {
        //this is for checking if user has made that task or not if not
        //we will return from here without performing further operations
        $has_user_created_task = $this->CheckCreatorOftask($data['board_id']);
        if ($has_user_created_task) {
            $task_data = Task::create($data);
            return $task_data;
        }

    }

    public function deleteTask($id)
    {
        $task_data = Task::where('id', $id)->delete();
        return $task_data;
    }

    public function show($id)
    {
        $task = Task::find($id);
        if ($task) {
            return $task;
        } else {
            return [];
        }
    }

    public function editTask($data, $id)
    {
        //checking user authorization for task
        $has_user_created_task = $this->CheckCreatorOftask($data['board_id']);

        $task_data = Task::where('id', $id)->first();

        if (!empty($task_data) && $has_user_created_task) {

            $task_data->task = $data['task'];
            $task_data->description = $data['description'];
            $task_data->board_id = $data['board_id'];
            $task_data->task_end_at = $data['task_end_at'];
            $task_data->task_start_at = $data['task_start_at'];

            $task_data->update();
            return $task_data;
        } else {
            return $task_data = [];
        }
    }

    //private function
    private function CheckCreatorOftask($board_id)
    {
        $board = Board::find($board_id);

        if ($board) {
            if (auth()->user()['id'] === $board->created_by) {
                return true;
            }
        }

        return false;
    }
}
