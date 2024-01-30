<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/13/17
 * Time: 8:02 AM
 */
class Dashboard  extends CI_Controller
{


    private $MODULE_ID = '';
    private $GROUP_ID = '';

    function __construct()
    {
        parent::__construct();


        $this->data['CURRENT_USER'] = current_user();

        $this->form_validation->set_error_delimiters('<div class="required">', '</div>');

        $this->data['title'] = 'Administrator';

        $tmp_group = get_user_group();
        $this->GROUP_ID = $this->data['GROUP_ID'] = $tmp_group->id;
        $this->MODULE_ID = $this->data['MODULE_ID'] = $tmp_group->module_id;
    }



    function dashboard(){
        $current_user = current_user();

        /*if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_USERS', 'create_group')) {
            $this->session->set_flashdata("message", show_alert("ADD_GROUP :: Access denied !!", 'info'));
            redirect(site_url(), 'refresh');
        }*/
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Dashboard');
        $this->data['active_menu'] = 'dashboard';

        $this->data['content'] = 'dashboard/dashboard';
        $this->load->view('template', $this->data);


    }


    function dashboard_analytics()
    {
        $account_year=$this->common_model->get_account_year()->row()->AYear;
        $a_array=explode('/',$account_year);
        $current_user = current_user();
        $month_array=array(
            0=>$a_array[0].'-07',
            1=>$a_array[0].'-08',
            2=>$a_array[0].'-09',
            3=>$a_array[0].'-10',
            4=>$a_array[0].'-11',
            5=>$a_array[0].'-12',
            6=>$a_array[1].'-01',
            7=>$a_array[1].'-02',
            8=>$a_array[1].'-03',
            9=>$a_array[1].'-04',
            10=>$a_array[1].'-05',
            11=>$a_array[1].'-06'
        );

        $nt4_level_array=array();
        $nt5_level_array=array();
        $nt6_level_array=array();
        $nt7_level_array=array();
        $nt8_level_array=array();
        $current_account_year_data=array();
        $all_nta_level_array=array();

        for ($i=2;$i<count($month_array);$i++)
        {
            
            // $nt4_result=$this->db->query("select sum(paid_amount) as amount from payment where ntalevel='4'  and   SUBSTRING(transaction_date,1,7)='".$month_array[$i]."'")->row();
            // array_push($nt4_level_array,(int)$nt4_result->amount);

            // $nt5_result=$this->db->query("select sum(paid_amount) as amount from payment where ntalevel='5'  and  SUBSTRING(transaction_date,1,7)='".$month_array[$i]."'")->row();
            // array_push($nt5_level_array,(int)$nt5_result->amount);

            // $nt6_result=$this->db->query("select sum(paid_amount) as amount from payment where  ntalevel='6'  and  SUBSTRING(transaction_date,1,7)='".$month_array[$i]."'")->row();
            // array_push($nt6_level_array,(int)$nt6_result->amount);

            // $nt7_result=$this->db->query("select sum(paid_amount) as amount from payment where  ntalevel='7'  and  SUBSTRING(transaction_date,1,7)='".$month_array[$i]."'")->row();
            // array_push($nt7_level_array,(int)$nt7_result->amount);

            // $nt8_result=$this->db->query("select sum(paid_amount) as amount from payment where  ntalevel='8'  and  SUBSTRING(transaction_date,1,7)='".$month_array[$i]."'")->row();
            // array_push($nt8_level_array,(int)$nt8_result->amount);

            // $all_result=$this->db->query("select sum(paid_amount) as amount from payment where    SUBSTRING(transaction_date,1,7)='".$month_array[$i]."'")->row();
            // array_push($all_nta_level_array,(int)$all_result->amount);


            $nt4_result=$this->db->query("select count(id) as regno from application where submitted='1'  and   SUBSTRING(submitedon,1,7)='".$month_array[$i]."'")->row();
            array_push($nt4_level_array,(int)$nt4_result->regno);

            $nt5_result=$this->db->query("select count(CenterRegNo) as regno from application where submitted='3'  and   SUBSTRING(submitedon,1,7)='".$month_array[$i]."'")->row();
            array_push($nt5_level_array,(int)$nt5_result->regno);

            // $nt6_result=$this->db->query("select sum(CenterRegNo) as regno from application where submitted='3'  and   SUBSTRING(approved_date,1,7)='".$month_array[$i]."'")->row();
            // array_push($nt6_level_array,(int)$nt6_result->amount);

            // $nt7_result=$this->db->query("select sum(CenterRegNo) as regno from application where submitted='3'  and   SUBSTRING(approved_date,1,7)='".$month_array[$i]."'")->row();
            // array_push($nt7_level_array,(int)$nt7_result->amount);

            // $nt8_result=$this->db->query("select sum(CenterRegNo) as regno from application where submitted='3'  and   SUBSTRING(approved_date,1,7)='".$month_array[$i]."'")->row();
            // array_push($nt8_level_array,(int)$nt8_result->amount);

            $all_result=$this->db->query("select count(status) as regno from application where SUBSTRING(submitedon,1,7)='".$month_array[$i]."'")->row();
            array_push($all_nta_level_array,(int)$all_result->regno);
        }

        $nt4_data_array=array(
            'name'=>'NTA Level 4',
            'data'=>$nt4_level_array
        );
        
        $nt4_data_json=json_encode($nt4_data_array);
        array_push($current_account_year_data,$nt4_data_json);
        // var_dump($nt4_data_json);exit;
        $nt5_data_array=array(
            'name'=>'NTA Level 5',
            'data'=>$nt5_level_array
        );
        $nt5_data_json=json_encode($nt5_data_array);
        array_push($current_account_year_data,$nt5_data_json);

        // $nt6_data_array=array(
        //     'name'=>'NTA Level 6',
        //     'data'=>$nt6_level_array
        // );
      
        // $nt6_data_json=json_encode($nt6_data_array);
        // array_push($current_account_year_data,$nt6_data_json);

        // $nt7_data_array=array(
        //     'name'=>'NTA Level 7',
        //     'data'=>$nt7_level_array
        // );
      
        // $nt7_data_json=json_encode($nt7_data_array);
        // array_push($current_account_year_data,$nt7_data_json);

        // $nt8_data_array=array(
        //     'name'=>'NTA Level 8',
        //     'data'=>$nt8_level_array
        // );
      
        // $nt8_data_json=json_encode($nt8_data_array);
        // array_push($current_account_year_data,$nt8_data_json);



        $all_data_array=array(
            'name'=>'Overall',
            'data'=>$all_nta_level_array
        );
        $all_nta_level_json=json_encode($all_data_array);
        array_push($current_account_year_data,$all_nta_level_json);


        $data=array(
            'current_account_year_data'=>$current_account_year_data
        );

        // echo json_encode($data);
        // exit;

    }

  
    function load_graph(){
       
          $ayear = $this->common_model->get_academic_year()->row()->AYear; 
           $monthly_data = $this->db->query("select date_format(timestamp, '%M') as month,sum(paid_amount) as amount from payment where a_year='$ayear' group by date_format(timestamp, '%M')  ")->result();
            $amounts = array();
            $months = array();
            
            foreach($monthly_data as $values)
            {
                $months[] = $values->month.'-'.$ayear;
                $amounts[] =$values->amount;
            }
             $populated_month = json_encode($months);
             $populated_amounts = json_encode($amounts);

            // echo json_encode(array($populated_month,$populated_amounts));
           //echo  $populated_month;


    }

