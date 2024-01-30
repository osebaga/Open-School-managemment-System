<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Application Fee Payment</h5>
<!--          --><?php //if(!is_section_used('PAYMENT',$APPLICANT_MENU)){ ?>
<!--                 <a class="btn btn-small btn-sm btn-success pull-right" href="javascript:void(0);" id="fake_pay">Fake Payment</a>-->
<!--          --><?php //} ?>
        </div>
    </div>

    <div class="ibox-content">
         <div style="margin-bottom: 15px; color: green; font-weight: bold;">Payment amount required is TZS : <?php echo number_format(($APPLICANT->application_type!=3 ? APPLICATION_FEE:APPLICATION_FEE_POSTGRADUATE)); ?>. Please pay this amount only</div>
        <h3>Your Reference Number for payment is : <?php echo REFERENCE_START.$APPLICANT->id ?></h3>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 50px;">S/No</th>
                <th style="text-align: center; width: 100px;">Reference</th>
                <th style="text-align: center; width: 100px;">Mobile No</th>
                <th style="text-align: center; width: 100px;">Receipt</th>
                <th style="text-align: center; width: 100px;">Amount</th>
                <th style="text-align: center; width: 150px;">Trans Time</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $payment_transaction = $this->db->where('applicant_id',$APPLICANT->id)->get("application_payment")->result();
            $total_amount = 0;
            $total_charge = 0;

            foreach ($payment_transaction as $key=>$value){
                $total_amount += $value->amount;
                $total_charge += $value->charges;
                ?>
                <tr>
                    <td style="text-align: right;"><?php echo $key+1; ?> .</td>
                    <td style="text-align: center;"><?php echo $value->reference ?></td>
                    <td style="text-align: center;"><?php echo $value->msisdn ?></td>
                    <td style="text-align: center;"><?php echo $value->receipt ?></td>
                    <td style="text-align: right;"><?php echo number_format(($value->amount+$value->charges),2) ?></td>
                    <td style="text-align: center;"><?php echo $value->createdon ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td style="text-align: right;" colspan="4">Total</td>
                <td style="text-align: right;"><?php echo number_format(($total_amount+$total_charge),2) ?></td>
                <td style="text-align: center;"></td>
            </tr>
            </tbody>
        </table>




        <?php if(!is_section_used('PAYMENT',$APPLICANT_MENU)){ ?>
            <h5 style="color: blue;">NOTE : After Payment other link will be available for you to continue to fill your application form. If you fail to pay the application fee within 4 days, then your basic details will be deleted in our system</h5>
            <div style="padding-top: 20px;">
                <h2>Choose Method to Pay</h2>
              <div class="clearfix">
                  <div class="col-md-4" style="text-align: center;">
                      <img style="width: 200px; height: 80px;"  src="<?php echo base_url() ?>/icon/tigo_pesa.png" class="pay_method1" title="tigopesa" >
                      <div style="margin-top: 10px;"><input type="radio"  value="tigopesa" name="pay_method" class="pay_method"/></div>
                  </div>
                  <div class="col-md-4" style="text-align: center;">
                      <img style="width: 170px; height: 80px;" src="<?php echo base_url() ?>/icon/mpesa.jpg" class="pay_method1" title="mpesa" >
                      <div style="margin-top: 10px;"><input type="radio"  value="mpesa" name="pay_method" class="pay_method"/></div>

                  </div>
                  <div class="col-md-3" style="text-align: center;">
                      <img style="width: 170px; height: 80px;" src="<?php echo base_url() ?>/icon/airtel.jpg" class="pay_method1" title="airtel" >
                      <div style="margin-top: 10px;"><input type="radio" value="airtel" name="pay_method" class="pay_method"/></div>
                  </div>
              </div>
                <div id="tigopesa" style="display: none;">
                    <div style="font-size: 16px; font-weight: bold; padding-top: 20px; color: brown;">Tigo Pesa : Follow steps to pay</div>
                     <div style="padding-left: 100px; font-size: 15px;">
                         1. Dial <b>*150*01#</b><br/>
                         2. Select  4  <b>" Pay Bill "</b> <br/>
                         3. Select 3  <b>" Enter Busness Number "</b><br/>
                         4. Enter <b>400700</b> <br/>
                         5. Enter Reference Number <b>" Enter <?php echo REFERENCE_START.$APPLICANT->id ?>"</b><br/>
                         6. Enter amount  <b>" Enter <?php echo number_format(($APPLICANT->application_type!=3 ? APPLICATION_FEE:APPLICATION_FEE_POSTGRADUATE)); ?> "</b> <br/>
                         7. Enter Password  <b>" Enter your account Password "</b>
                     </div>
                </div>
                <div id="mpesa" style="display: none;">
                    <div style="font-size: 16px; font-weight: bold; padding-top: 20px; color: brown;">M-Pesa : Follow steps to pay</div>
                    <div style="padding-left: 100px; font-size: 15px;">
                        1. Dial <b>*150*00#</b><br/>
                        2. Select  4  <b>" Pay Bill "</b> <br/>
                        3. Select 4  <b>" Enter Busness Number "</b><br/>
                        4. Enter <b>400700</b> <br/>
                        5. Enter Reference Number <b>" Enter <?php echo REFERENCE_START.$APPLICANT->id ?>"</b><br/>
                        6. Enter amount  <b>" Enter <?php echo number_format(($APPLICANT->application_type!=3 ? APPLICATION_FEE:APPLICATION_FEE_POSTGRADUATE)); ?> "</b> <br/>
                        7. Enter Password  <b>" Enter your account Password "</b><br/>
                        8. Enter 1 <b>" To agree "</b>
                    </div>
                </div>
                <div id="airtel" style="display: none;" >
                    <div style="font-size: 16px; font-weight: bold; padding-top: 20px; color: brown;">Airtel Money : Follow steps to pay</div>
                    <div style="padding-left: 100px; font-size: 15px;">
                        1. Dial <b>*150*60#</b><br/>
                        2. Select  5  <b>" Make Payments "</b> <br/>
                        3. Select 3  <b>" Enter Busness Number "</b><br/>
                        4. Enter <b>400700</b> <br/>
                        5. Enter Reference Number <b>" Enter <?php echo REFERENCE_START.$APPLICANT->id ?>"</b><br/>
                        6. Enter amount  <b>" Enter <?php echo number_format(($APPLICANT->application_type!=3 ? APPLICATION_FEE:APPLICATION_FEE_POSTGRADUATE)); ?> "</b> <br/>
                        7. Enter Password  <b>" Enter your account Password "</b><br/>
                    </div>
                </div>
            </div>
          <?php }else{ ?>
<!--            <div style="text-align: right; margin-right: 30px;"><a href="<?php /*echo site_url('applicant_profile') */?>" class="btn btn-sm btn-success"><i class="fa fa-angle-double-right"></i> Next Step</a></div>-->
        <?php } ?>

<input type="hidden" value="" id="paid_all" />






    </div>
</div>

<script>
    $(document).ready(function () {
        $("#fake_pay").click(function () {
            $(this).html('Please wait.....');
            $.ajax({
                url:'<?php echo site_url('applicant/fakepay') ?>',
                type:'POST'
            });
        });


        $(".pay_method1").click(function () {
           var title = $(this).attr('title');
            $('input:radio[name=pay_method][value='+title+']').prop("checked","checked").change();
        });


        $(".pay_method").change(function () {
            var pay_method = $(this).val();
           if(pay_method =='tigopesa'){
               $("#tigopesa").show();
               $("#airtel").hide();
               $("#mpesa").hide();
           }else if(pay_method =='airtel'){
               $("#airtel").show();
               $("#tigopesa").hide();
               $("#mpesa").hide();
           }else if(pay_method =='mpesa'){
               $("#mpesa").show();
               $("#tigopesa").hide();
               $("#airtel").hide();
           }
        });

        <?php if(!is_section_used('PAYMENT',$APPLICANT_MENU)){ ?>
        setInterval(function(){
            $.ajax({
                type:"post",
                url:"<?php echo site_url('is_applicant_pay') ?>",
                datatype:"html",
                success:function(data)
                {
                    if(data == '1'){
                        window.location.reload();
                    }
                    //do something with response data
                }
            });
        },3000)
        <?php } ?>
    });
</script>
