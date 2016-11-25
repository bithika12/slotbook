@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h1>Create A Task</h1>
        </div>

        <div class="panel-body">
          <form name="task-post" role="form" action="{{URL('task/save')}}" method="post" enctype="multipart/form-data">
            {{CSRF_FIELD()}}
            <div class="form-group">
              <label for="email">Task Title</label>
              <input type="text" class="form-control" name="title" value="{{old('title')}}">
            </div>
            <div class="form-group">
              <label for="pwd">Task Description</label>
              <textarea class="form-control" name="desc" rows="5">{{old('desc')}}</textarea>
            </div>
            <div class="form-group">
              <label for="pwd">File Browser</label>
              <p></p>
              <label class="btn-sm btn-danger btn-file">
                Upload A File 
                <input type="file" name="file[]" style="display: none;">
              </label>
            </div>
            <button type="submit" class="btn btn-primary">Submit Task</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
