<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>">Home</a>
            </li>
            <?php

            foreach($bscrum as $bscrumkey=>$bscrumvalue){
                ?>
                <li <?php echo (count($bscrum) == ($bscrumkey+1) ? 'class="active"':''); ?>>
                    <a href="<?php echo site_url($bscrumvalue['link']) ?>"><?php echo (count($bscrum) == ($bscrumkey+1) ? '<strong>'.$bscrumvalue['title'].'</strong>':$bscrumvalue['title']); ?></a>
                </li>
            <?php
            }
            ?>

        </ol>
    </div>
    <div class="col-lg-6">
<?php
include 'header_notification.php';
?>
    </div>
</div>