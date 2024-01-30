<div class="container">
    <?php
    if ($allowed == 1) { ?>
        <div class="row">
            <?php
            if (isset($message)) {
                echo $message;
            } else if ($this->session->flashdata('message') != '') {
                echo $this->session->flashdata('message');
            }
            ?>
            <div style="font-weight: bold; text-align: center;">Note to the referee: This is confidential information on the applicant</div>
            <div class="col-md-4">
                <div class="ibox">
                    <div class="ibox-heading">
                        <div class="ibox-title">
                            <h5>Applicant Information</h5>
                        </div>
                    </div>

                    <div class="ibox-content no-padding" style="overflow-x: hidden;">
                        <br/>
                        <div style="text-align: center;"><img style="height: 130px; width: 130px;"
                                                              src="<?php echo HTTP_PROFILE_IMG . $APPLICANT->photo; ?>">
                        </div>
                        <table class="table">
                            <tr>
                                <th style="width: 30%;" class="no-borders">Name:</th>
                                <td class="no-borders"><?php echo $APPLICANT->FirstName . ' ' . $APPLICANT->MiddleName . ' ' . $APPLICANT->LastName; ?></td>
                            </tr>
                            <tr>
                                <th>Sex:</th>
                                <td><?php echo $APPLICANT->Gender ?></td>
                            </tr>
                            <tr>
                                <th>Nationality:</th>
                                <td><?php echo get_country($APPLICANT->Nationality); ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?php echo $APPLICANT->Email; ?></td>
                            </tr>
                            <tr>
                                <th>Mobile:</th>
                                <td><?php echo $APPLICANT->Mobile1; ?></td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td><?php echo $APPLICANT->physical; ?></td>
                            </tr>
                            <tr>
                                <th colspan="2"><br/>Applicant Programme Choices</th>
                            </tr>
                            <?php
                            $mycoice = $this->applicant_model->get_programme_choice($APPLICANT->id);
                            ?>
                            <tr>
                                <td colspan="2">

                                    <?php
                                    if (isset($mycoice)) { ?>
                                        <table class="table">
                                            <tr>
                                                <th class="no-borders" style="width: 5%;">1.</th>
                                                <td class="no-borders"><?php echo get_value('programme', array("Code" => $mycoice->choice1), 'Name'); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="no-borders">2.</th>
                                                <td class="no-borders"><?php echo get_value('programme', array("Code" => $mycoice->choice2), 'Name'); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="no-borders">3.</th>
                                                <td class="no-borders"><?php echo get_value('programme', array("Code" => $mycoice->choice3), 'Name'); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="no-borders">4.</th>
                                                <td class="no-borders"><?php echo get_value('programme', array("Code" => $mycoice->choice4), 'Name'); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="no-borders">5.</th>
                                                <td class="no-borders"><?php echo get_value('programme', array("Code" => $mycoice->choice5), 'Name'); ?></td>
                                            </tr>
                                        </table>
                                    <?php } ?>


                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>


            <div class="col-md-8 no-padding no-margins">

                <div class="ibox" style="margin-right: -30px;">

                    <div class="ibox-content">
                        <h5 style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">REFEREE INFORMATION PROVIDED BY
                            APPLICANT</h5>
                        <table class="table">
                            <tr>
                                <td class="no-borders">
                                    <strong>Name : </strong><?php echo $REFEREE->name; ?><br/>
                                    <strong>Mobile : </strong><?php echo $REFEREE->mobile1; ?><br/>
                                    <strong>Mobile 2 : </strong><?php echo $REFEREE->mobile2; ?><br/>
                                    <strong>Email : </strong><?php echo $REFEREE->email; ?>
                                </td>
                                <td class="no-borders">
                                    <strong>Organization : </strong><?php echo $REFEREE->organization; ?><br/>
                                    <strong>Position : </strong><?php echo $REFEREE->position; ?><br/>
                                    <strong>Address : </strong><?php echo $REFEREE->address; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>


                <div class="ibox" style="margin-right: -30px;">
                    <div class="ibox-heading">
                        <div class="ibox-title">
                            <h5>Recommendation</h5>
                        </div>
                    </div>

                    <div class="ibox-content">
                        To enable us assess the applicant’s suitability for the programme, kindly evaluate the applicant
                        in
                        the areas listed below
                        <br/><br/>
                        <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid"') ?>

                        1. How do you evaluate the following :
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 50%;">Area</th>
                                <?php
                                foreach (recommendation_rate() as $k => $v) {
                                    echo '<th style="text-align: center;">' . $v . '</th>';
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sel =  (isset($recommendation_info) ? $recommendation_info->recommendation_arrea: '');
                            $sel_value = json_decode($sel,true);
                            foreach ($recommendation_area as $rec_key => $rec_value) {
                                ?>

                                <tr>
                                    <td><?php echo $rec_value->name; ?><span class="required">*</span>
                                        <?php
                                        if(form_error('recommend_'.$rec_value->id)){
                                            echo form_error('recommend_'.$rec_value->id);
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    foreach (recommendation_rate() as $k => $v) {
                                        $sel2 = set_value('recommend_'.$rec_value->id,(isset($recommendation_info)  ? $sel_value[$rec_value->id]  :''));
                                        ?>
                                        <td style="text-align: center;"><input type="radio" class="radio-inline"
                                                                               value="<?php echo $k; ?>" <?php echo ($sel2 == $k ? 'checked="checked"':''); ?>
                                                                               name="recommend_<?php echo $rec_value->id ?>"/>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        2. Other capabilities/talents worth mentioning:
                        <textarea rows="4" name="other_capability" class="form-control"><?php echo set_value('other_capability',(isset($recommendation_info) ? $recommendation_info->other_capability:'')); ?></textarea>

                        <br/>
                        3. Is the applicant capable of producing original work?<span class="required">*</span>
                        <?php
                        $sel =  set_value('producing_org_work',(isset($recommendation_info) ? $recommendation_info->producing_org_work:-1));

                        foreach (yes_no() as $k => $v) { ?>
                            <div style="margin-left: 100px; margin-top: 4px;"><input type="radio" class="radio-inline" <?php echo ($sel == $k ? 'checked="checked"':'') ?>
                                                                                     value="<?php echo $k; ?>"
                                                                                     name="producing_org_work"/> <?php echo $v; ?>
                            </div>
                        <?php } echo form_error('producing_org_work'); ?>

                        <br/>
                        4. Has he/she pursued any similar degree/postgraduate programme that you are aware of?<span class="required">*</span>
                        <?php
                        $sel =  set_value('other_degree',(isset($recommendation_info) ? $recommendation_info->other_degree:-1));
                        foreach (yes_no() as $k => $v) { ?>
                            <div style="margin-left: 100px; margin-top: 4px;"><input type="radio" class="radio-inline"
                                                                                     value="<?php echo $k; ?>" <?php echo ($sel == $k ? 'checked="checked"':'') ?>
                                                                                     name="other_degree"/> <?php echo $v; ?>
                            </div>
                        <?php } echo form_error('other_degree'); ?>
                        <br/>
                        5. What is the basis of your response in 3 above ?<span class="required">*</span>
                        <textarea rows="4" name="description_for_qn3" class="form-control"><?php echo set_value('description_for_qn3',(isset($recommendation_info) ? $recommendation_info->description_for_qn3:'')); ?></textarea>
                        <?php echo form_error('description_for_qn3'); ?>
                        <br/>
                        6. What do you consider to be the applicant’s weaknesses<span class="required">*</span>
                        <textarea rows="4" name="weakness" class="form-control"><?php echo set_value('weakness',(isset($recommendation_info) ? $recommendation_info->weakness:'')); ?></textarea>
                        <?php echo form_error('weakness'); ?>
                        <br/>
                        7. For how long have you known the applicant and in what capacity?<span class="required">*</span>
                        <textarea rows="4" name="applicant_known" class="form-control"><?php echo set_value('applicant_known',(isset($recommendation_info) ? $recommendation_info->applicant_known:'')); ?></textarea>
                        <?php echo form_error('applicant_known'); ?>
                        <br/>
                        8. Please tell us anything else you think we should know about this applicant.
                        <textarea rows="4" name="anything" class="form-control"><?php echo set_value('anything',(isset($recommendation_info) ? $recommendation_info->anything:'')); ?></textarea>

                        <br/>
                        9. Please indicate your overall recommendation for the candidate :<span class="required">*</span>
                        <?php
                        $sel =  set_value('recommend_overall',(isset($recommendation_info) ? $recommendation_info->recommend_overall:''));

                        foreach (recommendation_overall() as $ko => $vo) { ?>
                            <div style="margin-left: 100px; margin-top: 4px;"><input type="radio" class="radio-inline"
                                                                                     value="<?php echo $ko; ?>" <?php echo ($sel == $ko ? 'checked="checked"':'') ?>
                                                                                     name="recommend_overall"/> <?php echo $vo; ?>
                            </div>
                        <?php }  echo form_error('recommend_overall'); ?>


                        <?php if($APPLICANT->status == 0){ ?>

                            <div class="form-group" style="margin-top: 10px; border-top: 1px solid #ccc; padding-top: 10px;">
                                <div class="col-lg-offset-4 col-lg-6">
                                    <input class="btn btn-sm btn-success" type="submit" value=" Save Information"/>
                                </div>
                            </div>

                        <?php }else{ ?>
                            <script>
                                disable_edit();
                            </script>
                        <?php } ?>



                    </div>
                </div>


            </div>


        </div>

    <?php } else {
        echo show_alert('Invalid URL request -  Recommendation Page for the clicked URL not found any more !!  ', 'info');
    } ?>
</div>