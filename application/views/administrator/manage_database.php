<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}


?>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Manage Database</h5>
        </div>
        <div class="ibox-content">
            <?php  if(!isset($query)) {
                echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

                <div class="form-group">
                    <label class="col-lg-12 control-label"></label>

                    <div class="col-lg-12">
                        <textarea class="form-control" rows="5" name="query"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12" style="text-align: right;">
                        <input class="btn btn-sm btn-success" type="submit" value="Commit Query"/>
                    </div>
                </div>

                <?php echo form_close();
            }else{
                echo "<div style='padding-bottom: 10px; border-bottom: 1px solid red;'><b>SQL Query : </b>".$query.'</div>';

                echo '<div style="width: 100%; height: 700px; overflow: auto; padding-top: 20px;">'.$result.'</div>';

            } ?>

            </div>
        </div>
