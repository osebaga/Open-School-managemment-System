<link href="<?php echo base_url(); ?>media/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>media/css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>media/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>media/css/select2-bootstrap.css" rel="stylesheet">

<link href="<?php echo base_url(); ?>media/css/plugins/select2/select2.min.css" rel="stylesheet">


<script src="<?php echo base_url(); ?>media/js/jquery-2.1.1.js"></script>
<script src="<?php echo base_url(); ?>media/js/plugins/select2/select2.full.min.js"></script>

<script src="<?php echo base_url(); ?>media/js/bootstrap.min.js"></script>
<style>
    body {
        background: #ffffff;
    }
</style>
<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox-content" style="padding: 0px;margin-right: 5px; border: 0px; font-size: 15px;">
    <div style=" margin-bottom: 20px;"><span
                style="color: darkgreen; font-weight: bold;">SELECTED PROGRAMME :</span> <?php echo $programme_info->Name; ?>
    </div>


    <?php
            if (isset($content_view) && isset($data)) {
                $this->load->view($content_view, $data);
            } else {
                $this->load->view($content_view);
            }

    ?>




</div>

<script>
    $(document).ready(function () {
        $(".select34").select2({
            theme: 'bootstrap',
            placeholder: '[ Select Subject ]',
            allowClear: true
        });


    })

</script>