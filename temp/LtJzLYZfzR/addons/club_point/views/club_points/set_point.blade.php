@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-8">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-striped res-table mar-no" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="20%">{{__('Name')}}</th>
                                <th>{{__('Product Owner')}}</th>
                                <th>{{__('Num of Sale')}}</th>
                                <th>{{__('Base Price')}}</th>
                                <th>{{__('Rating')}}</th>
                                <th>{{__('Point')}}</th>
                                <th>{{__('Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $product)
                                <tr>
                                    <td>{{ ($key+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                                    <td>
                                        <a href="{{ route('product', $product->slug) }}" target="_blank" class="media-block">
                                            <div class="media-left">
                                                <img loading="lazy"  class="img-md" src="{{ asset($product->thumbnail_img)}}" alt="Image">
                                            </div>
                                            <div class="media-body">{{ __($product->name) }}</div>
                                        </a>
                                    </td>
                                    <td>
                                    @if ($product->user != null)
                                        {{ $product->user->name }}
                                    @endif
                                    </td>
                                    <td>
                                        @php
                                            $qty = 0;
                                            if($product->variant_product){
                                                foreach ($product->stocks as $key => $stock) {
                                                    $qty += $stock->qty;
                                                }
                                            }
                                            else{
                                                $qty = $product->current_stock;
                                            }
                                            echo $qty;
                                        @endphp
                                    </td>
                                    <td>{{ number_format($product->unit_price,2) }}</td>
                                    <td>{{ $product->rating }}</td>
                                    <td>{{ $product->earn_point }}</td>
                                    <td>
                                        <div class="btn-group dropdown">
                                            <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                                {{__('Actions')}} <i class="dropdown-caret"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="{{route('product_club_point.edit', encrypt($product->id))}}">{{__('Edit')}}</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="pull-right">
                            {{ $products->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">{{__('Set Point for Product')}}</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <small>Set any specific point for those products what are between 'min price' and 'max price'. Min-price should be less than Max-price</small>
                    </div>
                    <form class="form-horizontal" action="{{ route('set_products_point.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="col-lg-6">
                                <label class="control-label">{{__('Set Point for multiple products')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" min="0" step="0.01" class="form-control" name="point" placeholder="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-6">
                                <label class="control-label">{{__('Min Price')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" min="0" step="0.01" class="form-control" name="min_price" value="{{ \App\Product::min('unit_price') }}" placeholder="50" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-6">
                                <label class="control-label">{{__('Max Price')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="number" min="0" step="0.01" class="form-control" name="max_price" value="{{ \App\Product::max('unit_price') }}" placeholder="110" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
