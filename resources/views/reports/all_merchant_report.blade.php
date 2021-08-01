@extends('layouts.app')

@section('content')

    <div class="col-md-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">All Merchant's</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no demo-dt-basic">
                        <thead>
                            <tr>
                                <th>SL#</th>
                                <th>Merchant Name</th>
                                <th>Merchant Email</th>
                                <th>Merchant Phone</th>
                               <th>Merchant Profit's / Club Point's</th>
                                <th>Created At</th>
                                <th>Customer(T)</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($merchants as $merchant)
                                @if($merchant != null)
                                    <tr>
                                        <td width="5%">{{ $loop->iteration }}</td>
                                        <td>{{ $merchant->name }}</td>
                                        <td>{{ $merchant->email }}</td>
                                        <td>{{ $merchant->phone }}</td>
                                        <td>
                                            @php
                                                //total deposite Profit amount
                                               $depositProfit = DB::table('deposits')->where('user_id', $merchant->id)->sum('deposit_amount');
                                                //Total earn points
                                               $depositPoint = DB::table('deposits')->where('user_id', $merchant->id)->sum('deposit_club_point');
                                                //Available profit amount
                                               $withdrawamount = DB::table('withdraws')->where('user_id', $merchant->id)->sum('withdraw_amount');

                                               $merchant_Profit = $depositProfit-$withdrawamount;
                                            @endphp

                                            @if($merchant_Profit or $depositPoint != null)
                                                {{  number_format($merchant_Profit, 2) }} BHD / {{ $depositPoint }} Point
                                            @else
                                                0.00 BHD / 00 Point
                                            @endif
                                        </td>
                                        <td>{{ date('d M, Y', strtotime($merchant->created_at)) }}</td>
                                        <td>

                                            @php
                                                $customers = DB::table('users')->where('referred_by', $merchant->referral_code)->where('user_type', 'customer')->where('is_merchant', 0)->get();
                                                $total_customers= count($customers);
                                            @endphp
                                            Customer ({{ $total_customers }})
                                        </td>
                                        <td>
                                            <a class="btn btn-primary dropdown-toggle dropdown-toggle-icon" href="{{ route('customer_report.index', encrypt($merchant->id)) }}">View Customer ({{ $total_customers }})</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
