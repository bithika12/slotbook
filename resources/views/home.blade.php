@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-md-4 text-center alert-danger alert ">
            <h1 class="Overall">15</h1>
            <p>Oveall Tasks</p>
        </div>
        <div class="col-md-4 text-center alert-warning alert ">
            <h1 class="individual">25</h1>
            <p>Your Tasks</p>
        </div>
        <div class="col-md-4 text-center alert-info alert ">
            <h1 class="user_count">33</h1>
            <p>Users Count</p>
        </div>

        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">View Tasks</div>
                <div class="panel-body">Here you can see list of tasks</div>
                <div class="panel-footer">
                    <a class="btn btn-primary btn-sm" href="{{URL('view/tasks')}}">
                      <span class="glyphicon glyphicon-plus"></span> View Tasks
                  </a>
              </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Create A Task</div>
                <div class="panel-body">Here you can add new task</div>
                <div class="panel-footer">
                    <a class="btn btn-primary btn-sm" href="{{URL('task/new')}}">
                      <span class="glyphicon glyphicon-plus"></span> Add Task
                    </a>
              </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">View Users</div>
                <div class="panel-body">View All Users Details</div>
                <div class="panel-footer">
                    <a class="btn btn-primary btn-sm" href="{{URL('view/users')}}">
                      <span class="glyphicon glyphicon-plus"></span> View Users
                    </a>
                </div>
            </div>
        </div>
  </div>
</div>
@endsection
