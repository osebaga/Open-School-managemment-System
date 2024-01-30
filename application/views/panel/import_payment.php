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
        <h5>Import GEPG Payments</h5>

    </div>
    <div class="ibox-content">

        <?php echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <?php echo form_hidden('post_data', '1'); ?>
        

        <div  class="form-group">
            <div class="col-lg-8 col-lg-offset-3">
                <a href="../uploads/docs/Import_payment.xlsx">Download Template</a>
            </div>
        </div>



        <div class="form-group"><label class="col-lg-3 control-label" required>Payment Year : <span
                    class="required">*</span></label>
                    <div class="col-lg-5">
                    <select name="ayear"  id="ayear" class="form-control " >
                    <option>[Select Account Year]</option>
                    <?php
                    $sel = (isset($_GET['ayear']) ? $_GET['ayear'] : "");
                    $year_list=$this->db->query("select * from ayear  order by AYear")->result();
                    foreach($year_list as $key=>$value) {?>
                        <option <?php echo($sel == $value->AYear ? 'selected="selected"' : ''); ?> value="<?php echo $value->AYear  ?>"><?php echo $value->AYear; ?></option>
                        <?php
                    }
                    ?>

                </select>
            </div>
        </div>
 
        <div class="form-group"><label class="col-lg-3 control-label">Payment Sheet : <span
                    class="required">*</span></label>

            <div class="col-lg-5">
                <input type="file" value="" class="form-control" name="userfile">
                <?php echo isset($upload_error) ?  $upload_error : ''; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" type="submit" value="Import Payment"/>
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
