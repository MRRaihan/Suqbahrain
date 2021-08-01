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
                                        {{__('FAQS')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li><a href="{{ route('faqs.index') }}">{{__('FAQS')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <div class="dashboard-widget text-center plus-widget mt-4 c-pointer" data-toggle="modal" data-target="#withdraw_modal">
                                    <i class="la la-plus"></i>
                                    <span class="d-block title heading-6 strong-400 c-base-1">{{ __('Create a withdraw') }}</span>
                                </div>
                            </div>
                        </div> --}}
                        <div class="card no-border mt-4">
                            <table class="table table-sm table-hover table-responsive-md">
                                <thead>
                                <tr>
                                    <th>{{ __('SL#') }}</th>
                                    <th width="30%">{{ __('Question') }}</th>
                                    <th width="50%">{{__('Answer')}}</th>
                                    <th width="15%">{{__('Faq Category')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($faqs) > 0)
                                    @foreach ($faqs as $key => $faq)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $faq->faq_question ?? 'no data' }}</td>
                                            <td>{{ $faq->faq_answer ?? 'no data' }}</td>
                                            <td>{{ $faq->faq_category->faq_category_name ?? 'no data' }}</td>
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
                                {{-- {{ $withdraws->links() }} --}}
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection
