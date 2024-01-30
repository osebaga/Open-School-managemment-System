<?php
include VIEWPATH.'include/pbscrum.php';
?>

<div class="col-lg-12 text-center">
    <?php if($_GET['type'] != 4 ) { ?>
        <h1>Registration Process step 1</h1>
        <p>Application Deadline Date : <?php echo date('F d, Y', strtotime(get_application_deadline())); ?> </p>

        <?php
    }else{
        echo "<h1></h1>";
    }
    if (isset($message)) {
        echo $message;
    } else if ($this->session->flashdata('message') != '') {
        echo $this->session->flashdata('message');
    }
    ?>
</div>


<div class="row gray-bg">
    <div class="container">
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-heading">
                    <?php if($_GET['type'] == 4 ){ ?>
                        <div class="ibox-title"><h5 style="color: brown;"> MAELEZO MUHIMU</h5></div>
                    <?php } else{?>
                    <div class="ibox-title"><h5 style="color: brown;"> IMPORTANT NOTE</h5></div>
                    <?php } ?>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <?php if($_GET['type'] != 4 ){ ?>
                        <tr>
                            <td class="no-borders"> 1. Your name must be the same as in  <?php echo ($_GET['entry'] > 6 ? 'your Academic' : 'Form IV') ?> Certificate</td>
                        </tr>
                        <tr>
                            <td> 2. Date of Birth must be the same as  in  Birth Certificate</td>
                        </tr>
                        <tr>
                            <?php if($_GET['entry'] > 6 ){ ?>
                                <td> 3. Index Number must be the same as  in  Entry Mode Certificate</td>
                            <?php }else{ ?>
                            <td> 3. Form IV index Number must be the same as  in  Form IV Certificate</td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td> 4. <strong>Failure to any of the above, Your application will be disqualified  </strong></td>
                        </tr>
                        <tr>
                            <td> 5. Make sure <b>Application Type</b> and <b>Entry Type</b> are correct before submit form in the right side because you will not be able to start any  new application</td>
                        </tr>
                        <tr>
                            <td> 6. Once <?php echo ($_GET['entry'] > 6 ? '' : 'Form IV' ); ?>  Index Number Registered, you will not be able to change it.</td>
                        </tr>
                        <tr>
                            <td> 7. <strong>Application fee must be paid within four (4) days from the first day of filling an application, otherwise your account will be deleted permanent.</strong></td>
                        </tr>
                        <tr>
                            <td> 8. <strong>Make sure you read Admission requirement before selecting/Choose programmes.</strong></td>
                        </tr>
                        <tr>
                            <td> 9. Online support : <?php echo ONLINE_SUPPORT; ?> </td>
                        </tr>
                        <?php }else{?>
                            <tr>
                                <td> 1. Unaweza kuwasiliana nasi kwa namba zifuatazo  : <br/><?php echo ONLINE_SUPPORT_SW; ?> </td>
                            </tr>
                        <?php }?>
                    </table>



                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-heading">
                    <?php if($_GET['type'] != 4 ){ ?>
                    <div class="ibox-title"><h5>Applicant Basic Information</h5></div>
                    <?php }else{?>
                        <div class="ibox-title"><h5 style="color: brown;">TAARIFA BINAFSI</h5></div>
                    <?php }?>
                </div>

                <div class="ibox-content">

                    <?php  echo form_open_multipart(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

                    <?php if($_GET['type'] != 4 ){ ?>

                    <div class="form-group"><label class="col-lg-3 control-label">Application Type  : <span class="required">*</span></label>

                        <div class="col-lg-7">
                            <input type="text"
                                   value="<?php echo application_type($type); ?>"
                                   class="form-control" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-3 control-label">Entry Type  : <span class="required">*</span></label>

                        <div class="col-lg-7">
                            <input type="text"
                                   value="<?php echo entry_type($entry); ?>"
                                   class="form-control" disabled="disabled"/>
                        </div>
                    </div>

                    <?php if($entry==1 or $entry==2 or $entry==4  or  $entry==3){

                        ?>
                        <div class="form-group"><label class="col-lg-4 control-label">
                                <?php if($_GET['NT'] == 0 ){
                                    echo ' O-level Index/O-level Equivalent Number/ :';
                                }else{
                                    echo ' O-level Index Number :';
                                }
                                ?>
                                <span class="required">*</span></label>

                            <div class="col-lg-6">
                                <input type="text" value="<?php echo set_value('o_level_index_no'); ?>"
                                       class="form-control" name="o_level_index_no"  onblur="loadAjaxData(this.value,'','','o-level')" id="o_level_index_no">
                                <div id="sample_index" >Eg <b><?php echo ($_GET['NT'] ==0 )?'EQxxxxxxxxxx':'S0125/0000/2005 or P0125/0000/2005'; ?></b></div>
                                <?php echo form_error('o_level_index_no'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-3 control-label">Year Completed : <span
                                        class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('o_completed_year'); ?>"
                                       class="form-control" name="o_completed_year" id="o_completed_year"  onKeyPress="return numbersonly(event,this.value)" maxlength="4" readonly onblur="checkYear(this.value,$('#o_level_index_no').val(),'o-level')">
                                <?php echo form_error('o_completed_year'); ?>
                            </div>
                        </div>


                        <?php
                    } ?>

                    <div class="form-group"><label class="col-lg-3 control-label">First Name : <span
                                    class="required">*</span></label>

                        <div class="col-lg-7">
                            <input type="text" value="<?php echo set_value('firstname'); ?>"
                                   class="form-control" name="firstname" id="firstname" <?php echo ($entry==1 or $entry==2 or $entry==4 or $entry==3 )?'readonly':''; ?> >
                            <?php echo form_error('firstname'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label">Last Name : <span
                                    class="required ">*</span></label>

                        <div class="col-lg-7">
                            <input type="text"
                                   value="<?php echo set_value('lastname'); ?>"
                                   class="form-control " name="lastname"  id="lastname" <?php echo ($entry==1 or $entry==2 or $entry==4 or $entry==3)?'readonly':''; ?>>
                            <?php echo form_error('lastname'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label">Middle Names : </label>

                        <div class="col-lg-7">
                            <input type="text"
                                   value="<?php echo set_value('middlename'); ?>"
                                   class="form-control " name="middlename"  id="middlename" <?php echo ($entry==1 or $entry==2 or $entry==4 or $entry==3 )?'readonly':''; ?>>
                            <?php echo form_error('middlename'); ?>
                        </div>
                    </div>
                    <?php if( $entry==2 ){
                        ?>
                        <div class="form-group"><label class="col-lg-4 control-label">
                                <?php if($_GET['NT'] == 0 ){
                                    echo ' A-level Index/ A-level Equivalent Number/ :';
                                }else{
                                    echo ' A-level Index Number :';
                                }
                                ?>
                                <span class="required">*</span></label>

                            <div class="col-lg-6">
                                <input type="text" value="<?php echo set_value('a_level_index_no'); ?>"
                                       class="form-control" name="a_level_index_no"  id="a_level_index_no" onblur="loadAjaxData(this.value,'','','a-level')">
                                <div id="sample_index" >Eg <b><?php echo ($_GET['NT'] ==0 )?'EQxxxxxxxxxx':'S0125/0000/2005 or P0125/0000/2005'; ?></b></div>
                                <div id="center_name"></div>

                                <?php echo form_error('a_level_index_no'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-3 control-label">Year Completed : <span
                                        class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('a_completed_year'); ?>"
                                       class="form-control" name="a_completed_year" id="a_completed_year"  onKeyPress="return numbersonly(event,this.value)" maxlength="4" readonly onblur="checkYear(this.value,$('#a_level_index_no').val(),'a-level')">
                                <?php echo form_error('a_completed_year'); ?>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-3 control-label">School : <span
                                        class="required">*</span></label>

                            <div class="col-lg-7">
                                <input type="text" value="<?php echo set_value('school'); ?>"
                                       class="form-control" name="school"  id="school" readonly>
                                <div id="center_name"></div>
                                <?php echo form_error('school'); ?>
                            </div>
                        </div>

                        <?php
                    } ?>


                    <?php if($entry==4){
                        ?>
                        <div class="form-group"><label class="col-lg-4 control-label">NACTE Award Verification Number : <span
                                        class="required">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo set_value('avn'); ?>"
                                       class="form-control" name="avn"  onblur="loadAjaxData(this.value,'','','avn')">
                                <div id="center_name"></div>
                                <?php echo form_error('avn'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-3 control-label">Institution : <span
                                        class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text" value="<?php echo set_value('institution'); ?>"
                                       class="form-control" name="institution" id="institution" readonly>
                                <div id="center_name"></div>
                                <?php echo form_error('institution'); ?>
                            </div>
                        </div>

                        <?php
                    } ?>

                        <?php if($entry==3){
                            ?>
                            <div class="form-group"><label class="col-lg-3 control-label">Certificate Type : <span
                                            class="required">*</span></label>

                                <div class="col-lg-7">
                                    <select name="cert_type" id="cert_type" class="form-control">
                                        <option value=""> [ Select Certificate Type ]</option>
                                        <?php  $sel =  set_value('cert_type');?>
                                       <option value="1" <?php echo($sel==1)?"selected" : ''; ?>>Grade A Teachers' Certificate</option>
                                        <option value="0" <?php echo($sel==0)?"selected" : ''; ?>>Others</option>
                                    </select>

                                    <?php echo form_error('cert_type'); ?>
                                </div>
                            </div>


                            <div class="form-group"><label class="col-lg-4 control-label">NT level 4 Index Number : <span
                                            class="required">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" value="<?php echo set_value('ntlevel_index'); ?>"
                                           class="form-control" id="ntlevel_index" name="ntlevel_index"  onblur1="loadAjaxData(this.value,'','','nt')">
                                    <div id="sample_ntindex"  style="display: none">Eg <b>E0125/0000/2005</b></div>

                                    <?php echo form_error('ntlevel_index'); ?>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-3 control-label">Programme Title : <span
                                            class="required">*</span></label>
                                <div class="col-lg-7">
                                    <input type="text" value="<?php echo set_value('program_title'); ?>"
                                           class="form-control" name="program_title" id="program_title" >
                                    <?php echo form_error('program_title'); ?>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-3 control-label">College /
                                    Institution  : <span
                                            class="required">*</span></label>

                                <div class="col-lg-7">
                                    <input type="text"
                                           value="<?php echo set_value('school'); ?>"
                                           class="form-control" name="school">
                                    <?php echo form_error('school'); ?>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">Examination Authority : <span
                                            class="required">*</span></label>

                                <div class="col-lg-8">
                                    <input type="text"
                                           value="<?php echo set_value('exam_authority1'); ?>"
                                           class="form-control" name="exam_authority1" placeholder="Eg: NACTE">
                                    <?php echo form_error('exam_authority1'); ?>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">Country : <span
                                            class="required">*</span></label>

                                <div class="col-lg-7">
                                    <select name="country1" id="country1" class="form-control select50 ">
                                        <option value=""> [ Select Country ]</option>
                                        <?php
                                        $nationality_list=$this->common_model->get_nationality()->result();
                                        $sel = set_value('country1');
                                        foreach ($nationality_list as $key => $value) {
                                            ?>
                                            <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                                    value="<?php echo $value->id; ?>"><?php echo $value->Country; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                    <?php echo form_error('country1'); ?>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-lg-3 control-label">GPA : </label>
                                <div class="col-lg-7">
                                    <input type="text" value="<?php echo set_value('gpa'); ?>"
                                           class="form-control" name="gpa" id="gpa" >
                                    <div id="center_name"></div>
                                    <?php echo form_error('gpa'); ?>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">Year Completed : <span
                                            class="required">*</span></label>
                                <div class="col-lg-7">
                                    <input type="text" placeholder="Eg: 2015"
                                           value="<?php echo set_value('completed_year'); ?>"
                                           class="form-control" name="completed_year">
                                    <?php echo form_error('completed_year'); ?>
                                </div>
                            </div>

                            <div class="form-group disabledata"><label class="col-lg-4 control-label">Attach NT level 4 Certificate <span
                                            class="required">*</span> : </label>
                                <div class="col-lg-6">
                                    <input type="file" name="file1" class="form-control"/>
                                    <?php echo(form_error('file1') ? form_error('file1') : (isset($upload_error) ? '<div class="required">' . $upload_error . '</div>' : ''));

                                    ?>
                                </div>
                            </div>




                            <?php
                        } ?>


                    <div class="form-group"><label class="col-lg-3 control-label">Gender : <span
                                    class="required">*</span></label>

                        <div class="col-lg-7">
                            <select name="gender" class="form-control">
                                <option value=""> [ Select Gender ]</option>
                                <?php
                                $sel =  set_value('gender');
                                foreach ($gender_list as $key => $value) {
                                    ?>
                                    <option <?php echo($sel == $value->code ? 'selected="selected"' : ''); ?>
                                            value="<?php echo $value->code; ?>"><?php echo $value->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php echo form_error('gender'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label">Birth Date : <span
                                    class="required ">*</span></label>

                        <div class="col-lg-7">
                            <input type="text" placeholder="DD-MM-YYYY"
                                   value="<?php echo  set_value('dob'); ?>"
                                   class="form-control  mydate_input" name="dob" autocomplete="off">
                            <?php echo form_error('dob'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label">Place of Birth : <span
                                    class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <input type="text"
                                   value="<?php echo set_value('birth_place'); ?>"
                                   class="form-control" name="birth_place" >
                            <?php echo form_error('birth_place'); ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-3 control-label">Marital Status : <span
                                    class="required ">*</span></label>

                        <div class="col-lg-7">
                            <select name="marital_status" class="form-control ">
                                <option value=""> [ Select Marital Status ]</option>
                                <?php
                                $sel =  set_value('marital_status');
                                foreach ($marital_status_list as $key => $value) {
                                    ?>
                                    <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                            value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php echo form_error('marital_status'); ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-3 control-label" style="font-size: 13px;">Country of Residence : <span
                                    class="required ">*</span></label>

                        <div class="col-lg-7">
                            <select name="residence_country" class="form-control select50">
                                <option value=""> [ Select Country ]</option>
                                <?php
                                $sel =  set_value('residence_country',(isset($_GET['NT']) ?  220 :''));
                                foreach ($nationality_list as $key => $value) {
                                    ?>
                                    <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                            value="<?php echo $value->id; ?>"><?php echo $value->Country; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php echo form_error('residence_country'); ?>
                        </div>
                    </div>
                        <div class="form-group"><label class="col-lg-3 control-label"> Region of Residence: <span
                                        class="required ">*</span></label>

                            <div class="col-lg-7">
                                <select name="region" id="region" class="form-control  "  onchange="loadDistrict    (this.value,'populate_districts','populate_districts','populate_district');">
                                    <option value=""> [ Select Region]</option>
                                    <?php
                                    $sel =  set_value('region');
                                    foreach ($regions as $key => $value) {
                                        ?>
                                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                                value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('region'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-3 control-label"> District of Residence: <span
                                        class="required ">*</span></label>

                            <div class="col-lg-7">
                                <div id="populate_districts">
                                    <select name="district" class="form-control  ">
                                        <option value=""> [ Select District ]</option>
                                        <?php
                                        $sel =  set_value('district');
                                        foreach ($districts as $key => $value) {
                                            ?>
                                            <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                                    value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php echo form_error('district'); ?>
                            </div>
                        </div>


                        <div class="form-group"><label class="col-lg-3 control-label">Nationality : <span
                                    class="required ">*</span></label>

                        <div class="col-lg-7">
                            <select name="nationality" class="form-control select51 ">
                                <option value=""> [ Select Nationality ]</option>
                                <?php
                                $sel =  set_value('nationality',(isset($_GET['NT']) ? 220 :''));
                                foreach ($nationality_list as $key => $value) {
                                    ?>
                                    <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                            value="<?php echo $value->id; ?>"><?php echo $value->Name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php echo form_error('nationality'); ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-lg-3 control-label">Disability : <span
                                      class="required ">*</span></label>

                        <div class="col-lg-7">
                            <select name="disability" class="form-control ">
                                <option value=""> [ Select Disability ]</option>
                                <?php
                                $sel =  set_value('disability');
                                foreach ($disability_list as $key => $value) {
                                    ?>
                                    <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                            value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <?php echo form_error('disability'); ?>
                        </div>
                    </div>


                    <div class="form-group"><label class="col-lg-3 control-label">Email : <span
                                    class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <input type="text"
                                   value="<?php echo set_value('email'); ?>"
                                   class="form-control" name="email"  id="email">
                            <?php echo form_error('email'); ?>
                        </div>
                    </div>

             <?php if ($type== 2) {
                 ?>
                
                    <div class="form-group"><label class="col-lg-3 control-label">Campus: <span
                                    class="required ">*</span></label>

                        <div class="col-lg-7">
                            <select name="application_campus" class="form-control" id = 'application_campus'>
                                <option value=""> [ Select Campus ]</option>
                                <?php
                                foreach ($campus as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value->name; ?>"><?php echo $value->name; ?></option>
                                    <?php 
                                }
                                ?>
                            </select>
                            <?php echo form_error('application_campus'); ?>
                        </div>
                    </div>
                <?php } ?>



                        <?php if($type==2) {?>


                            <div class="form-group"><label class="col-lg-3 control-label">National Identification Number : </label>

                                <div class="col-lg-7">
                                    <input type="text"
                                           value="<?php echo set_value('idnumber'); ?>"
                                           class="form-control" name="idnumber" id="idnumber">
                                    <?php echo form_error('idnumber'); ?>
                                </div>
                            </div>

                        <?php  } ?>


                    <div style="color: brown; font-weight: bold; margin-bottom: 15px; margin-top: 10px;  border-bottom: 1px solid brown; font-size: 15px;">Login Credentials</div>

                    <div class="form-group"><label class="col-lg-3 control-label">Username : <span
                                    class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <input type="text"  name="username"  id="username" value="<?php echo set_value('username'); ?>"  class="form-control" readonly>
                            <div style="font-size: 11px;">N.B Username is your valid email address</div>
                            <?php echo form_error('username'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label">Password : <span
                                    class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <input type="password"
                                   value=""
                                   class="form-control" name="password">
                            <?php echo form_error('password'); ?>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-lg-3 control-label">Confirm Password : <span
                                    class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <input type="password"
                                   value=""
                                   class="form-control" name="conf_password">
                            <?php echo form_error('conf_password'); ?>
                        </div>
                    </div>









                    <input id="olevel_name" name="olevel_name" type="hidden">
                    <input id="alevel_name" name="alevel_name" type="hidden">
                    <?php }  else{?>
<!--Iposa inaanza hapa-->

                        <div class="form-group"><label class="col-lg-4 control-label">Number ya usajili(Reg#)  : <span class="required">*</span></label>

                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txtRegno'); ?>"
                                       class="form-control" name="txtRegno"/>
                                <?php echo form_error('txtRegno'); ?>
                            </div>
                        </div>



                        <div class="form-group"><label class="col-lg-4 control-label">Jina La kwanza  : <span class="required">*</span></label>

                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txtFirstName'); ?>"
                                       class="form-control" name="txtFirstName"/>
                                <?php echo form_error('txtFirstName'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Jina La Kati  :</label>

                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txtMiddleName'); ?>"
                                       class="form-control" name="txtMiddleName"/>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Jina La Mwishao  : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txtLastName'); ?>"
                                       class="form-control" name="txtLastName"/>
                                <?php echo form_error('txtLastName'); ?>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-4 control-label">Jinsia (ME Au KE) : <span
                                        class="required">*</span></label>

                            <div class="col-lg-7">
                                <select name="txtGender" class="form-control">
                                    <option value=""> [ Chagua Jinsia ]</option>
                                    <?php
                                    $sel =  set_value('txtGender');
                                    ?>
                                    <option value="Male" <?php echo ($sel=='Male')?"selected='selected'":''; ?>>ME </option>
                                    <option value="Female" <?php echo ($sel=='Female')?"selected='selected'":''; ?>>KE </option>
                                </select>
                                <?php echo form_error('txtGender'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Tarehe ya Kuzaliwa : <span
                                        class="required ">*</span></label>

                            <div class="col-lg-7">
                                <input type="text" placeholder="DD-MM-YYYY"
                                       value="<?php echo  set_value('txtDob'); ?>"
                                       class="form-control  mydate_input" name="txtDob" autocomplete="off">
                                <?php echo form_error('txtDob'); ?>
                            </div>
                        </div>


                        <div class="form-group"><label class="col-lg-4 control-label">Kabila  : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txtTribe'); ?>"
                                       class="form-control" name="txtTribe"/>
                                <?php echo form_error('txtTribe'); ?>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-4 control-label">Hali ya Ndoa: <span
                                        class="required">*</span></label>

                            <div class="col-lg-7">
                                <select name="txtMerritalStatus" class="form-control">
                                    <option value=""> [ Chagua hali ya ndoa ]</option>
                                    <?php
                                    $sel =  set_value('txtMerritalStatus');
                                    ?>
                                    <option value="Married" <?php echo ($sel=='Married')?"selected='selected'":''; ?>>Sijaoa/Sijaolewa </option>
                                    <option value="Single" <?php echo ($sel=='Single')?"selected='selected'":''; ?>>Nimeoa/Nimeolewa </option>
                                </select>
                                <?php echo form_error('txtMerritalStatus'); ?>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-4 control-label">Idadi ya watoto</label>
                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txtChildren'); ?>"
                                       class="form-control" name="txtChildren"/>
                            </div>
                        </div>


                        <div class="form-group"><label class="col-lg-4 control-label">Mkoa: <span
                                        class="required">*</span></label>

                            <div class="col-lg-7">
                                <select name="txtRegion" id="txtRegion" class="form-control  "  onchange="loadDistrict(this.value,'populate_districts','populate_districts','populate_district');">
                                    <option value=""> [ Chagua Mkoa ]</option>
                                    <?php
                                    $sel =  set_value('txtRegion');
                                    foreach ($regions as $key => $value) {
                                        ?>
                                        <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                                value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('txtRegion'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Wilaya: <span
                                        class="required">*</span></label>

                            <div class="col-lg-7">
                                <div id="populate_districts" >
                                    <select name="district" id="district" class="form-control" onchange="loadVituo(this.value,'populate_vituo','populate_vituo','populate_vituo');">
                                        <option value=""> [ Chagua Wilaya ]</option>
                                        <?php
                                        $sel =  set_value('district');
                                        foreach ($districts as $key => $value) {
                                            ?>
                                            <option <?php echo($sel == $value->id ? 'selected="selected"' : ''); ?>
                                                    value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php echo form_error('district'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Kata  : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txtWard'); ?>"
                                       class="form-control" name="txtWard"/>
                                <?php echo form_error('txtWard'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Kijiji  : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txVillage'); ?>"
                                       class="form-control" name="txVillage"/>
                                <?php echo form_error('txVillage'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Kiwango Chaelimu(Darasa uliloishia)  : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <select class="form-control" id="txEducation" name="txEducation">
                                    <option value="">[ Kiwango cha elimu ]</option>
                                    <?php
                                    $sel =  set_value('txEducation');
                                    foreach (iposa_eduction_type() as $key => $value) {
                                        ?>
                                        <option <?php echo($sel == $key ? 'selected="selected"' : ''); ?>
                                                value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('txEducation'); ?>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-4 control-label">Kazi unayofanya kwa sasa  : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <select class="form-control" id="txJob" name="txJob">
                                    <option value="">[ Kazi unayofanya ]</option>
                                    <?php
                                    $sel =  set_value('txJob');
                                    foreach (iposa_job_type() as $key => $value) {
                                        ?>
                                        <option <?php echo($sel == $key ? 'selected="selected"' : ''); ?>
                                                value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('txJob'); ?>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-lg-4 control-label">Aina ya ulemavu(Kama ipo) : </label>
                            <div class="col-lg-7">

                                <select class="form-control" id="txtDisability" name="txtDisability">
                                    <option value="">[ Aina ya ulemavu ]</option>
                                    <?php
                                    $sel =  set_value('txtDisability');
                                    foreach (iposa_disability_type() as $key => $value) {
                                        ?>
                                        <option <?php echo($sel == $key ? 'selected="selected"' : ''); ?>
                                                value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('txtDisability'); ?>


                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Unapenda Kujifunza Mambo Gani Ikiwa Utapata Nafasi Ya Kujiunga Na Masomo Haya? : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <textarea class="form-control" rows="10" name="txtWantToLearn"><?php echo set_value('txtWantToLearn'); ?></textarea>

                                <?php echo form_error('txtWantToLearn'); ?>
                            </div>
                        </div>
                        <div style="color: brown; font-weight: bold; margin-bottom: 15px; margin-top: 10px;  border-bottom: 1px solid brown; font-size: 15px;">TAARIFA ZA MTU WA KARIBU</div>
                        <div class="form-group"><label class="col-lg-4 control-label">Jina la mtu wa karibu : <span class="required">*</span></label>
                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txtKinName'); ?>"
                                       class="form-control" name="txtKinName"/>
                                <?php echo form_error('txtKinName'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Uhusiano : <span class="required">*</span></label></label>
                            <div class="col-lg-7">
                                <select class="form-control" id="txtKinRelation" name="txtKinRelation">
                                    <option value="">[ Uhusino wa mtu wa karibu ]</option>
                                    <option value="Baba">Baba</option>
                                    <option value="Mama">Mama</option>
                                    <option value="Mke">Mke</option>
                                    <option value="Mme">Mme</option>
                                    <option value="Mlezi">Mlezi</option>
                                </select>

                                <?php echo form_error('txtKinRelation'); ?>
                            </div>
                        </div>

                    <div class="form-group"><label class="col-lg-4 control-label">Namba ya Simu ya mtu wa karibu : <span
                                class="required disabledata">*</span> </label>

                    <div class="col-lg-7">
                        <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo set_value('txtNextMobile'); ?>" class="form-control" name="txtNextMobile" onKeyPress="return numbersonly(event,this.value)" maxlength="10" >
                        <?php echo form_error('txtNextMobile'); ?>
                    </div>
                </div>
                        <div style="color: brown; font-weight: bold; margin-bottom: 15px; margin-top: 10px;  border-bottom: 1px solid brown; font-size: 15px;">UTHIBITISHO KUTOKA SERIKALI YA MTAA/KIJIJI</div>
                        <div class="form-group"><label class="col-lg-4 control-label">Jina la Mratibu Elimu Kata : <span class="required">*</span></label> </label>
                            <div class="col-lg-7">
                                <input type="text"
                                       value="<?php echo set_value('txtMratibuName'); ?>"
                                       class="form-control" name="txtMratibuName"/>
                                <?php echo form_error('txtMratibuName'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Namba ya Simu Mratibu : <span
                                        class="required disabledata">*</span> </label>

                            <div class="col-lg-7">
                                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="<?php echo set_value('txtMratibuMobile'); ?>" class="form-control" name="txtMratibuMobile" onKeyPress="return numbersonly(event,this.value)" maxlength="10" >
                                <?php echo form_error('txtMratibuMobile'); ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-lg-4 control-label">Tarehe  : <span
                                        class="required ">*</span></label>

                            <div class="col-lg-7">
                                <input type="text" placeholder="DD-MM-YYYY"
                                       value="<?php echo  set_value('txtMratibuDate'); ?>"
                                       class="form-control  mydate_input1" name="txtMratibuDate" autocomplete="off">
                                <?php echo form_error('txtMratibuDate'); ?>
                            </div>
                        </div>

                        <div style="color: brown; font-weight: bold; margin-bottom: 15px; margin-top: 10px;  border-bottom: 1px solid brown; font-size: 15px;">TAARIFA ZA KITUO</div>


                        <div class="form-group"><label class="col-lg-4 control-label">Kituo : <span class="required">*</span></label> </label>
                            <div class="col-lg-7">
                                <div id="populate_vituo">
                                <select name="kituo" class="select2_search1 form-control " >
                                    <option value=""></option>
                                    <?php
                                    $sel =  set_value('kituo');
                                    foreach($vituo_list as $key=>$value){ ?>
                                        <option <?php echo ($sel == $value->id ? 'selected="selected"':''); ?> value="<?php echo $value->id; ?>"><?php echo $value->name ?></option>
                                    <?php }
                                    ?>
                                </select>
                                </div>
                                <?php echo form_error('kituo'); ?>

                            </div>
                        </div>


<!--                        <div class="form-group"><label class="col-lg-4 control-label">Jina la Kituo : <span class="required">*</span></label> </label>-->
<!--                            <div class="col-lg-7">-->
<!--                                <input type="text"-->
<!--                                       value="--><?php //echo set_value('txKituoName'); ?><!--"-->
<!--                                       class="form-control" name="txKituoName"/>-->
<!--                                --><?php //echo form_error('txKituoName'); ?>
<!---->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form-group"><label class="col-lg-4 control-label">Anuani : <span class="required">*</span></label> </label>-->
<!--                            <div class="col-lg-7">-->
<!--                                <input type="text"-->
<!--                                       value="--><?php //echo set_value('txKituoAddress'); ?><!--"-->
<!--                                       class="form-control" name="txKituoAddress"/>-->
<!--                                --><?php //echo form_error('txKituoAddress'); ?>
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="form-group"><label class="col-lg-4 control-label">Jina la Mkuu wa Kituo : <span class="required">*</span></label> </label>-->
<!--                            <div class="col-lg-7">-->
<!--                                <input type="text"-->
<!--                                       value="--><?php //echo set_value('txKituoMkuuName'); ?><!--"-->
<!--                                       class="form-control" name="txKituoMkuuName"/>-->
<!--                                --><?php //echo form_error('txKituoMkuuName'); ?>
<!---->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="form-group"><label class="col-lg-4 control-label">Namba ya Simu ya Mkuu wa kituo : <span-->
<!--                                        class="required disabledata">*</span> </label>-->
<!---->
<!--                            <div class="col-lg-7">-->
<!--                                <input type="text" placeholder="Eg. 0xxxxxxxxx" value="--><?php //echo set_value('txtKituoMkuuMobile'); ?><!--" class="form-control" name="txtKituoMkuuMobile" onKeyPress="return numbersonly(event,this.value)" maxlength="10" >-->
<!--                                --><?php //echo form_error('txtKituoMkuuMobile'); ?>
<!--                            </div>-->
<!--                        </div>-->

                        <div class="form-group"><label class="col-lg-4 control-label">Tarehe  : <span
                                        class="required ">*</span></label>

                            <div class="col-lg-7">
                                <input type="text" placeholder="DD-MM-YYYY"
                                       value="<?php echo  set_value('txtKituoDate'); ?>"
                                       class="form-control  mydate_input1" name="txtKituoDate" autocomplete="off">
                                <?php echo form_error('txtKituoDate'); ?>
                            </div>
                        </div>
                        <div style="color: brown; font-weight: bold; margin-bottom: 15px; margin-top: 10px;  border-bottom: 1px solid brown; font-size: 15px;">AMBATANISHA FORM ULIYOJAZA KWA MKONO</div>
                        <div class="form-group"><label class="col-lg-4 control-label">Form (.pdf)  : </label>

                            <div class="col-lg-7">
                                <input type="file"  class="form-control" name="file" id="file">
                                <?php echo form_error('file'); ?>
                            </div>
                        </div>

                <?php } ?>
                    <div style="color: brown; font-weight: bold; margin-bottom: 15px; margin-top: 10px;  border-bottom: 1px solid brown; font-size: 15px;"><THIBITISHA></THIBITISHA></div>
                    <div class="form-group"><label class="col-lg-4 control-label"><?php echo ($_GET['type'] == 4) ?'Wewe ni mwanadamu ?':'Are you a human ?'; ?><span
                                    class="required ">*</span> </label>

                        <div class="col-lg-7">
                            <img src="<?php echo site_url('home/capture/'.$captcha_num); ?>"/>
                            <input type="text"
                                   value="" placeholder="<?php echo($_GET['type'] == 4)?'Andika tarakimu 6 unazoziona hapo juu':'Type six digit code as shown above'?>"
                                   class="form-control" name="capture">
                            <?php echo form_error('capture'); ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px;">
                        <div class="col-lg-offset-5 col-lg-6">
                            <input class="btn btn-sm btn-success" type="submit" value="Save Information"/>
                        </div>
                    </div>
                </div>


                    <?php echo form_close(); ?>



            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {


        $("#cert_type").change(function () {
            var type_selected=$(this). children("option:selected"). text();
            var value=$(this).val();

            if(value==1)
            {
                $("#program_title").val(type_selected)
                $("#program_title").prop("readonly", true);
                $("#ntlevel_index").prop("placeholder", "E0125/0000/2005");
                $("#sample_ntindex").show();
            }else
            {
                $("#program_title").val('')
                $("#program_title").prop("readonly", false);
                $("#sample_ntindex").css('display','none');
                $("#ntlevel_index").prop("placeholder", "");

            }
            // if(type_selected=='Not Employeed' )
            // {
            //     $("#organization_name").css('display','none');
            // }else{
            //     $("#organization_name").show();
            //
            //     if(type_selected=='Student')
            //     {
            //         $("#orgname").empty();
            //         $("#orgname").append("Institution Name");
            //     }else{
            //         $("#orgname").empty();
            //         $("#orgname").append("Organization Name");
            //     }
            // }

        });

        $('.mydate_input').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            endDate:"30-12-2007"
        });
        $('.mydate_input1').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",

        });


            $(".select50").select2({
                theme:'bootstrap',
                placeholder:'[ Select Country ]',
                allowClear:true
            });
            $(".select51").select2({
                theme:'bootstrap',
                placeholder:'[ Select Nationality ]',
                allowClear:true
            });
        $("#email").blur(function(){
            $('input[name="username"]').val(this.value);
            $("#username").prop("readonly", true);
        });


    })

    function checkYear(value_year,indexno,level)
    {

        if(value_year!="")
        {

           // alert(value_year + indexno + level);

            //alert("nipooo" + value_year + indexno);
            loadAjaxData(indexno,value_year,'',level);




        }

    }

    function loadAjaxData(value,target_field,get_focused_field,action) {
        if($.trim(value)=='')
        {
            exit;
        }

        $.ajax({
            type:"post",
            url:"<?php echo site_url('loadEducationData') ?>",
            data: {
                target:target_field,
                id:value,
                ffocus:get_focused_field,
                action:action
            },
            datatype:"text",
            success:function(data)
            {
                var my_data_array;
                my_data_array= data.split("_");
                if(my_data_array.length==1  && data.trim()!='')
                {
                    alert(data)
                }
                if(action=='o-level')
                {

//alert(data);


                    if(my_data_array[0]=="EQ")
                    {

                        $("#o_completed_year").prop("readonly", false);
                    }else
                    {
                        $("#o_completed_year").prop("readonly", true);
                    }
                    if(my_data_array.length>1)
                    {
                        $("#firstname").val(my_data_array[0]);
                        $("#lastname").val(my_data_array[1]);
                        $("#middlename").val(my_data_array[2]);
                        $("#o_completed_year").val(my_data_array[3]);
                        $("#olevel_name").val(my_data_array[4]);
                        //alert($("#olevel_name").val())
                    }



                }
                if(action=='a-level')
                {


                    if(my_data_array[0]=="EQ")
                    {

                        $("#a_completed_year").prop("readonly", false);
                    }else
                    {
                        $("#a_completed_year").prop("readonly", true);

                    }
                    if(data!="" &&  data!='EQ')
                    {
                        $("#school").val(my_data_array[0]);
                        $("#alevel_name").val(my_data_array[1]);
                        $("#a_completed_year").val(my_data_array[2]);
                        // alert($("#alevel_name").val())
                    }
                }



                if(action=='avn')
                {


                    $("#institution").val(my_data_array[0]);
                    $("#alevel_name").val(my_data_array[1]);
                    //alert($("#alevel_name").val())

                }
            }
        });

    }


    function loadDistrict(value,target_field,get_focused_field,action) {
        $.ajax({
            type:"post",
            url:"<?php echo site_url('loadDistrict') ?>",
            data: {
                target:target_field,
                id:value,
                ffocus:get_focused_field,
                action:action
            },
            datatype:"text",
            success:function(data)
            {
                $( "#" + target_field).html(data);
            }
        });

    }

    function loadVituo(value,target_field,get_focused_field,action) {

        $.ajax({
            type:"post",
            url:"<?php echo site_url('loadVituo') ?>",
            data: {
                target:target_field,
                id:value,
                ffocus:get_focused_field,
                action:action
            },
            datatype:"text",
            success:function(data)
            {

                $( "#" + target_field).html(data);
            }
        });

    }


</script>
