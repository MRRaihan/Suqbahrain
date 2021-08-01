@extends('layouts.app')

@section('content')



    <div class="col-md-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">All BDO's</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no demo-dt-basic">
                        <thead>
                            <tr>
                                <th>SL#</th>
                                <th>BDO Name</th>
                                <th>BDO Email</th>
                                <th>BDO Phone</th>
                                <th>BDO Profit</th>
                                <th>Created At</th>
                                <th>Distributor(T)| Merchant(T)| Customer(T)</th>
                                <th width="10%">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($bdos as $bdo)
                              @if($bdo != null)
                              <tr>
                                  <td width="5%">{{ $loop->iteration }}</td>
                                  <td>{{ $bdo->name }}</td>
                                  <td>{{ $bdo->email }}</td>
                                  <td>{{ $bdo->phone }}</td>
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
                                  <td>{{ date('d M, Y', strtotime($bdo->created_at)) }}</td>
                                  <td>
                                      @php
                                          $distributors = DB::table('users')->where('referred_by', $bdo->referral_code)->where('user_type', 'distributor')->get();
                                          $total_distributors= count($distributors);
                                          $total_merchants = 0;
                                          $total_customers = 0;
                                           foreach ($distributors as $distributor){
                                               $merchants = DB::table('users')->where('referred_by', $distributor->referral_code)->where('user_type', 'customer')->where('is_merchant', 1)->get();
                                               $total_merchants +=count($merchants);

                                               foreach ($merchants as $merchant){
                                                $customers = DB::table('users')->where('referred_by', $merchant->referral_code)->where('user_type', 'customer')->where('is_merchant', 0)->get();
                                                $total_customers +=count($customers);
                                               }
                                           }

                                      @endphp
                                      Distributor ({{ $total_distributors  }})  | Merchant ({{ $total_merchants }})  | Customer ({{ $total_customers }})
                                  </td>
                                  <td>
                                    @php
                                          $distributors = DB::table('users')->where('referred_by', $bdo->referral_code)->where('user_type', 'distributor')->get();
                                          $total_distributors= count($distributors);
                                      @endphp

                                    <a class="btn btn-primary dropdown-toggle dropdown-toggle-icon" href="{{ route('distributor_report.index', encrypt($bdo->id)) }}">View Distributor ({{ $total_distributors }})</a>

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
