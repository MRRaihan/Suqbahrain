@extends('layouts.app')

@section('content')

    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('FAQ Update')}}</h3>
            </div>
            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('faq.update', $faq->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{__('FAQ Category')}}</label>
                        <div class="col-sm-10">
                            <select class="form-control selectpicker" name="faq_category_id" id="faq_category_id">
                                <option value="" style="display: none" selected>Select Faq Category</option>
                                @foreach($faq_categories as $faq_category)
                                    <option value="{{ $faq_category->id }}" @if($faq->faq_category_id == $faq_category->id) selected @endif> {{ $faq_category->faq_category_name }} </option>
                                @endforeach
                            </select>
                            @error('faq_category_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="faq_question">{{__('Question')}}</label>
                        <div class="col-sm-10">
                            <textarea class="editor" name="faq_question" placeholder="Insert Question">{{ $faq->faq_question }}</textarea>
                            @error('faq_question')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="faq_answer">{{__('Answer')}}</label>
                        <div class="col-sm-10">
                            <textarea class="editor" name="faq_answer" placeholder="Insert Answer">{{ $faq->faq_answer }}</textarea>
                            @error('faq_answer')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <a href="{{ route('faq.index') }}" class="btn btn-dark">Back</a>
                    <button class="btn btn-info" type="submit">{{__('Update')}}</button>
                </div>
                <br>
                <br>
            </form>
            <!--===================================================-->
            <!--End Horizontal Form-->

        </div>
    </div>

@endsection
