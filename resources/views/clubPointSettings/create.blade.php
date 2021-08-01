@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Point Settings')}}
                <small class="text-warning">Default: Per doller = 10 points, customer 50%, merchant 40%, Distributor 10%</small>
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('pointSettings.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Point/per-doller')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="point_per_doller" value="{{  old('point_per_doller') }}" placeholder="Point for per doller">
                            @error('point_per_doller')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Merchant (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="marchant" value="{{  old('marchant') }}" placeholder="ex:10">
                            @error('marchant')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Distributor (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="distributor" value="{{  old('distributor') }}" placeholder="ex:10">
                            @error('distributor')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Customer (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="customer" value="{{  old('customer') }}" placeholder="ex:10">
                            @error('customer')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Start Date')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="date" class="form-control" name="point_start" value="{{  old('point_start') }}" placeholder="ex:10">
                            @error('point_start')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('End Date')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="date" class="form-control" name="point_end" value="{{  old('point_end') }}" placeholder="ex:10">
                            @error('point_end')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6 col-lg-offset-3">
                            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading bord-btm clearfix py-3">
        <h3 class="panel-title pull-left pad-no">{{__('Club Point Histroy')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped res-table mar-no" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Point Per Doller')}}</th>
                    <th>{{__('customer point')}}</th>
                    <th>{{__('marchant point')}}</th>
                    <th>{{__('distributor point')}}</th>
                    <th>{{__('start date')}}</th>
                    <th>{{__('end date')}}</th>
                    <th width="10%">{{__('Action')}}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($pointsettings as $key => $pointsetting)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $pointsetting->point_per_doller }}</td>
                        <td>{{$pointsetting->customer_point}}</td>
                        <td>{{$pointsetting->marchant_point}}</td>
                        <td>{{$pointsetting->distributor_point}}</td>
                        <td>{{$pointsetting->start_date}}</td>
                        <td>{{$pointsetting->end_date}}</td>
                        <td width="10%"><a href="#"></a> Delete</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="pull-right">
                {{-- {{ $refunds->appends(request()->input())->links() }} --}}
            </div>
        </div>
    </div>
</div>


@endsection

