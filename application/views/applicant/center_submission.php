<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title clearfix">
            <h5> <?php echo(is_section_used('SUBMIT', $APPLICANT_MENU) ? 'Review' : 'Submit') ?> Application</h5>
            <?php if ($APPLICANT->submitted != 0) { ?>
            <a href="<?php echo site_url('center_print_application/' . encode_id($APPLICANT->id)) ?>"
                class="btn btn-success pull-right">Print Application</a>
            <?php } ?>
        </div>
    </div>

    <div class="ibox-content">

        <div
            style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Center Informations
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th class="no-borders" style="width: 40%;">Center Name :</th>
                        <td class="no-borders"><?php echo $APPLICANT->CenterName; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Center Owner :</th>
                        <td class="no-borders"><?php echo ucwords($APPLICANT->CenterOwner); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Center Cordinator :</th>
                        <td class="no-borders"><?php echo $APPLICANT->CenterCordinator; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders"  >Taxpayer Identification Number :</th>
                        <td class="no-borders"><?php echo $APPLICANT->TIN; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders" style="width: 45%;">Country of Residence :</th>
                        <td class="no-borders"> <?php echo get_value('nationality', $APPLICANT->residence_country, 'Country'); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders" style="width: 45%;">Region of Residence :</th>
                        <td class="no-borders"><?php echo get_value('regions',$APPLICANT->region,'name'); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders" style="width: 45%;">District of Residence :</th>
                        <td class="no-borders"><?php echo get_value('districts',$APPLICANT->district,'name'); ?></td>
                    </tr>
               
                    <tr>
                        <th class="no-borders">Nationality :</th>
                        <td class="no-borders"><?php echo get_value('nationality', $APPLICANT->Nationality, 'Name'); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                   
                    <tr>
                        <th class="no-borders">NIDA :</th>
                        <td class="no-borders"><?php echo $APPLICANT->national_identification_number; ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="no-borders">TIN:</th>
                        <td class="no-borders"><?php echo $APPLICANT->TIN; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders" style="width: 44%;">Application Year :</th>
                        <td class="no-borders"><?php echo $APPLICANT->AYear; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders" style="width: 44%;">Application Type :</th>
                        <td class="no-borders"><?php echo center_application($APPLICANT->application_type); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Center Premises:</th>
                        <td class="no-borders"><?php echo center_premises($APPLICANT->Premises); ?></td>
                    </tr>

                    <tr>
                        <th class="no-borders" style="width: 43%;">Village/Street :</th>
                        <td class="no-borders"><?php echo $APPLICANT->Village; ?></td>
                    </tr>
                    
                    <tr>
                        <th class="no-borders">City:</th>
                        <td class="no-borders"><?php echo $APPLICANT->City; ?></td>
                    </tr>
                    
                    <!-- <tr>
                        <th class="no-borders">Town:</th>
                        <td class="no-borders"><?php echo $APPLICANT->Town; ?></td>
                    </tr> -->

                    <tr>
                        <th class="no-borders" style="width: 43%;">Plot/House Number :</th>
                        <td class="no-borders"><?php echo $APPLICANT->HouseNumber; ?></td>
                    </tr>
                </table>


            </div>
            <!-- <div class="col-md-2">
                <img src="<?php echo HTTP_PROFILE_IMG . $APPLICANT->photo; ?>" style="width: 130px;" />
            </div> -->
        </div>


        <div
            style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Contact Information
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th class="no-borders" style="width: 30%;">Mobile 1:</th>
                        <td class="no-borders"><?php echo $APPLICANT->Mobile1; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Mobile 2 :</th>
                        <td class="no-borders"><?php echo $APPLICANT->Mobile2; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Email :</th>
                        <td class="no-borders"><?php echo $APPLICANT->Email; ?></td>
                    </tr>

                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th class="no-borders" style="width: 40%;">Postal Address :</th>
                        <td class="no-borders"><?php echo $APPLICANT->postal; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Physcal Address :</th>
                        <td class="no-borders"><?php echo $APPLICANT->physical; ?></td>
                    </tr>

                </table>


            </div>
        </div>

        <!-- <div
            style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Next of Kin Information
        </div> -->
        <div class="row">
            <!-- <div class="col-md-6">
                <div style="font-weight: bold; color: blue; border-bottom: 1px solid blue; font-size: 15px;">Next of Kin
                    1
                </div>
                <table class="table">
                    <tr>
                        <th class="no-borders" style="width: 30%;">Name:</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[0]->name : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Mobile 1 :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[0]->mobile1 : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Mobile 2 :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[0]->mobile2 : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Email :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[0]->email : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Postal :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[0]->postal : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Relation :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[0]->relation : ''); ?></td>
                    </tr>

                </table>
            </div> -->
            <!-- <div class="col-md-6">
                <div style="font-weight: bold; color: blue; border-bottom: 1px solid blue; font-size: 15px;">Next of Kin
                    2
                </div>
                <table class="table">
                    <tr>
                        <th class="no-borders" style="width: 30%;">Name:</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[1]->name : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Mobile 1 :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[1]->mobile1 : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Mobile 2 :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[1]->mobile2 : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Email :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[1]->email : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Postal :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[1]->postal : ''); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Relation :</th>
                        <td class="no-borders"><?php echo(isset($next_kin) ? $next_kin[1]->relation : ''); ?></td>
                    </tr>

                </table>

            </div> -->
        </div>

        <div
            style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Application Fee Payment
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- <h4>Your Reference Number for payment is : <?php echo REFERENCE_START . $APPLICANT->id ?></h4> -->

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50px;">S/No</th>
                            <th style="text-align: center; width: 100px;">Reference</th>
                            <!-- <th style="text-align: center; width: 100px;">Mobile No</th> -->
                            <th style="text-align: center; width: 100px;">Control Number</th>
                            <th style="text-align: center; width: 100px;">Receipt</th>
                            <th style="text-align: center; width: 100px;">Amount</th>
                            <th style="text-align: center; width: 150px;">Trans Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    // $payment_transaction = $this->db->where('applicant_id', $APPLICANT->id)->get("application_payment")->result(); old

                    $payment_transaction = $this->db->where('student_id', $APPLICANT->id)->get("payment")->result();
                    $total_amount = 0;
                    $total_charge = 0;

                    foreach ($payment_transaction as $key => $value) {
                        // $total_amount += $value->amount;
                        $total_amount += $value->paid_amount;
                        $total_charge += $value->charges;
                        ?>
                        <!-- <tr>
                            <td style="text-align: right;"><?php echo $key + 1; ?> .</td>
                            <td style="text-align: center;"><?php echo $value->reference ?></td>
                            <td style="text-align: center;"><?php echo $value->msisdn ?></td>
                            <td style="text-align: center;"><?php echo $value->receipt ?></td>
                            <td style="text-align: right;"><?php echo number_format($value->amount + $value->charges, 2) ?></td>
                            <td style="text-align: center;"><?php echo $value->createdon ?></td>
                        </tr> -->

                        <!-- new implementation -->
                        <tr>
                            <td style="text-align: right;"><?php echo $key + 1; ?> .</td>
                            <td style="text-align: center;"><?php echo $value->ega_refference ?></td>
                            <td style="text-align: center;"><?php echo $value->control_number ?></td>
                            <td style="text-align: center;"><?php echo $value->receipt_number ?></td>
                            <td style="text-align: right;"><?php echo number_format($value->paid_amount, 2) ?></td>
                            <td style="text-align: center;"><?php echo $value->transaction_date ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td style="text-align: right;" colspan="4">Total</td>
                            <td style="text-align: right;"><?php echo number_format($total_amount + $total_charge, 2) ?>
                            </td>
                            <td style="text-align: center;"></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div
            style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Education Level
        </div>

        <div class="row">
            <div class="col-md-12">
            <table class="table">
                    <tr>
                        <th class="no-borders" style="width: 30%;">Owner's Education Level :</th>
                        <td class="no-borders"><?php echo $APPLICANT->OwnerProfession; ?></td>
                    </tr>
                </table>

      <?php
                foreach ($education_bg as $rowkey => $rowvalue) { ?>

            <div class="center_education_bg" style="margin-bottom: 50px;">

                <div style="font-size: 14px; border-bottom: 1px solid brown; color: brown; font-weight: bold;"><?php echo administrator($rowvalue->certificate); ?></div>

                <div class="education_div_data" id="divNo<?php echo $rowvalue->id; ?>"
                     RID="<?php echo $rowvalue->id; ?>" WAIT="<?php echo $rowvalue->hide; ?>">
                   <?php if($rowvalue->certificate != 4){ ?>
                     <table class="mytable2_educatiobbg">

                        <tr>
                            <th>Name :</th>
                            <td><?php echo $rowvalue->exam_authority; ?></td>
                        </tr>
                
                        <tr>
                            <th> Phone Number :</th>
                            <td><?php echo $rowvalue->division; ?></td>
                        </tr>
                        <tr>
                            <th>Education Level :</th>
                            <td><?php echo $rowvalue->school; ?></td>
                        </tr>
                        <!-- <tr>
                            <th>Teaching and Learning Session :</th>
                            <td><?php echo learning_session($rowvalue->country); ?></td>
                        </tr> -->

       
                    </table>
                    <?php } ?>
                    <br/>
                <?php

                    if ($rowvalue->certificate == 4) {
                        ?>
                        <strong>SOME OF SUBJECT PERFORMED</strong>
                        <br/>
                        <table cellpadding="0" cellspacing="0" class="table table-bordered"
                               id="mytable" style="width: ">
                            <thead>
                            <tr>
                                <th style="width: 70px;">S/No.</th>
                                <th style="width: 200px; text-align: center;">Pre-vocational Courses</th>
                                <th style="width: 200px; text-align: center;">Academic Subjects</th>
                                <th style="width: 150px; text-align: center;">Generic Skills</th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php
                            $sno = 1;
                            $subject_saved = $this->db->where(array('applicant_id' => $rowvalue->applicant_id, 'authority_id' => $rowvalue->id))->get("application_education_subject")->result();
                            foreach ($subject_saved as $k => $v) {
                                ?>
                                <tr>
                                    <td style="vertical-align: middle; text-align: center"><?php echo($k + 1); ?></td>
                                    <td style="text-align: center"><?php echo $v->grade; ?></td>

                                    <td><?php echo get_value('secondary_subject', $v->subject, 'name'); ?></td>
                                    <td style="text-align: center"><?php echo $v->year; ?></td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                    ?>
            </div>
        </div>



        <div
            style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Attachment
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered " id="mytable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">S/No</th>
                            <th style="width: 150px;">Certificate</th>
                            <th>Comment</th>
                            <th style="width: 100px;">Attachment</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    foreach ($attachment_list as $rowkey => $rowvalue) { ?>
                        <tr>
                            <td style="vertical-align: middle; text-align: center;"><?php echo($rowkey + 1); ?></td>
                            <?php
                            if($APPLICANT->application_category=='Center') {?>
                            <td><?php echo center_owner_attachment($rowvalue->certificate) ?></td>
                            <?php }else{ ?>
                            <td><?php echo entry_type_certificate($rowvalue->certificate) ?></td>
                            <?php } ?>
                              <td><?php echo $rowvalue->comment ?></td>
                            <td><a href="javascript:void(0);" class="view_image"
                                    title="<?php echo $rowvalue->filename; ?>" W="800" H="500"
                                    type="<?php echo get_file_mimetype($rowvalue->attachment) ?>"
                                    url="<?php echo HTTP_UPLOAD_FOLDER . 'attachment/' . $rowvalue->attachment ?>"><i
                                        class="fa fa-eye"></i> View</a></td>

                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>


                </table>

            </div>
        </div>

       
        <div
            style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Declaration
        </div>
        <div class="row">
            <div class="col-md-12">
                I, <b><?php echo $APPLICANT->FirstName . ' ' . $APPLICANT->LastName; ?></b> hereby declare that the
                information given in this form is true
                to the best of my knowledge
                <?php if ($APPLICANT->submitted == 0){ ?>
                <?php echo form_open(current_full_url(), ' class="form-horizontal ng-pristine ng-valid" id="uploadresult4"') ?>

                <div class="form-group" style="margin-top: 20px;">

                    <div class="col-lg-offset-1" style="font-weight: bold; color: red; font-size: 14px;">
                        NOTE :
                        <br />Please confirm all information is correct before click button below
                        <br />2. You will not be able to make changes in your application after submission <br />

                    </div>
                </div>
                <input type="hidden" value="1" name="submit_app" />

                <div class="form-group" style="margin-top: 10px;">
                    <div class="col-lg-offset-9">
                        <input class="btn btn-sm btn-success" id="submit_app" type="submit"
                            value=" Submit Application" />
                    </div>

                    <?php echo form_close(); ?>
                    <?php } else {
                        ?>
                    <div style="text-align: right; margin-right: 50px; margin-top: 20px;"><a
                            href="<?php echo site_url('center_print_application/' . encode_id($APPLICANT->id)) ?>"
                            class="btn btn-success">Print Application</a></div>
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>

    </div>


</div>

<script>
    $(document).ready(function () {
        var form = $("#uploadresult4");
        $("#submit_app").confirm({
            title: "Confirm Submission",
            content: "Are you sure you want to submit this Application ?",
            confirmButton: 'YES',
            cancelButton: 'NO',
            confirmButtonClass: 'btn-success',
            cancelButtonClass: 'btn-success',
            confirm: function () {
                form.submit();
            },

            cancel: function () {
                return true;
            }
        });


        $(".view_image").click(function () {
            var title = $(this).attr("title");
            var url = $(this).attr("url");
            var type = $(this).attr("type");
            var width = $(this).attr("W");
            var height = $(this).attr("H");

            var model = $("#myModal");
            model.find(".modal-content").css({
                height: (parseInt(height) + 120) + "px",
                width: (parseInt(width) + 5) + "px"
            });
            model.find("#model_header").html(title);
            model.find("#model_header").show();

            var object = '<object data="{FileName}" type="' + type + '" width="' + width +
                'px" height="' + height + 'px">';
            object +=
                'If you are unable to view file, you can download from <a href="{FileName}">here</a>';
            object += '</object>';
            object = object.replace(/{FileName}/g, url);
            model.find("#modal_body").css({
                height: height + "px",
                width: width + "px",
                padding: 0
            });
            model.find("#modal_body").html(object);
            model.find("#model_footer").show();
            model.modal();
        });

    })
</script>