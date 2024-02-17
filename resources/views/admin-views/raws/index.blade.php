@extends('layouts.admin.app')

@section('title', translate('Raw Material List'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
        <h2 class="h1 mb-0 d-flex align-items-center gap-2">
            <span class="page-header-title">
                {{translate('Raw_Material_List')}}
            </span>
        </h2>
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-top px-card pt-4">
                    <div class="row justify-content-between align-items-center gy-2">
                        <div class="col-md-4">
                            <h5 class="d-flex gap-2 mb-0">
                                {{translate('Raw_Material_List')}}
                                {{-- <span class="badge badge-soft-dark rounded-50 fz-12">{{$raws->total()}}</span> --}}
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex flex-wrap justify-content-md-end gap-3">
                                <form action="{{url()->current()}}" method="GET">
                                    <div class="input-group">
                                        <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="{{translate('Search by Name')}}" aria-label="Search" value="{{$search}}" required="" autocomplete="off">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">{{translate('Search')}}</button>
                                        </div>
                                    </div>
                                </form>
                                <a href="{{route('admin.raw.add-new')}}" class="btn btn-primary text-nowrap">
                                    <i class="tio-add"></i>
                                    <span class="text">{{translate('Add_New')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-4">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{translate('#')}}</th>
                                    <th>{{translate('Category name')}}</th>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Description')}}</th>
                                    <th>{{translate('Price')}}</th>
                                    <th>{{translate('Quantity')}}</th>
                                    <th>{{translate('Date')}}</th>
                                    <th class="text-center">{{translate('action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($raws as $raw)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td> @if($raw->category)
                                            {{ $raw->category->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $raw->name }}</td>
                                    <td>{{ $raw->description }}</td>
                                    <td>{{ $raw->price }}</td>
                                    <td>{{ $raw->quantity }}</td>
                                    <td>{{ $raw->created_at }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{route('admin.raw.edit',['id' => encrypt($raw->id)])}}"
                                            class="btn btn-outline-info btn-sm square-btn"
                                            title="{{translate('Edit')}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm square-btn" title="{{translate('Delete')}}" href="javascript:"
                                            onclick="form_alert('raw-{{$raw['id']}}','{{translate('Want to delete this Raw Material ?')}}')">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                        <form action="{{route('admin.raw.delete',[$raw['id']])}}"
                                              method="post" id="raw-{{$raw['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4 px-3">
                        <div class="d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{-- {{$raws->links()}} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
