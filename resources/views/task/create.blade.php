@extends('app')

@section('content')
<div class="bg-white p-3">
    <!-- For Task Creation Success Message -->
    @if(session('success'))
    <div class="alert alert-success">
        <strong>{{session('success')}}</strong>
    </div>
    @endif
    
    <!-- For Task Creation Error Messages -->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $e)
            <li>
                <strong>{{$e}}</strong>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="my-2" style="border-bottom:1px solid black;">
        <h4>Create Task</h4>
    </div>
    <form method="post" action="/task">
        @csrf
    <div style="max-width:500px" class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Select Employee</label>
        </div>
        <select name="employee" class="custom-select" id="inputGroupSelect01">
            <option value="">Select</option>
            @foreach($employees as $e)
            <option value="{{$e->id}}">{{$e->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label >Title</label>
        <input placeholder="Task Title" class="form-control" name="title" value="{{old('title')}}">
    </div>
    <div class="form-group">
        <label >Description</label>
        <textarea placeholder="Task Description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>
    <div style="
        width:60%;margin:auto
    ">
        <button type="submit" class="btn btn-secondary btn-block" style="font-weight:700">
            Create Task
        </button>
    </div>
    </form>
</div>
@endsection