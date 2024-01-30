<div class="ibox">
    <div class="ibox-heading">
        <div class="ibox-title">Dashboard</div>
    </div>
    <!-- Center Application -->
    <?php if($APPLICANT->application_category=='Center'){?>
        
        <div class="ibox-content"><?php if($APPLICANT->submitted==1){
            //submited status
            echo "<br/><br/>Dear <p style='color:green'>".$APPLICANT->CenterName."</p> Your Application has been Received Successfully!!";
        }
        //rejected status
        elseif($APPLICANT->submitted==2) { 
        echo "<br/><br/> Dear <p style='color:red'>".$APPLICANT->CenterName."</p> Your Application has been Rejected";
  
        //approved status
        }elseif($APPLICANT->submitted==3) { 
            echo "<br/><br/> Dear <p style='color:green'>".$APPLICANT->CenterName."</p> Your Application has been Approved and Eligible for Registration";
      
            }elseif($APPLICANT->submitted==4) { 
                //status in progress
                echo "<br/><br/> Dear <p style='color:blue'>".$APPLICANT->CenterName."</p> Your Application is In Progress";
          }elseif($APPLICANT->submitted==5){
            //verified status
            ?>
             <br/><br/> Dear <p style='color:darkgreen'><?php echo $APPLICANT->CenterName;?></p> Your Application has been Verified,Hence Regional Resident Tutor is notifying you to pay for registration fee(Non-refundable),
            <a href="<?php echo site_url('center_registration_fee'); ?>" class="btn btn-success">Click to generate control number</a>

         <?php }else{
            //incomplete status
            echo "<br/><br/> Dear <p style='color:red'>".$APPLICANT->CenterName."</p> Your Application still not submitted ";
          }
     }else{ ?>
    <!-- for normal applicant -->
        <div class="ibox-content"><?php if($APPLICANT->submitted==1){
            echo "<br/><br/> Dear ".$APPLICANT->firstname. ' '.$APPLICANT->lastname." Your Application Already Submitted";
        }else { ?>
            Welcome !, Please use menu at the left side to navigate in the system
            <br/><br/>
            <?php
        }
    }?>



    </div>
</div>
