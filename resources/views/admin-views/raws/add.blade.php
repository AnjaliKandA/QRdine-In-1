@extends('layouts.admin.app')

@section('title', translate('Add New Raw Material'))

@push('css_or_js')
<!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h1 mb-0">
                {{-- <img width="20" class="avatar-img" src="{{ asset('public/assets/admin/img/icons/cooking.png') }}"
                    alt=""> --}}
                <span class="page-header-title">
                    {{ translate('Add_New_Raw_Material') }}
                </span>
            </h2>
            <a href="{{ url()->previous() }}" class="btn btn-primary">
                <i class="tio-arrow-left"></i> {{ translate('Back') }}
            </a>
        </div>

        {{-- <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <span class="page-header-title">
                    {{ translate('Add_New_Raw_Material') }}
                </span>
                  <a href="{{ url()->previous() }}" class="btn btn-primary ml-auto">
                    <i class="tio-arrow-left"></i> {{ translate('Back') }}
                </a>

            </h2>
        </div> --}}
        <!-- End Page Header -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.raw.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="name">{{ translate('Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="{{ translate('Ex') }} : {{ translate('Enter the full name.') }}"
                                            value="{{ old('name') }}" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="name">{{ translate('Description') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="description" class="form-control" id="description"
                                            placeholder="{{ translate('Ex') }} : {{ translate('Description maximum 255 words.') }}"
                                            value="{{ old('description') }}" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1">{{ translate('Select Category') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="category_id" class="custom-select" required>
                                            <option value="" selected disabled>{{ translate('--Select_Category--') }}
                                            </option>
                                            @foreach ($categories as $category)
                                               <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlSelect1">{{ translate('Select Supplier') }} <span class="text-danger">*</span></label>
                                        <select name="supplier_id[]" class="custom-select" multiple required>
                                            <option value="" disabled>{{ translate('--Select_Supplier--') }}</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" @if(in_array($supplier->id, old('supplier_id', []))) selected @endif>{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name">{{ translate('Price') }} <span class="text-danger">*</span>
                                            {{ translate('(only number)') }}</label>
                                        <input type="number" name="price" class="form-control" id="price"
                                            placeholder="{{ translate('Ex') }} : {{ translate('Number') }}"
                                            value="{{ old('price') }}"  min="1" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name">{{ translate('Quantity') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="quantity" value="{{ old('quantity') }}"
                                            class="form-control" id="quantity"
                                            placeholder="{{ translate('Ex') }} : {{ translate('Number') }}"  min="1" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-3">
                                <button type="submit" class="btn btn-primary">{{ translate('Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

<!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $(document).ready(function () {
        // Initialize Select2 for the multi-select dropdown
        $('select[name="supplier_id[]"]').select2();
    });
</script>
@endpush
