@extends('layouts.bdo.master')
@section('title', 'Change Password')
@section('content-head')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Update Password</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('bdo.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item">Update Password</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="offset-md-2 col-md-8">
                    <!-- general form elements -->
                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Password Update</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="POST" action="{{route('change.password')}}">
                            @csrf
                            @method('put')

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="current_password" class="col-sm-4 col-form-label">Current Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="current_password" class="form-control" placeholder="Current Password" >
                                    </div>
                                    @error('current_password')
                                    <label for="current_password" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                      <div class="text-danger">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    @if(Session::has('err_msg_current_password'))
                                        <label for="current_password" class="col-sm-4 col-form-label"></label>
                                        <div class="col-sm-8">
                                            <p class="text-danger">{{ Session::get('err_msg_current_password') }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="new_password" class="col-sm-4 col-form-label">New Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" name="new_password" placeholder="New Password">
                                    </div>
                                    @error('new_password')
                                    <label for="current_password" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <div class="text-danger">{{ $message }}</div>
                                    </div>
                                    @enderror
                                    @if(Session::has('err_msg_same_password'))
                                        <label for="current_password" class="col-sm-4 col-form-label"></label>
                                        <div class="col-sm-8">
                                            <p class="text-danger">{{ Session::get('err_msg_same_password') }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-4 col-form-label">Confirm Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm Passsword" >
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Update Password</button>
                                <a href="{{ route('bdo.dashboard') }}" class="btn btn-dark float-right">Cancel</a>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


