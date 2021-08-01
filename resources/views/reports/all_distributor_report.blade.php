@extends('layouts.app')

@section('content')

    <div class="col-md-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">All Distributor's</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no demo-dt-basic">
                        <thead>
                            <tr>
                                <th>SL#</th>
                                <th>Distributor Name</th>
                                <th>Distributor Email</th>
                                <th>Distributor Phone</th>
                                <th>Distributor Profit's / Club Point's</th>
                                <th>Created At</th>
                                <th>Merchant(T)| Customer(T)</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distributors as $distributor)
                                @if($distributor != null)
                                    <tr>
                                        <td width="5%">{{ $loop->iteration }}</td>
                                        <td>{{ $distributor->name }}</td>
                                        <td>{{ $distributor->email }}</td>
                                        <td>{{ $distributor->phone }}</td>
                                        <td>
                                            @php
                                                //total deposite Profit amount
                                               $depositProfit = DB::table('deposits')->where('user_id', $distributor->id)->sum('deposit_amount');
                                                //Total earn points
                                               $depositPoint = DB::table('deposits')->where('user_id', $distributor->id)->sum('deposit_club_point');
                                                //Available profit amount
                                               $withdrawamount = DB::table('withdraws')->where('user_id', $distributor->id)->sum('withdraw_amount');

                                               $distributor_Profit = $depositProfit-$withdrawamount;
                                            @endphp

                                            @if($distributor_Profit or $depositPoint != null)
                                                {{  number_format($distributor_Profit, 2) }} BHD / {{ $depositPoint }} Point
                                            @else
                                                0.00 BHD / 00 Point
                                            @endif
                                        </td>
                                        <td>{{ date('d M, Y', strtotime($distributor->created_at)) }}</td>
                                        <td>
                                           @php
                                                $merchants = DB::table('users')->where('referred_by', $distributor->referral_code)->where('user_type', 'customer')->where('is_merchant', 1)->get();
                                                $total_merchants= count($merchants);
                                                $total_customers = 0;
                                                     foreach ($merchants as $merchant){
                                                      $customers = DB::table('users')->where('referred_by', $merchant->referral_code)->where('user_type', 'customer')->where('is_merchant', 0)->get();
                                                      $total_customers +=count($customers);
                                                     }
                                            @endphp
                                             Merchant ({{ $total_merchants }})  | Customer ({{ $total_customers }})
                                        </td>
                                        <td>
                                            <a class="btn btn-primary dropdown-toggle dropdown-toggle-icon" href="{{ route('merchant_report.index', encrypt($distributor->id)) }}">View Merchant ({{ $total_merchants }})</a>
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
