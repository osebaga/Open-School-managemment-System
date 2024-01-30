<?php
$current_print_title="GRADUATE LIST";
$current_file_name="graduate_list".date("Y-m-d");
$current_pdf_orientation="portrait";//landscape or portrait
$current_column_visibility=":visible";// "" or :visible
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');

}

  
?>

<div class="ibox">
    <div class="ibox-title">
        
        <?php echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <?php echo form_hidden('post_data', '1'); ?>
        <div class="form-group no-padding">

            <div class="col-md-4">
                <select name="programme" class="form-control">
                    <option value=""> [ Select Programme ]</option>
                    <?php $result = $this->db->query("select * from programme where programme_id<>''")->result();
                    foreach ($result as $key => $value) { ?>
                        <option value="<?php echo $value->programme_id; ?>"><?php echo $value->Name; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="intake" class="form-control">
                    <option value=""> [ Select Intake ]</option>
                    <option value="SEPTEMBER">SEPTEMBER</option>
                    <option value="MARCH">MARCH</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="ayear" id="ayear" class="form-control ">
                    <option>[Select applicant Year]</option>
                    <?php
                    $sel = (isset($_GET['ayear']) ? $_GET['ayear'] : "");
                    $year_list = $this->db->query("select * from ayear  order by AYear")->result();
                    foreach ($year_list as $key => $value) { ?>
                        <option <?php echo ($sel == $value->AYear ? 'selected="selected"' : ''); ?> value="<?php echo substr($value->AYear, 5, 4)  ?>"><?php echo substr($value->AYear, 5, 4); ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
           <div class="col-md-2">
           <select name="semester" id="semester" class="form-control ">
                    <option>[Select Semester]</option>
                    <option value="1">Semester I</option>
                    <option value="2">Semester II</option>
           </select>
           </div>

            <div class="col-md-1">
                <input class="btn btn-md btn-success" type="submit" value="Pull List" />
            </div>
      
        </div>
   
        <?php echo form_close(); ?>

       

            <div style="clear: both;"></div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive  text-align"  id="datatable" width="100%">

                <thead>
                    <tr>
                        <th><div>S/No</div></th>
                        <th>RegNo</th>
                        <th>F4IndexNo</th>
                        <th>FirstName</th>
                        <th>MiddleName</th>
                        <th>SurName</th>
                        <th>Sex</th>
                        <th>DOB</th>
                        <th>AYear</th>
                        <th>NTA Level</th>
                        <th>Intake</th>
                        <th>Nationality</th>
                        <th>Study Mode</th>
                         
                    </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                   $i=0;
                    foreach ($applicants as $key => $value) {
                        $i=$i + 1;
                        ?>

                        <tr>
                            <td style="text-align: right;"><?php echo $i; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['registration_number']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['form_four_index_number']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['first_name']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['middle_name']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['surname']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['gender']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['date_of_birth']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['academic_year']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['level']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['intake']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['nationality']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['study_mode']; ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                    </tbody>
                </table>

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
       $("document").on("click",".print_invoice",function () {
           alert('nipooo');
           var ID = $(this).attr("ID");
                   window.location.href = '<?php echo site_url('print_invoice') ?>/'+ID;
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

