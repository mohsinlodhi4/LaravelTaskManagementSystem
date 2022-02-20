<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        'description',
        'status',
        'feedback'
    ];

    public function status(): Attribute
    {
        return new Attribute(
            fn ($value) => $value==1?'Completed':'Pending'
        );
    }
    public function createdAt(): Attribute
    {
        return new Attribute(
            fn ($value) => date( 'Y-m-d H:i:sa',strtotime($value))
        );
    }
    public function updatedAt(): Attribute
    {
        return new Attribute(
            fn ($value) => date( 'Y-m-d H:i:sa',strtotime($value))
        );
    }




    // public function employee(){
    //     return $this->belognsTo(User::class,'employee_id');
    // }

    // public function employer(){
    //     return $this->belognsTo(User::class,'employer_id');
    // }

    // Created Many to many relation for future extension. In case we want multiple employees to work on single task 
    public function employees(){
        return $this->belongsToMany(User::class, 'task_users', 'task_id', 'employee_id')
        ->withTimestamps()
        ->using(TaskUser::class);
    }
}
