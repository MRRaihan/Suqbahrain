<!-- withdraw Modal -->
<div class="modal account-modal fade multi-step" id="_withdraw" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-0 border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="login-header">
                    <h3>{{ __('Are you want to withdraw your amount with this bank information?') }}</h3>
                    <p class="text-muted">{{ __('If not, Change primary bank information by click') }}
                        <a href="{{ route('bankinfo.index')}}">
                            {{ __(' Here.') }}
                        </a>

                    </p>
                </div>
                <table class="table table-striped">
                    <tbody>
                      <tr>
                        <th scope="row">Account Name :</th>
                        <td>{{$bankinfo->ac_holder}}</td>
                      </tr>
                      <tr>
                        <th scope="row">Bank Name :</th>
                        <td>{{$bankinfo->bank_name}}</td>
                      </tr>
                      <tr>
                        <th scope="row">Account No. :</th>
                        <td>{{$bankinfo->ac_no}}</td>
                      </tr>
                      <tr>
                        <th scope="row">IBAN No. :</th>
                        <td class="text-danger">{{$bankinfo->iban_number}}</td>
                      </tr>
                      <tr>
                        <th scope="row">Withdrawable Amount :</th>
                        <td class="text-danger">{{ floor($availbleProfit) }}</td>
                      </tr>
                      <tr>
                        <td colspan="2" scope="row"> After this withdraw, Your next withdraw available after 30 days.</th>
                        {{-- <td class="text-danger">{{ floor($availbleProfit) }}</td> --}}
                      </tr>
                    </tbody>
                  </table>
                {{-- <form method="POST" action="{{ route('withdraw.store') }}"> --}}
                <form>
                    {{ csrf_field() }}
                    <input type="hidden" name="bank_info_id" value="{{ $bankinfo->id }}">
                    <input type="hidden" name="withdraw_amount" value="{{ floor($availbleProfit) }}">

                    {{-- <div class="form-group">
                        <div class="custom-control custom-control-xs custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="agree_term"
                                   id="Mianr" checked disabled>
                            <label class="custom-control-label" for="Mianr">I agree
                                to suqbahrain </label> <a tabindex="-1" href="javascript:void(0);">Privacy
                                Policy</a> &amp; <a tabindex="-1" href="javascript:void(0);"> Terms.</a>
                        </div>
                    </div> --}}

                    <div id="agree_term_err" class="text-danger error_msg" style="display:none"></div>

                    <div class="form-group">
                     <button class="btn btn-info login-btn btn-submit">{{ __('Submit') }}</button>


                     <a href="{{ route('dashboard')}}" class="text-white btn btn-danger">{{ __('Cancel') }}</a>

                     {{-- <button class="btn btn-info login-btn">{{ __('Submit') }}</button> --}}
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- /Withdraw Modal -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $(".btn-submit").click(function(e){
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var bank_info_id = $("input[name='bank_info_id']").val();
            var withdraw_amount = $("input[name='withdraw_amount']").val();
            var agree_term = $("input[name='agree_term']").val();
            console.log(agree_term);
            $.ajax({
                url: "{{ route('withdraw_amount.store') }}",
                type:'POST',
                data: {
                    _token:_token,
                    bank_info_id,
                    withdraw_amount,
                    agree_term:agree_term
                },
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        console.log(data.success)
                        // alert(data.success);
                        window.location.replace("{{ route('withdraw_amount.index') }}");
                    }else{
                        console.log(data.error);
                        // alert(data.error);
                        window.location.replace("{{ route('dashboard') }}");
                        // printErrorMsg(data.error);
                    }
                }
            });
        });
        function printErrorMsg (msg) {
            // $(".print-error-msg").find("ul").html('');

            // $(".error_msg").css('display','block');
            // $("#agree_term_err").append(msg['agree_term']);
            // $.each( msg, function( key, value ) {
            //     $(".print-error-msg").find("ul").append(key+'<li>'+value+'</li>');
            //     if(key=='first_name'){
            //     }
            // });

        }
    });
</script>
