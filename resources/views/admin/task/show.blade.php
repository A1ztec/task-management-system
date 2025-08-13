@extends('layouts.layout')
@section('title', 'Show Task')



@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Task Details</h3>
            </div>

            <div class="card-body">
                @include('flash::message')

                <div class="mb-3">
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Tasks List
                    </a>
                </div>

                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Title</th>
                        <td>{{ $task->title }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $task->description }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $task->status }}</td>
                    </tr>
                    <tr>
                        <th>Priority</th>
                        <td>{{ $task->priority }}</td>
                    </tr>
                    <tr>
                        <th>Due Date</th>
                        <td>{{ $task->due_date }}</td>
                    </tr>
                    <tr>
                        <th>Assignee</th>
                        <td>{{ $task->user->name }}</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
@endsection

