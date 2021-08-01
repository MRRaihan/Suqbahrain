@extends('layouts.bdo.master')
@section('title', 'withdraw List')
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
                        <li class="breadcrumb-item">withdraw</li>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Your Transaction Histry</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="5%">SL#</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Bank</th>
                    <th>A/C No.</th>
                    <th>IBAN</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($withdraws as $key => $withdraw)
                    @if($withdraw != null)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $withdraw->created_at->format('jS F Y h:i A') }}</td>
                            <td>{{ $withdraw->bankinfo->ac_holder ?? 'no data' }}</td>
                            <td>{{ $withdraw->withdraw_amount ?? 'no data' }} BHD</td>
                            <td>{{ $withdraw->bankinfo->bank_name ?? 'no data' }}</td>
                            <td>{{ $withdraw->bankinfo->ac_no ?? 'no data' }}</td>
                            <td>{{ $withdraw->bankinfo->iban_number ?? 'no data' }}</td>
                            <td>{{ $withdraw->status }}</td>

                            <td class="d-flex">
                                @if ($withdraw->status == 'pending')
                                    <form class="d-inline-block pull-right" method="post" action="{{ route('withdraw.destroy', $withdraw->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger ml-2" onclick="return confirm('Are you confirm?')">Delete</button>
                                    </form>
                                @else
                                <button class="btn btn-danger ml-2 disabled">Delete</button>
                                @endif
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
