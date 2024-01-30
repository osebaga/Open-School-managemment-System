<?php
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
if (isset($_GET)) {
    $title1 = '';
 
    if (isset($_GET['center']) && $_GET['center'] <> '') {
        $center = $this->db->query("SELECT * FROM Center WHERE CenterRegNo='".$_GET['center']."' ")->row();

        $title1 .= " Center :<strong> " . $center->CenterName . '</strong>';
    }
    if (isset($_GET['student_status']) && $_GET['student_status'] <> '') {

        $title1 .= " Student Status :<strong> " . student_status($_GET['student_status'] ). '</strong>';
    }
    if ($title1 <> '') {
        echo '<div class="alert alert-warning">' . $title1 . '</div>';
    }

}

?>

<div class="ibox">
    <div class="ibox-title">
        <h5>Student List</h5>
    </div>
    <div class="ibox-content">
        <?php echo form_open(current_full_url(), 'method="GET" class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group no-padding">
        <label for="center" class="col-sm-1 col-form-label col-form-label-sm">Center:</label>
        <div class="col-md-4">
                <select name="center"  id="center" class="form-control campus" >
                <option value=""> </option>
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
            <label for="center" class="col-sm-2 col-form-label col-form-label-sm">Student Status:</label>
            <div class="col-md-3">
                <select name="student_status"  id="student_status" class="form-control campus" >
                <option value=""> </option>
                <?php
                    foreach (student_status() as $tkey => $tvalue) {
                        ?>
                        <option <?php echo(isset($_GET['status']) ? ($_GET['status'] == $tkey ? 'selected="selected"' : '') : '') ?>
                                value="<?php echo $tkey; ?>"><?php echo $tvalue ?></option>
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
                        <th style="width: 1px; text-align: center">S/No</th>
                        <th>RegNo</th>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Programme</th>
                        <th>Status</th>
                        <th>Student Center</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                  
                    $page = ($this->uri->segment(2) ? ($this->uri->segment(2) + 1) : 1);
                        foreach ($student_list as $statement_key => $statement_value) {
                            $result = $this->db->query("select * from Center where CenterRegNo='$statement_value->CenterRegNo'")->row();
                            $program_choices=$this->db->query("SELECT * FROM application_programme_choice  WHERE applicant_id=".$statement_value->id." order by id DESC ")->row();

                            ?>
                       
                        <tr>
                            <td style="text-align: right;"><?php echo $page++; ?></td>
                            <td style="text-align: left;"><?php echo $statement_value->RegNo; ?></td>
                            <td style="text-align: left;"><?php echo $statement_value->FirstName .'   '.$statement_value->MiddleName.'   '.$statement_value->LastName; ?></td>
                            <td style="text-align: left;"><?php echo $statement_value->Gender; ?></td>
                            <td style="text-align: left;"><?php echo $program_choices->Name; ?></td>
                            <!-- <td style="text-align: left;"><?php echo $statement_value->student_status; ?></td> -->
                            <td>
                            <?php
                            if(isset($statement_value->student_status))
                            {
                                echo '<a href="javascript:void(0);" style="display: block;" class="student_status" ID="'.$statement_value->id.'" firstname="'.$statement_value->FirstName.'" middlename="'.$statement_value->MiddleName.'" lastname="'.$statement_value->LastName.'" SELECTED_ID="'.$statement_value->RegNo.'" SELECTED_VALUE="'.student_status($statement_value->student_status).'" >'.student_status($statement_value->student_status);
                            }
                            else
                            {
                                echo '<a href="javascript:void(0);" style="display: block;" class="student_status" ID="'.$statement_value->id.'" firstname="'.$statement_value->FirstName.'" middlename="'.$statement_value->MiddleName.'" lastname="'.$statement_value->LastName.'" SELECTED_ID="'.$statement_value->RegNo.'" SELECTED_VALUE="'.$statement_value->student_status.'" >'.'No Status';
                            }                         
                               ?></a>
                        </td> 
                            <td style="text-align: left;"><?php echo $result->CenterName; ?></td> 
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div>
                <?php echo form_close();
                ?>
            </div>
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
     

       $(".campus").select2({
                theme:'bootstrap',
                placeholder:'[ Select ]',
                allowClear:true
            });


        $("body").on("click",".student_status",function () {
            var applicant_id = $(this).attr("ID");
            var selected_ID = $(this).attr("SELECTED_ID");
            var selected_VALUE = $(this).attr("SELECTED_VALUE");
            var firstname = $(this).attr("firstname");
            var middlename = $(this).attr("middlename");
            var lastname = $(this).attr("lastname");


           $.confirm({
                title:'Applicant Name : '+firstname+' '+middlename+' '+lastname,
                content:'<div class="col-md-12 form-horizontal">' +
                '<div class="form-group"><label class="col-lg-3 control-label">Current Status. </label><div class="col-lg-8">'+
                '<input type="text" disabled="disabled" value="'+selected_VALUE+'" class="form-control"></div></div>'
                + '<div class="form-group"><label class="col-lg-3 control-label">Assign Status. : <span class="required">*</span></label><div class="col-lg-8">'+
                // '<input class="form-control" id="student_status" name="student_status" placeholder="--Enter Registration Number--"/>'
                '<select class="form-control" id="student_status" name="student_status"><option value="">--Enter Registration Number--</option>'
                <?php foreach (student_status() as $k=>$v){  ?>
                      +'<option value="<?php echo $k; ?>"><?php echo $v; ?></option>'
                 <?php } ?>
                +'</select></div></div>'

                +'<div id="errordiv"></div></div>',
                confirmButton:'Save',
                columnClass:'col-md-7 col-md-offset-2',
                cancelButton:'Cancel',
                cancelButtonClass: 'btn-success',
                confirmButtonClass: 'btn-success',
                confirm:function () {
                    var student_status = this.$content.find("#student_status").val();
                    this.$content.find("#errordiv").html("Please wait......");
                    if(student_status != '') {
                        $.ajax({
                            url: '<?php echo site_url('logs/change_student_status') ?>',
                            type: 'post',
                            data: {
                                student_status: student_status,
                                applicant_id: applicant_id
                            },
                            success: function () {
                                // console.log(applicant_id);
                              window.location.reload();

                            }
                        })
                    }else{
                        this.$content.find("#errordiv").html("Please select...");
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

