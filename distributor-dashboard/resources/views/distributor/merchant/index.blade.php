@extends('layouts.distributor.master')
@section('title', 'Merchant List')
@section('table_css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/distributor/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/distributor/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/distributor/css/bootstrap-toggle.css')}}">
@endsection
@section('content-head')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('distributor.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item">Merchant List</li>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <a style="float: right;" href="{{ route('merchant.create') }}" class="btn btn-rounded btn-info pull-right">{{__('Add New Merchant')}}</a>
        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Merchant List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="5%">SL#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Type</th>
                    <th width="10%">Profit</th>
                    <th>Status</th>
                    <th width="14%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($merchants as $key => $merchant)

                    @if($merchant != null)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $merchant->name}}</td>
                            <td>{{ $merchant->email }}</td>
                            <td>{{ $merchant->phone }}</td>
                            <td>
                                @if($merchant->is_merchant == 1) Merchant @endif
                            </td>
                            <td>
                                @php
                                  //total deposite Profit amount
                                  $depositProfit = DB::table('deposits')->where('user_id', $merchant->id)->sum('deposit_amount');

                                  //Available profit amount
                                  $withdrawamount = DB::table('withdraws')->where('user_id', $merchant->id)->sum('withdraw_amount');

                                  $merchant_Profit = $depositProfit-$withdrawamount;
                                @endphp

                                @if($merchant_Profit != null)
                                {{  number_format($merchant_Profit, 2) }} BHD
                                @else
                                    0.00 BHD
                                @endif
                            </td>
                            <td>
                                <input  type="checkbox"   class="toggle-class" data-id="{{$merchant->id}}"  data-toggle="toggle" data-on="Active" data-onstyle="success" data-offstyle="danger" data-off="InActive" {{ $merchant->status==true ? 'checked' : '' }}>
                            </td>

                            <td class="d-flex">
                                @php
                                  $customers = DB::table('users')->where('referred_by', $merchant->referral_code)->where('user_type', 'customer')->get();
                                  $total_customers= count($customers);
                                @endphp
                                
                                <form class="d-inline-block pull-right" method="post" action="{{ route('merchant.destroy', $merchant->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger  ml-2" @if($total_customers > 0) disabled @endif onclick="return confirm('Are you confirm?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                  @endif
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection

@section('table_script')

    <!-- DataTables -->
    <script src="{{asset('assets/distributor/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/distributor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/distributor/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/distributor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/distributor/js/bootstrap-toggle.js')}}"></script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
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
