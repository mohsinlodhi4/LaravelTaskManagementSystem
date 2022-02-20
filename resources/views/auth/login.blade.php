@extends('app')

@section('content')
<div class="container bg-white p-4" style="max-width:600px">
<div class="mb-2">
    <h3 class="text-center">Login Page</h3>
</div>
@if(session()->has('error'))
<div class="alert alert-danger">
    {{session('error')}}
</div>
@elseif($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $e)
        <li>{{$e}}</li>
        @endforeach
    </ul>
</div>
@endif
  <form class="mt-3" method="post" action="/login">
      @csrf
    
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" value="{{old('email')}}" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>
    <!-- <input type="hidden" name="role_id"> -->
    <button type="submit" class="btn btn-block btn-secondary ">Submit</button>
    </form>
    
    
</div>

@endsection