
<div class="modal fade" id="bankinfocreate_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="text" name="c_ac_holder" class="form-control" id="ac_holder" placeholder="Enter A/C holer name">
                        <div id="c_ac_holder" class="text-danger error_msgs" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">A/C Number</label>
                        <input type="text" name="c_ac_no" class="form-control" id="ac_no" placeholder="Enter A/C Number">
                        <div id="c_ac_no" class="text-danger error_msgs" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">IBAN Number</label>
                        <input type="text" name="c_iban_number" class="form-control" id="iban_number" placeholder="Enter IBAN Number">
                        <div id="c_iban_number" class="text-danger error_msgs" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bank Name</label>
                        <input type="text" name="c_bank_name" class="form-control" id="bank_name" placeholder="Enter Bank Name">
                        <div id="c_bank_name" class="text-danger error_msgs" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bank Address (Optional)</label>
                        <input type="text" name="c_address" class="form-control" id="address" placeholder="Enter Bank Address">
                        <div id="c_address" class="text-danger error_msgs" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bank Routing No. (Optional)</label>
                        <input type="text" name="c_routing_no" class="form-control" id="routing_no" placeholder="Enter Bank Routing Number">
                        <div id="c_routing_no" class="text-danger error_msgs" style="display:none"></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select class="form-control" name="c_status" id="status">
                            <option value="">--- Select One ---</option>
                            <option value="primary">Primary Account</option>
                            <option value="secondary">Secondary Account</option>
                        </select>
                        <div id="c_status" class="text-danger error_msgs" style="display:none"></div>
                    </div>
                    <div class="text-right mt-4">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('cancel')}}</button>
                        <button type="submit" class="btn btn-base-1 btn_create">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".btn_create").click(function(e){
            e.preventDefault();

            var ac_holder = $("input[name='c_ac_holder']").val();
            var ac_no = $("input[name='c_ac_no']").val();
            var iban_number = $("input[name='c_iban_number']").val();
            var bank_name = $("input[name='c_bank_name']").val();
            var address = $("input[name='c_address']").val();
            var routing_no = $("input[name='c_routing_no']").val();
            var status = $("select[name='c_status']").val();
            console.log(ac_holder);

            $.ajax({
                url: "{{ route('bankinfo.store') }}",
                type:'POST',
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
            $(".error_msgs").css('display','block');
            $("#c_ac_holder").append(msg['ac_holder']);
            $("#c_ac_no").append(msg['ac_no']);
            $("#c_iban_number").append(msg['iban_number']);
            $("#c_bank_name").append(msg['bank_name']);
            $("#c_address").append(msg['address']);
            $("#c_routing_no").append(msg['routing_no']);
            $("#c_status").append(msg['status']);
        }
    });
</script>
