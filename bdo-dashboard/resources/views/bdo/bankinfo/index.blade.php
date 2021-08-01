@extends('layouts.bdo.master')
@section('title', 'bankinfo List')
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
                        <li class="breadcrumb-item">Bank Info</li>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <a style="float: right;" href="{{ route('bankinfo.create') }}" class="btn btn-rounded btn-info pull-right">{{__('Add New Bank Information')}}</a>
    </div>
</div>

<br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Your Bank Account Information</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="5%">SL#</th>
                    <th>Name</th>
                    <th>A/C No</th>
                    <th>Bank</th>
                    <th>IBAN</th>
                    <th>Address</th>
                    <th>Routing</th>
                    {{--<th width="10%">Profit</th>--}}
                    {{--<th>Status</th>--}}
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($bankinfos as $key => $bankinfo)
                    {{--@php
                    dd($bankinfo);
                    @endphp--}}
                    @if($bankinfo != null)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $bankinfo->ac_holder}}</td>
                            <td>{{ $bankinfo->ac_no }}</td>
                            <td>{{ $bankinfo->bank_name }}</td>
                            <td>{{ $bankinfo->iban_number }}</td>
                            <td>{{ $bankinfo->address }}</td>
                            <td>{{ $bankinfo->routing_no }}</td>
                            <td>{{ $bankinfo->status }}</td>

                            <td class="d-flex">
                                <a href="{{ route('bankinfo.edit', $bankinfo->id)}}" class="btn btn-primary ml-2">Edit</a>
                                
                                <form class="d-inline-block pull-right" method="post" action="{{ route('bankinfo.destroy', $bankinfo->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger ml-2" onclick="return confirm('Are you confirm?')">Delete</button>
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
