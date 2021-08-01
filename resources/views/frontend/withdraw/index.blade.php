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
                                        {{__('Amount withdraw')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li><a href="{{ route('withdraw_amount.index') }}">{{__('Withdraw  Request')}}</a></li>
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
                                    <th>{{ __('Date') }}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Bank')}}</th>
                                    <th>{{__('A/C No.')}}</th>
                                    <th>{{__('IBAN')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($withdraws) > 0)
                                    @foreach ($withdraws as $key => $withdraw)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $withdraw->created_at == null ? 'no data': $withdraw->created_at->format('jS F Y h:i A') }}</td>
                                            <td>{{ $withdraw->bankinfo->ac_holder ?? 'no data' }}</td>
                                            <td>{{ $withdraw->withdraw_amount ?? 'no data' }}</td>
                                            <td>{{ $withdraw->bankinfo->bank_name ?? 'no data' }}</td>
                                            <td>{{ $withdraw->bankinfo->ac_no ?? 'no data' }}</td>
                                            <td>{{ $withdraw->bankinfo->iban_number ?? 'no data' }}</td>


                                            <td>
                                                @if ($withdraw->status == 'pending')
                                                    <span class="badge badge-pill badge-danger">{{$withdraw->status}}</span>
                                                @elseif ($withdraw->status == 'Accepted')
                                                    <span class="badge badge-pill badge-secondary">{{$withdraw->status}}</span>
                                                @else
                                                    <span class="badge badge-pill badge-success">{{$withdraw->status}}</span>
                                                @endif
                                            </td>

                                            <td class="d-flex">
                                                @if ($withdraw->status == 'pending')
                                                    <form class="d-inline-block pull-right" method="post" action="{{ route('withdraw_amount.destroy', $withdraw->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger ml-2" onclick="return confirm('Are you confirm?')">Delete</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-danger ml-2 disabled">Delete</button>
                                                @endif
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
                                {{-- {{ $withdraws->links() }} --}}
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <div class="modal fade" id="withdraw_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title strong-600 heading-5">{{__('Create a withdraw')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-3 pt-3">
                    <form class="" action="{{ route('withdraw_amount.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mb-3" name="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <label>Provide a detailed description <span class="text-danger">*</span></label>
                            <textarea class="form-control editor" name="details" placeholder="Type your reply" data-buttons="bold,underline,italic,|,ul,ol,|,paragraph,|,undo,redo"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" name="attachments[]" id="file-2" class="custom-input-file custom-input-file--2" data-multiple-caption="{count} files selected" multiple />
                            <label for="file-2" class=" mw-100 mb-0">
                                <i class="fa fa-upload"></i>
                                <span>Attach files.</span>
                            </label>
                        </div>
                        <div class="text-right mt-4">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('cancel')}}</button>
                            <button type="submit" class="btn btn-base-1">{{__('Send withdraw')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
