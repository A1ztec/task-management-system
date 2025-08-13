@extends('layouts.layout')
@section('User Details')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User Details</h3>
        </div>

        <div class="card-body">
            @include('flash::message')

            <div class="mb-3">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Users List
                </a>
            </div>

            <table class="table table-bordered table-striped">
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ $user->role }}</td>
                </tr>
            </table>

        </div>
    </div>
</div>
@endsection

