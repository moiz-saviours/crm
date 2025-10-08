@extends('admin.layouts.app')

@section('content')

    <div class="container">
        <h3 class="mb-4">User Activity Logs</h3>
        @php
            use Carbon\Carbon;

            function renderKeyValue($data) {
                echo '<table class="table table-sm mb-0 table-bordered">';
                foreach ($data as $key => $value) {
                    echo '<tr>';
                    echo '<td><strong>' . ucfirst(str_replace('_', ' ', $key)) . '</strong></td>';
                    echo '<td>';

                    if (is_array($value) || is_object($value)) {
                        renderKeyValue($value);
                    } else {
                        $isDateField = preg_match('/(_at|date|timestamp)$/i', $key);
                        $isDateValue = false;

                        // Check if the value looks like a date or datetime string
                        if (is_string($value) && strtotime($value) !== false) {
                            try {
                                $parsedDate = Carbon::parse($value);
                                $isDateValue = true;
                            } catch (Exception $e) {
                                $isDateValue = false;
                            }
                        }

                        if ($isDateField || $isDateValue) {
                            try {
                                echo e(Carbon::parse($value)->addHours(5)->format('Y-m-d h:i:s A'));
                            } catch (Exception $e) {
                                echo e($value); // fallback if invalid date
                            }
                        } else {
                            echo e($value);
                        }
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
