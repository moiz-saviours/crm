@extends('admin.layouts.app')
@section('title','Brands')
@section('content')
    @push('css')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

    @endpush
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h3 class="text-center">Brand Table</h3>
                        <a href="{{ route('admin.brand.create') }}" class="btn btn-primary float-end"><i
                                class="fas fa-plus"></i></a>

                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table table-responsive p-0">
                            <table id="brandsTable" class="table table-striped" style="width: 100%">
                                <thead>
                                <tr>
                                    <th class="align-middle text-center text-nowrap" >Id</th>
                                    <th class="align-middle text-center text-nowrap" >Logo</th>
                                    <th class="align-middle text-center text-nowrap" >Brand Key</th>
                                    <th class="align-middle text-center text-nowrap" >Name</th>
                                    <th class="align-middle text-center text-nowrap" >Url</th>
                                    <th class="align-middle text-center text-nowrap" >Status</th>
                                    <th class=""></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($brands as $key => $brand)
                                    <tr>
                                        <td class="align-middle text-center text-nowrap" >{{$brand->id}}</td>
                                        <td class="align-middle text-center text-nowrap" ><img
                                                src="{{ filter_var($brand->logo, FILTER_VALIDATE_URL) ? $brand->logo : asset('assets/images/brand-logos/'.$brand->logo) }}"
                                                class="avatar avatar-sm me-3"
                                                alt="{{$brand->name}}" title="{{$brand->name}}">
                                        </td>
                                        <td class="align-middle text-center text-nowrap" >{{$brand->brand_key}}
                                        </td>
                                        <td class="align-middle text-center text-nowrap" >{{$brand->name}}
                                        </td>
                                        <td class="align-middle text-center text-nowrap" >{{$brand->url}}
                                        </td>
                                        <td class="align-middle text-center text-nowrap" ><span
                                                class="badge badge-sm bg-gradient-{{$brand->status == 1 ? "success" : "primary"}}">{{$brand->status == 1 ? "Active" : "Inactive"}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                               data-toggle="tooltip" data-original-title="Edit user">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <!-- DataTables JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
        <script>
            $(document).ready(function () {
            });
        </script>

    @endpush
@endsection
