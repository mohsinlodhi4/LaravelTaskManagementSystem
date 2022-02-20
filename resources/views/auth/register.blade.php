@extends('app')

@section('content')

<!--  -->
<div class="container bg-white p-4" style="max-width:600px">
<div class="mb-2">
    <h3 class="text-center">Registration Page</h3>
</div>
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $e)
        <li>{{$e}}</li>
        @endforeach
    </ul>
</div>
@endif
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#employee" role="tab" aria-controls="home" aria-selected="true">Employee</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#employer" role="tab" aria-controls="profile" aria-selected="false">Employer</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="employee" role="tabpanel" aria-labelledby="home-tab">
      <!-- Employee Registration Form Start -->
  <form style="position:relative" class="mt-3" method="post" action="/registerEmployee">
  @csrf
  @if(count($employers)< 1)
      <div style="
        position:absolute;
        width:100%; height:100%;
        background:rgba(0,0,0,0.2);
        z-index:100;
      ">
        <div style="
            position:absolute;
            z-index: 10;
            display: flex;
            width: inherit;
            height: inherit;
            justify-content: center;
            align-items: center;
        ">
          <h4 class="p-2 bg-white">No Employer Registered Yet</h4>
        </div>
      </div>
      @endif
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Employer</label>
        </div>
        <select name="employer" class="custom-select" id="inputGroupSelect01">
            <option value="">Select</option>
            @foreach($employers as $e)
            <option value="{{$e->id}}">{{$e->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" value="{{old('employee_name')}}" name="employee_name" id="name" aria-describedby="emailHelp" placeholder="Enter name">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" value="{{old('employee_email')}}" name="employee_email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" value="{{old('employee_password')}}" name="employee_password" id="password" placeholder="Password">
    </div>
    <!-- <input type="hidden" name="role_id"> -->
    <button type="submit" class="btn btn-block btn-secondary ">Submit</button>
    </form>
      <!-- Employee Registration Form End -->

  </div>
  <!-- Employer Registration Start -->
  <div class="tab-pane fade" id="employer" role="tabpanel" aria-labelledby="profile-tab">
      
  <form class="mt-3" method="post" action="registerEmployer">
      @csrf
    
    <div class="form-group">
        <label for="name">Name</label>
        <input name="name" value="{{old('name')}}" type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Enter name">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" value="{{old('email')}}" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" value="{{old('password')}}" class="form-control" name="password" placeholder="Password">
    </div>
    <!-- <input type="hidden" name="role_id"> -->
    <button type="submit" class="btn btn-block btn-secondary ">Submit</button>
    </form>
  </div>
  <!-- Employer Registration End -->
</div>
    
</div>
@endsection