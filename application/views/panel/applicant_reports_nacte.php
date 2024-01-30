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
        <h5>Applicants' NACTE Reports</h5>

    </div>
    <div class="ibox-content">

        <?php echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <?php echo form_hidden('post_data', '1'); ?>

        <!-- <div class="form-group">
            <div class="col-lg-8 col-lg-offset-3">
                <a href="../uploads/docs/selected-candidates.xlsx">Download Template</a>
            </div>
        </div> -->

        <div class="form-group"><label class="col-lg-3 control-label">Programme : <span
                        class="required">*</span></label>

            <div class="col-lg-5">
                <select name="programme" class="form-control">
                    <option value=""> [ Select Option ]</option>
                    <?php $result=$this->db->query("select * from programme where programme_id<>''")->result();
                    foreach ($result as $key=>$value)
                    {?>
                        <option value="<?php echo $value->programme_id; ?>"><?php echo $value->Name; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php// echo isset($upload_error) ?  $upload_error : ''; ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label"> Intake : <span
                    class="required">*</span></label>

            <div class="col-lg-5">
                <select name="intake" class="form-control">
                    <option value="SEPTEMBER">SEPTEMBER</option>
                    <option value="MARCH">MARCH</option>
                </select>

            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Select Option : <span
                        class="required">*</span></label>

            <div class="col-lg-5">
                <select name="option" class="form-control">
                   <option value="1">Admissions - verified students results</option>
                    <option value="2">Get Submitted list</option>
                    <option value="3">Feedback error to correct</option>

                </select>
                <?php// echo isset($upload_error) ?  $upload_error : ''; ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Applicant Year: <span
                        class="required">*</span></label>

            <div class="col-lg-5">
            <select name="ayear"  id="ayear" class="form-control " >
                    <option>[Select applicant Year]</option>
                    <?php
                    $sel = (isset($_GET['ayear']) ? $_GET['ayear'] : "");
                    $year_list=$this->db->query("select * from ayear  order by AYear")->result();
                    foreach($year_list as $key=>$value) {?>
                        <option <?php echo($sel == $value->AYear ? 'selected="selected"' : ''); ?> value="<?php echo substr($value->AYear,0,4)  ?>"><?php echo substr($value->AYear,0,4); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>


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
