@extends('layouts.layout')
@section('title', 'Edit Task')


@section('content')
    <br>


    <section class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Task</h3>
                        </div>
                        <div class="card-body">

                            @include('partials.validation_errors')
                            @include('flash::message')

                            <form method="post" action="{{ route('admin.tasks.update', $task) }}">

                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title"
                                        value="{{$task->title}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <input name="description" class="form-control" id="description" placeholder="Enter description"
                                        value="{{$task->description}}">
                                </div>

                                <div class="form-group mb-3">
                                    <select name="status" class="form-select">
                                        @foreach(App\Enums\Task\TaskStatus::options() as $value => $title)
                                            <option value="{{ $value }}" {{ $task->status->value === $value ? 'selected' : '' }}>
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select name="priority" class="form-select" id="priority">
                                        @foreach(App\Enums\Task\TaskPriority::options() as $value => $title)
                                            <option value="{{ $value }}" {{ $task->priority->value === $value ? 'selected' : '' }}>
                                                {{ $title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="due_date" class="form-label">Due Date</label>
                                    <input type="date" name="due_date" class="form-control" id="due_date"
                                        value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
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
