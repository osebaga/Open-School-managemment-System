<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
?>
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5>Login History</h5>
    </div>
    <div class="ibox-content">

        <div class="col-md-12">

            <form method="GET" action="<?php echo site_url('login_history/'); ?>" class="form-horizontal pull-right">
                <input type="text" class="form-control mydate_input" value="<?php echo(isset($_GET['from']) ? $_GET['from'] : ''); ?>"
                       name="from" placeholder=" FROM : DD-MM-YYYY" style="width: 250px; float: left;"/>
                <input type="text" class="form-control mydate_input" value="<?php echo(isset($_GET['to']) ? $_GET['to'] : ''); ?>"
                       name="to" placeholder="TO : DD-MM-YYYY"
                       style="width: 250px;float: left; margin-left: 20px; margin-right: 20px;"/>


                <input class="btn   btn-primary " type="submit" value="Search"/>

            </form>
        </div>
        <div style="clear: both;"></div>


        <table cellspacing="0" cellpadding="0" class="table table-bordered"
               style="" id="datatable">
            <thead>
            <tr>
                <th style="width: 170px;">TIMESTAMP</th>
                <th style="width: 100px;">IP ADDRESS</th>
                <th style="width: 150px;">USERNAME</th>
                <th>OTHER DETAILS</th>
            </tr>
            </thead>

            <tbody>
            <?php

            foreach($login_history_list as $loginkey=>$loginvalue){
                ?>
<tr>
    <td style="text-align: center;"><?php echo $loginvalue->login_time;  ?></td>
    <td style="text-align: center;"><?php echo $loginvalue->ip;  ?></td>
    <td style="text-align: center;"><?php echo $CURRENT_USER->username;  ?></td>
    <td><?php echo $loginvalue->browser;  ?></td>
</tr>
            <?php
            }
            ?>
            </tbody>
        </table>
<!--        <div>--><?php //echo $pagination_links; ?>
<!--        <div style="clear: both;"></div>-->
<!--        </div>-->


    </div>
</div>