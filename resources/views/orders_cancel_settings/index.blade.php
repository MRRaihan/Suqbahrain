@extends('layouts.app')
@section('content')
    <div class="row">
        <form class="form-horizontal" action="{{ route('orders_cancel_settings.settings_update.admin') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $cancelRemaining->id ?? '' }}">
            <div class="col-lg-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{__('Order cancel\'s remaining time setting after order time ')}}</h3>
                    </div>
                    <div class="panel-body">
                            <div class="form-group">
                                <div class="col-lg-3">
                                    <label class="control-label">{{__('Set Hour(s)')}}</label>
                                </div>
                                <div class="col-lg-5">
                                    <input type="number" min="0" step="0.01" class="form-control" name="hours" @if ($cancelRemaining != null) value="{{ $cancelRemaining->cancel_hours }}" @endif placeholder="100" required>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label">{{__('Hour(s)')}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                                </div>
                            </div>
                        <p class="h5 mt-4">{{ __('Note: Customer & Merchant can be cancel their order after order\'s given hours.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{__('Product Return Days Settings')}}</h3>
                    </div>
                    <div class="panel-body">
                            <div class="form-group">
                                <div class="col-lg-3">
                                    <label class="control-label">{{__('Set Days(s)')}}</label>
                                </div>
                                <div class="col-lg-5">
                                    <input type="number" min="0" step="0.01" class="form-control" name="days" @if ($cancelRemaining != null) value="{{ $cancelRemaining->return_days }}" @endif placeholder="100" required>
                                </div>
                                <div class="col-lg-3">
                                    <label class="control-label">{{__('Days(s)')}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                                </div>
                            </div>

                        <p class="h5 mt-4">{{ __('Note: Customer & Merchant can be Return their order after order\'s given Days.') }}</p>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

