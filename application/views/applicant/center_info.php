<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Center Informations</h5></div>
    </div>

    <div class="ibox-content">

        <?php  echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>


        <div class="form-group"><label class="col-lg-3 control-label">Application Type  : <span class="required">*</span></label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo center_application($APPLICANT->application_type); ?>"
                       class="form-control" disabled="disabled"/>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Center Premises  : <span class="required">*</span></label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo center_premises($APPLICANT->Premises); ?>"
                       class="form-control" disabled="disabled"/>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Center Name : <span
                    class="required">*</span></label>

            <div class="col-lg-7">
                <input type="text" value="<?php echo ucwords(set_value('centername',$APPLICANT->CenterName)); ?>"
                       class="form-control" name="centername">
                <?php echo form_error('centername'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Center Owner : <span
                    class="required ">*</span></label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('centerowner',$APPLICANT->CenterOwner); ?>"
                       class="form-control " name="centerowner">
                <?php echo form_error('centerowner'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Center Cordinator : </label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('cordinator',$APPLICANT->CenterCordinator); ?>"
                       class="form-control " name="cordinator">
                <?php echo form_error('cordinator'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Owner's Edu. Level : <span
                    class="required ">*</span></label>

            <div class="col-lg-7">
                <input type="text" 
                       value="<?php echo  set_value('profession',$APPLICANT->OwnerProfession); ?>"
                       class="form-control" name="profession">
                <?php echo form_error('profession'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">TIN : <span
                        class="required ">*</span> </label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('TIN',$APPLICANT->TIN); ?>"
                       class="form-control" name="TIN" onKeyPress="return numbersonly(event,this.value)" maxlength="9">
                <?php echo form_error('TIN'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Email : <span
                        class="required ">*</span> </label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('email',$APPLICANT->Email); ?>"
                       class="form-control" name="email">
                <?php echo form_error('email'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">NIDA :</label>

            <div class="col-lg-7">
                <input type="text"
                       value="<?php echo set_value('nida',$APPLICANT->national_identification_number); ?>"
                       class="form-control" name="nida" maxlength="20" onKeyPress="return numbersonly(event,this.value)">
                <?php echo form_error('nida'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Country of Residence : <span
                        class="required ">*</span></label>

            <div class="col-lg-7">
                <select name="residence_country" class="form-control select50">
                    <option value=""> [ Select Country ]</option>
                    <?php
                    $sel =  set_value('residence_country',$APPLICANT->residence_country);
                    foreach ($nationality_list as $key => $value) {
                        ?>
                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                value="<?php echo $value->id; ?>"><?php echo $value->Country; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('residence_country'); ?>
            </div>
        </div>
    
        <div class="form-group"><label class="col-lg-3 control-label"> Region of Residence: <span
                                class="required ">*</span></label>

                        <div class="col-lg-7">
                            <select name="region" id="region" class="form-control  select50"
                                onchange="loadDistrict    (this.value,'populate_districts','populate_districts','populate_district');">
                                <option value=""> [ Select Region]</option>
                                <?php
                                $sel =  set_value('region',$APPLICANT->region);
                                foreach ($region_list as $key => $value) {
                                        ?>
                                <option <?php echo($sel == $value->name ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php
                                    }
                                    ?>
                            </select>
                            <?php echo form_error('region'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label"> District of Residence: <span
                                class="required ">*</span></label>

                        <div class="col-lg-7">
                            <div id="populate_districts">
                                <select name="district" class="form-control select50 ">
                                    <option value=""> [ Select District ]</option>
                                    <?php
                                    $sel =  set_value('district',$APPLICANT->district);
                                    foreach ($district_list as $key => $value) {
                                            ?>
                                    <option <?php echo($sel == $value->name ? 'selected="selected"' : ''); ?>
                                        value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php
                                        }
                                        ?>
                                </select>
                            </div>
                            <?php echo form_error('district'); ?>
                        </div>
                    </div>











        <div class="form-group"><label class="col-lg-3 control-label">Nationality : <span
                    class="required ">*</span></label>

            <div class="col-lg-7">
                <select name="nationality" class="form-control select51 ">
                    <option value=""> [ Select Nationality ]</option>
                    <?php
                    $sel =  set_value('nationality',$APPLICANT->Nationality);
                    foreach ($nationality_list as $key => $value) {
                        ?>
                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                            value="<?php echo $value->id; ?>"><?php echo $value->Name; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('nationality'); ?>
            </div>
        </div>
 



 <?php if($APPLICANT->status == 0){ ?>
        <div class="form-group" style="margin-top: 10px;">
            <div class="col-lg-offset-4 col-lg-6">
                <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
            </div>
        </div>

        <?php }else{ ?>
<script>
    disable_edit();
</script>
            <?php } ?>
        <?php echo form_close(); ?>



    </div>
</div>

<script>
    $(document).ready(function () {
        $(".select50").select2({
            theme:'bootstrap',
            placeholder:'[ Select ]',
            allowClear:true
        });
        $(".select51").select2({
            theme:'bootstrap',
            placeholder:'[ Select Nationality ]',
            allowClear:true
        });


    });
</script>