@extends('app')


@section('content')
<div class="bg-white p-3">
<div style="
        border-bottom: 1px solid black;
    ">
        <h5><strong>Task List</strong></h5>
    </div>
    <br>
    @if(session('success'))
    <div class="alert alert-success">
      <strong>  {{session('success')}}</strong>
    </div>
    @endif
    @if(count($tasks_users) < 1 )
        <div class="text-center alert alert-warning">
            <h4>
                You have No Tasks !
            </h4>
        </div>
    @else
    <h4>Tasks</h4>
    <table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Employee</th>
        <th scope="col">Action</th>
        <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks_users as $task_u)
        <tr>
        <th scope="row">{{$loop->iteration}}</th>
        <td>{{$task_u->task->title}}</td>
        <td>{{$task_u->employee->name}}</td>
        <td>
            @if(auth()->user()->role_id==1)
            <form style="display:inline" method="post" action="{{ route('task.destroy',$task_u->task_id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    Delete
                </button>
            </form>
            @else
            <button 
            data-eid='{{$task_u->id}}'
            class="btn btn-warning taskUpdate">
                Update
            </button>
            @endif
            <button 
            class="btn btn-primary taskDetails" 
            data-id='{{$task_u->id}}'>
                View Details
            </button>
        </td>
        <td>{{$task_u->task->status}}</td>
        </tr>
        @endforeach
        
    </tbody>
    </table>
    <div>
        {{$tasks_users->links()}}
    </div>
@endif
</div>
<!-- Task Details Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div style="max-width:800px" class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-2" style='border-bottom:1px solid black'>
            <h3 id="taskTitle">1asdsa</h3>
            <div class="d-flex justify-content-between">
                <div>
                    <p class='mb-0'><strong>Initiated At: </strong> </p><span id="createdAt"></span>
                </div>
                <div>
                    <p  class='mb-0'><strong>Completed At:</strong> </p><span id="updatedAt"></span>
                </div>
            </div>
        </div>
        <div class="mb-2"  style='border-bottom:1px solid black'>
            <h4 >Description</h4>
            <div style="white-space: pre;" id="description"></div> <br>
            <p> <strong> Status: </strong> <span id="status"></span></p>
        </div>
        <div class="mb-2">
            <h4 >Feedback</h4>
            <div style="white-space: pre;" id="feedback">...</div> <br>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Task Details Modal End -->

<!-- Task Update Modal -->
<div class="modal fade" id="taskUpdate" tabindex="-1" role="dialog" aria-labelledby="taskUpdateLabel" aria-hidden="true">
  <form method="POST" action='' id='taskUpdateForm' style="max-width:800px" class="modal-dialog" role="document">
  @csrf
  @method('PUT')
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskUpdateLabel">Task Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-2" style='border-bottom:1px solid black'>
            <h3 id="taskTitleUpdate"></h3>
            <div class="d-flex justify-content-between">
                <div>
                    <p class='mb-0'><strong>Initiated At: </strong> </p><span id="createdAtUpdate"></span>
                </div>
                <div>
                    <p  class='mb-0'><strong>Completed At:</strong> </p><span id="updatedAtUpdate"></span>
                </div>
            </div>
        </div>
        <div>
            <div class="form-group">
                <label >Feedback</label>
                <textarea style='white-space:pre;' placeholder="Feedback" name='feedback' id='feedbackUpdate' class="form-control" rows="3"></textarea>
            </div>
            <div>
                Task Status: 
                <input name='status' type="checkbox" value="1" class='toggle_checkbox' id="switch" /><label class='toggle_label' for="switch">Toggle</label>
            </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type='submit' class='btn btn-primary'>
              Save
          </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
</form>
</div>
<!-- Task Update Modal End -->
<script>
    $(document).ready(()=>{
        // Task Details Modal Start
        $('.taskDetails').on('click',function(){
            let id = $(this).data('id');
            $.ajax({
                type:'GET',
                url:'/task/'+id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    $("#taskTitle").html(data.title);
                    $("#createdAt").html(data.created_at);
                    $("#description").html(data.description);
                    $("#status").html(data.status);
                    let completed_at = '...';
                    if(data.status=='Completed'){
                        completed_at = data.updated_at;
                    }
                    $("#updatedAt").html(completed_at);
                    let feedback = '...'
                    if(data.feedback!=null){
                        feedback = data.feedback;
                    }
                    $("#feedback").html(feedback);
                      $("#exampleModal").modal('show');
                    // console.log(data);

                },
                error:function(data){
                    console.log(data);
                }
            });
        });
        // Task Details Modal End

        // Task Update Modal Start
        $('.taskUpdate').on('click',function(){
            let id = $(this).data('eid');
            
            $.ajax({
                type:'GET',
                url:'/task/'+id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    $("#taskUpdateForm").attr('action','/task/'+data.id);

                    $("#taskTitleUpdate").html(data.title);
                    $("#createdAtUpdate").html(data.created_at);
                    $("#statusUpdate").html(data.status);
                    let completed_at = '...';
                    if(data.status=='Completed'){
                        completed_at = data.updated_at;
                        $('#switch').prop('checked',true);
                    }
                    $("#updatedAtUpdate").html(completed_at);
                    let feedback = '...'
                    if(data.feedback!=null){
                        feedback = data.feedback;
                    }
                    
                    $("#feedbackUpdate").html(feedback);
                      $("#taskUpdate").modal('show');

                },
                error:function(data){
                    console.log(data);
                }
            });
        })
        // Task Update Modal End
    })
</script>
<!-- Details Modal -->
@endsection