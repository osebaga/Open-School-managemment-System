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
        <h5> TCU Transfers</h5>

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
                    <option value="1">Internal Transfer</option>
                    <option value="2">Inter Institutional Transfer</option>
                </select>
                <?php echo form_error('status'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Form Four Index Number : <span
                        class="required">*</span></label>

            <div class="col-lg-5">

                <input type="text" value="<?php echo set_value('o_level_index_no'); ?>"
                       class="form-control" name="o_level_index_no"  onblur="loadAjaxData(this.value,'','','o-level')" id="o_level_index_no">
                <div  >Eg <b>S0125/0000/2005 or P0125/0000/2005 </b></div>
                <?php echo form_error('o_level_index_no'); ?>            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Form Six Index Number : <span
                        class="required">*</span></label>

            <div class="col-lg-5">

                <input type="text" value="<?php echo set_value('a_level_index_no'); ?>"
                       class="form-control" name="a_level_index_no" id="a_level_index_no"  onblur="loadAjaxData(this.value,'','','a-level')">
                <div id="sample_index" >Eg <b>S0125/0000/2005 or P0125/0000/2005</b></div>
                <div id="center_name"></div>

                <?php echo form_error('a_level_index_no'); ?>
            </div>

        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Previous Program Code : <span
                        class="required">*</span></label>

            <div class="col-lg-5">

                <input type="text" value="<?php echo set_value('prev_prog_code'); ?>"
                       class="form-control" name="prev_prog_code" id="prev_prog_code"  >
                <?php echo form_error('prev_prog_code'); ?>
            </div>

        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Current Program Code : <span
                        class="required">*</span></label>

            <div class="col-lg-5">

                <input type="text" value="<?php echo set_value('current_prog_code'); ?>"
                       class="form-control" name="current_prog_code" id="current_prog_code" >
                <?php echo form_error('prev_prog_code'); ?>
            </div>

        </div>
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" type="submit" value="Submit Transfer"/>
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
