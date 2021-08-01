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
                    <th width="5%">SL#</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Bank</th>
                    <th>A/C No.</th>
                    <th>IBAN</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <tbody>
                    @foreach($withdraws as $key => $withdraw)
                    @if($withdraw != null)
                        <tr>
                            <td>{{$key+1}}
                                @if($withdraw->status == 'pending')
                                    <span class="pull-right badge badge-info">{{ __('Pending') }}</span>
                                @endif
                            </td>
                            <td>{{ $withdraw->user->name ?? '' }}</td>
                            <td>{{ $withdraw->user->user_type ?? '' }}</td>
                            <td>{{ $withdraw->created_at->format('jS F Y h:i A') }}</td>
                            <td>{{ $withdraw->bankinfo->ac_holder ?? 'no data' }}</td>
                            <td>{{ $withdraw->withdraw_amount ?? 'no data' }} BHD</td>
                            <td>{{ $withdraw->bankinfo->bank_name ?? 'no data' }}</td>
                            <td>{{ $withdraw->bankinfo->ac_no ?? 'no data' }}</td>
                            <td>{{ $withdraw->bankinfo->iban_number ?? 'no data' }}</td>
                            <td>{{ $withdraw->status }}</td>

                            <td class="d-flex">
                                @if ( $withdraw->status == 'pending' || $withdraw->status == 'accepted')
                                    <form class="d-inline-block pull-right" method="POST" action="{{ route('withdraw.update', $withdraw->id) }}">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" name="status" value="{{$withdraw->status}}">
                                        <button class="btn ml-2 {{ $withdraw->status == 'pending' ? 'btn-info' : 'btn-success'}}" onclick="return confirm('Are you confirm?')">

                                            {{ $withdraw->status == 'pending' ? 'Accept' : 'Compleate'}}

                                        </button>
                                    </form>

                                @else
                                    <button class="btn btn-danger ml-2 disabled">Done</button>
                                @endif
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

