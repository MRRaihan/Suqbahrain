@extends('layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Manual Payment Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('manual_payment_methods.store') }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="type">{{__('Type')}}</label>
                    <div class="col-sm-10">
                        <select class="form-control demo-select2-placeholder" name="type" id="type" required>
                            <option value="custom_payment">{{__('Custom Payment')}}</option>
                            <option value="bank_payment">{{__('Bank Payment')}}</option>
                            <option value="check_payment">{{__('Check Payment')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Name')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="heading" value="" placeholder="Name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="photo">{{__('Checkout Thumbnail')}} (438x235)px</label>
                    <div class="col-sm-10">
                        <input type="file" id="photo" name="photo" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{__('Payment Instruction')}}</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="editor" data-buttons='bold,underline,italic,hr,|,ul,ol,|,align,paragraph,|,image,table'></textarea>
                    </div>
                </div>
                <div id="bank_payment_data">
                    <div id="bank_payment_informations">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 control-label">{{__('Bank Information')}}</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-3"><input type="text" id="bank_name" name="bank_name[]" class="form-control" placeholder="Bank Name"></div>
                                        <div class="col-sm-3"><input type="text" id="account_name" name="account_name[]" class="form-control" placeholder="Account Name"></div>
                                        <div class="col-sm-3"><input type="text" id="account_number" name="account_number[]" class="form-control" placeholder="Account Number"></div>
                                        <div class="col-sm-3"><input type="text" id="routing_number" name="routing_number[]" class="form-control" placeholder="Routing Number"></div>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-primary" onclick="addBankInfoRow()">Add More</button>
                                </div>
                            </div>
                        </div>
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
            $('#bank_payment_data').hide();

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
