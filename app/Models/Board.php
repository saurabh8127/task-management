<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;
    protected $fillable = ['board_name', 'description', 'board_start_at', 'board_end_at', 'board_final_date', 'number_of_task_allowed', 'created_by'];

    public $timestamps = [
        'created_at' => 'CURRENT_TIMESTAMP',
        'updated_at' => 'CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
    ];

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }
}
