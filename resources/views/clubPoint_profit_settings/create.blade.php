@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Point Settings')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('profit_settings.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Point/per-doller')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="point_per_doller" value="{{  env('point_per_doller') }}" placeholder="Point for per doller" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Merchant (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="marchant" value="{{  env('marchant') }}" placeholder="ex:10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Distributor (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="distributor" value="{{  env('distributor') }}" placeholder="ex:10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Customer (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="customer" value="{{  env('customer') }}" placeholder="ex:10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Start Date')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="date" class="form-control" name="point_start" value="{{  env('point_start') }}" placeholder="ex:10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('End Date')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="date" class="form-control" name="point_end" value="{{  env('point_end') }}" placeholder="ex:10" required>
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

    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Profit Distribution Settings')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('profit_settings.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('BDO (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="bdo" value="{{  env('bdo') }}" placeholder="ex:10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Merchant (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="marchant" value="{{  env('marchant') }}" placeholder="ex:10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Distributor (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="distributor" value="{{  env('distributor') }}" placeholder="ex:10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Customer (%)')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="customer" value="{{  env('customer') }}" placeholder="ex:10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Start Date')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="date" class="form-control" name="customer" value="{{  env('customer') }}" placeholder="ex:10" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('End Date')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="date" class="form-control" name="customer" value="{{  env('customer') }}" placeholder="ex:10" required>
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


@endsection
