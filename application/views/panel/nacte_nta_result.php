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
        <h5>NACTE NTA Result</h5>

    </div>
    <div class="ibox-content">

        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <div class="form-group">
            <div class="col-lg-5 col-lg-offset-3">
            <input class="form-control" type="text" name="registration_number" placeholder="Enter NACTE Registration Number NS0001/0002/2001"/>
            </div>
        </div>
        <div class="form-group">
        <div class="col-lg-5 col-lg-offset-3">
        <select name="nta_level" class="form-control">
            <option value=""> [ Select NTA Level]</option>
            <option value="4">NTA Level 4</option>
            <option value="5">NTA Level 5</option>
            <option value="6">NTA Level 6</option>
                </select>
        </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-8">
                <input class="btn btn-sm btn-success" type="submit" value="Get NTA Result"/>
            </div>
        </div>
        <?php echo form_close(); ?>

       <?php
        if(isset($nta_result)){
           // var_dump($nta_result);
             ?>
          <table class="table table-bordered" width="30%">
            <tbody>
            <?php 
            if($code == 200){ 
            foreach ($nta_result as $key=>$value){
                ?> 
                <tr>
            <td style="text-align: left;width: 5px;">Registration Number</td>
            <td style="width: 5px;" ><?php echo $value['registration_number']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left;width: 5px;">Firstname</td>
            <td style="width: 5px;" ><?php echo $value['firstname']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left;width:5px;">Middle Name</td>
            <td style="width: 5px;" ><?php echo $value['middle_name']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left; width: 5px;">Surname</td>
            <td style="width: 5px;" ><?php echo $value['surname']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left;width: 5px;">Sex</td>
            <td style="width: 5px;" ><?php echo $value['sex']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left;width: 5px;">Date Of Birth</td>
            <td style="width: 5px;" ><?php echo $value['DOB']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left;width: 5px;">Academic Year</td>
            <td style="width: 5px;" ><?php echo $value['accademic_year']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left; width: 5px;">Insitute Name</td>
            <td style="width: 5px;" ><?php echo $value['institution_name']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left; width: 5px;">Programme Name</td>
            <td style="width: 5px;" ><?php echo $value['programme_name']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left; width: 5px;">GPA</td>
            <td style="width: 5px;" ><?php echo $value['GPA']; ?></td>
                </tr>
                <tr>
            <td style="text-align: left; vertical-align: middle; width: 5px;">Class Award</td>
            <td style="width: 5px;" ><?php echo $value['class_award']; ?></td>
                </tr>
                <?php  }
                }else{ ?>
              <tr>
            <td colspan="2" style="text-align: center;"><?php echo $nta_result;  ?></td>
             
                </tr>
                <?php } 
                 ?>
            </tbody>
        </table>
       
       <?php } ?>
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
