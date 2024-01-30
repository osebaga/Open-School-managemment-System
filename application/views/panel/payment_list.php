<?php
$ayear = $this->common_model->get_academic_year()->row()->AYear;
$current_print_title="INVOICE LIST";
$current_file_name="invoice_list_".date("Y-m-d");
$current_pdf_orientation="portrait";//landscape or portrait
$current_column_visibility=":visible";// "" or :visible
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');

}
if (isset($_GET)) {
    $title1 = '';
    if (isset($_GET['from']) && $_GET['from'] <> '') {
        $title1 .= " From :<strong> " . $_GET['from'] . '</strong>';
    }

    if (isset($_GET['to']) && $_GET['to'] <> '') {
        $title1 .= " To :<strong> " . $_GET['to'] . '</strong>';
    }

    if (isset($_GET['fee_type']) && $_GET['fee_type'] <> '') {
        $title1 .= " Revenue Source :<strong> " . $_GET['fee_type'] . '</strong>';
    }

    if (isset($_GET['ntalevel']) && $_GET['ntalevel'] <> '') {

        $title1 .= " Program :<strong> " .$_GET['ntalevel'] . '</strong>';
    }
    if (isset($_GET['center']) && $_GET['center'] <> '') {
        $center = $this->db->query("SELECT * FROM Center WHERE CenterRegNo='".$_GET['center']."' ")->row();

        $title1 .= " Center :<strong> " . $center->CenterName . '</strong>';
    }

    if (isset($_GET['fee']) && $_GET['fee'] <> '') {
        $tit = $_GET['fee'];

        $fees = json_encode($tit);
        $fee_list = json_decode($fees);
        $direct_cost = $fee_list[0];
        $tuition_fee = $fee_list[1];

        if($tuition_fee==''){
            $combine_fee  = '('.$direct_cost.')';

        }else
        {
            $combine_fee  = '('.$direct_cost. ',' .$tuition_fee.')';
        }
        $fee = $this->db->query("SELECT * FROM fee_structure WHERE id IN $combine_fee ")->row();
        $feename = $fee->name;
 
        $title1 .= " Fee Name :<strong> " .$feename . '</strong>';
    }


     if (isset($_GET['year_of_study']) && $_GET['year_of_study'] <> '') {

        $year_of_study_array=array(
                '1'=>'First Year',
                '2'=>'Second Year',
                '3'=>'Third Year'
        );
         $title1 .= "  Year Of Study :<strong> " . $year_of_study_array[$_GET['year_of_study']] . '</strong>';
     }

     if (isset($_GET['ayear']) && $_GET['ayear'] <> '') {
        $title1 .= " Academic Year :<strong> " . $_GET['ayear'] . '</strong>';
    }

    if ($title1 <> '') {
        echo '<div class="alert alert-warning">' . $title1 . '</div>';
    }

}

?>

