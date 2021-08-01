@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('faqCategory.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Faq Category')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('FAQS')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{__('Faq Category Name')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faq_categories as $key => $faq_category)
                    @if($faq_category != null)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $faq_category->faq_category_name }}</td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li style="background: #1c3550; color: #fff;"><a  href="{{route('faqCategory.edit', encrypt($faq_category->id))}}">{{__('Edit')}}</a></li>
                                        <li style="background: #8a2020; color: #fff;">
                                            <form class="d-inline-block" action="{{ route('faqCategory.destroy', $faq_category->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn" onclick="return confirm('Are you confirm ?')">{{__('Delete')}}</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
