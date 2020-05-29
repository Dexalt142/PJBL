@extends('layouts.guru')

@section('page-title', 'Project')
@section('page-header', 'Project')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru-dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Project</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($projects as $project)
                @component('component.guru.card-project')
                    @slot('project', $project)
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
   
@endsection
