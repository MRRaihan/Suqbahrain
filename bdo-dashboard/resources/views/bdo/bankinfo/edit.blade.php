@extends('layouts.bdo.master')
@section('title', 'Create New Distributor')
@section('content-head')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('bdo.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item">Update Bank Info</li>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update your bank Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="POST" action="{{route('bankinfo.update', $bankinfo->id)}}">
                            <div class="card-body">
                                @method('PUT')
                                @csrf

                                {{-- <input type="hidden" name="distributor_id" value="1" class="form-control" id="distributor_id"> --}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">A/C Holder Name</label>
                                    <input type="text" name="ac_holder" class="form-control" id="ac_holder" placeholder="Enter A/C holer name" value="{{ $bankinfo->ac_holder }}">
                                    @error('ac_holder')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">A/C Number</label>
                                    <input type="text" name="ac_no" class="form-control" id="ac_no" placeholder="Enter A/C Number" value="{{ $bankinfo->ac_no }}">
                                    @error('ac_no')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">IBAN Number</label>
                                    <input type="text" name="iban_number" class="form-control" id="iban_number" placeholder="Enter IBAN Number" value="{{ $bankinfo->iban_number }}">
                                    @error('iban_number')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control" id="bank_name" placeholder="Enter Bank Name" value="{{ $bankinfo->bank_name }}">
                                    @error('bank_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bank Address (Optional)</label>
                                    <input type="text" name="address" class="form-control" id="address" placeholder="Enter Bank Address" value="{{ $bankinfo->address }}">
                                    @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bank Routing No. (Optional)</label>
                                    <input type="text" name="routing_no" class="form-control" id="routing_no" placeholder="Enter Bank Routing Number" value="{{ $bankinfo->routing_no }}">
                                    @error('routing_no')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option {{ $bankinfo->status == 'primary' ? 'selected' : '' }}  value="primary">Primary Account</option>
                                        <option {{ $bankinfo->status == 'secondary' ? 'selected' : '' }} value="secondary">Secondary Account</option>
                                    </select>
                                    @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

