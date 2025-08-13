@extends('layouts.layout')


@php
    $colors = [
        'total tasks' => 'bg-primary',
        'pending tasks' => 'bg-warning',
        'completed tasks' => 'bg-success',
        'in progress tasks' => 'bg-info',
        'total Users' => 'bg-danger',
    ];
@endphp

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row">
@foreach ($data as $key => $value)
        <!-- small card -->
        <div class="col-md-3 col-sm-3 mb-2">
            <div class="card text-white {{$colors[$key] ?? 'bg-secondary'}}">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fa fa-{{$key}}"></i>
                        </div>
                        <div>
                            <h5 class="card-title">{{$key}}</h5>
                            <h3 class="card-text">{{$value}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
                    </div>

@endsection
