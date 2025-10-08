@extends('admin.layouts.app')

@section('content')

    <div class="container">
        <h3 class="mb-4">User Activity Logs</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($activities as $data)
                    @foreach ($data as $key => $value)
                        <tr>
                            <td><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}</strong></td>
                            <td>
                                @if (is_array($value) || is_object($value))
                                    <table class="table table-sm mb-0 table-bordered">
                                        @foreach ($value as $subKey => $subValue)
                                            <tr>
                                                <td><strong>{{ ucfirst(str_replace('_', ' ', $subKey)) }}</strong></td>
                                                <td>{{ is_array($subValue) || is_object($subValue) ? json_encode($subValue) : $subValue }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @else
                                    {{ $value }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="table-secondary">
                        <td colspan="2"><hr class="my-2 border-primary"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
