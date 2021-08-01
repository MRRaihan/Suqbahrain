@extends('layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Manual Payment Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('manual_payment_methods.update', $manual_payment_method->id) }}" method="POST" enctype="multipart/form-data">
          <input name="_method" type="hidden" value="PATCH">
          @csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="type">{{__('Type')}}</label>
                    <div class="col-sm-10">
                        <select class="form-control demo-select2-placeholder" name="type" id="type" required>
                            <option value="custom_payment" @if($manual_payment_method->type == 'custom_payment') selected @endif>{{__('Custom Payment')}}</option>
                            <option value="bank_payment" @if($manual_payment_method->type == 'bank_payment') selected @endif>{{__('Bank Payment')}}</option>
                            <option value="check_payment" @if($manual_payment_method->type == 'check_payment') selected @endif>{{__('Check Payment')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Heading')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="heading" value="{{ $manual_payment_method->heading }}" placeholder="" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="photo">{{__('Checkout Thumbnail')}} (438x235)px</label>
                    <div class="col-sm-10">
                        <input type="file" id="photo" name="photo" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{__('Payment Instruction')}}</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="editor">@php echo $manual_payment_method->description @endphp</textarea>
                    </div>
                </div>
                <div id="bank_payment_data">
                    <div id="bank_payment_informations">
                        @if($manual_payment_method->bank_info != null)
                            @foreach (json_decode($manual_payment_method->bank_info) as $key => $bank_info)
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-2 control-label">{{__('Bank Information')}}</label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-3"><input type="text" name="bank_name[]" class="form-control" placeholder="Bank Name" value={{ $bank_info->bank_name }}></div>
                                                <div class="col-sm-3"><input type="text" name="account_name[]" class="form-control" placeholder="Account Name" value={{ $bank_info->account_name }}></div>
                                                <div class="col-sm-3"><input type="text" name="account_number[]" class="form-control" placeholder="Account Number" value={{ $bank_info->account_number }}></div>
                                                <div class="col-sm-3"><input type="text" name="routing_number[]" class="form-control" placeholder="Routing Number" value={{ $bank_info->routing_number }}></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            @if ($key == 0)
                                                <button type="button" class="btn btn-primary" onclick="addBankInfoRow()">Add More</button>
                                            @else
                                                <div class="col-sm-1">
                                                    <button type="button" class="btn btn-primary" onclick="removeBankInfoRow(this)">Remove</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
            </div>
        </form>
        <!--===================================================-->
        <!--End Horizontal Form-->

        <div class="hide" id="bank_info_row">
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">{{__('Bank Information')}}</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-3"><input type="text" name="bank_name[]" class="form-control" placeholder="Bank Name"></div>
                            <div class="col-sm-3"><input type="text" name="account_name[]" class="form-control" placeholder="Account Name"></div>
                            <div class="col-sm-3"><input type="text" name="account_number[]" class="form-control" placeholder="Account Number"></div>
                            <div class="col-sm-3"><input type="text" name="routing_number[]" class="form-control" placeholder="Routing Number"></div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-primary" onclick="removeBankInfoRow(this)">Remove</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function(){

            $('#type').on('change', function(){
                if($('#type').val() == 'bank_payment'){
                    $('#bank_payment_data').show();
                }
                else {
                    $('#bank_payment_data').hide();
                }
            });
        });

        function addBankInfoRow(){
            $('#bank_payment_informations').append($('#bank_info_row').html());
        }

        function removeBankInfoRow(el){
            $(el).closest('.form-group').remove();
        }

    </script>
@endsection
