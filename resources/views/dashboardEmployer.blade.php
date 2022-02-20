@extends('app')


@section('content')
<div class="bg-white p-3">
    <div style="
        border-bottom: 1px solid black;
    ">
        <h5>Hello  <strong>{{$user->name}}</strong></h5>
    </div>
    <br>
    @if(count($user->employees) < 1 )
        <div class="text-center alert alert-warning">
            <h4>
                You have No Employees !
            </h4>
        </div>
    @else
    <h4>Employees</h4>
    <table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user->employees as $e)
        <tr>
        <th scope="row">{{$loop->iteration}}</th>
        <td>{{$e->name}}</td>
        <td>{{$e->email}}</td>
        </tr>
        @endforeach
        
    </tbody>
    </table>
@endif
</div>

@endsection