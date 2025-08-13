@extends('layouts.layout')
@section('title', 'Create User')

@section('content')
    <br>


    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add user</h3>
                        </div>
                        <div class="card-body">

                            @include('partials.validation_errors')

                            <form method="post" action="{{ route('admin.tasks.store')}}" enctype="multipart/form-data">

                                @csrf

                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">title</label>
                                    <input type="text" name="title" class="form-control" id="name" placeholder="Enter title"
                                        value="{{old('title')}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="label" class="form-label">description</label>
                                    <input name="description" class="form-control" id="description" placeholder="Enter description"
                                        value="{{old('description')}}">
                                </div>

                               <div class="form-group mb-3">
                                   <label for="label" class="form-label">status</label>
                                   <select name="status" class="form-select" id="status">
                                       @foreach(App\Enums\Task\TaskStatus::options() as $value => $title)
                                           <option value="{{ $value }}">{{ $title }}</option>
                                       @endforeach
                                   </select>
                               </div>
                               <div class="form-group mb-3">
                                   <label for="label" class="form-label">priority</label>
                                   <select name="priority" class="form-select" id="priority">
                                       @foreach(App\Enums\Task\TaskPriority::options() as $value => $title)
                                           <option value="{{ $value }}">{{ $title }}</option>
                                       @endforeach
                                   </select>

                                   <div class="form-group mb-3">
                                       <label for="label" class="form-label">due date</label>
                                       <input type="date" name="due_date" class="form-control" id="due_date" placeholder="Enter due date"
                                              value="{{old('due_date')}}">

                                   <div class="form-group mb-3">
                                       <label for="label" class="form-label">assignee</label>
                                       <select name="user_id" class="form-select" id="assignee">
                                           @foreach($users as $user)
                                               <option value="{{ $user->id }}">{{ $user->name }}</option>
                                           @endforeach
                                       </select>
                                   </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<!-- /.content -->
