@extends('layouts.app')

@section('content')

    <!-- Basic Data Tables -->
    <!--===================================================-->
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('DISTRIBUTORS')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="10%">SL#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Phone')}}</th>
                    <th>{{__('Referred Code')}}</th>
                    <th>{{__('Profit(10%) / Point(10%)')}}</th>
                    <th>{{__('Status')}}</th>
                    <th width="9%">{{__('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($distributors as $distributor)
                    @if($distributor != null)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $distributor->name ?? 'No data' }}</td>
                            <td>{{ $distributor->email ?? 'No data' }}</td>
                            <td>{{ $distributor->phone ?? 'No data' }}</td>
                            <td>{{ $distributor->referral_code ?? 'No data' }}</td>
                            <td>
                                @php
                                    //total deposite Profit amount
                                   $depositProfit = DB::table('deposits')->where('user_id', $distributor->id)->sum('deposit_amount');
                                    //Total earn points
                                   $depositPoint = DB::table('deposits')->where('user_id', $distributor->id)->sum('deposit_club_point');
                                    //Available profit amount
                                   $withdrawamount = DB::table('withdraws')->where('user_id', $distributor->id)->sum('withdraw_amount');

                                   $distributor_Profit = $depositProfit-$withdrawamount;
                                @endphp

                                @if($distributor_Profit or $depositPoint  != null)
                                    {{  number_format($distributor_Profit, 2) }} BHD / {{ $depositPoint }} Point
                                @else
                                    0.00 BHD / 00 Point
                                @endif
                            </td>

                            <td>
                                <input  type="checkbox"   class="toggle-class" data-id="{{$distributor->id}}"  data-toggle="toggle" data-on="Active" data-onstyle="success" data-offstyle="danger" data-off="InActive" {{ $distributor->status==true ? 'checked' : '' }}>
                            </td>
                            <td>
                                @php
                                    $merchants = DB::table('users')->where('referred_by', $distributor->referral_code)->where('user_type', 'customer')->where('is_merchant', 1)->get();
                                    $total_merchants= count($merchants);
                                @endphp
                                <div class="btn-group d-flex">
                                    <a class="btn btn-dark d-inline-block" href="{{ route('admin.dashboard') }}">{{__('Back')}}</a> &nbsp;
                                    <form class="d-inline-block pull-right" action="{{ route('all-distributor.destroy', $distributor->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" @if($total_merchants > 0) disabled @endif onclick="return confirm('Are you confirm ?')">{{__('Delete')}}</button>
                                    </form>
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

    <script>
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
    </script>
@endsection
