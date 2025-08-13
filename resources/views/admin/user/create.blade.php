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

                        <form method="post" action="{{ route('admin.users.store')}}" enctype="multipart/form-data">

                            @csrf

                            <div class="form-group mb-3">
                                <label for="name" class="form-label">name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
                            </div>
                            <div class="form-group mb-3">
                                <label for="label" class="form-label">email</label>
                                <input name="email" class="form-control" id="email" placeholder="Enter content">
                            </div>

                            <div class="form-group mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" class="form-select" id="role">
                                    @foreach(App\Enums\User\UserRole::options() as $value => $title)
                                        <option value="{{ $value }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="password">password</label>
                                <input type="password" name="password" class="form-control-file" id="password"
                                    placeholder="Enter your password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">password confirmation</label>
                                <input type="password" name="password_confirmation" class="form-control-file"
                                    id="password_confirmation" placeholder="Enter your password confirmation">
                            </div>



                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
