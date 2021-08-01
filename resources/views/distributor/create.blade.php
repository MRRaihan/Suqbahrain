@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">{{__('Create Distributor')}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{{route('distributor.store')}}" method="POST">
                    <!--<form class="form-horizontal" action="{{url('/admin/distributor')}}" method="POST">-->

                        @csrf

                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Name')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Distributor name">
                            </div>
                            
                            @error('name')
                                <div class="col-lg-3"></div>
                                <div class="col-lg-8" style="margin-top: 0.6%;">
                                    <div class="text-danger">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Email')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="email" class="form-control" name="email" value="{{ old('email')  }}" placeholder="Distributor Email" >
                            </div>
                            
                            @error('email')
                                <div class="col-lg-3"></div>
                                <div class="col-lg-8" style="margin-top: 0.6%;">
                                    <div class="text-danger">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>
                        

                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Phone')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="phone" value="{{  old('phone') }}" placeholder="xxxxxxxx" >
                            </div>
                            
                            @error('phone')
                                <div class="col-lg-3"></div>
                                <div class="col-lg-8" style="margin-top: 0.6%;">
                                    <div class="text-danger">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>


                       {{-- <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Identification')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="identification" value="{{  old('identification') }}" placeholder="Distributor pasport number" >
                            </div>
                            
                            @error('identification')
                                <div class="col-lg-3"></div>
                                <div class="col-lg-8" style="margin-top: 0.6%;">
                                    <div class="text-danger">{{ $message }}</div>
                                </div>
                            @enderror
                        </div> --}}

                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Address')}}</label>
                            </div>
                            <div class="col-lg-8">
                                <textarea type="text" name="address" id="address" cols="10" rows="4" class="form-control" placeholder="Your address">{{  old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-8">
                                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                                <a href="{{ route('distributor.index') }}" class="btn btn-dark">{{__('Back')}}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection

