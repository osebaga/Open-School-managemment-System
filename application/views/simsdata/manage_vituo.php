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
                echo 'Sajili Vituo';
            } else if (!is_null($id) && isset($action)) {
                echo 'Edit Vituo ';
            }
            ?></h5>
    </div>
    <div class="ibox-content">


        <?php


            echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

        <div class="form-group"><label class="col-lg-3 control-label">Mkoa : <span class="required">*</span></label>

            <div class="col-lg-8">
                <select name="txtRegion" id="txtRegion" class="form-control  "  onchange="loadDistrict(this.value,'populate_districts','populate_districts','populate_district');">
                    <option value=""> [  Mkoa ]</option>
                    <?php
                    $sel = isset($vituoinfo) ? get_value('districts',$vituoinfo->district,'region_id'): set_value('district');
                    foreach ($regions as $key => $value) {
                        ?>
                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php echo form_error('txtRegion'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Wilaya : <span class="required">*</span></label>

            <div class="col-lg-8">
                <div id="populate_districts">
                    <select name="district" class="form-control  ">
                        <option value=""> [  Wilaya ]</option>
                        <?php
                        $sel = (isset($vituoinfo) ? $vituoinfo->district : set_value('district'));
                        foreach ($districts as $key => $value) {
                            ?>
                            <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <?php echo form_error('district'); ?>
            </div>
        </div>


        <div class="form-group"><label class="col-lg-3 control-label">Jina la kituo : <span class="required">*</span></label>

                <div class="col-lg-8">
                    <input type="text" name="name"
                           value="<?php echo(isset($vituoinfo) ? $vituoinfo->name : set_value('name')) ?>"
                           class="form-control"/>
                    <?php echo form_error('name'); ?>
                </div>
            </div>

        <div class="form-group"><label class="col-lg-3 control-label">Anuani : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" name="anuani"
                       value="<?php echo(isset($vituoinfo) ? $vituoinfo->anuani : set_value('anuani')) ?>"
                       class="form-control"/>
                <?php echo form_error('anuani'); ?>
            </div>
        </div>

        <div class="form-group"><label class="col-lg-3 control-label">Jina la Mkuu wa Kituo : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" name="mkuukituo"
                       value="<?php echo(isset($vituoinfo) ? $vituoinfo->jinalamkuu : set_value('mkuukituo')) ?>"
                       class="form-control"/>
                <?php echo form_error('mkuukituo'); ?>
            </div>
        </div>
        <div class="form-group"><label class="col-lg-3 control-label">Namba ya Simu ya Mkuu wa kituo : <span class="required">*</span></label>

            <div class="col-lg-8">
                <input type="text" name="mkuukituonumber" placeholder="Eg. 0xxxxxxxxx"
                       value="<?php echo(isset($vituoinfo) ? $vituoinfo->simuyamkuu : set_value('mkuukituonumber')) ?>"
                       class="form-control" onKeyPress="return numbersonly(event,this.value)" maxlength="10"/>
                <?php echo form_error('mkuukituonumber'); ?>
            </div>
        </div>

            <div class="form-group">
                <div class="col-lg-offset-3 col-lg-8">
                    <input class="btn btn-sm btn-success" type="submit" value="Save Vituo"/>
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
            placeholder: " [ Select College/School ] ",
            allowClear: true
        });

    })

    function loadDistrict(value,target_field,get_focused_field,action) {
        $.ajax({
            type:"post",
            url:"<?php echo site_url('loadDistrict') ?>",
            data: {
                target:target_field,
                id:value,
                ffocus:get_focused_field,
                action:action
            },
            datatype:"text",
            success:function(data)
            {
                $( "#" + target_field).html(data);
            }
        });

    }
</script>