@extends('layouts.admin.app')

@section('title', translate('Notifications'))

@push('css_or_js')

@endpush
@section('content')
<div class="content container-fluid">
     <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <i class="tio-notifications"></i>
                <span class="page-header-title">
                    {{translate('Notification')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->
        <div class="row g-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-top px-card pt-4">
                        <div class="row justify-content-between align-items-center gy-2">
                            <div class="col-md-4">
                                <h5 class="d-flex gap-2 mb-0">
                                    {{translate('Notification_List')}}
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
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="py-4">
                        <div class="table-responsive">
                            <table id="" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{translate('#')}}</th>
                                    <th>{{translate('Content')}}</th>
                                    <th>{{translate('Date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($notifications as $notification)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $notification->content }}</td>
                                    <td>{{ $notification->created_at }}</td>
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
@endsection