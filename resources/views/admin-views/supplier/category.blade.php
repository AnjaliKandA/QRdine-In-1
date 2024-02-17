@extends('layouts.admin.app')

@section('title', 'Add new Category')

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
                    Add Supplier Category
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <div class="row g-2">
            <div class="col-5">
                <form action="{{ route('admin.inventory.category.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="number">Category Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="number"
                                            placeholder="Category Name" value="{{ old('name') }}" required>
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

            <div class="col-7">
                <div class="card">
                    <div class="card-top px-card pt-4">
                        <div class="row justify-content-between align-items-center gy-2">
                            <div class="col-sm-4 col-md-6 col-lg-8">
                                <h5 class="d-flex gap-2">
                                    Category List

                                </h5>
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
                                        <th>Category Name</th>


                                        <th class="text-center">{{ translate('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category as $k => $table)
                                        <tr>
                                            <th scope="row">{{ $k + 1 }}</th>
                                            <td>{{ $table->name ?? '' }}</td>


                                            <td>
                                                <div class="d-flex justify-content-center gap-3">
                                                    {{-- <a href="{{ route('admin.table.update', [$table['id']]) }}"
                                                        class="btn btn-outline-info btn-sm square-btn"
                                                        title="{{ translate('Edit') }}">
                                                        <i class="tio-edit"></i>
                                                    </a> --}}
                                                    <button type="button" class="btn btn-outline-danger btn-sm square-btn"
                                                        title="{{ translate('Delete') }}"
                                                        onclick="form_alert('table-{{ $table['id'] }}','{{ translate('Want to delete this table ?') }}')">
                                                        <i class="tio-delete"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.table.delete', [$table['id']]) }}"
                                                    method="post" id="table-{{ $table['id'] }}">
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
                                {{ $category->links() }}
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
