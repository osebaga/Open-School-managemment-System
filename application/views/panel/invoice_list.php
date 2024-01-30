<?php
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
    if (isset($_GET['center']) && $_GET['center'] <> '') {
        $center = $this->db->query("SELECT * FROM Center WHERE CenterRegNo='".$_GET['center']."' ")->row();

        $title1 .= " Center :<strong> " . $center->CenterName . '</strong>';
    }

    if (isset($_GET['fee_id']) && $_GET['fee_id'] <> '') {
        $tit = $_GET['fee_id'];

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
 
        $title1 .=" Fee Type :<strong> " .$feename. '</strong>';


    }


    if ($title1 <> '') {
        echo '<div class="alert alert-warning">' . $title1 . '</div>';
    }

}

?>

<div class="ibox">
    <div class="ibox-title">
        <h5>Invoice List</h5>
        <!--        <div style="text-align: right;"><a style="font-size: 11px; text-decoration: underline;"-->
        <!--                                           href="--><?php //echo site_url('renotify/?resend=1'); ?><!--">Resend notification by-->
        <!--                Email</a></div>-->
    </div>
    <div class="ibox-content">
        <?php echo form_open(current_full_url(), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group no-padding">

            <div  class=" col-sm-offset-0 col-md-2">
                <input name="from" placeholder="FROM : DD-MM-YYYY" class="form-control mydate_input"
                       value="<?php echo(isset($_GET['from']) ? $_GET['from'] : '') ?>"/>

            </div>

            <div class="col-md-2">
                <input name="to" placeholder="TO : DD-MM-YYYY" class="form-control mydate_input"
                       value="<?php echo(isset($_GET['to']) ? $_GET['to'] : '') ?>"/>
            </div>
            <div class="col-md-3">
                <select name="fee_id[]" class="form-control" >
                    <!-- <option value="">[ Fee Type ]</option> -->
                    <?php
                    $fee_list=$this->db->query("select * from fee_structure")->result();
                    foreach ($fee_list as $tkey => $tvalue) {
                        ?>
                        <option <?php echo(isset($_GET['fee_id']) ? ($_GET['fee_id'] == $tvalue->id ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $tvalue->id; ?>"><?php echo $tvalue->name ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="center" class="form-control" >
                    <!-- <option value="">[ Fee Type ]</option> -->
                    <?php
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
            <div class="col-md-1">
                <input type="submit" value="Search" class="btn btn-success btn-sm">
            </div>
        </div>

        <hr>
        <div class="row">
            <!--            <div class="col-md-6">-->
            <!--                <a style="float:left"-->
            <!--                   href="--><?php //echo site_url('report/export_member/?' . ((isset($_GET) && !empty($_GET)) ? http_build_query($_GET) : '')); ?><!--"-->
            <!--                   class="btn btn-sm btn-success">Export Excel</a>-->
            <!--            </div>-->
            <!--            <div class="col-md-6">-->
            <!--                <p style="">--><?php //echo $pagination_links; ?><!--</p>-->
            <!--            </div>-->


            <div style="clear: both;"></div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive  text-align"  id="datatable" width="100%">

                    <thead>
                    <tr>
                        <th><div>S/No</div></th>
                        <th>Date</th>
                        <th>RegNo</th>
                        <th>Name</th>
                        <th>Bill For</th>
                        <th>Amount</th>
                        <!-- <th>GfsCode</th> -->
                        <th>Control Number</th>
                        <th>Status Code</th>
                        <th>Invoice Age</th>
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
                            <!--  <td style="text-align: left;">--><?php //echo ($current_student_info) ? ucfirst($current_student_info->FirstName).' '.ucfirst($current_student_info->MiddleName).' '.ucfirst($current_student_info->LastName) : $invoice_value->student_name; ?><!--</td>-->
                            <td style="text-align: left;"><?php echo $invoice_value->student_id; ?></td>
                            <td style="text-align: left;"><?php echo $invoice_value->student_name; ?></td>
                            <td style="text-align: left;"><?php echo $invoice_value->fee_name; ?></td>
                            <td style="text-align: left;"><?php echo number_format($invoice_value->amount,0); ?></td>
                            <!-- <td style="text-align: left;"><?php // echo $invoice_value->GfsCode; ?></td> -->
                            <td style="text-align: left;"><?php echo $invoice_value->control_number; ?></td>
                            <td style="text-align: left;"><?php echo $invoice_value->status; ?></td>

                
                            <td style="text-align: left;"><?php echo GetNumberOfDaysBetweenDates($invoice_value->timestamp); ?></td>

                            <td>
                                <input type="checkbox" name="txtSelect[]" value="<?php  echo $invoice_value->id?>"
                                    <?php if(($invoice_value->status==2))
                                        echo"disabled"; ?> />
                            </td>
                            <td style="text-align: left;"><a href=" <?php echo (isset($invoice_value->status) and $invoice_value->status==1)? site_url('print_invoice/'.encode_id($invoice_value->id)) : '#'; ?>/"<i class="fa fa-print   "></i>Print</a></td>
                            <td style="text-align: left;"><a href=" <?php echo (isset($invoice_value->status) and $invoice_value->status==1)? site_url('print_transfer/'.encode_id($invoice_value->id)) : '#'; ?>/"<i class="fa fa-print   "></i>Print</a></td>


                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div>
                    <div style="clear: both;"></div>
                    <button type="submit" onclick="return confirm_submit('Are you sure');"  name="resubmit_selected" class="btn btn-sm btn-success pull-left">Resubmit Selected</button>
                    <button type="submit" onclick="return confirm_submit('Are you sure');"  name="cancel_selected" class="btn btn-sm btn-success pull-right">Cancel Selected</button>
                </div>
                <?php echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("document").on("click",".print_invoice",function () {
            // alert('nipooo');
            var ID = $(this).attr("ID");
            window.location.href = '<?php echo site_url('print_invoice') ?>/'+ID;
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
                '<div class="form-group"><label class="col-lg-3 control-label">Control Number Status </label><div class="col-lg-8">'+
                '<input type="text" disabled="disabled" value="'+selected_VALUE+'" class="form-control"></div></div>'
                + '<div class="form-group"><label class="col-lg-3 control-label">New Status : <span class="required">*</span></label><div class="col-lg-8">'+
                '<input class="form-control" id="status" name="status"  value="2" readonly placeholder="--Enter Status--"/>'
                +'</div></div>'

                +'<div id="errordiv"></div></div>',
                confirmButton:'Save',
                columnClass:'col-md-7 col-md-offset-2',
                cancelButton:'Cancel',
                cancelButtonClass: 'btn-success',
                confirmButtonClass: 'btn-success',
                confirm:function () {
                    var status = this.$content.find("#status").val();
                    this.$content.find("#errordiv").html("Please wait......");
                    if(status != '') {
                        $.ajax({
                            url: '<?php echo site_url('logs/change_control_number_status') ?>',
                            type: 'post',
                            data: {
                                status: status,
                                student_id: student_id,
                                control_number:control_number
                            },
                            success: function () {
                                // console.log(control_number);
                                window.location.reload();
                            }
                        })
                    }else{
                        this.$content.find("#errordiv").html("Please select new entry mode...");
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

