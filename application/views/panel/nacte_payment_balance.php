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
        <h5>NACTE Payment Balance</h5>

    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="text-center">
        <div class="col-lg-5 col-lg-offset-3">
        <p>Note: Payment_reference number obtained once payment done via control number generated</p>
        </div>
        </div>
        <div class="form-group">
            <div class="col-lg-5 col-lg-offset-3">
            <input class="form-control" type="text" name="payment_reference" placeholder="Enter Payment Reference Number"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" type="submit" value="Check Balance"/>
            </div>
        </div>
        <?php echo form_close(); ?>

       <?php
        if(isset($balance)){

            echo '<h2> Balance : '. $balance.'</h2>';
        }

        ?>
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
