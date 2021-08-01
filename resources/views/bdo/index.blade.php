@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('bdo.create') }}" class="btn btn-rounded btn-info pull-right">{{__('Add New BDO')}}</a>
        </div>
    </div>

    <br>

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
                    <th>{{__('Profit (2.5%)')}}</th>
                    <th>{{__('Status')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bdos as $key => $bdo)
                    @if($bdo != null)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bdo->name }}</td>
                            <td>{{ $bdo->email}}</td>
                            <td>{{ $bdo->phone }}</td>
                            <td>{{ $bdo->referral_code}}</td>
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
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li style="background: #1c3550; color: #fff;"><a href="{{route('bdo.edit', encrypt($bdo->id))}}">{{__('Edit')}}</a></li>
                                        <li style="background: #8a2020; color: #fff;">
                                            <form class="d-inline-block" action="{{ route('bdo.destroy', $bdo->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn" @if($total_distributors > 0) disabled @endif onclick="return confirm('Are you confirm ?')">{{__('Delete')}}</button>
                                            </form>
                                        </li>
                                    </ul>
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
