@php
    $displayedNumbers = [];
@endphp
@foreach($customers as $key=>$customer)
    @if(!in_array($customer['contact_person_number'], $displayedNumbers))
    <tr class="">
        <td class="">
            {{$customers->firstitem()+$key}}
        </td>
        {{-- <td>
            {{$customer['order_no']}}
        </td> --}}
        <td class="max-w300">
            <a class="text-dark media align-items-center gap-2" href="{{route('admin.customer.view',[$customer['id']])}}">
                <div class="avatar">
                    <img src="{{asset('storage/app/public/profile')}}/{{$customer['image']}}" class="rounded-circle img-fit"
                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'">
                </div>
                {{-- <div class="media-body text-truncate">{{$customer['f_name']." ".$customer['l_name']}}</div> --}}
                <div class="media-body text-truncate">{{$customer['contact_person_name']}}</div>
            </a>
        </td>
        <td>
            {{-- <div><a href="mailto:{{$customer['email']}}" class="text-dark"><strong>{{$customer['email']}}</strong></a></div> --}}
            <div><a class="text-dark" href="tel:{{$customer['contact_person_number']}}">{{$customer['contact_person_number']}}</a></div>
        </td>
        <td>
            <label class="badge badge-soft-info py-1 px-5 mb-0">
                {{-- {{$customer->orders->count()}} --}}
                {{ $orderCounts[$customer->contact_person_number] ?? 0 }}
            </label>
        </td>
        {{-- <td>{{$customer->orders->sum('order_amount')}}</td> --}}
        {{-- <td class="show-point-{{$customer['id']}}-table">
            {{$customer['point']}}
        </td> --}}
        {{-- <td>
            <label class="switcher">
                <input id="{{$customer['id']}}" data-url="{{route('admin.customer.update_status', ['id' => $customer['id']])}}" onclick="status_change(this)" type="checkbox" class="switcher_input" {{$customer->is_active == 1? 'checked' : ''}}>
                <span class="switcher_control"></span>
            </label>
        </td> --}}
        <td>
            <div class="d-flex justify-content-center gap-2">
                <a class="btn btn-outline-success btn-sm square-btn"
                    href="{{route('admin.customer.view',[$customer['id']])}}">
                    <i class="tio-visible"></i>
                </a>
{{--                <a class="btn btn-outline-info btn-sm square-btn" href="javascript:" onclick="set_point_modal_data('{{route('admin.customer.set-point-modal-data',[$customer['id']])}}')">--}}
{{--                    <i class="tio-coin"></i>--}}
{{--                </a>--}}
                <button class="btn btn-outline-danger btn-sm square-btn"  onclick="form_alert('customer-{{$customer['id']}}', '{{translate('delete_this_user')}}')" >
                    <i class="tio-delete"></i>
                </button>
                <form id="customer-{{$customer['id']}}" action="{{route('admin.customer.destroy',['id' => $customer['id']])}}" method="post">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </td>
    </tr>
    @php
        $displayedNumbers[] = $customer['contact_person_number'];
    @endphp
    @endif
@endforeach