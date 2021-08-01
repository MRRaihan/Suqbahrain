@extends('layouts.bdo.master')
@section('title', 'Distributor List')
@section('table_css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/bdo/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bdo/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bdo/css/bootstrap-toggle.css')}}">
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
                        <li class="breadcrumb-item"><a href="{{route('bdo.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item">Distributor List</li>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <a style="float: right;" href="{{ route('distributor.create') }}" class="btn btn-rounded btn-info pull-right">{{__('Add New Distributor')}}</a>
        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Distributor List</h3>
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
                    <th>Referral Code</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th width="10%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($distributors as $key => $distributor)
                    {{--@php
                    dd($distributor);
                    @endphp--}}
                    @if($distributor != null)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $distributor->name}}</td>
                            <td>{{ $distributor->email }}</td>
                            <td>{{ $distributor->phone }}</td>
                            <td>{{ $distributor->referral_code }}</td>
                            <td>
                                @if($distributor->is_distributor == 1) Distributor @endif
                            </td>
                            {{--<td>
                                @php
                                  $result = DB::table('order_details')->where('user_id', $distributor->id)->sum('profit');
                                  $distributor_profit = $result * (50/100)
                                @endphp
                                @if($distributor_profit != null)
                                {{ $distributor_profit }} BHD
                                @else
                                    0.0 BHD
                                @endif
                            </td>--}}
                            <td>
                                <input  type="checkbox" id="xyz"   class="toggle-class" data-id="{{$distributor->id}}"  data-toggle="toggle" data-on="Active" data-onstyle="success" data-offstyle="danger" data-off="InActive" {{ $distributor->status==true ? 'checked' : '' }}>
                            </td>

                            <td class="d-flex">
                                @php
                                    $merchants = DB::table('users')->where('referred_by', $distributor->referral_code)->where('user_type', 'customer')->where('is_merchant', 1)->get();
                                    $total_merchants= count($merchants);
                                @endphp
                                <form class="d-inline-block pull-right" method="post" action="{{ route('distributor.destroy', $distributor->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger  ml-2" @if($total_merchants > 0) disabled @endif onclick="return confirm('Are you confirm?')">Delete</button>
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
    <script src="{{asset('assets/bdo/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/bdo/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/bdo/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/bdo/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/bdo/js/bootstrap-toggle.js')}}"></script>

    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>

    <script>

        /*$(function() {*/
            $('#xyz').change(function() {
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

    </script>
@endsection
