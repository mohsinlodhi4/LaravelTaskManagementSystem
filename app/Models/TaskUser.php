<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskUser extends Pivot
{
    use HasFactory;

    public $table = "task_users";

    public function employer(){
        return $this->belongsTo(User::class,'employer_id');
    }

    public function task(){
        return $this->belongsTo(Task::class,'task_id');
    }

    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }

}
