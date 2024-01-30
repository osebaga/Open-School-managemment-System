<?php
if (isset($member_error)) {
    foreach($member_error as $key=>$value){
        echo $value;
        echo "<br/>";
    }
}

if(isset($message)){
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5>Applicants' TCU Reports</h5>

    </div>
    <div class="ibox-content">

        <?php echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <?php echo form_hidden('post_data', '1'); ?>

        <!-- <div class="form-group">
            <div class="col-lg-8 col-lg-offset-3">
                <a href="../uploads/docs/selected-candidates.xlsx">Download Template</a>
            </div>
        </div> -->
        <div class="form-group"><label class="col-lg-3 control-label">Select option : <span
                        class="required">*</span></label>

            <div class="col-lg-5">
                <select name="status" class="form-control">
                    <option value=""> [ Select Option ]</option>
                    <option value="1">Get Confirmed Applicants</option>
                    <option value="2">Get Admitted Applicants</option>
                    <option value="3">Get Applicants' Admission Status</option>
                     <option value="4">Get Programmes with admitted candidates</option>
                    <option value="7">Get applicants’ Verification Status</option>
                    <option value="5">Get verification status for internally transferred students</option>
                    <option value="8">Get verification status for inter institutional transferred students</option>
                    <option value="6">Get verification status for non degree students</option>



                </select>
                <?php echo isset($upload_error) ?  $upload_error : ''; ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Programme : <span
                        class="required">*</span></label>

            <div class="col-lg-5">
                <select name="programme" class="form-control">
                    <option value=""> [ Select Option ]</option>
                    <?php foreach ($programme_list as $key => $value) { ?>
                    <option value="<?php echo $value->Code; ?>"><?php echo $value->Name; ?></option>
                  <?php } ?>
                </select>
                <?php// echo isset($upload_error) ?  $upload_error : ''; ?>
            </div>
        </div>
        <!-- <div class="form-group"><label class="col-lg-3 control-label">Admission Sheet : <span
                    class="required">*</span></label>

            <div class="col-lg-5">
                <input type="file" value="" class="form-control" name="userfile">
                <?php //echo isset($upload_error) ?  $upload_error : ''; ?>
            </div>
        </div> -->

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" type="submit" value="Download Excel Report"/>
            </div>
        </div>
        <?php echo form_close(); ?>

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
