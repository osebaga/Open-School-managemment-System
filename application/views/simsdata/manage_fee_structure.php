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
                echo 'Add New Fee Structure';
            } else if (!is_null($id) && isset($action)) {
                echo 'Edit Fee Structure Information';
            }
            ?></h5>
    </div>




    <div class="ibox-content">
        <?php
        echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>


        <div class="form-group"><label class="col-lg-3 control-label"> Fee Category : <span
                        class="required ">*</span></label>
            <div class="col-lg-8">
                <select name="fee_category" id="fee_category" class="form-control ">
                    <option value=""> [Fee Category]</option>
                    <?php
                    $sel = (isset($feestructureinfo) ? $feestructureinfo->fee_category : set_value('fee_category'));
                    foreach (NTA_Fee_Categories() as $key=>$value){
                        echo '<option '.($sel==$key ? 'selected="selected"':'').' value="'.$key.'">'.$value.'</option>';
                    }
                    ?>
                </select>
                <?php echo form_error('fee_category'); ?>
            </div>
        </div>
        <div class="form-group"  id="for_student_check"><label class="col-lg-3 control-label">For Student  ? : <span class="required">*</span></label>
            <div class="col-lg-8">
                <select name="for_student"  class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($feestructureinfo) ? $feestructureinfo->for_student : set_value('for_student'));

                    ?>
                    <option  value=""></option>
                    <option <?php echo ($sel == 1 ? 'selected="selected"':''); ?> value="1">Yes</option>
                    <option <?php echo ($sel == 0 ? 'selected="selected"':''); ?> value="0">No</option>
                </select>
                <?php echo form_error('for_student'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Name : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" name="name"
                       value="<?php echo(isset($feestructureinfo) ? $feestructureinfo->name : set_value('name')) ?>"
                       class="form-control"/>
                <?php echo form_error('name'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label"> Has Exactly Amount : <span
                        class="required ">*</span></label>
            <div class="col-lg-8">
                <select name="fixed" id="fixed" class="form-control ">
                    <option value=""> [Does Fee has a Fixed Amount? ]</option>
                    <?php
                    $sel = (isset($feestructureinfo) ? $feestructureinfo->fixed : set_value('fixed'));
                    ?>
                    <option <?php echo($sel == 1 ? 'selected="selected"' : ''); ?> value="1">YES</option>
                    <option <?php echo($sel == 0 ? 'selected="selected"' : ''); ?>value="0">NO</option>
                </select>
                <?php echo form_error('fixed'); ?>
            </div>
        </div>


        <div class="form-group" id="amount" style="display: none" ><label class="col-lg-3 control-label">Fee Amount : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" name="amount"
                       value="<?php echo(isset($feestructureinfo) ? $feestructureinfo->amount : set_value('amount')) ?>"
                       class="form-control"  onKeyPress="return numbersonly(event,this.value)"/>
                <?php echo form_error('amount'); ?>
            </div>
        </div>


        <div class="form-group"  id="percentage"><label class="col-lg-3 control-label">Has Percentage Pay ? : <span class="required">*</span></label>
            <div class="col-lg-8">
                <select name="percentage" id="percentage_check" class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($feestructureinfo) ? $feestructureinfo->percentage : set_value('percentage'));

                    ?>
                    <option  value=""></option>
                    <option <?php echo ($sel == 1 ? 'selected="selected"':''); ?> value="1">Yes</option>
                    <option <?php echo ($sel == 0 ? 'selected="selected"':''); ?> value="0">No</option>
                </select>
                <?php echo form_error('percentage'); ?>
            </div>
        </div>
        <div class="form-group" id="percentage_value" style="display: none" ><label class="col-lg-3 control-label">Percentage Value : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" name="percentage_value"
                       value="<?php echo(isset($feestructureinfo) ? $feestructureinfo->parcentage_value : set_value('percentage_value')) ?>"
                       class="form-control"  placeholder="10,20,30,40.."/>
                <?php echo form_error('percentage_value'); ?>
            </div>
        </div>



        <div class="form-group"  id="ntlevel"><label class="col-lg-3 control-label">For Center ? : <span class="required">*</span></label>
            <div class="col-lg-8">
                <select name="ntlevel"  id="ntlevel_check" class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($feestructureinfo) ? $feestructureinfo->ntlevel : set_value('ntlevel'));

                    ?>
                    <option  value=""></option>
                    <option <?php echo ($sel == 1 ? 'selected="selected"':''); ?> value="1">Yes</option>
                    <option <?php echo ($sel == 0 ? 'selected="selected"':''); ?> value="0">No</option>
                </select>
                <?php echo form_error('ntlevel'); ?>
            </div>
        </div>

        <div class="form-group"  id="ntlevel_value"><label class="col-lg-3 control-label">Programme Value ? : <span class="required">*</span></label>
            <div class="col-lg-8">
                <select name="ntlevel_value"  id="ntlevel_value_check" class="select2_search1 form-control " >
                    <?php
                        $centers=$this->db->query("select * from Center")->result();
                        foreach ($centers as $key=>$value){
                        $sel = (isset($feestructureinfo) ? $feestructureinfo->ntlevel_value : set_value('ntlevel_value'));

                        echo '<option '.($sel==$value->CenterRegNo ? 'selected="selected"':'').' value="'.$value->CenterRegNo.'">'.$value->CenterName.'</option>';
                    }


                    ?>



                </select>
                <?php echo form_error('ntlevel_value'); ?>
            </div>
        </div>



        <div class="form-group"  id="carryover"><label class="col-lg-3 control-label">Carry Over ? : <span class="required">*</span></label>
            <div class="col-lg-8">
                <select name="carryover" id="carryover_check" class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($feestructureinfo) ? $feestructureinfo->carryover : set_value('carryover'));

                    ?>
                    <option  value=""></option>
                    <option <?php echo ($sel == 1 ? 'selected="selected"':''); ?> value="1">Yes</option>
                    <option <?php echo ($sel == 0 ? 'selected="selected"':''); ?> value="0">No</option>
                </select>
                <?php echo form_error('carryover'); ?>
            </div>
        </div>

        <div class="form-group" id="carryover_quality_assurance_value" style="display: none" ><label class="col-lg-3 control-label">Quality Assurance : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" name="carryover_quality_assurance_value"
                       value="<?php echo(isset($feestructureinfo) ? $feestructureinfo->carryover_quality_assurance_value : set_value('carryover_quality_assurance_value')) ?>"
                       class="form-control"  onKeyPress="return numbersonly(event,this.value)"/>
                <?php echo form_error('carryover_quality_assurance_value'); ?>
            </div>
        </div>




        <div class="form-group"><label class="col-lg-3 control-label">GEPG Fee Category : <span class="required">*</span></label>
            <div class="col-lg-8">
                <select name="gepg_category_code" class="select2_search1 form-control " >
                    <option value="">[select GEPG category]</option>
                    <?php
                    $fee_list=$this->db->query("select * from fee_type")->result();
                    foreach($fee_list as $key=>$value)
                    {
                        $sel = (isset($feestructureinfo) ? $feestructureinfo->fee_code : set_value('gepg_category_code'));

                        ?>
                        <option <?php echo ($sel == $value->code ? 'selected="selected"':''); ?>  value="<?php echo $value->code; ?>"><?php echo $value->name; ?></option>
                        <?php

                    }
                    ?>           </select>
                <?php echo form_error('gepg_category_code'); ?>
            </div>
        </div>


        <div class="form-group"  ><label class="col-lg-3 control-label">Bill Option : <span class="required">*</span></label>
            <div class="col-lg-8">
                <select name="pay_option" id="pay_option" class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($feestructureinfo) ? $feestructureinfo->pay_option : set_value('pay_option'));

                    ?>
                    <option  value=""></option>
                    <option <?php echo ($sel == 3 ? 'selected="selected"':''); ?> value="3">Full Payment</option>
                    <option <?php echo ($sel == 2 ? 'selected="selected"':''); ?> value="2">Partial Payment</option>
                </select>
                <?php echo form_error('pay_option'); ?>
            </div>
        </div>

        <div class="form-group"  ><label class="col-lg-3 control-label">Bill Expire Days : <span class="required">*</span></label>
            <div class="col-lg-8">
                <select name="exp_days" id="exp_days" class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($feestructureinfo) ? $feestructureinfo->exp_days : set_value('exp_days'));

                    ?>
                    <option  value=""></option>
                    <option <?php echo ($sel == '30days' ? 'selected="selected"':''); ?> value="30days">30 days</option>
                    <option <?php echo ($sel == '180days' ? 'selected="selected"':''); ?> value="180days">180 days</option>
                    <option <?php echo ($sel == '365days' ? 'selected="selected"':''); ?> value="365days">365 days</option>

                </select>
                <?php echo form_error('exp_days'); ?>
            </div>
        </div>


        <div class="form-group" id="" style=" " ><label class="col-lg-3 control-label">Reference Prefix : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" name="reference_prefix" id="reference_prefix"
                       value="<?php echo(isset($feestructureinfo) ? $feestructureinfo->ref_prefix : set_value('reference_prefix')) ?>"
                       class="form-control"  onKeyPress="return TextOnly(event,this.value)" class="form-control" maxlength="4"/>
                <?php echo form_error('reference_prefix'); ?>
            </div>
        </div>



        <div class="form-group"  id="hidden"><label class="col-lg-3 control-label">Hide : <span class="required">*</span></label>
            <div class="col-lg-8">
                <select name="hidden" id="hidden" class="select2_search1 form-control " >
                    <?php
                    $sel = (isset($feestructureinfo) ? $feestructureinfo->hidden : set_value('hidden'));

                    ?>
                    <option  value=""></option>
                    <option <?php echo ($sel == 1 ? 'selected="selected"':''); ?> value="1">Yes</option>
                    <option <?php echo ($sel == 0 ? 'selected="selected"':''); ?> value="0">No</option>
                </select>
                <?php echo form_error('hidden'); ?>
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


        $("#fee_category").change(function () {

var value = $(this).val();
if(value != 0)
{
    $("#for_student_check").hide();

}else{
    $("#for_student_check").show();

}


})
        $("#fixed").change(function () {

            var value = $(this).val();

            if (value == 1) {
                $("#amount").show();
                $("#percentage").show();
                $("#ntlevel").show();
                $("#carryover").show();

            }else{
                $("#amount").hide();
                $("#percentage").hide();
                $("#ntlevel").hide();
                $("#carryover").hide();

            }

        })

        if($("#fixed").val()==1)
        {
            $("#amount").show();
            $("#percentage").show();
            $("#ntlevel").show();
            $("#carryover").show();


        }else{
            $("#amount").hide();
            $("#percentage").hide();
            $("#ntlevel").hide();
            $("#carryover").hide();


        }

        $("#percentage_check").change(function () {

            var value = $(this).val();
            if (value == 1) {
                $("#percentage_value").show();
            }else{
                $("#percentage_value").hide();

            }

        })

        if($("#percentage_check").val()==1)
        {
            $("#percentage_value").show();

        }else{
            $("#percentage_value").hide();

        }

        $("#ntlevel_check").change(function () {

            var value = $(this).val();

            if (value == 1) {
                $("#ntlevel_value").show();
            }else{
                $("#ntlevel_value").hide();

            }

        })

        if($("#ntlevel_check").val()==1)
        {
            $("#ntlevel_value").show();

        }else{
            $("#ntlevel_value").hide();

        }

        $("#carryover_check").change(function () {

            var value = $(this).val();

            if (value == 1) {
                $("#carryover_quality_assurance_value").show();
            }else{
                $("#carryover_quality_assurance_value").hide();

            }

        })

        if($("#carryover_check").val()==1)
        {
            $("#carryover_quality_assurance_value").show();

        }else{
            $("#carryover_quality_assurance_value").hide();

        }



    })
</script>