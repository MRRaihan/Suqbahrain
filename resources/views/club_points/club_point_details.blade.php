@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-striped res-table mar-no" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="20%">{{__('Product Name')}}</th>
                                <th>{{__('Points')}}</th>
                                <th>{{__('Earned At')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($club_point_details as $key => $club_point)
                                <tr>
                                    <td>{{ ($key+1) + ($club_point_details->currentPage() - 1)*$club_point_details->perPage() }}</td>
                                    @if ($club_point->product != null)
                                        <td>{{ $club_point->product->name }}</td>
                                    @endif
                                    <td>{{ $club_point->point }}</td>
                                    <td>{{ $club_point->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="pull-right">
                            {{ $club_point_details->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
