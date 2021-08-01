@extends('layouts.app')

@section('content')

    <!-- Basic Data Tables -->
    <!--===================================================-->
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('CUSTOMERS')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="10%">SL#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>{{__('Phone')}}</th>
                    <th>{{__('Points(50%)')}}</th>
                    <th>{{__('Status')}}</th>
                    <th width="9%">{{__('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    @if($customer != null)
                        <tr>
                            <td>{{ $loop->iteration ?? 'No data' }}</td>
                            <td>{{ $customer->name ?? 'No data' }}</td>
                            <td>{{ $customer->email ?? 'No data'}}</td>
                            <td>{{ $customer->phone ?? 'No data' }}</td>
                            <td>
                                @php
                                    //Total earn points
                                   $depositPoint = DB::table('deposits')->where('user_id', $customer->id)->sum('deposit_club_point');
                                @endphp

                                @if($depositPoint != null)
                                    {{ $depositPoint }} Point
                                @else
                                     00 Point
                                @endif
                            </td>

                            <td>
                                <input  type="checkbox"   class="toggle-class" data-id="{{$customer->id}}"  data-toggle="toggle" data-on="Active" data-onstyle="success" data-offstyle="danger" data-off="InActive" {{ $customer->status==true ? 'checked' : '' }}>
                            </td>
                            <td>
                                <div class="btn-group d-flex">
                                    <a class="btn btn-dark d-inline-block" href="{{ route('admin.dashboard') }}">{{__('Back')}}</a> &nbsp;
                                    <form class="d-inline-block pull-right" action="{{ route('all-customer.destroy', $customer->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" onclick="return confirm('Are you confirm ?')">{{__('Delete')}}</button>
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
