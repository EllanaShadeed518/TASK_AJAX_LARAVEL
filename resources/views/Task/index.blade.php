@extends('Layouts.app')
@push('styles')
<style>
    body{
        background-color:#D8BFD8 ;
    }
#add_task,.search{
    background-color:#b43eb4 ;
}
table{
    background-color: #F0F8FF;
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

    <div class="d-flex justify-content-between">
    <div>
<button type="button" id="add_task" class="btn  mt-5 mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add Task
  </button></div>
  <div class="float-right">
<form >
<button type="button" class="search btn rounded mb-2 p-1">SEARCH</button>
    <input type="text"@class(['form-control' ])  id="search" >

    <span class=" text-danger error-text    search_error">

    </span>

</form></div>
</div>

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
                            <input type="text" @class(['form-control','title', ])  id="title" value="{{ old('title') }}" placeholder="Enter Title Task ">

                                <span class=" text-danger error-text  title_error">

                                </span>

                        </div>
                        <div class="form-group ">
                            <label>Select Task Priority</label>
                            <select  class="form-select priority" aria-label="Default select example">
                                <option  value="1">High</option>
                                <option value="2">Mid</option>
                                <option value="3">Low</option>
                              </select>
                              <span class="text-danger error-text priority_error ">

                              </span>
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
            <tbody >
                @forelse ($tasks as $task)
                <tr>
                    <td>{{{ $loop->iteration }}}</td>
                    <td>{{ $task->title }}</td>
                    @if ($task->priority==1)
                      <td class="text-success fw-bold "> High</td>
                      @elseif ($task->priority==2)
                      <td class="text-warning fw-bold "> Mid</td>
                      @else
                      <td class="text-primary fw-bold "> Low</td>
                    @endif
                    <td>{{ $task->status }}</td>
                    <td>
                        <div class="d-flex">
                           <!-- <button type="button" class="btn btn-sm btn-info "style="height:30px" data-toggle="modal" data-target="#exampleModalLi">Update</button>-->
                            <form  >

                                <input type="button" style="margin-right: 5px" class="  text-center btn btn-sm btn-danger delete-btn p-2"style="height:30px"  data-url="{{ route('task-delete', $task->id) }}" value="Delete">

                            </form>

                            <form  >

                                <input type="button"  style="margin-left:5px"class="  text-center btn btn-sm btn-primary status-btn p-2"style="height:30px"  data-url="{{ route('task-status', $task->id) }}" value="Change Status">

                            </form>

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
    url:"{{route('task-store')}}",
    data: data,
    dataType: 'json',//data sending is json
    beforeSend:function(){
        $(document).find('span.error-text').text('')
    },
    success:function(response){
        if(response.status==0){
            $.each(response.error,function(prefix,val){
                $('span.'+prefix+'_error').text(val[0]);
            })
        }
        else{
            console.log(response);
        $(".modal").hide();
        window.location="{{route('task-index')}}";
        }


    }
        });
        });
    });
</script>
<script>
$(document).ready(function(){
    $(document).on('click','.status-btn',function(e){
e.preventDefault();
var urlTask = $(this).data("url");
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$.ajax({
type:'POST',
url:urlTask,
dataType: 'json',//data sending is json
success:function(response){
    console.log(response);
    window.location="{{route('task-index')}}";

}
    });
    });
});
</script>
<script>
    $(document).ready(function(){
        $(document).on('click','.delete-btn',function(e){
    e.preventDefault();
    var urlTask = $(this).data("url");
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
    type:'DELETE',
    url:urlTask,
    dataType: 'json',//data sending is json
    success:function(response){
        console.log(response);
        window.location="{{route('task-index')}}";

    }
        });
        });
    });
    </script>


<script>
    $(document).ready(function(){
        $(document).on('click','.search',function(e){
e.preventDefault();
var data ={
    'title':$('#search').val(),


}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$.ajax({
type:'GET',
    url:"{{route('task-search')}}",
    data: data,
    dataType: 'json',//data sending is json
    beforeSend:function(){
        $(document).find('span.error-text').text('');

    },
    success:function(response){
        if(response.status==0){
            $.each(response.error,function(val){
                $(' span.search_error').text(response.error.title);
            })
        }
        else{



          console.log(response);
$('tbody ').html(response.tasks);


        }



    }
        });
        });
    });

</script>
@endpush



