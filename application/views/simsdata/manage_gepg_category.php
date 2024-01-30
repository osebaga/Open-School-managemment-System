<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}

?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5><?php
            if (is_null($id) && !isset($action)) {
                echo 'Add New GePG category ';
            } else if (!is_null($id) && isset($action)) {
                echo 'Edit GePG category Information';
            }
            ?></h5>
    </div>
    <div class="ibox-content">
        <?php
        echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>



            <div class="form-group"><label class="col-lg-3 control-label">Name : <span class="required">*</span></label>

                <div class="col-lg-8">
                    <input type="text" name="name"
                           value="<?php echo(isset($gepgcategoryinfo) ? $gepgcategoryinfo->name : set_value('name')) ?>"
                           class="form-control"/>
                    <?php echo form_error('name'); ?>
                </div>
            </div>

        <div class="form-group"><label class="col-lg-3 control-label">GFS code : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" name="gfscode"
                       value="<?php echo(isset($gepgcategoryinfo) ? $gepgcategoryinfo->gfscode : set_value('gfscode')) ?>"
                       class="form-control"/>
                <?php echo form_error('gfscode'); ?>
            </div>
        </div>





        <div class="form-group">
                <div class="col-lg-offset-3 col-lg-8">
                    <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
                </div>
            </div>
            <?php echo form_close();
     ?>

    </div>
</div>

<script>
    $(function(){


        $(".select2_search1").select2({
            theme: "bootstrap",
            placeholder: " [ Select Option ] ",
            allowClear: true
        });

    })

    $(document).ready(function () {

        $("#fixed").change(function () {

            var value = $(this).val();

            if (value == 1) {
                $("#amount").show();
                $("#percentage").show();
            }else{
                $("#amount").hide();
                $("#percentage").hide();
            }

        })

        if($("#fixed").val()==1)
        {
            $("#amount").show();
            $("#percentage").show();
        }else{
            $("#amount").hide();
            $("#percentage").hide();
        }

    })
</script>