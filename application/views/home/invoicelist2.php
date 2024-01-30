<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Student Invoices</h5></div>

    </div>


    <div class="ibox-content">

        <?php  echo form_open(current_full_url(), '  method="GET" class="form-horizontal ng-pristine ng-valid"') ?>

        <div class="form-group no-padding">

            <div class="col-md-5">
                <input type="text"
                       value=""
                       class="form-control"  name="regno" placeholder="Enter Registration number "/>

            </div>

            <div class="col-md-1">
                <input type="submit" value="Search" class="btn btn-success btn-sm">
            </div>
        </div>

        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive  text-align"  id="datatable" width="100%">

                <thead>
                <tr>
                    <th><div>S/No</div></th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>GfsCode</th>
                    <th>Control Number</th>
                    <th>Select</th>
                    <th>Print Bill</th>
                    <th>Print Transfer</th>


                </tr>
                </thead>
                <tbody>
                <?php
                $page = ($this->uri->segment(2) ? ($this->uri->segment(2) + 1) : 1);
                foreach ($invoice_list as $invoice_key => $invoice_value) {
                    $current_student_info=$this->db->query("select * from application where id='".$invoice_value->student_id."'")->row();
                    //$amount_paid = $this->db->select_sum('amount')->where(array('applicant_id' => $applicant_value->id))->get('application_payment')->row();
                    ?>
                    <tr>
                        <td style="text-align: right;"><?php echo $page++; ?></td>
                        <td style="text-align: left;"><?php echo $invoice_value->timestamp; ?></td>
                        <td style="text-align: left;"><?php echo isset($current_student_info) ? ucfirst($current_student_info->FirstName).' '.ucfirst($current_student_info->MiddleName).' '.ucfirst($current_student_info->LastName) : $invoice_value->student_name; ?></td>
                        <td style="text-align: left;"><?php echo $invoice_value->amount; ?></td>
                        <td style="text-align: left;"><?php echo $invoice_value->GfsCode; ?></td>
                        <td style="text-align: left;"><?php echo $invoice_value->control_number; ?></td>

                        <td>
                            <input type="checkbox" name="txtSelect[]" value="<?php  echo $invoice_value->id?>"
                                <?php if(($invoice_value->status==2))
                                    echo"disabled"; ?> />
                        </td>
                        <td style="text-align: left;"><a href=" <?php echo (isset($invoice_value->status) and $invoice_value->status==1)? site_url('print_student_invoice/'.encode_id($invoice_value->id)) : '#'; ?>/"<i class="fa fa-print   "></i>Print</a></td>
                        <td style="text-align: left;"><a href=" <?php echo (isset($invoice_value->status) and $invoice_value->status==1)? site_url('print_student_transfer/'.encode_id($invoice_value->id)) : '#'; ?>/"<i class="fa fa-print   "></i>Print</a></td>


                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

            <div>
                <div style="clear: both;"></div>
           <a class="btn btn-primary" href=" <?php echo (isset($_GET['regno'])) ? site_url('student_invoices/?regno='.$_GET['regno']) : '#'; ?>"<i class="fa fa-refresh   "></i>Get Control Number</a>

            <div class="pull-right">
            <a href="javascript:history.go(-1)" class="btn btn-sm btn-success" >Go Back </a>

           </div>
            </div>
            <?php echo form_close();
            ?>
        </div>


        <?php echo form_close(); ?>

        <div style="clear: both;"></div>
        <div style="padding-top: 20px;">
            <?php

             $html .= '<table class="table" cellspacing="0" cellpadding="3">
    <thead>
    <tr>
        <th style="width: 50px;">Jinsi ya Kulipa</th>
        <th style="text-align: center; width: 100px;">How to Pay</th>
        
        
    </tr>
    </thead>
    <tbody>';

            $html .= ' <tr>
            <td style="text-align: left;">1. Kupitia Bank:  Fika tawi lolote au wakala wa benki ya 
            NMB,BOT. Number ya kumbukumbu: <b>[Control Number]</b>
            </td>
            <td style="text-align: left;">1. Via Bank: Visit any branch or bank agent of  
            NMB,BOT. Reference number: <b>[Control Number]</b>
            </td>
                      
        </tr>
        <tr>
            <td >2. Kupitia Mitandao ya Simu
            <ul>
            <li>Ingia kwenye menyu  ya mtandao husika</li>
            <li>Chagua 4(Lipa Bill)</li>
            <li>Chagua 5(Malipo ya serikali)</li>
            <li>Ingiza <b> [Control Number] </b> kama number ya kumbukumbu</li>
         </ul>
        
            </td>
            <td >2. Via mobile network operators MNO: Enter to the respective USSD Menu of MNO
            <ul>
            <li>Select 4(Make Payment)</li>
            <li>Select 5(Government Payments)</li>
            <li>Enter <b> [Control Number] </b> as referrence number</li>
            </ul>
       
            </td>            
        </tr>
    </tbody>
</table>';

            echo $html;
            ?>


        </div>
</div>

<script>
    $(document).ready(function () {
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
    });
</script>