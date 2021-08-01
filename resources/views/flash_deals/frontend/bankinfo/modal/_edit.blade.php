

@foreach ($bankinfos as $key => $bankinfo)
<div class="modal fade" id="bankinfoedit_modal{{ $bankinfo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
        <div class="modal-content position-relative">
            <div class="modal-header">
                <h5 class="modal-title strong-600 heading-5">{{__('Update your bank information')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-3 pt-3">
                {{-- <form class="" action="{{ route('bankinfo.update', $bankinfo->id) }}" method="POST" enctype="multipart/form-data"> --}}
                    <form>
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">A/C Holder Name</label>
                        <input type="text" name="ac_holder{{ $bankinfo->id}}" class="form-control" id="ac_holder" placeholder="Enter A/C holer name" value="{{ $bankinfo->ac_holder }}">
                        <div id="ac_holder_err{{ $bankinfo->id}}" class="text-danger error_msg" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">A/C Number</label>
                        <input type="text" name="ac_no{{ $bankinfo->id}}" class="form-control" id="ac_no" placeholder="Enter A/C Number" value="{{ $bankinfo->ac_no }}">
                        <div id="ac_no_err{{ $bankinfo->id}}" class="text-danger error_msg" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">IBAN Number</label>
                        <input type="text" name="iban_number{{ $bankinfo->id}}" class="form-control" id="iban_number" placeholder="Enter IBAN Number" value="{{ $bankinfo->iban_number }}">
                        <div id="iban_number_err{{ $bankinfo->id}}" class="text-danger error_msg" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bank Name</label>
                        <input type="text" name="bank_name{{ $bankinfo->id}}" class="form-control" id="bank_name" placeholder="Enter Bank Name" value="{{ $bankinfo->bank_name }}">
                        <div id="bank_name_err{{ $bankinfo->id}}" class="text-danger error_msg" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bank Address (Optional)</label>
                        <input type="text" name="address{{ $bankinfo->id}}" class="form-control" id="address" placeholder="Enter Bank Address" value="{{ $bankinfo->address }}">
                        <div id="address_err{{ $bankinfo->id}}" class="text-danger error_msg" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bank Routing No. (Optional)</label>
                        <input type="text" name="routing_no{{ $bankinfo->id}}" class="form-control" id="routing_no" placeholder="Enter Bank Routing Number" value="{{ $bankinfo->routing_no }}">
                        <div id="routing_no_err{{ $bankinfo->id}}" class="text-danger error_msg" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select class="form-control" name="status{{ $bankinfo->id}}" id="status">
                            <option {{ $bankinfo->status == 'primary' ? 'selected' : '' }}  value="primary">Primary Account</option>
                            <option {{ $bankinfo->status == 'secondary' ? 'selected' : '' }} value="secondary">Secondary Account</option>
                        </select>
                        <div id="status_err{{ $bankinfo->id}}" class="text-danger error_msg" style="display:none"></div>
                    </div>
                    <div class="text-right mt-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('cancel')}}</button>
                        <button type="submit" class="btn btn-base-1 bank_submit{{ $bankinfo->id}}">{{__('Update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".bank_submit{{ $bankinfo->id}}").click(function(e){
            e.preventDefault();

            var ac_holder = $("input[name='ac_holder{{ $bankinfo->id}}']").val();
            var ac_no = $("input[name='ac_no{{ $bankinfo->id}}']").val();
            var iban_number = $("input[name='iban_number{{ $bankinfo->id}}']").val();
            var bank_name = $("input[name='bank_name{{ $bankinfo->id}}']").val();
            var address = $("input[name='address{{ $bankinfo->id}}']").val();
            var routing_no = $("input[name='routing_no{{ $bankinfo->id}}']").val();
            var status = $("select[name='status{{ $bankinfo->id}}']").val();
            console.log("{{ $bankinfo->id}}");

            $.ajax({
                url: "{{ route('bankinfo.update', $bankinfo->id) }}",
                type:'PUT',
                data: {
                    ac_holder:ac_holder,
                    ac_no:ac_no,
                    iban_number:iban_number,
                    bank_name:bank_name,
                    address:address,
                    routing_no:routing_no,
                    status:status,
                },
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        // alert(data.success);
                        window.location.replace("{{ route('bankinfo.index') }}");
                    }else{
                        console.log(data.error);
                        printErrorMsg(data.error);
                    }
                }
            });
        });
        function printErrorMsg (msg) {
            $(".error_msg").css('display','block');
            $("#ac_holder_err{{ $bankinfo->id}}").append(msg['ac_holder']);
            $("#ac_no_err{{ $bankinfo->id}}").append(msg['ac_no']);
            $("#iban_number_err{{ $bankinfo->id}}").append(msg['iban_number']);
            $("#bank_name_err{{ $bankinfo->id}}").append(msg['bank_name']);
            $("#address_err{{ $bankinfo->id}}").append(msg['address']);
            $("#routing_no_err{{ $bankinfo->id}}").append(msg['routing_no']);
            $("#status_err{{ $bankinfo->id}}").append(msg['status']);
        }
    });
</script>

@endforeach
