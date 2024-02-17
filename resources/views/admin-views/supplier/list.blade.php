@extends('layouts.admin.app')

@section('title', 'Add new Supplier')

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{ asset('public/assets/admin/img/icons/table.png') }}"
                    alt="">
                <span class="page-header-title">
                    Add new Supplier
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <div class="row g-2">
            <div class="col-12">
                <form action="{{ route('admin.inventory.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="number">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="number"
                                            placeholder="Supplier Name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Gmail <span class="text-danger">*</span></label>
                                        <input type="gmail" name="gmail" class="form-control" id="capacity"
                                            placeholder="Gmail" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlSelect1">Category <span
                                                class="text-danger">*</span></label>
                                        <select name="category_id" class="custom-select" required>
                                            <option value="" selected>{{ translate('--select--') }}</option>
                                            @foreach ($category as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Phone Number <span class="text-danger">*</span></label>
                                        <input type="number" name="phonenumber" class="form-control"
                                            placeholder="Phone number" value="{{ old('phonenumber') }}" required>

                                        {{-- <input type="text" name="Phone Number" pattern="[7-9]{1}[0-9]{9}"
                                            title="Phone number with 7-9 and remaing 9 digit with 0-9"> --}}
                                        {{-- 
                                        <input type="text" pattern="[6789][0-9]{9}"
                                            title="Please enter valid phone number"> --}}

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Whatapps Phone Number <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="whatappsnumber" class="form-control"
                                            placeholder="Whatapps Phone Number" value="{{ old('whatappsnumber') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Address </label>

                                        <Textarea class="form-control" name="address"></Textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary">{{ translate('reset') }}</button>
                                <button type="submit" class="btn btn-primary">{{ translate('submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-top px-card pt-4">
                        <div class="row justify-content-between align-items-center gy-2">
                            <div class="col-sm-4 col-md-6 col-lg-8">
                                <h5 class="d-flex gap-2">
                                    Supplier List

                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group">
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="Search by Phone Number" aria-label="Search"
                                            value="{{ $search }}" required="" autocomplete="off">
                                        <div class="input-group-append">
                                            <button type="submit"
                                                class="btn btn-primary">{{ translate('Search') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="py-4">
                        <div class="table-responsive">
                            <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ translate('SL') }}</th>
                                        <th>Name</th>
                                        <th>Gmail</th>
                                        <th>Phone No</th>
                                        <th>Whatapps Number</th>
                                        <th>Category</th>
                                        <th>Address</th>
                                        <th class="text-center">{{ translate('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supplier as $k => $supplierdata)
                                        <tr>
                                            <th scope="row">{{ $k + 1 }}</th>
                                            <td>{{ $supplierdata['name'] }}</td>
                                            <td>{{ $supplierdata['gmail'] }}</td>
                                            <td>{{ $supplierdata['phonenumber'] }}</td>
                                            <td>{{ $supplierdata['whatappsnumber'] }}</td>


                                            <td>{{ $supplierdata->categorydata->name ?? '' }}</td>
                                            <td>{{ $supplierdata['address'] }}</td>

                                            <td>
                                                <div class="d-flex justify-content-center gap-3">
                                                    {{-- <a href="{{ route('admin.supplier.update', [$supplierdata['id']]) }}"
                                                        class="btn btn-outline-info btn-sm square-btn"
                                                        title="{{ translate('Edit') }}">
                                                        <i class="tio-edit"></i>
                                                    </a> --}}
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm square-btn"
                                                        title="{{ translate('Delete') }}"
                                                        onclick="form_alert('table-{{ $supplierdata['id'] }}','{{ translate('Want to delete this table ?') }}')">
                                                        <i class="tio-delete"></i>
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ route('admin.inventory.delete', [$supplierdata['id']]) }}"
                                                    method="post" id="table-{{ $supplierdata['id'] }}">
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
                                {{ $supplier->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script type="text/javascript">
        const handlePrint = () => {
            var actContents = document.body.innerHTML;
            document.body.innerHTML = actContents;
            window.print();
        }
    </script>
@endpush
