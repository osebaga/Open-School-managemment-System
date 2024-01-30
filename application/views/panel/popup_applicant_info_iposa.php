<div class="ibox">


    <div class="ibox-content">

        <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            TAARIFA BINAFSI
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table">

                    <tr>
                        <th class="no-borders" style="width: 40%;">Numbe ya Usajili :</th>
                        <td class="no-borders"><?php echo $APPLICANT->registrationnumber; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders" style="width: 40%;">Jina la kwanza :</th>
                        <td class="no-borders"><?php echo $APPLICANT->FirstName; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Jina la ukoo :</th>
                        <td class="no-borders"><?php echo $APPLICANT->LastName; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Jina la kati:</th>
                        <td class="no-borders"><?php echo $APPLICANT->MiddleName; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Jinsia :</th>
                        <td class="no-borders"><?php echo ($APPLICANT->Gender=='Male'?'ME':"KE"); ?></td>
                    </tr>

                    <tr>
                        <th class="no-borders">Kiwango cha elimu :</th>
                        <td class="no-borders"><?php echo iposa_eduction_type($APPLICANT->education) ; ?></td>
                    </tr>


                    <tr>
                        <th class="no-borders">Tarehe ya Kuzaliwa :</th>
                        <td class="no-borders"><?php echo format_date($APPLICANT->dob, false); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Kabila :</th>
                        <td class="no-borders"><?php echo $APPLICANT->tribe; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Hali ya Ndoa :</th>
                        <td class="no-borders"><?php echo(($APPLICANT->marital_status=='Single')?(($APPLICANT->Gender=='Male')?'Sijaoa':'Sijaolewa'):(($APPLICANT->Gender=='Male')?'Nimeoa':'Nimeolewa  ')); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Idadi ya watoto :</th>
                        <td class="no-borders"><?php echo $APPLICANT->children; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th class="no-borders">Mkoa :</th>
                        <td class="no-borders"><?php echo get_value('regions', $APPLICANT->region, 'name'); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">District :</th>
                        <td class="no-borders"><?php echo get_value('districts', $APPLICANT->district, 'name'); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Kata :</th>
                        <td class="no-borders"><?php echo $APPLICANT->ward; ?></td>
                    </tr>

                    <tr>
                        <th class="no-borders">Kijiji :</th>
                        <td class="no-borders"><?php echo $APPLICANT->villege; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders" style="width: 40%;">Mwaka wa usajili:</th>
                        <td class="no-borders"><?php echo $APPLICANT->AYear; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Kazi unayofanya kwa sasa  :</th>
                        <td class="no-borders"><?php echo iposa_job_type($APPLICANT->job) ; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Aina ya ulemavu(Kama ipo)  :</th>
                        <td class="no-borders"><?php echo iposa_disability_type($APPLICANT->Disability); ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Mambo unayopenda kujifunza  :</th>
                        <td class="no-borders"><?php echo $APPLICANT->wanttolean; ?></td>
                    </tr>
                </table>


            </div>
            <div class="col-md-2">