    function load_nta_graph()
    {
        $ayear = $this->common_model->get_account_year()->row()->AYear;
        $monthly_data = $this->db->query("select date_format(timestamp, '%M') as month,sum(paid_amount) as amount,ntalevel from payment where a_year='$ayear' and ntalevel<>'0' group by date_format(timestamp, '%M'),ntalevel")->result();
    
        $nta_5 =array();
        $nat_five = array();
        $nta_6 = array();
        $nat_six = array();
        $nta_4 = array();
        $nat_four = array();
        $nta_7 = array();
        $nat_seven = array();
        $nta_8 = array();
        $nat_eight = array();
        $months = array();
        $month_array = array();
         
        foreach($monthly_data as $values)
        {
            $check_4 = $this->db->query("select date_format(timestamp, '%M') as month,sum(paid_amount) as amount,ntalevel from payment where a_year='$ayear' and ntalevel ='4' and date_format(timestamp,'%M') = '$values->month' group by date_format(timestamp, '%M')")->result();
            $check_5 = $this->db->query("select date_format(timestamp, '%M') as month,sum(paid_amount) as amount,ntalevel from payment where a_year='$ayear' and ntalevel ='5' and date_format(timestamp,'%M') = '$values->month' group by date_format(timestamp, '%M')")->result();
            $check_6 = $this->db->query("select date_format(timestamp, '%M') as month,sum(paid_amount) as amount,ntalevel from payment where a_year='$ayear' and ntalevel ='6' and date_format(timestamp,'%M') = '$values->month' group by date_format(timestamp, '%M')")->result();
            $check_7 = $this->db->query("select date_format(timestamp, '%M') as month,sum(paid_amount) as amount,ntalevel from payment where a_year='$ayear' and ntalevel ='7' and date_format(timestamp,'%M') = '$values->month' group by date_format(timestamp, '%M')")->result();
            $check_8 = $this->db->query("select date_format(timestamp, '%M') as month,sum(paid_amount) as amount,ntalevel from payment where a_year='$ayear' and ntalevel ='8' and date_format(timestamp,'%M') = '$values->month' group by date_format(timestamp, '%M')")->result();

            if(empty($check_4)){
                $nta_4[] =  array('amount'=>0,'month'=>$values->month); 
            }
            if(empty($check_5)){
                $nta_5[] =  array('amount'=>0,'month'=>$values->month);  
            }
            if(empty($check_6)){
                $nta_6[] = array('amount'=>0,'month'=>$values->month); 
            }

            if(empty($check_7)){
                $nta_7[] = array('amount'=>0,'month'=>$values->month); 
            }
            if(empty($check_8)){
                $nta_8[] = array('amount'=>0,'month'=>$values->month); 
            }

            if($values->ntalevel == 4)
            {
            $nta_4[] = array('amount'=>$values->amount,'month'=>$values->month); 
            }
            if($values->ntalevel == 5)
            {  
             $nta_5[] = array('amount'=>$values->amount,'month'=>$values->month);                  
            }
            if($values->ntalevel == 6)
            {
            $nta_6[] = array('amount'=>$values->amount,'month'=>$values->month);    
            }
            if($values->ntalevel == 7)
            {
            $nta_7[] = array('amount'=>$values->amount,'month'=>$values->month);    
            }
            if($values->ntalevel == 8)
            {
            $nta_8[] = array('amount'=>$values->amount,'month'=>$values->month);    
            }
            $months[] = $values->month.'-'.$ayear;
        }
         
        $months = array_unique($months);
        foreach($months as $v){
             $month_array[] = $v;
            
            }
         
           // $unique_types = array_unique(array_map(function($elem){return $elem['month'];}, $nta_5)); 
           
                foreach($nta_4 as $k => $v) 
                {
                    foreach($nta_4 as $key => $value) 
                    {
                        if($k != $key && $v['month'] == $value['month'])
                        {
                            unset($nta_4[$k]);
                        }
                    }
                }
                foreach($nta_5 as $k => $v) 
                {
                    foreach($nta_5 as $key => $value) 
                    {
                        if($k != $key && $v['month'] == $value['month'])
                        {
                            unset($nta_5[$k]);
                        }
                    }
                }
                foreach($nta_6 as $k => $v) 
                {
                    foreach($nta_6 as $key => $value) 
                    {
                        if($k != $key && $v['month'] == $value['month'])
                        {
                            unset($nta_6[$k]);
                        }
                    }
                }
                foreach($nta_7 as $k => $v) 
                {
                    foreach($nta_7 as $key => $value) 
                    {
                        if($k != $key && $v['month'] == $value['month'])
                        {
                            unset($nta_7[$k]);
                        }
                    }
                }
                foreach($nta_8 as $k => $v) 
                {
                    foreach($nta_8 as $key => $value) 
                    {
                        if($k != $key && $v['month'] == $value['month'])
                        {
                            unset($nta_8[$k]);
                        }
                    }
                }
               
                 foreach($nta_4 as  $values)
                 {
                    $nta_four[] = $values['amount'];       
                 }
                 foreach($nta_5 as  $values)
                 {
                    $nta_five[] = $values['amount'];       
                 }
                 foreach($nta_6 as  $values)
                 {
                    $nta_six[] = $values['amount'];       
                 }
                 foreach($nta_7 as  $values)
                 {
                    $nta_seven[] = $values['amount'];       
                 }
                 foreach($nta_8 as  $values)
                 {
                    $nta_eight[] = $values['amount'];       
                 }
        
        $nta_4 = json_encode($nta_four);
        $nta_5 =json_encode($nta_five);
        $nta_6 = json_encode($nta_six);
        $nta_7 = json_encode($nta_seven);
        $nta_8 = json_encode($nta_eight);
        $month_array = json_encode($month_array);
    

        echo json_encode(array($nta_4,$nta_5,$nta_6,$nta_7,$nta_8,$month_array)); 

    }
}