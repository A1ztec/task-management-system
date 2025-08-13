@extends('layouts.layout')

@section('title', 'User Management')

@section('content')
<section class="content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">List of Users</h3>

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
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New User
                </a>
            </div>


            @if($users->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        {{$user->role}}
                                    </td>
                                    <td class="d-flex">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-success btn-sm mr-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm mr-1">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <form method="post" action="{{ route('admin.users.destroy', $user) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                @if(auth()->user()->id == $user->id) disabled @endif>
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
        </div>
    </div>
</section>
@endsection
