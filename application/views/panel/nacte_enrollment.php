<?php
$current_print_title = "NACTE ENROLLMENT";
$current_file_name = "invoice_list_" . date("Y-m-d");
$current_pdf_orientation = "portrait"; //landscape or portrait
$current_column_visibility = ":visible"; // "" or :visible
if (isset($message)) {
    echo $message;
} else if ($this->session->flashdata('message') != '') {
    echo $this->session->flashdata('message');
}
  $prog = '';
?>

<div class="ibox">
    <div class="ibox-title">
        <h5>Nacte Enrollment</h5>
    </div>
    <div class="ibox-content">
    <?php echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>
        <?php echo form_hidden('post_data', '1'); ?>
        <div class="form-group no-padding">

            <div class="col-md-4">
                <select name="programme" class="form-control">
                    <option value=""> [ Select Programme ]</option>
                    <?php $result = $this->db->query("select * from programme where programme_id<>''")->result();
                    foreach ($result as $key => $value) { ?>
                        <option value="<?php echo $value->programme_id; ?>"><?php echo $value->Name; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="intake" class="form-control">
                    <option value=""> [ Select Intake ]</option>
                    <option value="SEPTEMBER">SEPTEMBER</option>
                    <option value="MARCH">MARCH</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="ayear" id="ayear" class="form-control ">
                    <option>[Select applicant Year]</option>
                    <?php
                    $sel = (isset($_GET['ayear']) ? $_GET['ayear'] : "");
                    $year_list = $this->db->query("select * from ayear  order by AYear")->result();
                    foreach ($year_list as $key => $value) { ?>
                        <option <?php echo ($sel == $value->AYear ? 'selected="selected"' : ''); ?> value="<?php echo substr($value->AYear, 5, 4)  ?>"><?php echo substr($value->AYear, 5, 4); ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-1">
                <input class="btn btn-md btn-success" type="submit" value="Pull List" />
            </div>
      
        </div>
   
        <?php echo form_close(); ?>
    
         <form action="<?php echo site_url('enroll_nacte');  ?>" method="POST" > 
                <input class="btn btn-sm btn-success" type="submit" name="enroll" value="Enroll Selected"/>
            
            <div style="clear: both;"></div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive  text-align" id="datatable" width="100%">
                    <thead>
                        <tr>
                            <th>
                                <div>S/No</div>
                            </th>
                            <th>Check</th>
                            <th>F4IndexNo</th>
                            <th>FirstName</th>
                            <th>SecondName</th>
                            <th>LastName</th>
                            <th>Verification Code</th>
                            <th>Verification Status</th>
                            <th>Intake</th>
                            <th>Applicant Year</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $j = 1;

                        for ($i = 0; $i < count($applicants); $i++) {
                            
                            $applicant = $this->db->query("SELECT FirstName,MiddleName,LastName FROM application WHERE form4_index ='" . $applicants[$i]['username'] . "' ")->row();
                        ?>
                        <tr>
                            <td style="text-align: right;"><?php echo $j; ?></td>
                            <td style="text-align: left;"><input type="checkbox" name="user_id[]" value="<?php echo $applicants[$i]['user_id']; ?>"/>
                             <input type="hidden" name="year" value="<?php echo $applicants[$i]['academic_year']; ?>" />
                             <input type="hidden" name="intake" value="<?php echo $applicants[$i]['intake']; ?>" />
                             <input type="hidden" name="programme" value="<?php echo $prog_id; ?>" /> 
                            </td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['username']; ?></td>
                            <td style="text-align: left;"><?php echo $applicant->FirstName; ?></td>
                            <td style="text-align: left;"><?php echo $applicant->MiddleName; ?></td>
                            <td style="text-align: left;"><?php echo $applicant->LastName; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['user_id']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['verification_status']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['intake']; ?></td>
                            <td style="text-align: left;"><?php echo $applicants[$i]['academic_year']; ?></td>
                           
                            <!-- <td style="text-align: left;"></td> -->
                        </tr>

                        <?php $j++;
                        }
                      
                        ?>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>