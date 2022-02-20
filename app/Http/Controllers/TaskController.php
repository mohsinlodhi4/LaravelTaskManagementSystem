<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('employer')->only(['create','store','destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks_users = TaskUser::with(['employee','task'])->where('employer_id',auth()->id())
            ->orWhere('employee_id',auth()->id())
            ->latest()
            ->paginate(10);
            // ->get();
        return view('task.viewTasks',['tasks_users'=>$tasks_users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create',[
            "employees"=>auth()->user()->employees
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "title"=>"required",
            "employee"=>"required",
            "description"=>"required"
        ]);

        $task = Task::create([
            "title"=>$request["title"],
            "description"=>$request["description"]
        ]);
        
        // Attaching employee and employer with task
        $task->employees()->attach($request['employee'],['employer_id'=>auth()->id()]);
        return back()->with('success','Task Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find(TaskUser::find($id)->task_id);
        return response()->json($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $task = Task::find($id);
        $task->update([
            'feedback'=> $request['feedback'],
            'status'=> $request['status'] ?? 0
        ]);

        return back()->with('success','Task Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::find($id)->delete();
        return back()->with('success','Task Deleted Successfully');
    }
}
