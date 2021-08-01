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
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Phone')}}</th>
                    <th>{{__('Referred Code')}}</th>
                    <th>{{__('Profit(2.5%)')}}</th>
                    <th>{{__('Status')}}</th>
                    <th width="9%">{{__('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bdos as $bdo)
                    @if($bdo != null)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bdo->name ?? 'No data' }}</td>
                            <td>{{ $bdo->email ?? 'No data' }}</td>
                            <td>{{ $bdo->phone ?? 'No data' }}</td>
                            <td>{{ $bdo->referral_code ?? 'No data' }}</td>
                            <td>
                                @php
                                    //total deposite Profit amount
                                   $depositProfit = DB::table('deposits')->where('user_id', $bdo->id)->sum('deposit_amount');

                                    //Available profit amount
                                   $withdrawamount = DB::table('withdraws')->where('user_id', $bdo->id)->sum('withdraw_amount');

                                   $bdo_Profit = $depositProfit-$withdrawamount;
                                @endphp

                                @if($bdo_Profit != null)
                                    {{  number_format($bdo_Profit, 2) }} BHD
                                @else
                                    0.00 BHD
                                @endif
                            </td>

                            <td>
                                <input  type="checkbox"   class="toggle-class" data-id="{{$bdo->id}}"  data-toggle="toggle" data-on="Active" data-onstyle="success" data-offstyle="danger" data-off="InActive" {{ $bdo->status==true ? 'checked' : '' }}>
                            </td>
                            <td>
                                @php
                                    $distributors = DB::table('users')->where('referred_by', $bdo->referral_code)->where('user_type', 'distributor')->get();
                                    $total_distributors= count($distributors);
                                @endphp
                                <div class="btn-group d-flex">
                                    <a class="btn btn-dark d-inline-block" href="{{ route('admin.dashboard') }}">{{__('Back')}}</a> &nbsp;
                                    <form class="d-inline-block pull-right" action="{{ route('all-bdo.destroy', $bdo->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" @if($total_distributors > 0) disabled @endif onclick="return confirm('Are you confirm ?')">{{__('Delete')}}</button>
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