<div class="ibox">
    <div class="ibox-title">
        <h5>Payment List</h5>
        <!--        <div style="text-align: right;"><a style="font-size: 11px; text-decoration: underline;"-->
        <!--                                           href="--><?php //echo site_url('renotify/?resend=1'); ?><!--">Resend notification by-->
        <!--                Email</a></div>-->
    </div>
    <div class="ibox-content">
        <?php echo form_open(current_full_url(), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group no-padding">


   
            <div  class="  col-sm-4">
                <label for="from date" class="col-sm-3 col-form-label col-form-label-sm">From:</label>
                <div class="col-sm-9">
                <input name="from" placeholder="FROM : DD-MM-YYYY" class="form-control" type="date"
                       value=""/>
                       <!-- value="<?php echo(isset($_GET['from']) ? $_GET['from'] : '') ?>"/> -->

                </div>
            </div>


            <div class="col-md-4">
            <label for="from date" class="col-sm-2 col-form-label col-form-label-sm">To:</label>
                <div class="col-sm-9">
                <input name="to" placeholder="TO : DD-MM-YYYY" class="form-control" type="date"
                       value=""/>
                       <!-- value="<?php echo(isset($_GET['to']) ? $_GET['to'] : '') ?>"/> -->

            </div>
            </div>

            <div class="col-md-3" style="width: 28%;">
                <select name="fee_type" class="form-control">
                    <option value="">[ All Sources ]</option>
                    <?php
                    $fee_type_list=$this->db->query("select * from fee_type")->result();
                    foreach ($fee_type_list as $tkey => $tvalue) {
                        ?>
                        <option <?php echo(isset($_GET['fee_type']) ? ($_GET['fee_type'] == $tvalue->name ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $tvalue->name; ?>"><?php echo $tvalue->name ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>



        </div>


        <div class="form-group" style="margin-left: 8%;">

            <div class="col-sm-3">
                <select name="fee[]" class="form-control" >
                    <!-- <option value=""  >[All Fees]</option> -->

                    <?php
                    $sel = (isset($_GET['fee'])) ? $_GET['fee'] :'';
                    $fee_list=$this->db->query("select * from fee_structure where  hidden=0")->result();
                    foreach($fee_list as $key=>$value)
                    { ?>
                        <option   <?php echo ($sel == $value->id ? 'selected="selected"':''); ?> value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php

                    }
                    ?>
                </select>
            </div>
<!--            <div class="  col-md-3">-->
<!--                <select name="year_of_study"  id="year_of_study" class="select2_search1 form-control " >-->
<!--                    --><?php
//                    $sel = (isset($_GET['year_of_study']) ? $_GET['year_of_study'] : "");
//                    ?>
<!--                    <option  value="">[All  Year Of Study]</option>-->
<!--                    <option --><?php //echo ($sel == 1 ? 'selected="selected"':''); ?><!-- value="1">First Year</option>-->
<!--                    <option --><?php //echo ($sel == 2 ? 'selected="selected"':''); ?><!-- value="2">Second Year</option>-->
<!--                    <option --><?php //echo ($sel == 2 ? 'selected="selected"':''); ?><!-- value="3">Third Year</option>-->
<!---->
<!--                </select>-->
<!--            </div>-->

            <div class="col-sm-3 " style=" margin-left:9%">

                <select name="center"  id="center" class="form-control " >
                    <option  value="">[All Centers]</option>
                    <?php
                    $sel = (isset($_GET['center']) ? $_GET['center'] : "");
                    $center_list=$this->db->query("select * from Center")->result();
                    foreach ($center_list as $tkey => $tvalue) {
                        ?>
                        <option <?php echo(isset($_GET['center']) ? ($_GET['center'] == $tvalue->CenterRegNo ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $tvalue->CenterRegNo; ?>"><?php echo $tvalue->CenterName ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3" style="width: 21%; margin-left:4%">
                <select name="ayear"  id="ayear" class="form-control " >
                    <option  value="">[All Financial Year]</option>
                    <?php
                    $sel = (isset($_GET['ayear']) ? $_GET['ayear'] : "");
                    $year_list=$this->db->query("select * from account_year  order by AYear")->result();
                    foreach($year_list as $key=>$value) {?>
                        <option <?php echo($sel == $value->AYear ? 'selected="selected"' : ''); ?> value="<?php echo $value->AYear  ?>"><?php echo $value->AYear; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-1">
                <input type="submit" value="Search" class="btn btn-success btn-sm">
            </div>
        </div>

        <hr>

        <div class="row">

            <div style="clear: both;"></div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive  text-align"  id="datatable" width="100%">

                    <thead>
                    <tr>
                        <th><div>S/No</div></th>
                        <th>Transaction Date</th>
                        <th>Reg Number</th>
                        <th>Control Number</th>
                        <th>Amount</th>
                        <th>Payer Name</th>
                        <th>Pay For</th>
                        <!-- <th>Reference #</th> -->
                        <!-- <th>Receipt #</th> -->
                        <th>Payer Mobile</th>
                        <!-- <th>Chanell</th> -->
                        <!-- <th>Chanell Name</th> -->
                        <th>Print</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $page = ($this->uri->segment(2) ? ($this->uri->segment(2) + 1) : 1);
                    $total_amount=0;
                    foreach ($payment_list as $payment_key => $payment_value) {

                        $total_amount = ($total_amount + $payment_value->paid_amount);
                        // $sarisdb =$this->load->database('saris',TRUE);
                        // $this->data['campus'] = $sarisdb->query("SELECT Campus FROM student where RegNo='$payment_value->student_id'")->row();
                        //$amount_paid = $this->db->select_sum('amount')->where(array('applicant_id' => $applicant_value->id))->get('application_payment')->row();
                        ?>
                        <tr>
                            <td style="text-align: right;"><?php echo $page++; ?></td>
                            <td style="text-align: left;"><?php echo $payment_value->transaction_date; ?></td>
<!--                            <td style="text-align: left;">--><?php //echo $payment_value->invoice_number ?><!--</td>-->
                            <td style="text-align: left;"><?php echo $payment_value->student_id; ?></td>
                            <!-- <td style="text-align: left;"><?php
                            echo '<a href="javascript:void(0);" style="display: block;" class="change_status" ID="'.$payment_value->id.'" firstname="'.$payment_value->student_name.'" control_number="'.$payment_value->control_number.'" SELECTED_ID="'.$payment_value->student_id.'" SELECTED_VALUE="'.$payment_value->student_id.'" >'.$payment_value->student_id;
                            ?></a></td> -->
                            <td style="text-align: left;"><?php echo $payment_value->control_number; ?></td>
                            <td style="text-align: left;"><?php echo number_format($payment_value->paid_amount,0); ?></td>
                            <td style="text-align: left;"><?php echo ($payment_value->student_name)?$payment_value->student_name : $payment_value->payer_name; ?></td>
                            <td style="text-align: left;"><?php echo ($payment_value->fee_name)?$payment_value->fee_name :$payment_value->paid_for; ?></td>
                            <!-- <td style="text-align: left;"><?php echo $payment_value->ega_refference?></td> -->
                            <!-- <td style="text-align: left;"><?php echo $payment_value->receipt_number; ?></td> -->
                            <td style="text-align: left;"><?php echo $payment_value->payer_mobile; ?></td>
                            <!-- <td style="text-align: left;"><?php echo $payment_value->payment_channell; ?></td> -->
                            <!-- <td style="text-align: left;"><?php echo $payment_value->channel_name; ?></td> -->
                            <td style="text-align: left;"><a href=" <?php echo site_url('print_receipt/'.encode_id($payment_value->id)) ?>"<i class="fa fa-print"></i>Print</a></td>

                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>

                <h2 align="center" style="font-weight: bold; color: brown;"> Total Amount <?php echo number_format($total_amount,0); ?></h2>

                <div>
                    <div style="clear: both;"></div>
                    <button type="submit" onclick="return confirm_submit('Are you sure');"  name="pull_transctions" class="btn btn-sm btn-success pull-left">Pull Transactions</button>
                    <!--                   <button type="submit" onclick="return confirm_submit('Are you sure');"  name="cancel_selected" class="btn btn-sm btn-success pull-right">Cancel Selected</button>-->
                </div>
                <?php echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Edit Academic Year Modal -->
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalEdit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="title"></h4>
            </div>
            <div class="modal-body">

                <form id="form_updated_academic_term" action="" method="post">
                    <div class="form-group" style="display:none">
                        <label class="control-label" for="id">Iterm ID</label>
                        <input type="text" id="id" name="id" class="form-control" />
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="id">Academic Term</label>
                        <input type="text" id="term" name="term" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="id">Academic Term</label>
                        <!-- <input type="text" id="term" name="term" class="form-control" /> -->
                        <select name="professional_category" id="term" class="form-control" <?php echo(isset($professional_category) ? 'disabled' : '') ?> >
                            <option value=""> [ Select professional category ]</option>
                            <?php
                            // $cat = 1;
                            foreach (application_type() as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">No</button>
                <button type="submit" id="submit_form_term_update" class="btn btn-success pull-left crud-submit-edit">Confirm</button>
                <button type="button" id="term_update_feedback" style="display: none" class="btn btn-success pull-right"><span id="term_update_feedback_msg"></span></button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("body").on("click",".popup_applicant_info",function () {
            var ID = $(this).attr("ID");
            var title = $(this).attr("title");
            $.confirm({
                title:title,
                content:"URL:<?php echo site_url('popup_applicant_info') ?>/"+ID+'/?status=1',
                confirmButton:'Print',
                columnClass:'col-md-10 col-md-offset-2',
                cancelButton:'Close',
                extraButton:'ExtraB',
                cancelButtonClass: 'btn-success',
                confirmButtonClass: 'btn-success',
                confirm:function () {
                    window.location.href = '<?php echo site_url('print_application') ?>/'+ID;
                    return false;
                },
                cancel:function () {
                    return true;
                }

            });
        });


        $("body").on("click",".change_status",function () {
            var student_id = $(this).attr("ID");
            var selected_ID = $(this).attr("SELECTED_ID");
            var selected_VALUE = $(this).attr("SELECTED_VALUE");
            var firstname = $(this).attr("firstname");
            var control_number = $(this).attr("control_number");


         
           $.confirm({
                title:'Name : '+firstname+' | '+control_number,
                content:'<div class="col-md-12 form-horizontal">' +
                '<div class="form-group"><label class="col-lg-3 control-label">Assign Registration Number </label><div class="col-lg-8">'+
                '<input type="text" disabled="disabled" value="'+selected_VALUE+'" class="form-control"></div></div>'
                + '<div class="form-group"><label class="col-lg-3 control-label">Registration Number : <span class="required">*</span></label><div class="col-lg-8">'+
                '<input class="form-control" id="regno" name="regno" placeholder="--Enter Registration Number--"/>'
                +'</div></div>'

                +'<div id="errordiv"></div></div>',
                confirmButton:'Save',
                columnClass:'col-md-7 col-md-offset-2',
                cancelButton:'Cancel',
                cancelButtonClass: 'btn-success',
                confirmButtonClass: 'btn-success',
                confirm:function () {
                    var regno = this.$content.find("#regno").val();
                    this.$content.find("#errordiv").html("Please wait......");
                    if(regno != '') {
                        $.ajax({
                            url: '<?php echo site_url('logs/assign_regno') ?>',
                            type: 'post',
                            data: {
                                regno: regno,
                                student_id: student_id
                            },
                            success: function () {
                                // console.log(student_id);
                                window.location.reload();
                            }
                        })
                    }else{
                        this.$content.find("#errordiv").html("Please enter RegNo...");
                    }
                    return false;
                },
                cancel:function () {
                    return true;
                }

                
            });
        });
    });



    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Approve application');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#id').val($(this).data('id'));
        $('#term').val($(this).data('term'));
        $('#myModalEdit').modal('show');


    });
</script>
<input type="hidden" id="txtColumnVisibility" name="txtColumnVisibility" value="<?php echo $current_column_visibility; ?>" >
<input type="hidden" id="txtCurrentFilename" name="txtCurrentFilename" value="<?php echo $current_file_name; ?>" >
<input type="hidden" id="txtPaperOrientation" name="txtPaperOrientation" value="<?php echo $current_pdf_orientation; ?>" >
<input type="hidden" id="txtCurrTitle" name="txtCurrTitle" value="<?php echo $current_print_title; ?>" >

