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
                    <!-- <a onclick="openModal()" href="{{ route('admin.brand.create') }}" class="btn btn-primary float-end"> + Add</i></a> -->
                    <a onclick="openModal()" class="btn btn-primary float-end"> + </i></a>

                    <div id="myModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            @include('admin.brands.create')
                        </div>
                    </div>

                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table table-responsive p-0 my_table">

                        <table id="brandsTable" class="table table-bordered table-hover" style="width: 100%">.
                            <thead>
                                <tr>
                                    <th class="align-middle text-center text-nowrap">#Id</th>
                                    <th class="align-middle text-center text-nowrap">Logo</th>
                                    <th class="align-middle text-center text-nowrap">Brand Key</th>
                                    <th class="align-middle text-center text-nowrap">Name</th>
                                    <th class="align-middle text-center text-nowrap">Url</th>
                                    <th class="align-middle text-center text-nowrap">Status</th>
                                    <th class="align-middle text-center text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brands as $key => $brand)
                                <tr>
                                    <td class="align-middle text-center text-nowrap">{{$brand->id}}</td>
                                    <td class="align-middle text-center text-nowrap"><img
                                            src="{{ filter_var($brand->logo, FILTER_VALIDATE_URL) ? $brand->logo : asset('assets/images/brand-logos/'.$brand->logo) }}"
                                            class="avatar avatar-sm me-3" alt="{{$brand->name}}" title="{{$brand->name}}">
                                    </td>
                                    <td class="align-middle text-center text-nowrap">{{$brand->brand_key}}
                                    </td>
                                    <td class="align-middle text-center text-nowrap">{{$brand->name}}
                                    </td>
                                    <td class="align-middle text-center text-nowrap">{{$brand->url}}
                                    </td>
                                    <td class="align-middle text-center text-nowrap"><span
                                            class="badge badge-sm bg-gradient-{{$brand->status == 1 ? "success" : "primary"}}">{{$brand->status == 1 ? "Active" : "Inactive"}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                            data-toggle="tooltip" data-original-title="Edit user"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                            data-toggle="tooltip" data-original-title="delete user"> <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>

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
    $(document).ready(function() {});
</script>

@endpush
@endsection