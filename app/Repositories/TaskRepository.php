<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{

    public function addTask($data)
    {
        $task_data = Task::create($data);
        return $task_data;
    }
    public function deleteTask($data)
    {
        $task_data = Task::where('id', $data['task_id'])->delete();
        return $task_data;
    }

    public function editTask($data)
    {
        $task_data = Task::where('id', $data['task_id'])->first();

        if (!empty($task_data)) {

            $task_data->task = $data['task'];
            $task_data->description = $data['description'];
            $task_data->board_id = $data['board_id'];

            $task_data->update();
            return $task_data;
        } else {
            return $task_data = [];
        }
    }
}
