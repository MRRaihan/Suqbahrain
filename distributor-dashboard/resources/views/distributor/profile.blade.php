@extends('layouts.distributor.master')
@section('title', 'Update Distributor Profile')
@section('content-head')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Update Distributor Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('distributor.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item">Update Profile</li>
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
                            <h3 class="card-title">Distributor Profile Update</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-4 col-form-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Your name" value="{{ \Illuminate\Support\Facades\Auth::user()->name }}">
                                    </div>
                                    @error('name')
                                    <label for="name" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <div class="text-danger">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" disabled  class="form-control" id="email" placeholder="Your email" value="{{ \Illuminate\Support\Facades\Auth::user()->email }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-sm-4 col-form-label">Phone</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Your phone" value="{{ \Illuminate\Support\Facades\Auth::user()->phone }}">
                                    </div>
                                    @error('phone')
                                    <label for="name" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <div class="text-danger">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-sm-4 col-form-label">Address</label>
                                    <div class="col-sm-8">
                                        <textarea  name="address" class="form-control" id="address" placeholder="Your address">{{ \Illuminate\Support\Facades\Auth::user()->address }}</textarea>
                                    </div>
                                    @error('address')
                                    <label for="name" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <div class="text-danger">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                
                                <div class="form-group row">
                                    <label for="avatar_original" class="col-sm-4 col-form-label">Update Profile Photo</label>
                                    <div class="col-sm-8">
                                        <input type="file" name="avatar_original" accept="image/*" class="form-control" >
                                    </div>
                                    @error('avatar_original')
                                    <label for="name" class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <div class="text-danger">{{ $message }}</div>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    @if(\Illuminate\Support\Facades\Auth::user()->avatar_original != null)
                                        <label for="name" class="col-sm-4 col-form-label"></label>
                                        <div class="col-sm-8">
                                            <img src="{{ asset(\Illuminate\Support\Facades\Auth::user()->avatar_original) }}" width="20%">
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Update</button>
                                <a href="{{ route('distributor.dashboard') }}" class="btn btn-dark float-right">Cancel</a>
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

