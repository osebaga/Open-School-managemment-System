<body style="background-color: #F0F0F0;">
   <div class="container" style="padding-top: 20px">
     <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
           <div class="clear-form">
             <?php echo form_open('login'); ?>
             <div class="form-heading">
                <br>
                <div style="color: #49628e; text-align: center; font-size: 12px;   margin: 0px 0px 0px 10px;">
                    <img src="<?php echo base_url() ?>images/logo_new.png" height="77" class="center"; style=" margin: 0px 0px 0px 0px;"/>
                </div>
                 
                <div style="color: #49628e; text-align: center; font-size: 14px;   margin: 0px 0px 0px 10px;"><b>OPEN SCHOOLS MANAGEMENT INFORMATION SYSTEM</b></div>
                <br>
                <div style="font-size: 14px;text-align: center;"> For Center? <a href="<?php echo site_url('center_registration'); ?>?start=2" style="font-weight: bold; text-decoration: underline;">Click to Register</a>  </div>
              
                <br>
                <div style="font-size: 14px;text-align: center;"> New applicant? <a href="<?php echo site_url('registration_start'); ?>?start=1" style="font-weight: bold; text-decoration: underline;">Create Account</a>  </div>
              
                <div style="font-size: 12px;text-align: center;"> Existing User? Login below  </div>
            </div>
            <div class="form-body">
                <div style="color: red; font-size: 12px;">
                    <?php if (isset($message)) {
                        echo $message;
                    } else if ($this->session->flashdata('message') != '') {
                        echo $this->session->flashdata('message');
                    }
                    ?>
                </div>

                <input type="text" name="identity" class="col-md-12" placeholder="Username">
                <?php echo form_error('identity'); ?>
                <input type="password" name="password" class="col-md-12" placeholder="Password">
                <?php echo form_error('password'); ?>
                <div class="body-split clearfix" style="margin-left: 30px;">
                    <div class="pull-left">
                        <label class="checkbox" style="font-size: 13px;">
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-success pull-right"  type="submit">Login</button>
                    </div>
                </div>
            </div>
            <div class="form-footer">
                <hr/>
                <p class="center">
                  <label style="font-size: 12px;">  <a href="<?php echo site_url('forgot_password'); ?>">Forgot Password? Get Help</a> </label>
                </p>
                <!-- <p class="center">
                Kindly read and understand  admission requirements before starting application process.
                    <a href="javascript:void(0);" data-toggle="popover" role="button" title="" data-original-title="Admission Requirement <a style='float:right;' href='javascript:void(0);' class='close_popover'>X</a>" data-html="true" data-placement="bottom" data-content="1. <a target='_blank' href='<?php echo ADMISSION_REQUIREMENT_UNDERGRADUATE ?>'>Entry Qualifications</a> <br/><br/><br/>" style="font-size: 12px; font-weight: bold; text-decoration: underline;">Admission Requirements</a>. <br/>
                </p> -->
                <br>
              </div>
            </form>
         </div>
      </div>
   </div>
  </div>
</body>