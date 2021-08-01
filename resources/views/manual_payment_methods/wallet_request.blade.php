@extends('layouts.app')

@section('content')

<div class="panel">
    <div class="panel-heading bord-btm clearfix pad-all h-100">
        <h3 class="panel-title pull-left pad-no">{{__('Offline Wallet Recharge Requests')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped res-table mar-no" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Method')}}</th>
                    <th>{{__('TXN ID')}}</th>
                    <th>{{__('Photo')}}</th>
                    <th>{{__('Approval')}}</th>
                    <th>{{__('Date')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wallets as $key => $wallet)
                    <tr>
                        <td>{{ ($key+1) }}</td>
                        <td>{{ $wallet->user->name }}</td>
                        <td>{{ $wallet->amount }}</td>
                        <td>{{ $wallet->payment_method }}</td>
                        <td>{{ $wallet->payment_details }}</td>
                        <td>
                            @if ($wallet->reciept != null)
                                <a href="{{ asset($wallet->reciept) }}" target="_blank">{{__('Open Reciept')}}</a>
                            @endif
                        </td>
                        <td>
                            <label class="switch">
                                <input onchange="update_approved(this)" value="{{ $wallet->id }}" type="checkbox" @if($wallet->approval == 1) checked @endif >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>{{ $wallet->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
            {{ $wallets->links() }}
        </table>
    </div>
</div>

@endsection
@section('script')
    <script type="text/javascript">
        function update_approved(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('offline_recharge_request.approved') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Money has been added successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
