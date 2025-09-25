@extends('admin.layouts.app')

@section('content')

    <div class="container">
        <h3 class="mb-4">User Activity Logs</h3>

        <ul class="list-group">
            @foreach($activities as $line)
                <li class="list-group-item">
                    {{ $line }}
                </li>
            @endforeach
        </ul>
    </div>

@endsection
