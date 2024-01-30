<?php
include VIEWPATH.'include/pbscrum.php';
?>

<div class="col-lg-12 text-center">
    <div class="navy-line"></div>
    <h3 style="margin-top: 10px; color: brown;">Welcome : <?php echo $CURRENT_USER->firstname.' '.$CURRENT_USER->lastname; ?></h3>
    <div style="font-weight: bold; font-size: 12px; margin-bottom: 10px;">Online support : <?php echo ONLINE_SUPPORT; ?> </div>
    <?php
    if (isset($message)) {
        echo $message;
    } else if ($this->session->flashdata('message') != '') {
        echo $this->session->flashdata('message');
    }
    ?>
</div>

<div class="row gray-bg">
    <div class="container">
        <div class="col-lg-3 no-padding no-margins">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Main Menu</h5>
                </div>
                <div class="ibox-content no-padding">
                    <ul class="folder-list m-b-md" style="padding: 0">
                        <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo site_url('applicant_dashboard') ?>"> <i class="fa fa-star "></i> Dashboard </a></li>
                        <li style="padding: 5px 20px; font-size: 15px;"><a  href="<?php echo site_url('applicant_basic/'.encode_id($APPLICANT->id)) ?>"> <i class="fa fa-star "></i> Person Particulars <span class="label label-warning pull-right"><i class="fa fa-check no-margins"></i></span> </a></li>
                        <?php
                        $count_progress = 0;
                        $total_menu = 8;
                        $basic = is_section_used('BASIC',$APPLICANT_MENU);
                        if($basic){$count_progress++;};
                        $contact = is_section_used('CONTACT',$APPLICANT_MENU);
                        if($contact){$count_progress++;};
                        $activate_account = is_section_used('ACTIVATE',$APPLICANT_MENU);
                        if($activate_account){$count_progress++;};
                        $payment = is_section_used('PAYMENT',$APPLICANT_MENU);
                        if($payment){$count_progress++;};
                        $photo = is_section_used('PHOTO',$APPLICANT_MENU);
                        if($photo){$count_progress++;};
                        $nextkin = is_section_used('NEXT_KIN',$APPLICANT_MENU);
                        if($nextkin){$count_progress++;};
                        $education = is_section_used('EDUCATION',$APPLICANT_MENU);
                        if($education){$count_progress++;};
                        $attachment = is_section_used('ATTACHMENT',$APPLICANT_MENU);
                        if($attachment){$count_progress++;};
                        $programme = is_section_used('PROGRAMME',$APPLICANT_MENU);
                        if($programme){$count_progress++;};
                        $last_section = $programme;
                        if($APPLICANT->application_type == 3){
                            $total_menu += 3;
                            $experience = is_section_used('EXPERIENCE',$APPLICANT_MENU);
                            if($experience){$count_progress++;};

                            $referee = is_section_used('REFEREE',$APPLICANT_MENU);
                            if($referee){$count_progress++;};

                            $sponsor = is_section_used('SPONSOR',$APPLICANT_MENU);
                            if($sponsor){$count_progress++;};

                            $last_section = $sponsor;
                        }
                        $submit = is_section_used('SUBMIT',$APPLICANT_MENU);
                        if($submit){$count_progress++;};
                        ?>
                        <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ( $basic ? site_url('applicant_contact/'.($contact ? encode_id($contact):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> Contact Information <span class="label label-warning pull-right"><i class="fa <?php echo  ($contact ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>
                        <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ( $contact ? site_url('applicant_activate/'.($activate_account ? encode_id($activate_account):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> Activate Account <span class="label label-warning pull-right"><i class="fa <?php echo  ($activate_account ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>
                        <?php if($activate_account){ ?>
                            <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ($activate_account  ? site_url('applicant_payment/'.($payment ? encode_id($payment):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> Application Fee Payment <span class="label label-warning pull-right"><i class="fa <?php echo  ($payment ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>
                            <?php if($payment) { ?>
                                <!--<li style="padding: 5px 20px; font-size: 15px;"><a href="<?php /*echo ( $payment ? site_url('applicant_profile/'.($photo ? encode_id($photo):'')):'javascript:void(0);') */?>"> <i class="fa fa-star "></i> Profile Picture <span class="label label-warning pull-right"><i class="fa <?php /*echo  ($photo ? 'fa-check':'fa-times'); */?> no-margins"></i></span> </a></li>-->
                                <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ( $payment ? site_url('applicant_next_kin/'.($nextkin ? encode_id($nextkin):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> Next of Kin Particulars <span class="label label-warning pull-right"><i class="fa <?php echo  ($nextkin ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>
                            <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ( $payment ? site_url('applicant_education/'.($education ? encode_id($education):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> Education Background <span class="label label-warning pull-right"><i class="fa <?php echo  ($education ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>
                            <!--<li style="padding: 5px 20px; font-size: 15px;"><a href="<?php /*echo ( $education ? site_url('applicant_attachment/'.($attachment ? encode_id($attachment):'')):'javascript:void(0);') */?>"> <i class="fa fa-star "></i> Attachment <span class="label label-warning pull-right"><i class="fa <?php /*echo  ($attachment ? 'fa-check':'fa-times'); */?> no-margins"></i></span> </a></li>-->
                            <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ( $education ? site_url('applicant_choose_programme/'.($programme ? encode_id($programme):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> Choose Programme <span class="label label-warning pull-right"><i class="fa <?php echo  ($programme ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>
                            <?php
                            if($APPLICANT->application_type == 3){
                                ?>
                                <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ( $programme ? site_url('applicant_experience/'.($experience ? encode_id($experience):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> Professional  Experience <span class="label label-warning pull-right"><i class="fa <?php echo  ($experience ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>
                                <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ( $experience ? site_url('applicant_referee/'.($referee ? encode_id($referee):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> Academic Referee <span class="label label-warning pull-right"><i class="fa <?php echo  ($referee ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>
                                <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ( $referee ? site_url('applicant_sponsor/'.($sponsor ? encode_id($sponsor):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> Sponsor&Current Employer <span class="label label-warning pull-right"><i class="fa <?php echo  ($sponsor ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>
                                <?php
                            }
                            ?>
                            <li style="padding: 5px 20px; font-size: 15px;"><a href="<?php echo ( $last_section ? site_url('applicant_submission/'.($submit ? encode_id($submit):'')):'javascript:void(0);') ?>"> <i class="fa fa-star "></i> <?php echo ($submit ? 'Review' : 'Submit') ?>  Application <span class="label label-warning pull-right"><i class="fa <?php echo  ($submit ? 'fa-check':'fa-times'); ?> no-margins"></i></span> </a></li>

                        <?php } }  ?>
                    </ul>

                </div>
            </div>




        </div>
        <div class="col-lg-9" style="padding-right: 0px;">
            <div class="progress progress-striped active">
                <div style="width: <?php echo number_format($count_progress/9*100); ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar progress-bar-success">
                    <span class=""><?php echo number_format($count_progress/$total_menu*100); ?>% Complete</span>
                </div>
            </div>
            <?php
            if (isset($middle_content) && isset($data)) {
                $this->load->view($middle_content, $data);
            } else {
                $this->load->view($middle_content);
            }
            ?>

        </div>
    </div>
</div>

