@extends('layouts.app')

@section('content')

    <div class="col-md-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">All Customer's</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no demo-dt-basic">
                        <thead>
                            <tr>
                                <th>SL#</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Customer Phone</th>
                                <th>Customer Club Point's</th>
                                <th>Customer Address</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                                @if($customer != null)
                                    <tr>
                                        <td width="5%">{{ $loop->iteration }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>
                                            {{ $customer->phone ?? 'No data' }}
                                        </td>
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
                                            {{ $customer->address ?? 'No data' }}
                                        </td>
                                        <td>{{ date('d M, Y', strtotime($customer->created_at)) }}</td>


<!--                                            <div class="btn-group right">
                                                <li>
                                                    <a class="btn btn-primary dropdown-toggle dropdown-toggle-icon" href="">BDO</a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-primary dropdown-toggle dropdown-toggle-icon" href="">Distributor</a>
                                                </li>
                                                <li>
                                                    <a class="btn btn-primary dropdown-toggle dropdown-toggle-icon" href="">Merchant</a>
                                                </li>

                                            </div>-->

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
<!--            <div class="panel-body">
                <div class="pull-right">
                    <a class="btn btn-primary" href="#">Back</a>
                </div>
            </div>-->
        </div>
    </div>


@endsection
