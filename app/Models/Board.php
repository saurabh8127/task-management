<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'member', 'number_of_task_allowed', 'created_by'];

    public $timestamps = [
        'created_at' => 'CURRENT_TIMESTAMP',
        'updated_at' => 'CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
    ];
}
