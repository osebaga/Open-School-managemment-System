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
echo"<br/><br/>";




if (isset($message_account_year)) {
    echo $message_account_year.'  '.$title1;
} else if ($this->session->flashdata('message_account_year') != '') {
    echo $this->session->flashdata('message_account_year');

}

?>

<div class="ibox">

    <div class="ibox-title">
        <h5>Debtors' Report</h5>
<!--        <div style="text-align: right;"><a style="font-size: 11px; text-decoration: underline;"-->
<!--                                           href="--><?php //echo site_url('renotify/?resend=1'); ?><!--">Resend notification by-->
<!--                Email</a></div>-->
    </div>
    <div class="ibox-content">
        <?php echo form_open(current_full_url(), ' method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group no-padding">




<!--            <div  class=" col-sm-offset-2 col-md-3">-->
<!--                <input name="from" placeholder="FROM : DD-MM-YYYY" class="form-control mydate_input"-->
<!--                       value="--><?php //echo(isset($_GET['from']) ? $_GET['from'] : '') ?><!--"/>-->
<!---->
<!--            </div>-->
<!---->
<!--            <div class="col-md-3">-->
<!--                <input name="to" placeholder="TO : DD-MM-YYYY" class="form-control mydate_input"-->
<!--                       value="--><?php //echo(isset($_GET['to']) ? $_GET['to'] : '') ?><!--"/>-->
<!--            </div>-->


            <div class="col-md-3">
                <select name="campus"  id="campus" class="select2_search1 form-control " >
                    <?php
                    $ca = (isset($_GET['campus']) ? $_GET['campus'] : "");
                    ?>
                <option value=""> [Select Campus]</option>
                    <?php
                    foreach($campus as $ca )  {            
                         ?>
                    
                   <option value=" <?php echo $ca->CampusID; ?>"><?php echo $ca->Campus; ?></option>
                   <?php 
                    }
                    ?>
                </select>
            </div>


            <div class="  col-md-3">
                <select name="ntlevel"  id="ntlevel" class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($_GET['ntlevel']) ? $_GET['ntlevel'] : "");

                    ?>
                    <option  value="">[All  NTA Level]</option>
                    <?php
                    foreach($ntalevel as $nt )  {     
                 $ntavaluenum = str_replace(['','-'], '', filter_var($nt->Ntalevel, FILTER_SANITIZE_NUMBER_INT));       
                         ?>
                    
                   <option value=" <?php echo $ntavaluenum; ?>"><?php echo $nt->Ntalevel; ?></option>
                   <?php 
                    }
                    ?>
                </select>
            </div>
            <div class="  col-md-3">
                <select name="intake"  id="intake" class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($_GET['intake']) ? $_GET['intake'] : "");
                    ?>
                    <option value=""> [Select Intake]</option>
                      <?php
                    foreach($intake as $int )  {            
                         ?>
                   <option value=" <?php echo $int->Code; ?>"><?php echo $int->Intake; ?></option>
                   <?php 
                    }
                    ?>
                </select>
            </div>



            <div class="  col-md-2">
                <select name="pay_category"  id="pay_category" class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($_GET['pay_category']) ? $_GET['pay_category'] : "");
                    ?>
                    <option  value="">[All  Category]</option>
                    <option <?php echo ($sel == 1 ? 'selected="selected"':''); ?> value="1">Not Paid</option>
                    <option <?php echo ($sel == 2 ? 'selected="selected"':''); ?> value="2">Partial Paid</option>
                    <option <?php echo ($sel == 3 ? 'selected="selected"':''); ?> value="3">Full Paid</option>

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
                        <th>Registration Number</th>
                        <th>Name</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                        <th>Print Statement</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_debit=0;
                    $total_credit=0;

                    $overal_total=0;
                    $page = ($this->uri->segment(2) ? ($this->uri->segment(2) + 1) : 1);
                    foreach ($statement_list as $statement_key => $statement_value) {
                        $debit_credit_array=explode("_",GetStudentAccoountBalance($statement_value->regno));
                            //$amount_paid = $this->db->select_sum('amount')->where(array('applicant_id' => $applicant_value->id))->get('application_payment')->row();
                        if(isset($_GET['pay_category']) and $_GET['pay_category']==2) //partial paid
                        {
                            if($debit_credit_array[1]==0 or ($debit_credit_array[0]-$debit_credit_array[1])==0 )
                            {
                                continue;
                            }


                        }

                        if(isset($_GET['pay_category']) and $_GET['pay_category']==3) //Full paid
                        {
                            if(($debit_credit_array[0]-$debit_credit_array[1])!=0 )
                            {
                                continue;
                            }

                        }
                        $total_debit +=$debit_credit_array[0];
                        $total_credit +=$debit_credit_array[1];
                        if($total_debit>$total_credit)
                        {
                            $credit =($total_debit-$total_credit);
                            $debit='';
                            $overal_total=$total_debit;
                        }elseif($total_credit>$total_debit)
                        {
                            $debit=($total_credit-$total_debit);
                            $credit='';
                            $total_debit=$total_credit;
                        }
                        ?>
                        <tr>
                            <td style="text-align: right;"><?php echo $page++; ?></td>
                            <td style="text-align: left;"><?php echo $statement_value->regno; ?></td>
                            <td style="text-align: left;"><?php echo $statement_value->name ?></td>
                            <td style="text-align: left;"><?php echo $debit_credit_array[0];//$payment_value->ega_refference?></td>
                            <td style="text-align: left;"><?php echo $debit_credit_array[1]; //$payment_value->receipt_number; ?></td>
                            <td style="text-align: left;"><?php echo($debit_credit_array[0]-$debit_credit_array[1]); //$payment_value->receipt_number; ?></td>

                            <td style="text-align: left;"><a href=" <?php echo site_url('print_balance/'.encode_id($statement_value->regno)) ?>"<i class="fa fa-print   "></i>Print</a></td>

                        </tr>

                        <?php
                    }
                    ?>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td bgcolor='#7fffd4'><b><font size='+2'><?php echo number_format($total_debit); ?></font></b></td>
                        <td bgcolor='#7fffd4'><b><font size='+2'><?php echo number_format($total_credit); ?></font></b></td>
                        <td></td>

                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><b><font size='+2'>To closing</font></b></td>
                        <td><b><font><font size='+2'><?php echo ($debit!='') ? number_format($debit) :''; ?></font></b></td>
                        <td> <b><font><font size='+2'><?php echo ($credit!='') ? number_format($credit): ''; ?></font></b></td>
                        <td></td>
                        <td></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td bgcolor='#7fffd4'><b><font size='+2'><?php echo number_format($overal_total); ?></font></b></td>
                        <td bgcolor='#7fffd4'><b><font><font size='+2'><?php echo number_format($overal_total); ?></font></font></td>
                        <td></td>
                        <td></td>

                    </tr>
                    </tbody>
                </table>
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
       })
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

