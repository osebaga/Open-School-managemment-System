<?php

if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins" xmlns="http://www.w3.org/1999/html">
    <div class="ibox-title clearfix">

    <h5 style="font-size:xx-large">Registration Fee(Non-Refundable)</h5>
            
    </div>
    <div class="ibox-content">
 <div class="row">
     <!--<div class="col-md-4">-->
 <div class="col-md-12">
 <?php
 //echo'$professional_info->category'.$professional_info->category;
 $uid = $CURRENT_USER->id;
  $ActiveYear=$this->common_model->get_academic_year()->row()->AYear;
  $Paid_amount = $this->applicant_model->get_paid_registration_fee($APPLICANT->id,1,$ActiveYear);

//   if($APPLICANT->application_category == 'Center')
//  {     
//     $application_fee_current=200000;   
//  }else
//  {
//        $application_fee_current=APPLICATION_FEE;
//  }


 $registration_fee = $this->db->query("select * from fee_structure where fee_code=8 ")->row();
 $application_fee_current = $registration_fee->amount;
 $amount_required = $application_fee_current;

 if($invoice_info->status==1)
 {
      $file=$invoice_info->control_number.'.png';
     $url='http://41.59.225.216/qr/';
     $exists = remoteFileExists($url.'/Qrcode/images/'.$file);
     if(!$exists)
     {
             //$url=base_url()."Qrcode/qrcode.php";
            $this->collegeinfo = get_collage_info();

            //$student_info=$this->db->query("select * from students where id=".$invoice_info->student_id)->row();
             $date=date("Y-m-d",strtotime($invoice_info->timestamp));
             $message=array(
                 "opType"=>2,
                 "shortCode"=>"001001",
                 "billReference"=>$invoice_info->control_number,
                 "amount"=>$invoice_info->amount,
                 "billCcy"=>'TZS',
                 "billExprDt"=>date("Y-m-d",strtotime(($date .' + 180days'))),
                 "billPayOpt"=>3,
                 "billRsv01"=>$this->collegeinfo->Name.$APPLICANT->FirstName. ' ' . $APPLICANT->LastName
             );
             $message=json_encode($message);

             $postdata = array(
                 "title" => $message,
                 "control" =>$invoice_info->control_number ,

             );

             sendDataOverPost($url,$postdata);

     }
 }


      if($Paid_amount < $amount_required  && $invoice_info->status<>2)
      {?>

     <div class="col-md-12">
         <h2 style="font-size:xx-large"" >Use below control number to make payments </h2>
         <strong><p style="color:green;font-size:xx-large;font-weight: bold" >Control number :
                 <span><?php echo isset($invoice_info) ? $invoice_info->control_number : ''; ?></span></p></strong>
         <strong><p style="color:green;font-size:xx-large"">Amount required:
                 <span><?php /*if($professional_info->category==3){ echo number_format(STUDENT_APPLICATION_FEE); } else { echo number_format(APPLICATION_FEE);}*/
                     echo number_format($application_fee_current); ?></span> TSH </p></strong>
         <?php
         if($invoice_info)
         {
           if($invoice_info->control_number)
           {
               $file=$invoice_info->control_number.'.png';
               $url='http://41.59.225.216/qr/';
               $exists = remoteFileExists($url.'/Qrcode/images/'.$file);
               if($exists) {
                   echo'<img src="'.$url.'Qrcode/images/'.$file.'" width="260">';
               }
           }
         }

         ?>
     </div>

     <div class="col-md-8">

         <?php
         }else
         {

         ?>

         <div class="col-md-12">
             <table class="table table-striped table-bordered dt-responsive  text-align"  id="datatable" width="100%">
                 <thead>
                 <tr>
                     <th style="width: 50px;">S/No</th>
                     <th style="width: 100px;">Date</th>
                     <th style="width: 100px;">Control No</th>
                     <th style="width: 100px;">Mobile</th>
                     <th style="width: 100px;">Receipt</th>
                     <th style="width: 100px;">Amount</th>
                     <th style="width: 100px;">Payment For</th>
                     <th style="width: 100px;">Payment Provider</th>
                     <?php if($Paid_amount > $amount_required){
                         ?>
                         <th style="width: 100px;">Print Receipt</th>
                     <?php
                     } ?>


                 </tr>
                 </thead>
                 <tbody>
                 <?php
                 $page = 1;
                 $payment_fee = $this->db->query("select * from payment where control_number='$invoice_info->control_number'")->result();
                //  var_dump($payment_fee);exit;
                 foreach ($payment_fee as $key => $value) {
                     $invoice_payed=$this->db->query("select * from invoices where id=" . $value->invoice_number)->row();
                     if($invoice_payed)
                     {
                         $payed_for=$invoice_payed->type;
                     }

                     ?>
                     <tr>
                         <td><?php echo $page; ?></td>
                         <td><?php echo $value->transaction_date; ?></td>
                         <td><?php echo $value->control_number; ?></td>
                         <td><?php echo $value->payer_mobile; ?></td>
                         <td><?php echo $value->receipt_number; ?></td>
                         <td><?php echo $value->paid_amount; ?></td>
                         <td><?php echo (isset($invoice_payed->type))?$invoice_payed->type:''; ?></td>
                         <td><?php echo $value->payment_channell; ?></td>
                         <?php if($Paid_amount >= $amount_required){
                             ?>
                             <td> <a href=" <?php  echo ($value->id)? site_url('print_receipt/'.encode_id($value->id)) : '#'; ?>/"<i class="fa fa-print"></i>Print Receipt</a></td>
                             <?php
                         } ?>
                     </tr>
                     <?php
                     $page++;
                 }
                 }?>
           </tbody>
       </table>

       </div>

  </div>

  <div class="form-group">
      <div class="col-lg-12 clearfix">
          <?php
          if ($invoice_info->status==0  ) {
          ?>
                    <a class="btn-info btn-lg" href="javascript:void(0);"
                    id="request_control_number">Get Control Number</a>
          <?php } ?>

      </div>
      <?php if($invoice_info->status==1){?>
      <div class="col-lg-12 clearfix">
          <?php
          if ($Paid_amount < $amount_required and isset($invoice_info)) {
              ?>
              <div class=" col-lg-8 clearfix" align="right">
                  <a href=" <?php echo (isset($invoice_info->status) and $invoice_info->status==1)? site_url('print_invoice/'.encode_id($invoice_info->id)) : '#'; ?>/"<i class="fa fa-print fa-2x"></i>Print Invoice</a></td>
              </div>
              <div class="col-lg-4 clearfix">
                  <a href=" <?php echo (isset($invoice_info->status) and $invoice_info->status==1)? site_url('print_transfer/'.encode_id($invoice_info->id)) : '#'; ?>/"<i class="fa fa-print  fa-2x"></i>Print Transfer</a>
              </div>

          <?php } ?>
      </div>
        <?php }else{?>
            <div class="col-lg-12 clearfix">
          <?php
          if ($Paid_amount < $amount_required and isset($invoice_info)) {
              ?>
              <div class=" col-lg-8 clearfix" align="right">
                  <a href=" <?php echo (isset($invoice_info->status) and $invoice_info->status==1)? site_url('print_invoice/'.encode_id($invoice_info->id)) : '#'; ?>/"<i class="fa fa-print fa-2x"></i>Print Invoice</a></td>
              </div>
              <div class="col-lg-4 clearfix">
                  <a href=" <?php echo (isset($invoice_info->status) and $invoice_info->status==1)? site_url('print_transfer/'.encode_id($invoice_info->id)) : '#'; ?>/"<i class="fa fa-print  fa-2x"></i>Print Transfer</a>
              </div>

          <?php } ?>
      </div>
       <?php } ?>
  </div>

  <div class="row">
    <div class="col-md-12">
      <?php if($Paid_amount < $amount_required and isset($invoice_info)){ ?>
        <hr>
           <h5 style="color: blue;">NOTE : After Payment other link will be available for you to continue to fill your application form. If you fail to pay the application fee within 4 days, then your basic details will be deleted in our system</h5>
        <?php } ?>


    </div>

  </div>
  </div>
     <?php if ($Paid_amount < $amount_required and isset($invoice_info)) { ?>
     <?php

     $html = '<table class="table" cellspacing="0" cellpadding="3">
    <thead>
    <tr>
        <th style="width: 50px;">Jinsi ya Kulipa</th>
        <th style="text-align: center; width: 100px;">How to Pay</th>
        
        
    </tr>
    </thead>
    <tbody>';

     $html .= ' <tr>
            <td style="text-align: left;">1. Kupitia Bank:  Fika tawi lolote au wakala wa benki ya 
            NMB. Number ya kumbukumbu: <b>'.$invoice_info->control_number.'</b>
            </td>
            <td style="text-align: left;">1. Via Bank: Visit any branch or bank agent of  
            NMB. Reference number: <b>'.$invoice_info->control_number.'</b>
            </td>
                      
        </tr>
        <tr>
            <td >2. Kupitia Mitandao ya Simu
            <ul>
            <li>Ingia kwenye menyu  ya mtandao husika</li>
            <li>Chagua 4(Lipa Bill)</li>
            <li>Chagua 5(Malipo ya serikali)</li>
            <li>Ingiza <b>'.$invoice_info->control_number.'</b> kama number ya kumbukumbu</li>
         </ul>
        
            </td>
            <td >2. Via mobile network operators MNO: Enter to the respective USSD Menu of MNO
            <ul>
            <li>Select 4(Make Payment)</li>
            <li>Select 5(Government Payments)</li>
            <li>Enter <b>'.$invoice_info->control_number.'</b> as referrence number</li>
            </ul>
       
            </td>            
        </tr>
    </tbody>
</table>';

echo $html;

     }?>
     </div>
 </div>


</div>



<script>
    $(function(){
        $(".select2_search").select2({
            theme: "bootstrap",
            placeholder: " [ Select Principal ] ",
            allowClear: true
        });

    })
</script>
<script>
    $(document).ready(function () {

        $('.mydate_input').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            // endDate:"31-12-2004"
        });

        $(".select50").select2({
                theme:'bootstrap',
                placeholder:'[ Select Country ]',
                allowClear:true
            });
        $(".select51").select2({
                theme:'bootstrap',
                placeholder:'[ Select Nationality ]',
                allowClear:true
            });

    })
</script>

<script>
    $(document).ready(function () {

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
                }
            });
        },3000)
        <?php } ?>

        $("#request_control_number").click(function () {
            $(this).html('Please wait.....');
           
            $.ajax({
                url:'<?php echo site_url('applicant/request_center_registration_fee') ?>',
                type:'POST',
                success:function(data)
                {
                        window.location.reload();
                }
            });
        });

    });
</script>
