@extends('Layouts.app')
@push('styles')
<style>
    body{
        background-color: #F0F8FF;
    }
#add_task{
    background-color:#b43eb4 ;
}
table{
    background-color: #D8BFD8;
}
#name_page{
   color: #452c63;
   font-family: 'Delicious Handrawn', cursive;
font-family: 'Open Sans', sans-serif;
font-family: 'Raleway', sans-serif;
}

</style>
@endpush
@section('content')
<div id="name_page" class="text-center mt-2 ">
<h2 >ALL TASKS:</h2></div>



<!-- Button trigger modal -->
<button type="button" id="add_task" class="btn  mt-5 mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add Task
  </button>

  <!-- Modal -->
  <div class="modal " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <div class="modal-body">



                    <div class="card-body">
                        <form>
                        <div class="form-group">

                            <label for="name">Title</label>
                            <input type="text" @class(['form-control','title' , 'is-invalid' => $errors->has('title')])  id="title" value="{{ old('title') }}" placeholder="Enter Title Task ">
                            @error('title')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Select Task Priority</label>
                            <select  class="form-select priority" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">High</option>
                                <option value="2">Mid</option>
                                <option value="3">Low</option>
                              </select>
                        </div>
                    </form>

                        <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class=" add_task btn  btn-primary">Create</button>
                        </div></div>

        </div>


      </div>
    </div></div>

<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table  table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr>
                        <td>{{{ $loop->iteration }}}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->priority }}</td>
                        <td>{{ $task->status }}</td>
                        <td>
                            <div class="d-flex">


                            </div>
                        </td>
                    </tr>



                @empty
                    <tr>
                        <th colspan="5" class="text-center">
                            There isn't any task yet
                        </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>















@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click','.add_task',function(e){
e.preventDefault();
var data ={
    'title':$('.title').val(),
    'priority':$('.priority').val(),

}
console.log(data);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
type:'POST',
    url:"{{route('task_store')}}",
    data: data,
    dataType: 'json',//data sending is json
    success:function(response){
        console.log(response);
    }
        });
        });
    });
</script>
@endpush
