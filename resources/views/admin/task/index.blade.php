

@extends('layouts.layout')

@section('title', 'Task Management')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">List of Tasks</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                @include('flash::message')
                <div class="mb-3">
                    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> New Task
                    </a>
                </div>

                <div class="mb-3">
                    <a href="{{ route('admin.tasks.export') }}" class="btn btn-secondary">
                        <i class="fa fa-file-excel"></i> Export Tasks
                    </a>
                </div>


                <form method="GET" action="{{ route('admin.tasks.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request()->get('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ request()->get('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="priority" class="form-control">
                                <option value="">All Priorities</option>
                                <option value="low" {{ request()->get('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request()->get('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request()->get('priority') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                                <i class="fa fa-filter"></i> Clear Filters
                            </a>
                        </div>
                    </div>
                </form>

                @if($tasks->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Due Date</th>
                                    <th>Assignee</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->status }}</td>
                                        <td>{{ $task->priority }}</td>
                                        <td>{{ $task->due_date }}</td>
                                        <td>{{ $task->user->name }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-success btn-sm mr-1">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-info btn-sm mr-1">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <form method="post" action="{{ route('admin.tasks.destroy', $task) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    @if(auth()->user()->id == $task->user->id) disabled @endif>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        No data available.
                    </div>
                @endif
            </>
        </div>
    </section>
@endsection

<!-- /.content -->
