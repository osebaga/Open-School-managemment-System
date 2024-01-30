<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">
            <h5>Professional Experience</h5>
        </div>
    </div>

    <div class="ibox-content">

        <?php foreach (experience() as $key=>$value){ ?>
            <div style="margin-bottom: 50px;">
        <div style="font-size: 15px; font-weight: bold; color: brown; border-bottom: 1px solid brown; margin-bottom: 10px;" class="clearfix">
            <?php echo $value; ?>
            <?php  if($APPLICANT->status == 0) { ?>
            <a class="pull-right" style="font-size: 13px !important;" href="<?php echo site_url('applicant_experience/?cat='.$key.'&action=new') ?>"><i class="fa fa-plus"></i> Add New</a>
            <?php } ?>
        </div>
                <?php

                    switch ($key){

                        case 1:
                            include_once 'experience/intership.php';
                            break;

                        case 2:
                            include_once 'experience/training.php';
                            break;

                        case 3:
                            include_once 'experience/work.php';
                            break;

                        default:
                            break;

                    }    ?>


            </div>

        <?php } ?>

    </div>
</div>

<script>
    $(document).ready(function () {
        $(".remove_delete2").confirm({
            title: "Confirm Deletion",
            content: "Are you sure you want to remove selected data ? ",
            confirmButton: 'YES',
            cancelButton: 'NO',
            confirmButtonClass: 'btn-success',
            cancelButtonClass: 'btn-success'
        });

    });
</script>