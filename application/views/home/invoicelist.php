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
                <button type="submit" onclick="return confirm_submit('Are you sure');"  name="resubmit_selected" class="btn btn-sm btn-success pull-left">Get control  Number</button>
            </div>
            <?php echo form_close();
            ?>
        </div>


        <?php echo form_close(); ?>

        <div style="clear: both;"></div>
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
                    4. Enter <b>001001</b> <br/>
                    5. Enter Reference Number <b>" Enter your control number <?php echo isset($invoice_info) ? $invoice_info->control_number : ''; ?>"</b><br/>
                    6. Enter amount  <b>" Enter <?php echo $application_fee_current ?> "</b> <br/>
                    7. Enter Password  <b>" Enter your account Password "</b>
                </div>
            </div>
            <div id="mpesa" style="display: none;">
                <div style="font-size: 16px; font-weight: bold; padding-top: 20px; color: brown;">M-Pesa : Follow steps to pay</div>
                <div style="padding-left: 100px; font-size: 15px;">
                    1. Dial <b>*150*00#</b><br/>
                    2. Select  4  <b>" Pay Bill "</b> <br/>
                    3. Select 4  <b>" Enter Busness Number "</b><br/>
                    4. Enter <b>001001</b> <br/>
                    5. Enter Reference Number <b>" Enter  your control number <?php echo isset($invoice_info) ? $invoice_info->control_number : ''; ?>"</b><br/>
                    6. Enter amount  <b>" Enter <?php echo $application_fee_current ?> "</b> <br/>
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
                    4. Enter <b>001001</b> <br/>
                    5. Enter Reference Number <b>" Enter your control number <?php echo isset($invoice_info) ? $invoice_info->control_number : ''; ?>"</b><br/>
                    6. Enter amount  <b>" Enter <?php echo $application_fee_current ?> "</b> <br/>
                    7. Enter Password  <b>" Enter your account Password "</b><br/>
                </div>
            </div>
            <h2><b>In Summary payment Procedures through
                    mobile networks are as follows:</b></h2>
            <div style="padding-left: 90px; font-size: 20px;">
                <b> 1. Dial *150*01#, or *150*00# or *150*60# or *150*88# or *150*71#
                    or *150*02# for (Tigo Pesa, M-Pesa, Airtel Money, Halo Pesa TTCL Pesa
                    and Ezy Pesa) respectively.</b><br/>
                2. Select Pay bills</b><br/>
                3. Enter Busness Number <b>001001</b></b><br/>
                4. Enter Control Number <b><?php echo isset($invoice_info) ? $invoice_info->control_number : ''; ?></b><br/>
                5. Enter Due Amount <b><?php echo $application_fee_current ?> </b><br/>
                6. Confirm (By entering your pin number)

            </div>

            <h2><b>Via Banks</b></h2>
            <div style="padding-left: 90px; font-size: 20px;">
                <b> Visit any branch or bank agent of CRDB
                    NMB,BOT. Reference number: Control Number</b>

            </div>



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