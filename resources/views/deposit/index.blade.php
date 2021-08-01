@extends('layouts.app')

@section('content')

    <!-- Basic Data Tables -->
    <!--===================================================-->
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('BDOS')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="10%">SL#</th>
                    <th>{{__('Product')}}</th>
                    <th>{{__('Customer')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Delivery Status')}}</th>
                    <th>{{__('Payment Method')}}</th>
                    <th>{{__('Payment Status')}}</th>
                    <th>{{__('Profit')}}</th>
                    <th width="10%">{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order_details as $key => $order_detail)
                    @if($order_detail != null && ($order_detail->user->is_merchant ?? '0') == 1  )
                        <tr>
                            <td>{{ $loop->iteration }}
                                @if($order_detail->commission_splitting_status == 'pending')
                                    <span class="pull-right badge badge-info">{{ __('Pending') }}</span>
                                @endif
                            </td>

                            <td>{{ $order_detail->product->name ?? $order_detail->product_id }}</td>
                            <td>{{ $order_detail->user->name ?? 'no data' }}</td>
                            <td>{{ $order_detail->price }} BHD</td>
                            <td>{{ $order_detail->delivery_status }}</td>
                            <td>{{ $order_detail->shipping_type }}</td>
                            <td>{{ $order_detail->payment_status }}</td>
                            <td>
                                @if($order_detail->profit != null)
                                    {{ $order_detail->profit }} BHD
                                @else
                                    0.00 BHD
                                @endif
                            </td>
                            <td>
                                <div class="btn-group dropdown">
                                    @if ($order_detail->commission_splitting_status == 'done')
                                        <button class="btn dropdown-toggle dropdown-toggle-icon btn-success disabled">
                                            {{ __('Done') }}
                                        </button>
                                    @elseif($order_detail->payment_status == 'paid' && $order_detail->delivery_status == 'delivered' && \Carbon\Carbon::now()->diffInDays($order_detail->created_at) >= 7)
                                        <form action="{{ route('deposit.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_detail_id" value="{{$order_detail->id}}">

                                            <button class="btn dropdown-toggle dropdown-toggle-icon btn-primary">
                                                {{ __('Splitting') }}
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn dropdown-toggle dropdown-toggle-icon btn-warning disabled" aria-disabled="false">
                                            {{ __('Splitting') }}
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('asset/js/bootstrap-toggle.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('.delete-confirm').click(function(event) {
                var form =  $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                Swal.fire({
                    title: Are you sure to delete ${name}?,
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //submit form
                        form.submit();
                    }
                })
            });
        });
    </script>

    {{--<script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var user_id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '{{ route("change.status") }}',
                    data: {'status': status, 'user_id': user_id},
                    success: function(data){
                        // console.log(data);
                        if(!data.error) {
                            toastr.success(data.success);
                        }

                    }
                });
            })
        })
    </script>--}}
@endsection

