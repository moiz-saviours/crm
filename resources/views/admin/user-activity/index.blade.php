@extends('admin.layouts.app')

@section('content')

    <div class="container">
        <h3 class="mb-4">User Activity Logs</h3>
        @php
            function renderKeyValue($data) {
                echo '<table class="table table-sm mb-0 table-bordered">';
                foreach ($data as $key => $value) {
                    echo '<tr>';
                    echo '<td><strong>' . ucfirst(str_replace('_', ' ', $key)) . '</strong></td>';
                    echo '<td>';
                    if (is_array($value) || is_object($value)) {
                        renderKeyValue($value);
                    } else {
                        echo e($value);
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        @endphp
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
                                    {!! renderKeyValue($value) !!}
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
