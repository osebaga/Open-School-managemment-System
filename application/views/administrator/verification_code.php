<div class="ibox float-e-margins">

    <div class="ibox-content">
        <!-- <div class="col-md-12 clearfix">

<form method="GET" action="<?php echo current_full_url(); ?>" class="form-horizontal clearfix ">
    <div class="col-md-12 " >
        <div class=" col-lg-4 col-lg-offset-1" >
    <input type="text" class="form-control " value="<?php echo(isset($_GET['key']) ? $_GET['key'] : ''); ?>"
           name="key" placeholder=" Search....."/>
            </div>
        <div class="col-lg-1">
    <input class="btn   btn-primary " type="submit" value="Search"/>
            </div>
    </div>
</form>
</div> -->


        <div class="table-responsive">
            <table cellspacing="0" cellpadding="0" class="table table-bordered" style="" id="datatable">
                <thead>
                    <tr>
                        <th style="width: 1px;">S/No.</th>
                        <th style="width: 120px;">Email</th>
                        <th style="width: 120px;">Username</th>
                        <th style="width: 100px;">Mobile</th>
                        <th style="width: 100px;">Verification Code</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
           $current_user_id = current_user();
            $page1 = ($this->uri->segment(2) ? $this->uri->segment(2) : 1);
             
            foreach($verification as $key => $value){
                ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $page1++; ?>. </td>
                        <td><?php echo $value->email?></td>
                        <td><?php echo $value->username;  ?></td>
                        <td><?php echo $value->phone;  ?></td>
                        <td><?php echo $value->activation_code; ?></td>
                    </tr>
                    <?php
            }

            if(count($verification) == 0){
                ?>
                    <tr>
                        <td colspan="9">No data found !!</td>
                    </tr>
                    <?php
            }
            ?>
                </tbody>
            </table>
        </div>


    </div>
</div>