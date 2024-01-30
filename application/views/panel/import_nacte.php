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
        <h5>Import Admitted Students  NACTE</h5>

    </div>
    <div class="ibox-content">

        <?php echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <?php echo form_hidden('post_data', '1'); ?>

        <div class="form-group">
            <div class="col-lg-8 col-lg-offset-3">
                <a href="../uploads/docs/selected-candidates-nacte.xlsx">Download Template</a>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Select option : <span
                        class="required">*</span></label>

            <div class="col-lg-5">
                <select name="selectoradmitted" class="form-control">
                    <option value=""> [ Select Option ]</option>
<!--
                        <option value="1">Selected</option> -->
                    <option value="1">Admitted</option>

                </select>
                <?php echo isset($upload_error) ?  $upload_error : ''; ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Program: <span
                        class="required">*</span></label>

            <div class="col-lg-5">
                <select name="program" class="form-control">
                    <option value=""> [ Select Option ]</option>
                    <?php $result=$this->db->query("select * from programme where programme_id<>''")->result();
                    foreach ($result as $key=>$value)
                    {?>
                        <option value="<?php echo $value->programme_id; ?>"><?php echo $value->Name; ?></option>
                   <?php
                    }
                    ?>


                </select>
                <?php echo isset($upload_error) ?  $upload_error : ''; ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Admission Sheet : <span
                    class="required">*</span></label>

            <div class="col-lg-5">
                <input type="file" value="" class="form-control" name="userfile">
                <?php echo isset($upload_error) ?  $upload_error : ''; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" type="submit" value="Import Members"/>
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