<!--                <img src="--><?php //echo HTTP_PROFILE_IMG . $APPLICANT->photo; ?><!--" style="width: 130px;"/>-->
            </div>
        </div>





        <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            TAARIFA ZA MTU WA KARIBU
        </div>
        <div class="row">
            <div class="col-md-12">

                <table class="table">
                    <tr>
                        <th class="no-borders" style="width: 30%;">Jina la mtu wa karibu:</th>
                        <td class="no-borders"><?php echo $APPLICANT->kinname; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Uhusiano :</th>
                        <td class="no-borders"><?php echo $APPLICANT->kinrelation; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Namba ya Simu ya mtu wa karibu :</th>
                        <td class="no-borders"><?php echo $APPLICANT->kinmobile; ?></td>
                    </tr>


                </table>
            </div>

        </div>

        <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            UTHIBITISHO KUTOKA SERIKALI YA MTAA/KIJIJI
        </div>
        <div class="row">
            <div class="col-md-12">

                <table class="table">
                    <tr>
                        <th class="no-borders" style="width: 30%;">Jina la Mratibu Elimu Kata :</th>
                        <td class="no-borders"><?php echo $APPLICANT->mratibuname; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Namba ya Simu Mratibu :</th>
                        <td class="no-borders"><?php echo $APPLICANT->mratibumobile; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Tarehe :</th>
                        <td class="no-borders"><?php echo $APPLICANT->mratibudate; ?></td>
                    </tr>


                </table>
            </div>

        </div>

        <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            TAARIFA ZA KITUO
        </div>
        <div class="row">
            <div class="col-md-12">

                <table class="table">
                    <tr>
                        <th class="no-borders" style="width: 30%;">Jina la Kituo :</th>
                        <td class="no-borders"><?php $kituoinfo=get_value('iposa_vituo', $APPLICANT->kituoname,'');echo $kituoinfo->name; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Anuani :</th>
                        <td class="no-borders"><?php echo $kituoinfo->anuani; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Jina la Mkuu wa Kituo :</th>
                        <td class="no-borders"><?php echo $kituoinfo->jinalamkuu; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Namba ya Simu ya Mkuu wa kituo :</th>
                        <td class="no-borders"><?php echo $kituoinfo->simuyamkuu; ?></td>
                    </tr>
                    <tr>
                        <th class="no-borders">Tarehe :</th>
                        <td class="no-borders"><?php echo $APPLICANT->kituodate; ?></td>
                    </tr>

                </table>
            </div>

        </div>






        <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            VIAMBATANISHO
        </div>
        <div class="row">
            <div class="col-md-12">

                    <table class="table table-bordered " id="mytable">
                        <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th style="width: 150px;">JINA</th>
                            <th style="width: 100px;">Angalia</th>

                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td style="vertical-align: middle; text-align: center;">1</td>
                                <td>FORM ULIYOJAZA KWA MKONO</td>

                                <td>
                                    <a href="javascript:void(0);" class="view_image"
                                       title="<?php echo($APPLICANT->filename)?$APPLICANT->filename:'Attachment' ; ?>" W="800" H="500"
                                       type="<?php echo get_file_mimetype($APPLICANT->attachment); ?>"
                                       url="<?php echo HTTP_UPLOAD_FOLDER . 'attachment/' . $APPLICANT->attachment ?>">
                                        <i class="fa fa-eye">.pdf</i>
                                    </a>
                                </td>

                            </tr>

                        </tbody>


                    </table>

            </div>
        </div>





        <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            Declaration
        </div>
        <div class="row">
            <div class="col-md-12">

                    Mimi,
                    <b><?php echo $APPLICANT->FirstName . ' ' . $APPLICANT->LastName; ?></b>
                Nathibitisha ya kwama taarifa nilizotoa ni za kweli kwa ufahamu wangu nikiwa mwenye akili timamu.

            </div>

        </div>


        <?php
        if(isset($change_status)){ ?>
            <br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
                Change Status of this Application
            </div>

            <div class="row">
                <div class="col-md-12">
                     <div class="form-horizontal ng-pristine ng-valid"'>
                    <div class="form-group" id="department"><label class="col-lg-3 control-label">Status : <span class="required">*</span></label>

                        <div class="col-lg-7">
                            <div class="input-group">
                            <select name="change_status_id" id="change_status_id"  class="form-control">
                                <?php
                                $sel = $APPLICANT->submitted;
                                foreach(application_status() as $key=>$value){
                                    if($key < 2 ){
                                    ?>
                                    <option <?php echo ($sel == $key ? 'selected="selected"':''); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php
                                } }
                                ?>
                            </select>
                                <span class="input-group-btn"> <button type="button" class="btn btn-primary change_status">Change
                                        </button> </span>
                            </div>
                            <div id="error_div" style="color: red;"></div>
                        </div>
                    </div>
                </div>
                </div>
            </div>

        <?php } ?>





    </div>


</div>

<script>
    $(document).ready(function () {
      $(".change_status").click(function () {
          var new_status = $('#change_status_id').val();
          var applicant_id = '<?php echo $APPLICANT->id ?>';
         $("#error_div").html('Saving <img style="height: 16px; width:16px;" src="<?php echo base_url() ?>icon/loader.gif"/>');
         $.ajax({
             url:"<?php echo site_url('change_status') ?>",
             type:'POST',
             dataType:'html',
             data: {status: new_status,applicant_id:applicant_id},
             success: function (data) {
                 $("#error_div").html(data);
             }
         });
      });

        $(".view_image").click(function () {
            var title = $(this).attr("title");
            var url = $(this).attr("url");
            var type = $(this).attr("type");
            var width = $(this).attr("W");
            var height = $(this).attr("H");

            //var model = $("#myModal");
            //model.find(".modal-content").css({height:(parseInt(height)+120)+"px",width:(parseInt(width)+5)+"px"});
            // model.find("#model_header").html(title);
            //model.find("#model_header").show();

            var object = '<object data="{FileName}" type="' + type + '" width="' + width + 'px" height="' + height + 'px">';
            object += 'If you are unable to view file, you can download from <a href="{FileName}">here</a>';
            object += '</object>';
            object = object.replace(/{FileName}/g, url);
            // model.find("#modal_body").css({height:height+"px",width:width+"px",padding:0});
            // model.find("#modal_body").html(object);
            // model.find("#model_footer").show();
            // model.modal();
            $.confirm({
                title: title,
                content: object,
                confirmButton: false,
                columnClass: 'col-md-8',
                cancelButton: 'Close',
                cancelButtonClass: 'btn-success'
            });

        });

    })
</script>
