@extends('frontend.layouts.app')

@section('content')
<section class="gry-bg py-4 profile">
    <div class="container">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-lg-3 d-none d-lg-block">
                @if(Auth::user()->user_type == 'seller')
                    @include('frontend.inc.seller_side_nav')
                @elseif(Auth::user()->user_type == 'customer')
                    @include('frontend.inc.customer_side_nav')
                @endif
            </div>

            <div class="col-lg-9">
                <div class="main-content">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{__('Bank Information')}}
                                </h2>
                            </div>
                            <div class="col-md-6">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                        <li><a href="{{ route('bankinfo.index') }}">{{__('bankinfo')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <div class="dashboard-widget text-center plus-widget mt-4 c-pointer" data-toggle="modal" data-target="#bankinfocreate_modal">
                                <i class="la la-plus"></i>
                                <span class="d-block title heading-6 strong-400 c-base-1">{{ __('Add New Bank Information') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card no-border mt-4">
                        <table class="table table-sm table-hover table-responsive-md">
                            <thead>
                                <tr>
                                    <th>{{ __('SL#') }}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('A/C No.')}}</th>
                                    <th>{{__('Bank')}}</th>
                                    <th>{{__('IBAN')}}</th>
                                    {{-- <th>{{ __('Address') }}</th> --}}
                                    <th>{{__('Routing')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($bankinfos) > 0)
                                    @foreach ($bankinfos as $key => $bankinfo)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{ $bankinfo->ac_holder}}</td>
                                            <td>{{ $bankinfo->ac_no }}</td>
                                            <td>{{ $bankinfo->bank_name }}</td>
                                            <td>{{ $bankinfo->iban_number }}</td>
                                            {{-- <td>{{ $bankinfo->address }}</td> --}}
                                            <td>{{ $bankinfo->routing_no }}</td>
                                            <td>
                                                @if ($bankinfo->status == 'pending')
                                                    <span class="badge badge-pill badge-danger">{{$bankinfo->status}}</span>
                                                @elseif ($bankinfo->status == 'Accepted')
                                                    <span class="badge badge-pill badge-secondary">{{$bankinfo->status}}</span>
                                                @else
                                                    <span class="badge badge-pill badge-success">{{$bankinfo->status}}</span>
                                                @endif
                                            </td>

                                            <td class="d-flex">

                                                <div class="" data-toggle="modal" data-target="#bankinfoedit_modal{{ $bankinfo->id }}">
                                                    <span class="btn btn-primary ml-2">{{ __('Edit') }}</span>
                                                </div>

                                                {{-- <a href="{{ route('bankinfo.edit', $bankinfo->id)}}" class="btn btn-primary ml-2">Edit</a> --}}

                                                <form class="d-inline-block pull-right" method="post" action="{{ route('bankinfo.destroy', $bankinfo->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger ml-2" onclick="return confirm('Are you confirm?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center pt-5 h4" colspan="100%">
                                            <i class="la la-meh-o d-block heading-1 alpha-5"></i>
                                            <span class="d-block">{{ __('No history found.') }}</span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-wrapper py-4">
                        <ul class="pagination justify-content-end">
                            {{-- {{ $bankinfos->links() }} --}}
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>


@include('frontend.bankinfo.modal._create')

@if(count($bankinfos) > 0)
 @include('frontend.bankinfo.modal._edit')
@endif




@endsection
