<?php
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
 

?>
<div class="ibox float-e-margins">
    <div class="ibox-title clearfix">
        <h5>Nacte  List</h5>
       
    </div>
    <div class="ibox-content">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 50px;  text-align: center;">S/No</th>
                <th style="">Programme Name</th>
                
            </tr>
            </thead>
            <tbody>
            <?php 
              
            foreach ($programme_list as $key=>$value){
                    $check_programme = $this->db->query("select Name,programme_id from programme where Name = '".$value['programme']."' ")->row();
                    if(!empty($check_programme)){ 
                    $this->db->query("update programme set programme_id = '".$value['programe_id']."' where name = '".$value['programme']."' ");
                    }
                ?> 
                <tr>

                    <td style="text-align: right; vertical-align: middle;"><?php echo $key+1; ?>.</td>
                    <td style="vertical-align: middle;" ><?php echo $value['programme']; ?></td>
                    
                </tr>
                <?php  } ?>
            </tbody>
        </table>
    </div>

</div>

<script>

     

    $(document).ready(function () {

       
    });
</script>
