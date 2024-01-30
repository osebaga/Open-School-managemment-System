<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/16/17
 * Time: 10:45 AM
 */
class Panel extends CI_Controller
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

    function invoice_list()
    {
        $current_user = current_user();
        $ega_auth=$this->db->query("select * from ega_auth")->row();
        if(isset($_GET['resubmit_selected']) )
        {
            if(isset($_GET['txtSelect']))
            {
                $selected_invoices=$_GET['txtSelect'];
                $i=0;
                foreach ($selected_invoices as $key=>$invoice_id)
                {
                    $invoice_info=$this->db->query("select * from invoices where id=".$invoice_id)->row();

                    if($invoice_info->status==0 ) {
                        $refference=$ega_auth->prefix.$invoice_id;
                        $fee_type=$invoice_info->type;
                        // $invoice_student_info=$this->db->query("select * from application where id='".$invoice_info->student_id."'")->row();
                        //$student_name=$invoice_student_info->FirstName. ''.$invoice_student_info->MiddleName. ''.$invoice_student_info->LastName;
                        $student_email=$invoice_info->student_email;
                        $postdata = array(
                            "customer" => $ega_auth->username,
                            "reference" => $ega_auth->prefix.$invoice_id,
                            "student_name" =>$invoice_info->student_name,
                            "student_id" => $invoice_info->student_id,
                            "student_email"=>$student_email,
                            "student_mobile"=>$invoice_info->student_mobile,
                            "GfsCode"=>$invoice_info->GfsCode,
                            "amount"=>$invoice_info->amount,
                            "type"=>$invoice_info->type,
                            "secret"=>$ega_auth->api_secret,
                            "action"=>'SEND_INVOICE'
                        );
                        $url=$ega_auth->call_url;
                        $result=sendDataOverPost($url,$postdata);
                        $result_array=json_decode($result,true);
                        $log_data_array=array(
                            'request'=>print_r($postdata,true),
                            'responce'=>$result,
                            'status'=>$result_array['status'],
                            'description'=>$result_array['description'],
                            'type'=>'invoice'
                        );
                        $this->db->insert('ega_logs',$log_data_array);
                    }

                }
                $this->session->set_flashdata("message", show_alert("Selected Invoice Successfully Resubmited", 'info'));
                redirect(site_url('invoice_list/'),'refresh');
            }else
            {
                $this->session->set_flashdata("message", show_alert("Please select at  list one invoice", 'danger'));
                redirect(site_url('invoice_list/'),'refresh');
            }
        }

        if(isset($_GET['cancel_selected']) )
        {
            if(isset($_GET['txtSelect']))
            {
                $selected_invoices=$_GET['txtSelect'];
                $i=0;
                $refference='';
                foreach ($selected_invoices as $key=>$invoice_id)
                {
                    if($i==0)
                        $refference=$ega_auth->prefix.$invoice_id;
                    else
                        $refference = $refference.','.$ega_auth->prefix.$invoice_id;
                    $i+=1;
                }

                $invoince_cancel= array(
                    'references'=>$refference,
                    "secret" =>$ega_auth->api_secret,
                    "customer" => $ega_auth->username,
                    "action"   => 'CANCEL_INVOICE'
                );

                $url=$ega_auth->call_url;
                $result=sendDataOverPost($url,$invoince_cancel);
                $result_array=json_decode($result,true);
                $log_data_array=array(
                    'request'=>print_r($invoince_cancel,true),
                    'responce'=>$result,
                    'status'=>$result_array['status'],
                    'description'=>$result_array['description'],
                    'type'=>'invoice'
                );
                $this->db->insert('ega_logs',$log_data_array);
                if($result_array['status']=='1')
                {
                    $update_invoice=array(
                        'status'=>100
                    );

                    foreach ($selected_invoices as $key=>$invoice_id)
                    {
                        $this->db->update('invoices', $update_invoice, array('id'=>$invoice_id));

                    }

                }

                $this->session->set_flashdata("message", show_alert("Selected Invoice Successfully Cancelled", 'info'));
                redirect(site_url('invoice_list/'),'refresh');
            }else
            {
                $this->session->set_flashdata("message", show_alert("Please select at  list one invoice", 'danger'));
                redirect(site_url('invoice_list/'),'refresh');
            }

        }

        $where = ' WHERE 1=1';

        if (isset($_GET['type']) && $_GET['type'] != '') {
            $where .= " AND member_type='" . $_GET['type'] . "' ";
        }

         if (isset($_GET['center']) && $_GET['center'] != '') {
             $where .= " AND CenterRegNo='" . $_GET['center'] . "' ";
         }

        if (isset($_GET['fee_id']) && $_GET['fee_id'] != '') {
            $feeid= json_encode($_GET['fee_id']);
            $fee_id = json_decode($feeid);
            $first = $fee_id[0];
            $second = $fee_id[1];
            $feelist = '('.$first .','.$second.')';
            if ($second=='') {
                $feelist = '('.$first .')';
            }else
            {
                $feelist = '('.$first .','.$second.')';
            }
            // var_dump($feelist);
            // exit;
            $where .= " AND fee_id IN $feelist";
          
        }        


        if (isset($_GET['name']) && $_GET['name'] != '') {

            // $where .= " AND first_name LIKE '%" . $_GET['name'] . "%'  OR surname LIKE '%" . $_GET['name'] . "%' OR other_names LIKE '%" . $_GET['name'] . "%' ";
            $where .= " AND first_name LIKE '%" . $_GET['name'] . "%'  OR registration_number='".$_GET['name']."' OR surname LIKE '%" . $_GET['name'] . "%' OR other_names LIKE '%" . $_GET['name'] . "%' ";
        }

        if (isset($_GET['from']) && $_GET['from'] != '') {
            $where .= " AND DATE(timestamp)>='" . format_date($_GET['from']) . "' ";
        }

        if (isset($_GET['to']) && $_GET['to'] != '') {
            $where .= " AND DATE(timestamp)<='" . format_date($_GET['to']) . "' ";
        }

        $sql = " SELECT * FROM invoices  $where ";

        // echo $sql;
        // exit;
        $sql2 = "SELECT count(id) as counter FROM invoices $where ";

        $config["base_url"] = site_url('invoice_list/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");


        $config["total_rows"] = $this->db->query($sql2)->row()->counter;
        $config["per_page"] = 50;
        $config["uri_segment"] = 2;


        $this->data['invoice_list'] = $this->db->query($sql . " ORDER BY invoices.id DESC")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'invoice_list/', 'title' => 'Invoice List');

        $this->data['active_menu'] = 'invoice_list';
        $this->data['content'] = 'panel/invoice_list';
        $this->load->view('template', $this->data);

    }



    function import_payment()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }
        if (isset($_GET['ayear']) && $_GET['ayear'] <> '') {
            $this->data['ayear'] = $_GET['ayear'];

        }
        
        $this->form_validation->set_rules('post_data', 'post_data', 'required');

        $excel_upload = TRUE;

     
        $upload_error = '';
        if ($this->form_validation->run() == true) {
            
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
             

            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlsx format.</div>';
                $excel_upload = FALSE;
 
            }

    
            if ($excel_upload == TRUE) {
                //updated database group name from saris to default
             $otherdb = $this->load->database('default', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

               // $saris_acc_year=$otherdb->query("select MAX(AYear) as AYear from academicyear ")->row()->AYear;
                $saris_acc_year = $this->common_model->get_account_year()->row()->AYear;

                $dest_name = time() . 'result_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);

                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }
                foreach ($arr_data as $row) {
                    $data = array();
                    $courseError = array();
              
                    if (trim($row['E']) <> '') {
                        "<br>Control Number".$control_number=trim(strval($row['A']));
                        "<br/>Description=".$description=trim($row['B']);
                        "<br/>category=".$category=trim($row['C']);
                        "<br/>NTA_level=".$ntalevel=trim($row['D']);
                        "<br/>regno=".$reg_number=trim($row['E']);
                        "<br/>rereipt=".$ega_ref=$receipt=trim($row['F']);
                        "<br/>name=".$payername=trim($row['G']);
                        "<br/>Date=".$date = date('Y-m-d h:i:s', PHPExcel_Shared_Date::ExcelToPHP(trim($row['H'])));
                        "<br/>amount=".$amount=trim($row['I']);
                        // "<br/>Academic year=".$ayear= $saris_acc_year;
                        "<br/>Academic year=".$ayear= trim($this->input->post('ayear'));


                        
                        //checkRegno
                        // if(strlen($reg_number)==14)
                        // {
                        //     BACE21/DSM/013
                        //     echo"accouunt year=".$saris_acc_year.'regno='.$reg_number;
                        //     echo"<br>first sixt number=". substr($reg_number,0,6);
                        //     echo"<br>first four numbers=". substr($reg_number,6,4);
                        //     echo"<br>Year numbers=". substr($reg_number,10  ,4);
                        //     $reg_number=substr($reg_number,0,6).'/'.substr($reg_number,6,4).'/'.substr($reg_number,10  ,4);
                        // }
                        $is_accomodation=0;
                        $is_carry_over=0;
                        if($category==4){
                            $is_carry_over=1;
                        }
                        if($category==3){
                            $is_accomodation=1;
                        }

                        $cost_fee = explode(" ",ucfirst($description));
                        $fee_cost = $cost_fee[0];
                        if($fee_cost=='Tuition')
                        {
                            $categ = 2;
                        }elseif($fee_cost=='Direct')
                        {
                            $categ = 1;
                        }


                        $insert_array=array(
                            'student_id'=>$reg_number,
                            'ega_refference'=>$ega_ref,
                            'receipt_number'=>$ega_ref,
                            'control_number'=>$control_number,
                            'paid_amount'=>$amount,
                            'transaction_date'=>$date,
                            'a_year'=>$ayear,
                            'is_accoomodation'=>$is_accomodation,
                            'is_carry_over'=>$is_carry_over,
                            'payer_name'=>$payername,
                            'paid_for'=>ucfirst($description),
                            'description'=>ucfirst($description),
                            'ntalevel'=>$ntalevel,
                            'fee_category'=>$categ
                        );


                        // var_dump($insert_array);exit;
                  
                        $insert_invoice=array(
                            'student_id'=>$reg_number,
                            'control_number'=>$control_number,
                            'amount'=>$amount,
                            'timestamp'=>$date,
                            'a_year'=>$ayear,
                            'status'=>2,
                            'fee_name'=>ucfirst($description),
                            'student_name'=>$payername,
                            'description'=>ucfirst($description),
                            'nta_level'=>$ntalevel,
                            'fee_category'=>$categ,
                            'equivalent_amount'=>$amount,
                            'payment_details'=>ucfirst($description)
                        );


                        $chekif =$this->db->query("select * from invoices where control_number='$control_number' and student_id='$reg_number'")->row();
                      
                        if(!is_null($chekif))
                        {
                            $pay = $chekif->amount;
                            $pay_equ = $chekif->equivalent_amount;

                            $update_pay = $pay + $amount;
                            $update_equ = $pay_equ + $amount;
                          
                        }
                        $update_invoice=array(
                            'student_id'=>$reg_number,
                            'control_number'=>$control_number,
                            'amount'=>$update_pay,
                            'timestamp'=>$date,
                            'a_year'=>$ayear,
                            'status'=>2,
                            'fee_name'=>ucfirst($description),
                            'student_name'=>$payername,
                            'description'=>ucfirst($description),
                            'nta_level'=>$ntalevel,
                            'fee_category'=>$categ,
                            'equivalent_amount'=>$update_equ,
                            'payment_details'=>ucfirst($description)
                        );

                        // var_dump($update_invoice);exit;
                      
                        $check_if_exist_in_payment=$this->db->query("select * from payment where control_number='$control_number' and student_id='$reg_number' and receipt_number='$ega_ref'")->row();
                    
                        if(!is_null($check_if_exist_in_payment))
                        {
                            $malipo = $check_if_exist_in_payment->paid_amount;

                            $update_paid = $malipo + $amount;
                          
                        }
                        $update_array=array(
                            'student_id'=>$reg_number,
                            'control_number'=>$control_number,
                            'paid_amount'=>$update_paid,
                            'transaction_date'=>$date,
                            'a_year'=>$saris_acc_year,
                            'is_accoomodation'=>$is_accomodation,
                            'is_carry_over'=>$is_carry_over,
                            'payer_name'=>$payername,
                            'paid_for'=>ucfirst($description),
                            'ntalevel'=>$ntalevel,
                            'description'=>ucfirst($description),
                            'fee_category'=>$categ
                        );


                        if($is_carry_over==1)
                        {
                            echo"account year=".$saris_acc_year.'regno='.$reg_number;
                            echo "<br/>NTA level=".$ntalevel;
                            echo "<br/>Program=".$programme=$description;
                            echo '<br/>'.$reg_number.'is cccoomodation='.$amount;
                            $fee_structure=$this->db->query("select * from fee_structure where ntlevel_value='".$ntalevel."' and   fee_category=4")->row();
                            if($fee_structure->id)
                            {
                                $fee = $fee_structure->name;
                                $fee_amount =($fee_structure->amount + $fee_structure->carryover_quality_assurance_value);
                                $name=$payername;
                                $invoice_array=array(
                                    "regno"=>$reg_number,
                                    "ayear"=>$saris_acc_year,
                                    "amount"=>$fee_amount,
                                    "name"=>$name,
                                    "type"=>$fee,
                                    "side"=>'DR',
                                    "programme"=>$programme,
                                    "nta_level"=>$ntalevel
                                );
                                $check_if_invoice_exist = $this->db->query("select * from student_invoice where regno='".$reg_number."' and ayear='".$saris_acc_year."'  and `type`='".$fee."' and side='DR' and nta_level='".$ntalevel."'")->row();
                                if (!$check_if_invoice_exist) {
                                    $this->db->insert('student_invoice',$invoice_array);
                                }
                            }
                        }

                        if($is_accomodation==1)
                        {
                             echo"accouunt year=".$saris_acc_year.'regno='.$reg_number;
//                                $results= $otherdb->query("select student.Name,NTALevel,programme.Title as programme from ((programme inner join class on programme.programmecode = class.programme) inner join student on student.RegNo=class.RegNo) where class.Ayear='".$saris_acc_year."' and class.RegNo='$reg_number'")->row();
                            echo "<br/>NTA level=".$ntalevel;
                            echo "<br/>Program=".$programme=$description;
                            echo '<br/>'.$reg_number.'is cccoomodation='.$amount;
                            $fee_structure=$this->db->query("select * from fee_structure where ntlevel_value='".$ntalevel."' and   fee_category=3")->row();
                            if($fee_structure->id)
                            {
                                $fee = $fee_structure->name;
                                $fee_amount =$fee_structure->amount;
                                $name=$payername;
                                $invoice_array=array(
                                    "regno"=>$reg_number,
                                    "ayear"=>$saris_acc_year,
                                    "amount"=>$fee_amount,
                                    "name"=>$name,
                                    "type"=>$fee,
                                    "side"=>'DR',
                                    "programme"=>$programme,
                                    "nta_level"=>$ntalevel
                                );
                                $check_if_invoice_exist = $this->db->query("select * from student_invoice where regno='".$reg_number."' and ayear='".$saris_acc_year."'  and `type`='".$fee."' and side='DR' and nta_level='".$ntalevel."'")->row();
                                if (!$check_if_invoice_exist) {
                                    $this->db->insert('student_invoice',$invoice_array);
                                }
                            }

                        }

                        $check_if_exist=$this->db->query("select * from payment where control_number='$control_number' and student_id='$reg_number' and receipt_number='$ega_ref'")->result();
                        if(!$check_if_exist)
                        {
                            $insert_query=$this->db->insert("payment",$insert_array);
                        }
                        else{
                            //update
                            $upate_query=$this->db->update("payment",$update_array,array('control_number'=>$control_number),array('student_id'=>$reg_number));
                        }
                        // $check_if_exist_saris=$otherdb->query("select * from payment where control_number='$control_number'")->result();
                        // if(!$check_if_exist_saris){
                        //     $upate_query=$otherdb->insert("payment",$insert_array,array('control_number'=>$control_number));
                        // }
                        $chekif =$this->db->query("select * from invoices where control_number='$control_number' and student_id='$reg_number'")->result();
                        if(!$chekif)
                        {
                            $insert_into_invoice=$this->db->insert("invoices",$insert_invoice);
                        }
                        else{

                            $upate_into_invoice=$this->db->update("invoices",$update_invoice,array('control_number'=>$control_number),array('student_id'=>$reg_number));
              
                        }
                    }
                }
                $this->session->set_flashdata('message', show_alert('Payment Imported successfully!!', 'success'));

                unlink('./uploads/temp/' . $dest_name);
            }
        }

        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'import/', 'title' => 'Import GEPG payments');

        $this->data['active_menu'] = 'sims_data';
        $this->data['content'] = 'panel/import_payment';
        $this->load->view('template', $this->data);

    }
    function payment_list()
    {

        if(isset($_GET['pull_transctions']) )
        {

            $ch = curl_init();
            curl_setopt_array(
                $ch, array(
                CURLOPT_URL => 'http://41.59.225.216/ega-iae/pay_information_pushing.php',
                CURLOPT_RETURNTRANSFER => true
            ));
            $output = curl_exec($ch);
            // echo $output;
            $this->session->set_flashdata("message", show_alert("Operation Successfully", 'info'));
            redirect(site_url('payment_list/'),'refresh');

        }

        $current_user = current_user();
        $ega_auth=$this->db->query("select * from ega_auth")->row();


        $ayear = $this->common_model->get_academic_year()->row()->AYear;

        $where = ' WHERE 1=1';

        // if (isset($_GET['type']) && $_GET['type'] != '') {
        //     $where .= " AND member_type='" . $_GET['type'] . "' ";
        // }

        if (isset($_GET['key']) && $_GET['key'] != '') {

            // $where .= " AND first_name LIKE '%" . $_GET['name'] . "%'  OR surname LIKE '%" . $_GET['name'] . "%' OR other_names LIKE '%" . $_GET['name'] . "%' ";
            $where .= " AND first_name LIKE '%" . $_GET['key'] . "%'  OR registration_number='".$_GET['key']."' OR surname LIKE '%" . $_GET['key'] . "%' OR other_names LIKE '%" . $_GET['key'] . "%'   OR email LIKE '%" . $_GET['key'] . "%'";
        }

        if (isset($_GET['from']) && $_GET['from'] != '') {
            $where .= " AND DATE(payment.transaction_date)>='" . format_date($_GET['from']) . "' ";
        }

        if (isset($_GET['center']) && $_GET['center'] != '') {
            $where .= " AND invoices.CenterRegNo='" . trim($_GET['center']). "' ";
        }

        if (isset($_GET['to']) && $_GET['to'] != '') {
            $where .= " AND DATE(payment.transaction_date)<='" . format_date($_GET['to']) . "' ";
        }

//        if((!isset($_GET['to']) or $_GET['to'] == '') and (!isset($_GET['from']) or $_GET['from'] == '') )
//        {
//            $where .=" AND payment.a_year='$ayear'";
//        }


        if (isset($_GET['fee_type']) && $_GET['fee_type'] != '') {
            $where .= " AND type='" . trim($_GET['fee_type']) . "' ";
        }

        if (isset($_GET['fee']) && $_GET['fee'] != '') {
            $fees = json_encode($_GET['fee']);
            $fee_list = json_decode($fees);
            $direct_cost = $fee_list[0];
            $tuition_fee = $fee_list[1];
    
            if($tuition_fee==''){
                $combine_fee  = '('.$direct_cost.')';

            }else
            {
                $combine_fee  = '('.$direct_cost. ',' .$tuition_fee.')';

            }            
            // $where .= " AND invoices.fee_id='" . trim($_GET['fee']) . "' ";

            $where .= " AND invoices.fee_id IN $combine_fee ";
          
        }


        // if (isset($_GET['ntalevel']) && $_GET['ntalevel'] != '') {
        //     $where .= " AND payment.ntalevel='" . trim($_GET['ntalevel']) . "' ";
        // }

        if (isset($_GET['ayear']) && $_GET['ayear'] != '') {
            $where .= " AND payment.a_year='" . trim($_GET['ayear']) . "' ";
        }

        $sql = " SELECT payment.*,student_name,type,fee_name FROM payment  left join invoices on invoices.id=payment.invoice_number   $where ";


        $config["base_url"] = site_url('payment_list/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");


        $this->data['payment_list'] = $this->db->query($sql . " ORDER BY payment.transaction_date DESC")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'invoice_list/', 'title' => 'Payment List');

        $this->data['active_menu'] = 'invoice_list';
        $this->data['content'] = 'panel/payment_list';
        $this->load->view('template', $this->data);

    }


    function applicant_list_iposa()
    {
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'APPLICANT', 'applicant_list')) {
            $this->session->set_flashdata("message", show_alert("APPLICANT_LIST :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant');
        $this->data['bscrum'][] = array('link' => 'applicant_list_iposa/', 'title' => 'IPOSA Applicant List');

        $this->load->library('pagination');

        $ayear = $this->common_model->get_academic_year()->row()->AYear;
        // $date = "2018-09-24";
        $where = " WHERE 1=1 ";



        if (isset($_GET['from']) && $_GET['from'] != '') {
            $frm = $_GET['from'];
            $from = format_date($frm, true);
            $where .= " AND DATE(application_iposa.createdon) >='" . $from . "' ";
        }

        if (isset($_GET['to']) && $_GET['to'] != '') {
            $t = $_GET['to'];
            $to = format_date($t, true);
            $where .= " AND DATE(application_iposa.createdon) <='" . $to . "' ";
        }

        if (isset($_GET['year']) && $_GET['year'] != '') {
            $where .= " AND application_iposa.AYear='" . $_GET['year'] . "' ";
        }
        if (isset($_GET['vituo']) && $_GET['vituo'] != '') {
            $where .= " AND application_iposa.kituoname='" . $_GET['vituo'] . "' ";
        }

        if (isset($_GET['key']) && $_GET['key'] != '') {
            $where .= " AND  (FirstName LIKE '%" . $_GET['key'] . "%' OR  LastName LIKE '%" . $_GET['key'] . "%')";
        }


        $sql = " SELECT * FROM application_iposa  $where ";
        $sql2 = " SELECT count(id) as counter FROM application_iposa  $where ORDER BY application_iposa.createdon DESC ";

        $config["base_url"] = site_url('applicant_list_iposa/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");


        $config["total_rows"] = $this->db->query($sql2)->row()->counter;
        $config["per_page"] = 50;
        $config["uri_segment"] = 2;

        include 'include/config_pagination.php';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2) ? $this->uri->segment(2) : 0);
        $this->data['pagination_links'] = $this->pagination->create_links();

        $this->data['applicant_list'] = $this->db->query($sql . " ORDER BY DATE(application_iposa.createdon) ASC ")->result();


        $this->data['active_menu'] = 'applicant_list_iposa';
        $this->data['content'] = 'panel/applicant_list_iposa';
        $this->load->view('template', $this->data);
    }


    function applicant_list()
    {
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'APPLICANT', 'applicant_list')) {
            $this->session->set_flashdata("message", show_alert("APPLICANT_LIST :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant');
        $this->data['bscrum'][] = array('link' => 'applicant_list/', 'title' => 'Applicant List');

        $this->load->library('pagination');

        $ayear = $this->common_model->get_academic_year()->row()->AYear;
        // $date = "2018-09-24";
        //$where = " WHERE 1=1 AND application.AYear='$ayear' ";
        $where = " WHERE 1=1  ";
        $check_where=0;

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $where .= " AND submitted='" . $_GET['status'] . "' ";
            $check_where+=1;
        }
        if (isset($_GET['entry']) && $_GET['entry'] != '') {
            $where .= " AND entry_category='" . $_GET['entry'] . "' ";
            $check_where+=1;

        }

        if (isset($_GET['center']) && $_GET['center'] != '') {
            $where .= " AND application.CenterRegNo='" . $_GET['center'] . "' ";
            $check_where+=1;

        }

        if (isset($_GET['from']) && $_GET['from'] != '') {
          $frm = $_GET['from'];
          $from = format_date($frm, true);
            $where .= " AND DATE(application.createdon) >='" . $from . "' ";
            $check_where+=1;
        }

        if (isset($_GET['to']) && $_GET['to'] != '') {
          $t = $_GET['to'];
          $to = format_date($t, true);
            $where .= " AND DATE(application.createdon) <='" . $to . "' ";
            $check_where+=1;
        }

        if (isset($_GET['year']) && $_GET['year'] != '') {
            $where .= " AND application.AYear='" . $_GET['year'] . "' ";
            $check_where+=1;
        }

        // if (isset($_GET['key']) && $_GET['key'] != '') {
        //     $where .= " AND  (form4_index LIKE '%" . $_GET['key'] . "%' OR  form6_index LIKE '%" . $_GET['key'] . "%' OR FirstName LIKE '%" . $_GET['key'] . "%' OR  LastName LIKE '%" . $_GET['key'] . "%' OR  email LIKE '%" . $_GET['key'] . "%')";
        //     $check_where+=1;
        // }

        if($check_where==0)
        {
             $where .= " AND   application.AYear='$ayear'";
        }

        $sql = " SELECT application.id,FirstName,MiddleName,LastName,Mobile1,paid_amount as amount,Nationality,submitted,application.CenterRegNo,RegNo,application.createdon,response,entry_category FROM application left join  payment on payment.student_id=application.id $where AND RegNo='' AND application.application_category='Applicant' ";
        $sql2 = " SELECT count(id) as counter FROM application  $where ORDER BY application.id DESC ";
// echo $sql;exit;
        $config["base_url"] = site_url('applicant_list/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");

        $config["total_rows"] = $this->db->query($sql2)->row()->counter;
        $config["per_page"] = 50;
        $config["uri_segment"] = 2;

        include 'include/config_pagination.php';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2) ? $this->uri->segment(2) : 0);
        $this->data['pagination_links'] = $this->pagination->create_links();

        $this->data['applicant_list'] = $this->db->query($sql . " ORDER BY application.id DESC ")->result();

        // var_dump($this->data['applicant_list']);
        // exit;

        $this->data['active_menu'] = 'applicant_list';
        $this->data['content'] = 'panel/applicant_list';
        $this->load->view('template', $this->data);
    }




    function centers_list()
    {
        $current_user = current_user();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant');
        $this->data['bscrum'][] = array('link' => 'centers_list/', 'title' => 'Center List');

        $this->load->library('pagination');

        $ayear = $this->common_model->get_academic_year()->row()->AYear;
        // $date = "2018-09-24";
        //$where = " WHERE 1=1 AND application.AYear='$ayear' ";
        $where = " WHERE 1=1  ";
        $check_where=0;

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $where .= " AND submitted='" . $_GET['status'] . "' ";
            $check_where+=1;
        }
        if (isset($_GET['entry']) && $_GET['entry'] != '') {
            $where .= " AND Premises='" . $_GET['entry'] . "' ";
            $check_where+=1;

        }

        if (isset($_GET['center']) && $_GET['center'] != '') {
            $where .= " AND application.application_type='" . $_GET['center'] . "' ";
            $check_where+=1;

        }

        if (isset($_GET['from']) && $_GET['from'] != '') {
          $frm = $_GET['from'];
          $from = format_date($frm, true);
            $where .= " AND DATE(application.createdon) >='" . $from . "' ";
            $check_where+=1;
        }

        if (isset($_GET['to']) && $_GET['to'] != '') {
          $t = $_GET['to'];
          $to = format_date($t, true);
            $where .= " AND DATE(application.createdon) <='" . $to . "' ";
            $check_where+=1;
        }

        if (isset($_GET['year']) && $_GET['year'] != '') {
            $where .= " AND application.AYear='" . $_GET['year'] . "' ";
            $check_where+=1;
        }

        if (isset($_GET['key']) && $_GET['key'] != '') {
            $where .= " AND  (form4_index LIKE '%" . $_GET['key'] . "%' OR  form6_index LIKE '%" . $_GET['key'] . "%' OR FirstName LIKE '%" . $_GET['key'] . "%' OR  LastName LIKE '%" . $_GET['key'] . "%' OR  email LIKE '%" . $_GET['key'] . "%')";
            $check_where+=1;
        }

        if($check_where==0)
        {
             $where .= " AND   application.AYear='$ayear'";
        }

        $sql = " SELECT application.id,CenterName,CenterOwner,CenterCordinator,Premises,OwnerProfession,TIN,Mobile1,paid_amount as amount,Nationality,submitted,application.CenterRegNo,application.createdon,response,application_type FROM application left join  payment on payment.student_id=application.id $where AND application.submitted!='3' ";
    //    echo $sql;exit;
        $sql2 = " SELECT count(id) as counter FROM application  $where ORDER BY application.id DESC ";
        $config["base_url"] = site_url('centers_list/');
        // echo $sql;exit;
        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");

        $config["total_rows"] = $this->db->query($sql2)->row()->counter;
        $config["per_page"] = 50;
        $config["uri_segment"] = 2;

        include 'include/config_pagination.php';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2) ? $this->uri->segment(2) : 0);
        $this->data['pagination_links'] = $this->pagination->create_links();

        $this->data['centers_list'] = $this->db->query($sql . " ORDER BY application.id DESC ")->result();

        $this->data['active_menu'] = 'applicant_list';
        $this->data['content'] = 'panel/centers_list';
        $this->load->view('template', $this->data);
    }


    function change_status()
    {

        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('applicant_id', 'Applicant ID', 'required');

        if ($this->form_validation->run() == true) {
            $array_data = array(
                'status' => $this->input->post('status'),
                 'submitted' => $this->input->post('status')
            );

            $applicant_id = $this->input->post('applicant_id');

            $register = $this->applicant_model->update_applicant($array_data, array('id' => $applicant_id));

            echo '<div style="color: #0000cc">Status updated..</div>';
        } else {
            echo $this->input->post('status') . '|' . $this->input->post('applicant_id') . ' The Status field is required';
        }


    }

    function popup_iposa_info($id)
    {

        $id = decode_id($id);
        $APPLICANT = $this->applicant_model->get_applicant_iposa($id);
        if ($APPLICANT) {
            $this->data['APPLICANT'] = $APPLICANT;
           // $next_kin = $this->applicant_model->get_nextkin_info($APPLICANT->id)->result();
//            if (count($next_kin) > 0){
//                $this->data['next_kin'] = $next_kin;
//            }

//            $referee = $this->applicant_model->get_applicant_referee($APPLICANT->id)->result();
//            if (count($referee) > 0) {
//                $this->data['academic_referee'] = $referee;
//            }

//            $sponsor = $this->applicant_model->get_applicant_sponsor($APPLICANT->id)->row();
//            if ($sponsor) {
//                $this->data['sponsor_info'] = $sponsor;
//            }

//            $employer = $this->applicant_model->get_applicant_employer($APPLICANT->id)->row();
//            if ($employer) {
//                $this->data['employer_info'] = $employer;
//            }

            //$this->data['education_bg'] = $this->applicant_model->get_education_bg(null, $APPLICANT->id);
            //$this->data['attachment_list'] = $this->applicant_model->get_attachment($APPLICANT->id);
//            $mychoice = $this->applicant_model->get_programme_choice($APPLICANT->id);
//            if ($mychoice) {
//                $this->data['mycoice'] = $mychoice;
//            }
            if (isset($_GET) && isset($_GET['status'])) {
                $this->data['change_status'] = 1;
            }
            $this->load->view('panel/popup_applicant_info_iposa', $this->data);
        } else {
            echo show_alert('This request did not pass our security checks.', 'info');
        }

    }


    function popup_applicant_info($id)
    {

        $id = decode_id($id);
        $APPLICANT = $this->applicant_model->get_applicant($id);
        if ($APPLICANT) {
            $this->data['APPLICANT'] = $APPLICANT;
            $next_kin = $this->applicant_model->get_nextkin_info($APPLICANT->id)->result();
            if (count($next_kin) > 0) {
                $this->data['next_kin'] = $next_kin;
            }

            $referee = $this->applicant_model->get_applicant_referee($APPLICANT->id)->result();
            if (count($referee) > 0) {
                $this->data['academic_referee'] = $referee;
            }

            $sponsor = $this->applicant_model->get_applicant_sponsor($APPLICANT->id)->row();
            if ($sponsor) {
                $this->data['sponsor_info'] = $sponsor;
            }

            $employer = $this->applicant_model->get_applicant_employer($APPLICANT->id)->row();
            if ($employer) {
                $this->data['employer_info'] = $employer;
            }

            $this->data['education_bg'] = $this->applicant_model->get_education_bg(null, $APPLICANT->id);
            $this->data['attachment_list'] = $this->applicant_model->get_attachment($APPLICANT->id);
            $mychoice = $this->applicant_model->get_programme_choice($APPLICANT->id);
            if ($mychoice) {
                $this->data['mycoice'] = $mychoice;
            }
            if (isset($_GET) && isset($_GET['status'])) {
                $this->data['change_status'] = 1;
            }
            $this->load->view('panel/popup_applicant_info', $this->data);
        } else {
            echo show_alert('This request did not pass our security checks.', 'info');
        }

    }


    function popup_center_info($id)
    {

        $id = decode_id($id);
        $APPLICANT = $this->applicant_model->get_applicant($id);
        if ($APPLICANT) {
            $this->data['APPLICANT'] = $APPLICANT;
            $next_kin = $this->applicant_model->get_nextkin_info($APPLICANT->id)->result();
            if (count($next_kin) > 0) {
                $this->data['next_kin'] = $next_kin;
            }

            // $referee = $this->applicant_model->get_applicant_referee($APPLICANT->id)->result();
            // if (count($referee) > 0) {
            //     $this->data['academic_referee'] = $referee;
            // }

            // $sponsor = $this->applicant_model->get_applicant_sponsor($APPLICANT->id)->row();
            // if ($sponsor) {
            //     $this->data['sponsor_info'] = $sponsor;
            // }

            // $employer = $this->applicant_model->get_applicant_employer($APPLICANT->id)->row();
            // if ($employer) {
            //     $this->data['employer_info'] = $employer;
            // }

            $this->data['education_bg'] = $this->applicant_model->get_education_bg(null, $APPLICANT->id);
            $this->data['attachment_list'] = $this->applicant_model->get_attachment($APPLICANT->id);
            $mychoice = $this->applicant_model->get_programme_choice($APPLICANT->id);
            if ($mychoice) {
                $this->data['mycoice'] = $mychoice;
            }
            if (isset($_GET) && isset($_GET['status'])) {
                $this->data['change_status'] = 1;
            }
            $this->load->view('panel/popup_center_info', $this->data);
        } else {
            echo show_alert('This request did not pass our security checks.', 'info');
        }

    }

    function manage_criteria($type = 1)
    {
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'CRITERIA', 'manage_criteria')) {
            $this->session->set_flashdata("message", show_alert("SELECTION_CRITERIA :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Criteria');
        $this->data['bscrum'][] = array('link' => 'manage_criteria/', 'title' => 'Eligibility Criteria');
        $this->data['selected'] = $type;
        $this->data['programme_list'] = $this->common_model->get_programme(null, $type)->result();
        $this->data['active_menu'] = 'manage_criteria';
        $this->data['content'] = 'panel/manage_criteria';
        $this->load->view('template', $this->data);
    }

    function programme_setting_panel($code = null)
    {
        $current_user = current_user();
        $this->data['CODE'] = $code;
        $ENTRY = (isset($_GET) && isset($_GET['entry']) ? $_GET['entry'] : null);
        if (!is_null($code)) {
            $row_year = $this->common_model->get_academic_year(null, 1, 1)->row();
            if ($row_year) {

                if (isset($_GET['sub_id']) && isset($_GET['cat']) && isset($_GET['row_id'])) {
                    //remove one row in the setting configurations
                    $get_row = $this->db->where('id', $_GET['row_id'])->get('application_criteria_setting')->row();
                    if ($get_row) {
                        $column = 'form6_inclusive';
                        if ($_GET['cat'] == 'IV') {
                            $column = 'form4_inclusive';
                        }

                        $column_data = json_decode($get_row->{$column}, true);
                        unset($column_data[$_GET['sub_id']]);

                        $this->db->update('application_criteria_setting', array($column => json_encode($column_data)), array('id' => $_GET['row_id']));
                        $this->session->set_flashdata('message', show_alert('Setting Data updated successfully', 'info'));
                        redirect(remove_query_string(array('sub_id', 'cat', 'row_id')), 'refresh');

                    }

                }

                //if(isset($_GET) && isset($_GET['type'])) {
                $this->form_validation->set_rules('save_data', 'Save Data', 'required');
                $this->form_validation->set_rules('form4_pass', '', 'integer');

                if ($this->form_validation->run() == true) {

                    $form4_data = array();
                    $form6_data = array();
                    $subject_form4 = $this->input->post('subjectIV');
                    $grade_form4 = $this->input->post('gradeIV');

                    $subject_form6 = $this->input->post('subjectVI');
                    $grade_form6 = $this->input->post('gradeVI');

                    $subjectIVOR = $this->input->post('subjectIVOR');
                    $gradeIVOR = $this->input->post('gradeIVOR');
                    $gradeIVORNO = $this->input->post('gradeIVORNO');

                    $subjectVIOR = $this->input->post('subjectVIOR');
                    $gradeVIOR = $this->input->post('gradeVIOR');
                    $gradeVIORNO = $this->input->post('gradeVIORNO');


                    if ($subject_form4) {
                        foreach ($subject_form4 as $k => $v) {
                            if ($grade_form4[$k] <> '' && $v <> '') {
                                $form4_data[$v] = $grade_form4[$k];
                            }
                        }
                    }

                    if ($subject_form6) {
                        foreach ($subject_form6 as $k => $v) {
                            if ($grade_form6[$k] <> '' && $v <> '') {
                                $form6_data[$v] = $grade_form6[$k];
                            }
                        }
                    }


                    $array_data = array(
                        'AYear' => $row_year->AYear,
                        'entry' => $this->input->post('entry'),
                        'form4_inclusive' => json_encode($form4_data),
                        'form4_exclusive' => ($this->input->post('subject4_exclusive') ? implode(',', $this->input->post('subject4_exclusive')) : ''),
                        'form4_pass' => trim($this->input->post('form4_pass')),
                        'form6_inclusive' => json_encode($form6_data),
                        'form6_exclusive' => ($this->input->post('subject6_exclusive') ? implode(',', $this->input->post('subject6_exclusive')) : ''),
                        'min_point' => ($this->input->post('min_point') ? $this->input->post('min_point') : ''),
                        'form6_pass' => trim($this->input->post('form6_pass')),
                        'gpa_pass' => trim($this->input->post('gpa_pass')),
                        'keyword1' => trim($this->input->post('keyword1')),
                        'ProgrammeCode' => $code,
                        'createdby' => $current_user->id,
                        'createdon' => date('Y-m-d H:i:s'),
                        'form4_or_subject' => ($gradeIVOR ? json_encode(array($gradeIVOR . '|' . $gradeIVORNO => $subjectIVOR)) : ''),
                        'form6_or_subject' => ($gradeVIOR ? json_encode(array($gradeVIOR . '|' . $gradeVIORNO => $subjectVIOR)) : ''),
                    );


                    $conf = $this->setting_model->programme_setting_criteria($array_data);
                    if ($conf) {
                        $this->session->set_flashdata('message', show_alert('Selection Criteria Saved successfully', 'success'));
                        redirect(current_full_url(), 'refresh');
                    } else {
                        $this->data['message'] = show_alert('Fail to save Criteria Information', 'info');
                    }
                }

                $setting_info = $this->setting_model->get_selection_criteria($code, $row_year->AYear, $ENTRY);

                if ($setting_info) {
                    $this->data['setting_info'] = $setting_info;
                }
                $this->data['content_view'] = "panel/set_criteria_rules";
                //}else{
                //  $this->data['content_view'] = "panel/set_criteria_category";
                //}
            } else {
                $this->data['message'] = show_alert('No active Year created, No Configuration allowed', 'info');
            }
            $this->data['programme_info'] = $this->db->where('Code', $code)->get('programme')->row();
            $this->data['subject_listIV'] = $this->setting_model->get_sec_subject(null, 1, 1)->result();
            $this->data['subject_listVI'] = $this->setting_model->get_sec_subject(null, 1, 2)->result();


            $this->load->view("panel/programme_setting_panel", $this->data);

        } else {
            echo "Please use link in the left side to start setting";
        }
    }

    function short_listed()
    {
        $current_user = current_user();
        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'APPLICANT', 'short_listed')) {
            $this->session->set_flashdata("message", show_alert("APPLICANT_SHORT_LISTED :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant');
        $this->data['bscrum'][] = array('link' => 'short_listed/', 'title' => 'Applicant Short Listed');


        $this->data['programme_list'] = $this->common_model->get_programme(null, null)->result();
        $this->data['active_menu'] = 'applicant_list';
        $this->data['content'] = 'panel/short_listed';
        $this->load->view('template', $this->data);

    }

    function run_eligibility()
    {
        $programme_list = $this->common_model->get_programme()->result();
        foreach ($programme_list as $key => $value) {
            $current_round=$this->db->query("select * from application_round where application_type=".$value->type)->row();
            if($current_round)
            {
                $round=$current_round->round;
            }else{
                $round=1;
            }
            $new = $this->db->insert('run_eligibility', array('ProgrammeCode' => $value->Code,'round'=>$round));
            $last_id = $this->db->insert_id();
            if ($last_id) {
                execInBackground('response run_eligibility ' . $last_id);
            }
        }

        $this->session->set_flashdata('message', show_alert('This process will take some time to finish. Please Wait ...', 'info'));
        redirect('short_listed', 'refresh');


    }

    function run_eligibility_active()
    {
        $check = $this->db->get("run_eligibility")->row();
        if (!$check) {
            $this->session->set_flashdata('message', show_alert('Run Eligibility completed, Please Continue with other activities ', 'success'));

        } else {
            $this->session->set_flashdata('message', show_alert('This process will take some time to finish. Please still wait ...', 'info'));
        }
        echo '1';
    }

    function collection()
    {
        $current_user = current_user();
        $ayear = $this->common_model->get_academic_year()->row()->AYear;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Fee');
        $this->data['bscrum'][] = array('link' => 'collection/', 'title' => 'Application Fee');

        $where = " WHERE 1=1 AND p.msisdn <> '' ";

        if (isset($_GET['from']) && $_GET['from'] != '') {
            $where .= " AND DATE(p.createdon) >='" . format_date($_GET['from']) . "' ";
        }

        if (isset($_GET['to']) && $_GET['to'] != '') {
            $where .= " AND DATE(p.createdon) <='" . format_date($_GET['to']) . "' ";
        }

        if (isset($_GET['ayear']) && $_GET['ayear'] != '') {
            $where .= " AND a.AYear ='".trim($_GET['ayear'])."' ";
        }else{
            $where .= " AND a.AYear ='".$ayear."' ";
        }

        if (isset($_GET['key']) && $_GET['key'] != '') {
            $where .= " AND  (a.form4_index LIKE '%" . $_GET['key'] . "%' OR  p.msisdn LIKE '%" . $_GET['key'] . "%'
             OR p.reference LIKE '%" . $_GET['key'] . "%' OR a.FirstName LIKE '%" . $_GET['key'] . "%' OR  a.LastName LIKE '%" . $_GET['key'] . "%')";
        }

        $sql = " SELECT p.*,a.FirstName,a.MiddleName,a.LastName FROM application_payment as p INNER JOIN application as a ON (p.applicant_id=a.id)  $where ";
        $sql2 = " SELECT count(p.id) as counter FROM application_payment as p INNER JOIN application as a ON (p.applicant_id=a.id)  $where ";

        $total_amount = " SELECT SUM(p.amount) as total_amount FROM application_payment as p INNER JOIN application as a ON (p.applicant_id=a.id)  $where ";
        $total_charges = " SELECT SUM(p.charges) as total_charges FROM application_payment as p INNER JOIN application as a ON (p.applicant_id=a.id)  $where ";

        $this->load->library('pagination');
        $config["base_url"] = site_url('collection/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");


        $config["total_rows"] = $this->db->query($sql2)->row()->counter;
        $config["per_page"] = 50;
        $config["uri_segment"] = 2;

        include 'include/config_pagination.php';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2) ? $this->uri->segment(2) : 0);
        $this->data['pagination_links'] = $this->pagination->create_links();

        $this->data['collection_list'] = $this->db->query($sql . " ORDER BY p.createdon DESC ")->result();
        $this->data['total_amount'] = $this->db->query($total_amount)->row()->total_amount;
        $this->data['total_charges'] = $this->db->query($total_charges)->row()->total_charges;


        $this->data['active_menu'] = 'collection';
        $this->data['content'] = 'panel/collection';
        $this->load->view('template', $this->data);
    }

    function selection_criteria($type = 1)
    {
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'CRITERIA', 'selection_criteria')) {
            $this->session->set_flashdata("message", show_alert("SELECTION_CRITERIA :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Criteria');
        $this->data['bscrum'][] = array('link' => 'selection_criteria/', 'title' => 'Selection Criteria');
        $this->data['selected'] = $type;
        $this->data['programme_list'] = $this->common_model->get_programme(null, $type)->result();
        $this->data['active_menu'] = 'manage_criteria';
        $this->data['content'] = 'panel/selection_criteria';
        $this->load->view('template', $this->data);
    }

    function programme_setting_selection($code = null)
    {
        $current_user = current_user();
        $this->data['CODE'] = $code;

        $CATEGORY = (isset($_GET) && isset($_GET['category']) ? $_GET['category'] : null);
        if (!is_null($code)) {
            $row_year = $this->common_model->get_academic_year(null, 1, 1)->row();
            if ($row_year) {

                if(isset($_GET['sub_id'])) {
                    //remove one row in the setting configurations
                    $get_row = $this->db->where('id', $_GET['sub_id'])->get('application_selection_criteria_filter')->row();

                    if ($get_row) {
                        $this->db->delete('application_selection_criteria_filter', array('id' => $get_row->id));
                        $this->session->set_flashdata('message', show_alert('Setting Data updated successfully', 'info'));
                        redirect(remove_query_string(array('sub_id')), 'refresh');

                    }
                }

                if ($this->input->post('capacity')) {
                    $capacity = $this->input->post('capacity');
                    $direct = $this->input->post('direct');

                    if (is_numeric($capacity) && is_numeric($direct)) {
                        $capacity_array = array(
                            'capacity' => $capacity,
                            'code' => $code,
                            'direct' => $direct
                        );
                        $row_check = $this->db->where('code', $code)->get('application_selection_criteria')->row();
                        if ($row_check) {
                            //update
                            $this->db->update('application_selection_criteria',$capacity_array,array('code'=>$code));
                        } else {
                            //insert
                            $this->db->insert('application_selection_criteria',$capacity_array);
                        }
                    }
                }
                $row_check = $this->db->where('code', $code)->get('application_selection_criteria')->row();
                if($row_check){
                    $this->data['setting_info'] = $row_check;
                    $this->data['CATEGORY'] = $CATEGORY;

                    if($this->input->post('applicant_category')){
                        $subjectIV_submitted = $this->input->post('subjectIV[]');
                        $subjectIV_submitted_order = $this->input->post('gradeIV[]');
                        foreach ($subjectIV_submitted as $ky=>$vy){
                            if($vy <> '' && $subjectIV_submitted_order[$ky] <> '' && is_numeric($subjectIV_submitted_order[$ky])) {
                                $array_subjectIV = array(
                                    'selection_id' => $row_check->id,
                                    'code' => $code,
                                    'category' => $CATEGORY,
                                    'filter_type' => 'FORM_IV',
                                    'filter_item' => $vy,
                                );

                                $check_case = $this->db->where($array_subjectIV)->get('application_selection_criteria_filter')->row();
                                if($check_case){
                                    //update
                                    $array_subjectIV['order_number'] = $subjectIV_submitted_order[$ky];
                                    $this->db->update('application_selection_criteria_filter',$array_subjectIV,array('id'=>$check_case->id));
                                }else{
                                    //insert['
                                    $array_subjectIV['order_number'] = $subjectIV_submitted_order[$ky];
                                    $this->db->insert('application_selection_criteria_filter',$array_subjectIV);
                                }

                            }
                        }

                        $subjectVI_submitted = $this->input->post('subjectVI[]');
                        $subjectVI_submitted_order = $this->input->post('gradeVI[]');
                        foreach ($subjectVI_submitted as $ky=>$vy){
                            if($vy <> '' && $subjectVI_submitted_order[$ky] <> '' && is_numeric($subjectVI_submitted_order[$ky])) {
                                $array_subjectVI = array(
                                    'selection_id' => $row_check->id,
                                    'code' => $code,
                                    'category' => $CATEGORY,
                                    'filter_type' => 'FORM_VI',
                                    'filter_item' => $vy,
                                );

                                $check_case = $this->db->where($array_subjectVI)->get('application_selection_criteria_filter')->row();
                                if($check_case){
                                    //update
                                    $array_subjectVI['order_number'] = $subjectVI_submitted_order[$ky];
                                    $this->db->update('application_selection_criteria_filter',$array_subjectVI,array('id'=>$check_case->id));
                                }else{
                                    //insert['
                                    $array_subjectVI['order_number'] = $subjectVI_submitted_order[$ky];
                                    $this->db->insert('application_selection_criteria_filter',$array_subjectVI);
                                }

                            }
                        }

                        $point_submitted = $this->input->post('point');
                        if($point_submitted <> '') {
                            $array_point = array(
                                'selection_id' => $row_check->id,
                                'code' => $code,
                                'category' => $CATEGORY,
                                'filter_type' => 'POINT',
                                'filter_item' => 'POINT',
                            );
                            $check_case = $this->db->where($array_point)->get('application_selection_criteria_filter')->row();
                            if ($check_case) {
                                //update
                                $array_point['order_number'] = $point_submitted;
                                $this->db->update('application_selection_criteria_filter', $array_point, array('id' => $check_case->id));
                            } else {
                                //insert'
                                $array_point['order_number'] = $point_submitted;
                                $this->db->insert('application_selection_criteria_filter', $array_point);
                            }
                        }

                        $gender_submitted = $this->input->post('gender');
                        $gender_order_submitted = $this->input->post('gender_order');
                        if($gender_submitted <> '' && $gender_order_submitted <> '') {
                            $array_gender = array(
                                'selection_id' => $row_check->id,
                                'code' => $code,
                                'category' => $CATEGORY,
                                'filter_type' => 'GENDER'
                            );

                            $check_case = $this->db->where($array_gender)->get('application_selection_criteria_filter')->row();
                            if ($check_case) {
                                //update
                                $array_gender['order_number'] = $gender_order_submitted;
                                $array_gender['filter_item'] = $gender_submitted;
                                $this->db->update('application_selection_criteria_filter', $array_gender, array('id' => $check_case->id));
                            } else {
                                //insert'
                                $array_gender['order_number'] = $gender_order_submitted;
                                $array_gender['filter_item'] = $gender_submitted;
                                $this->db->insert('application_selection_criteria_filter', $array_gender);
                            }
                        }

                        $fifo_submitted = $this->input->post('fifo');
                        if($fifo_submitted <> '') {
                            $array_fifo = array(
                                'selection_id' => $row_check->id,
                                'code' => $code,
                                'category' => $CATEGORY,
                                'filter_type' => 'FIFO',
                                'filter_item' => 'FIFO',
                            );
                            $check_case = $this->db->where($array_fifo)->get('application_selection_criteria_filter')->row();

                            if($check_case) {
                                //update
                                $array_fifo['order_number'] = $fifo_submitted;
                                $this->db->update('application_selection_criteria_filter', $array_fifo, array('id' => $check_case->id));
                            }else {
                                //insert'
                                $array_fifo['order_number'] = $fifo_submitted;
                                $this->db->insert('application_selection_criteria_filter', $array_fifo);
                            }
                        }
                    }

                    $this->data['subject_listIV'] = $this->setting_model->get_sec_subject(null, 1, 1)->result();
                    $this->data['subject_listVI'] = $this->setting_model->get_sec_subject(null, 1, 2)->result();
                }

                $this->data['content_view'] = "panel/set_criteria_rules";
            } else {
                $this->data['message'] = show_alert('No active Year created, No Configuration allowed', 'info');
            }
            $this->data['programme_info'] = $this->db->where('Code', $code)->get('programme')->row();
            $this->data['subject_list'] = $this->setting_model->get_sec_subject(null, 1)->result();

            $this->load->view("panel/programme_setting_selection", $this->data);

        } else {
            echo "Please use link in the left side to start setting";
        }
    }

    function applicant_selection()
    {
        $current_user = current_user();
        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'APPLICANT', 'applicant_selection')) {
            $this->session->set_flashdata("message", show_alert("APPLICANT_SELECTION :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant');
        $this->data['bscrum'][] = array('link' => 'applicant_selection/', 'title' => 'Applicant Selection');


        $this->data['programme_list'] = $this->common_model->get_programme(null,null)->result();
        $this->data['active_menu'] = 'applicant_list';
        $this->data['content'] = 'panel/applicant_selection';
        $this->load->view('template', $this->data);

    }

    function run_selection($choice)
    {
        $programme_list = $this->common_model->get_programme()->result();
        foreach ($programme_list as $key => $value) {
            $new = $this->db->insert('run_selection', array('ProgrammeCode' => $value->Code,'choice'=>$choice));
            $last_id = $this->db->insert_id();
            if ($last_id) {
                execInBackground('response run_selection '.$last_id);
            }
        }

        $this->session->set_flashdata('message', show_alert('This process will take some time to finish. Please Wait ...', 'info'));
        redirect('applicant_selection', 'refresh');


    }

    function run_selection_active()
    {
        $check = $this->db->get("run_selection")->row();
        if (!$check) {
            $this->session->set_flashdata('message', show_alert('Run Selection completed, Please Continue with other activities ', 'success'));

        } else {
            $this->session->set_flashdata('message', show_alert('This process will take some time to finish. Please still wait ...', 'info'));
        }
        echo '1';
    }

    function record_bank_trans(){
    $current_user = current_user();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Application Fee');
        $this->data['bscrum'][] = array('link' => 'record_bank_trans/', 'title' => 'Record Bank Transaction');

        $this->form_validation->set_rules('receipt', 'Receipt', 'required|is_unique[application_payment.receipt]');
        $this->form_validation->set_rules('reference', 'Reference', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');




        if ($this->form_validation->run() == true) {
            $reference = trim($this->input->post('reference'));
            $myreference = substr($reference,3);
            $client = $this->applicant_model->get_applicant($myreference);
            if($client){
                $payment = array(
                    'msisdn'=>'BANK',
                    'reference'=>$reference,
                    'applicant_id'=> $myreference,
                    'timestamp'=> date('Y-m-d H:i:s'),
                    'receipt'=>$this->input->post('receipt'),
                    'amount'=> trim($this->input->post('amount')),
                    'charges'=>0,
                    'channel'=>2,
                    'cretatedby'=>$current_user->id
                );

                $this->db->insert('application_payment',$payment);
                $this->session->set_flashdata('message',show_alert('Information saved successfuuly','success'));
                redirect('record_bank_trans','refresh');
            }else{
                $this->data['message'] = show_alert('Invalid Reference Number !!','warning');
            }
        }

        $this->data['active_menu'] = 'collection';
        $this->data['content'] = 'panel/record_bank_trans';
        $this->load->view('template', $this->data);
    }


    function populate_dashboard()
    {

        // echo "hapa nafika";exit;
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        // $this->form_validation->set_rules('course','Course', 'required');


        if ($this->form_validation->run() == true) {
            // echo "hapa nafika";exit;

            //$code_course = $this->input->post('course');
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;
                //load the excel library
                $this->load->library('excel');
                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }

                foreach ($arr_data as $row) {
                    $data = array();
                    $courseError = array();
                    if (trim($row['A']) <> '') {
                        $data['programcode'] = $row['A'];
                        $data['male'] = $row['B'];
                        $data['female'] = $row['C'];
                        echo $xml_data = PopulateDashboardRequest(TCU_USERNAME, TCU_TOKEN,$data['programcode'],$data['male'],$data['female']);
                        echo  $sendRequest = sendXmlOverPost('https://api.tcu.go.tz/dashboard/populate', $xml_data);

                    }
                    //delete excell here
                    unlink('./uploads/temp/' . $dest_name);
                }
                $this->session->set_flashdata('message', show_alert('Submitted Summary  successfully imported!!', 'success'));



            }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Populate Dashboard');
        $this->data['bscrum'][] = array('link' => 'import/', 'title' => 'Submited to TCU summary');

        $this->data['active_menu'] = 'applicant_list';
        $this->data['content'] = 'panel/populate_dashboard';
        $this->load->view('template', $this->data);


    }


    function import()
    {
      // echo "hapa nafika";exit;
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        $this->form_validation->set_rules('programme','Programme', 'required');


        if ($this->form_validation->run() == true) {
          // echo "hapa nafika";exit;

            $ayear = $this->common_model->get_academic_year(null, 1, 1)->row()->AYear;
            $code_course = $this->input->post('programme');
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
               // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }

                foreach ($arr_data as $row) {
                  // echo "hapa nafika";exit;
                    $data = array();
                    $courseError = array();
                    if (trim($row['A']) <> '') {
                        $data['ApplicantName'] = $row['A'];
                        // echo ($data['ApplicantName']); exit;
                        $data['F4INDEX'] = $row['B'];
                        $applicant = $this->db->get_where('application_education_authority', array('index_number' => $data['F4INDEX']))->row()->applicant_id;
                        // echo $applicant; exit;
                        $applicant_info = $this->db->get_where('application', array('id'=> $applicant))->row();
                        $entry=$applicant_info->entry_category;
                        $national_identification_number=$applicant_info->national_identification_number;

                        // echo $entry; exit;
                        if ($entry == 2) {
                            $data['f6indexno'] = $this->db->get_where('application_education_authority', array('applicant_id' => $applicant, 'certificate' => 2))->row()->index_number;
                        } else if ($entry == 4) {
                            $data['f6indexno'] = $this->db->get_where('application_education_authority', array('applicant_id' => $applicant, 'certificate' => 4))->row()->avn;

                        }

                        if($entry==2)
                        {
                            $category="A";
                        }elseif($entry==4)
                        {
                            $category="D";
                        }
                        // $data['f6indexno'] = $this->db->get_where('application_education_authority', array('applicant_id' => $applicant, 'certificate' => 2))->row()->index_number;
                        // echo $data['f6indexno']; exit;
                        $data['programChoices'] = $this->db->query("SELECT GROUP_CONCAT(programmecode) as programmes FROM application_elegibility where applicant_id='$applicant' group by applicant_id")->row()->programmes;
                        // echo $data['programChoices']; exit;
                        $data['mobileNumber'] = $applicant_info->Mobile1;

                        //new added field
                        $data['otherMobileNumber'] = $applicant_info->Mobile2;
                        $data['nationality'] = $this->db->get_where('nationality', array('id'=> $applicant_info->Nationality))->row()->name;
                        if(trim($data['nationality'])=='')
                        {
                            $data['nationality']='Tanzanian';
                        }

                        $data['impairment'] = $this->db->get_where('disability', array('id'=> $applicant_info->Disability))->row()->name;
                        $data['dateOfbirth'] = $applicant_info->dob;

                        // echo $data['mobileNumber']; exit;
                        $data['emailAddress'] = $applicant_info->Email;
                        // echo $data['emailAddress']; exit;
                        $data['AdmissionStatus'] = $row['C'];
                        // echo $data['AdmissionStatus']; exit;
                        $data['AdmittedProgramme'] = $code_course;
                        // echo $data['AdmittedProgramme']; exit;
                        $data['Reason'] = $row['E'];
                        // echo $data['Reason']; exit;
                        $data['round'] = $row['F'];

                            $data_to_import = array(
                              'f4index' => $data['F4INDEX'],
                              'f6index' => $data['f6indexno'],
                              'programmechoices' => $data['programChoices'],
                              'mobile' => $data['mobileNumber'],
                              'email' => $data['emailAddress'],
                              'admissionstatus' => $row['C'],
                              'admittedprogramme' => $code_course,
                              'reason' => $row['E'],
                              'round' => $row['F'],
                                'a_year'=>$ayear

                            );

                            $import = $this->db->insert('tcu_admitted', $data_to_import);

                            if ($import) {
                                $selectoradmit = $this->input->post('selectoradmitted');
                                $round = $this->input->post('round');
                                if ($selectoradmit == 1) {
                                    $other_f4indexno = $row['G'];
                                    $other_f6indexno = $row['H'];
                                  if($round == 2){
                                    $other_f4indexno = $row['G'];
                                    $other_f6indexno = $row['H'];
                                    $xml_data = ResubmitApplicantDetailsRequest(TCU_USERNAME, TCU_TOKEN, $data['F4INDEX'], $data['f6indexno'],
                                        $data['programChoices'], $data['mobileNumber'],$data['otherMobileNumber'], $data['emailAddress'],$category,$row['C'],$code_course, $row['E'],$data['nationality'],$data['impairment'],$data['dateOfbirth'], $other_f4indexno,$other_f6indexno);
                                    $sendRequest = sendXmlOverPost(TCU_DOMAIN.'/applicants/resubmit', $xml_data);
                                  }else{
                                    $xml_data = SubmitApplicantProgramChoicesRequest(TCU_USERNAME, TCU_TOKEN,  $data['F4INDEX'], $data['f6indexno'],
                                        $data['programChoices'], $data['mobileNumber'],$data['otherMobileNumber'], $data['emailAddress'],$category, $row['C'], $code_course,$row['E'],$data['nationality'],$data['impairment'],$data['dateOfbirth'],$national_identification_number,$other_f4indexno,$other_f6indexno);
                                     $sendRequest = sendXmlOverPost(TCU_DOMAIN.'/applicants/submitProgramme', $xml_data);
                                  }
                                    $responce=RetunMessageString($sendRequest,'ResponseParameters');
                                    $data = simplexml_load_string($responce);
                                    $json = json_encode($data);
                                    $array_data = json_decode($json,TRUE);
                                    $tcu_response = $array_data['StatusCode'];
                                      $f4index = $array_data['f4indexno'];
                                      $status = $array_data['StatusCode'];
                                      $description = $array_data['StatusDescription'];
                                      if($status==200){
                                          $tcu_status=$this->db->query("update application set tcu_status=2,tcu_status_description='Choices Submitted' where id=". $applicant);
                                          $update = array(
                                          'status' => 1,
                                          'description' => $description,
                                          'response' => $sendRequest,
                                        );
                                        $this->db->where('f4index', $f4index);
                                        $this->db->update('tcu_admitted', $update);
                                        $this->session->set_flashdata('message', show_alert('Member Imported successfully!!', 'success'));
                                       // unlink('./uploads/temp/' . $dest_name);

                                      }else{
                                        $update = array(
                                          'status' => 0,
                                          'description' => $description,
                                          'response' => $sendRequest,
                                        );
                                        $this->db->where('f4index', $data['F4INDEX']);
                                        $this->db->update('tcu_admitted', $update);
                                        $this->session->set_flashdata('message', show_alert('Member Imported successfully!!', 'success'));


                                    }

                            }
                        }

            }
            //delete excell here
                    unlink('./uploads/temp/' . $dest_name);
          }
        }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'import/', 'title' => 'Import Admitted students');
        $this->data['programme_list'] = $this->common_model->get_programme(null, $type=2)->result();
        $this->data['active_menu'] = 'applicant_list';
        $this->data['content'] = 'panel/import';
        $this->load->view('template', $this->data);
    }





    function download_admitted_pplicant()
    {
        $username = "UDSM";
        $token = "xfcgvbbjbhn";
        $institution = "ZTL";
        $programme = 1001;
        $xml_data = GetAdmittedApplicantRequest($username, $token, $programme);
        $sendRequest = sendXmlOverPost('http://127.0.0.1/tcu/GetAdmittedApplicant_server.php', $xml_data);
        $data = simplexml_load_string($sendRequest);
        for($i=0; $i<count($data->ResponseParameters->Applicant); $i++)
        {
            echo "<br>";
            echo $data->ResponseParameters->Applicant[$i]->f4indexno;
            echo $data->ResponseParameters->Applicant[$i]->f6indexno;
            echo $data->ResponseParameters->Applicant[$i]->mobilenumber;
            echo $data->ResponseParameters->Applicant[$i]->emailaddress;
            echo $data->ResponseParameters->Applicant[$i]->admissionStatus;
        }


    }


    function getprogrammeswithcandidates()
    {
        $username = "UDSM";
        $token = "xfcgvbbjbhn";
        $institution = "ZTL";
        $xml_data = GetProgrammesWithAdmittedCandidatesRequest($username, $token);
        $sendRequest = sendXmlOverPost('http://127.0.0.1/tcu/GetProgrammesWithAdmittedCandidates_server.php', $xml_data);
        echo $sendRequest;exit;
        $data = simplexml_load_string($sendRequest);

        echo $data->Response->ResponseParameters->Programmes;
        exit;
    }


    function applicantReports()
    {
        $current_user = current_user();

        if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'APPLICANT', 'applicant_list')) {
            $this->session->set_flashdata("message", show_alert("APPLICANT_LIST :: Access denied !!", 'info'));
            redirect(site_url('dashboard'), 'refresh');
        }

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant');
        $this->data['bscrum'][] = array('link' => 'applicant_list/', 'title' => 'Applicant List');

        $this->load->library('pagination');

        $where = ' WHERE 1=1 ';

        if (isset($_GET['entry']) && $_GET['entry'] != '') {
            $where .= " AND entry_category='" . $_GET['entry'] . "' ";
        }

        if (isset($_GET['type']) && $_GET['type'] != '') {
            $where .= " AND application_type='" . $_GET['type'] . "' ";
        }

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $where .= " AND submitted='" . $_GET['status'] . "' ";
        }

        if (isset($_GET['key']) && $_GET['key'] != '') {
            $where .= " AND  (form4_index LIKE '%" . $_GET['key'] . "%' OR  form6_index LIKE '%" . $_GET['key'] . "%' OR FirstName LIKE '%" . $_GET['key'] . "%' OR  LastName LIKE '%" . $_GET['key'] . "%')";
        }


        $sql = " SELECT * FROM application  $where ";
        $sql2 = " SELECT count(id) as counter FROM application  $where ";

        $config["base_url"] = site_url('applicant_list/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");


        $config["total_rows"] = $this->db->query($sql2)->row()->counter;
        $config["per_page"] = 50;
        $config["uri_segment"] = 2;

        include 'include/config_pagination.php';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2) ? $this->uri->segment(2) : 0);
        $this->data['pagination_links'] = $this->pagination->create_links();

        $this->data['applicant_list'] = $this->db->query($sql . " ORDER BY FirstName ASC LIMIT $page," . $config["per_page"])->result();


        $this->data['active_menu'] = 'applicant_list';
        $this->data['content'] = 'panel/applicantReports';
        $this->load->view('template', $this->data);
    }


    function applicant_status_admited_multiple($program_code)
    {
        $xml_data = GetApplicantVerificationStatus(TCU_USERNAME, TCU_TOKEN,$program_code);
        $response_data = sendXmlOverPost('https://api.tcu.go.tz/applicants/getApplicantVerificationStatus', $xml_data);
        $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);
        if($joson_data['Response']['ResponseParameters']['StatusCode']==200) {
            $applicants=$joson_data['Response']['ResponseParameters']['Applicant'];

            for ($i = 0; $i < count($applicants); $i++) {
                $applicant_id = $this->db->get_where('application_education_authority', array('index_number' => $applicants[$i]['f4indexno']))->row()->applicant_id;
                if($applicants[$i]['AdmissionStatus']=='Multiple Admission')
                {
                    //has multiple selection
                    $where_array=array(
                        'id'=>$applicant_id,
                        'tcu_status !='=>4
                    );

                    $data=array(
                        'tcu_status'=>4,
                        "tcu_status_description"=>$applicants[$i]['AdmissionStatus']
                    );

                    $this->db->where($where_array);
                    $this->db->update('application',$data);


                }elseif($applicants[$i]['AdmissionStatus']=='Qualified')
                {
                    //has a single selection
                    $where_array=array(
                        'id'=>$applicant_id,
                        'tcu_status !='=>3
                    );

                    $where=array(
                      'Code'=>$program_code
                    );
                    $data=array(
                        'tcu_status'=>3,
                        "tcu_status_description"=>get_value('programme',$where,'Name')
                    );

                    $this->db->where($where_array);
                    $this->db->update('application',$data);

                }else{
                    //Not qualify
                    $where_array=array(
                        'id'=>$applicant_id,
                    );

                    $data=array(
                        'tcu_status'=>7,
                        'tcu_status_description'=>$applicants[$i]['AdmissionStatus']
                    );

                    $this->db->where($where_array);
                    $this->db->update('application',$data);
                }

            }


        }




    }
    function applicant_reports()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        $this->form_validation->set_rules('status','Status', 'required');

        if ($this->form_validation->run() == true) {
            $programme = $this->input->post('programme');
            // echo $programme;exit;
            execInBackground("panel applicant_status_admited_multiple ".$programme);

            $status = $this->input->post('status');
            if($status == 1)
            {
                //confirmed else whrere
                $xml_data = GetListOfConfirmedApplicantsRequest(TCU_USERNAME, TCU_TOKEN,$programme);
                $response_data = sendXmlOverPost(TCU_DOMAIN.'/applicants/getConfirmed', $xml_data);
                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);

                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                   $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else
                {
                    $applicants=$joson_data['Response']['ResponseParameters']['Applicant'];
                    include_once 'report/listofconfirmed.php';
                    exit;
                }

            }
            else if ($status==2)
            {
                //confirmed and admited
                $xml_data = GetAdmittedApplicantRequest(TCU_USERNAME, TCU_TOKEN,$programme);
                $response_data = sendXmlOverPost(TCU_DOMAIN.'/admission/getAdmitted', $xml_data);
                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);
                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                    $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else {
                    $applicants = $joson_data['Response']['ResponseParameters']['Applicant'];
                    include_once 'report/admittedcandidates.php';
                    exit;
                }
            }
            else if ($status==3)
            {

                //who have multiple selection and single selection
                $xml_data = GetApplicantsAdmissionStatusRequest(TCU_USERNAME, TCU_TOKEN, $programme);
                $response_data = sendXmlOverPost(TCU_DOMAIN.'/applicants/getStatus', $xml_data);
              // var_dump($response_data);exit;
                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);
                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                    $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else {
                    $applicants = $joson_data['Response']['ResponseParameters']['Applicant'];
                    include_once 'report/admissionstatus.php';
                    exit;
                }
            }else if ($status==4)
            {
                //programe with no of admitted applicants
              $xml_data = GetProgrammesWithAdmittedCandidatesRequest(TCU_USERNAME, TCU_TOKEN);
              $response_data = sendXmlOverPost(TCU_DOMAIN.'/admission/getProgrammes', $xml_data);
              // var_dump($response_data);exit;
                //$responce=RetunMessageString($response_data,'ResponseParameters');

                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);
                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                    $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else {
                    $applicants = $joson_data['Response']['ResponseParameters']['Programme'];
                    include_once 'report/programmeswithadmittedcandidated.php';
                    exit;
                }
            }else if($status==5)
            {
                $xml_data = GetVerificationStatusForInternallyTransferredStudent(TCU_USERNAME, TCU_TOKEN,$programme);
                $response_data = sendXmlOverPost(TCU_DOMAIN.'/applicants/getInternalTransferStatus', $xml_data);
                // var_dump($response_data);exit;
                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);
                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                    $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else {

                    $applicants = $joson_data['Response']['ResponseParameters']['Applicant'];
                    //print_r($applicants);
                    //exit;
                    include_once 'report/internaltransferstatus.php';
                    exit;
                }
            }elseif($status==8)
            {

                $xml_data = GetVerificationStatusForInternallyTransferredStudent(TCU_USERNAME, TCU_TOKEN,$programme);
                $response_data = sendXmlOverPost(TCU_DOMAIN.'/applicants/getInterInstitutionalTransferStatus', $xml_data);
                //var_dump($response_data);exit;
                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);
                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                    $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else {
                    $applicants = $joson_data['Response']['ResponseParameters']['Applicant'];

                    include_once 'report/interinstitutionaltransferstatus.php';
                    exit;
                }
            }
            else if($status==6)
            {
                $xml_data = GetverificationStatusForNonDegreeStudents(TCU_USERNAME, TCU_TOKEN,$programme);
                $response_data = sendXmlOverPost(TCU_DOMAIN.'/applicants/getNonDegreeAdmittedStatus', $xml_data);
                // var_dump($response_data);exit;
                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);
                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                    $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else {
                    $applicants = $joson_data['Response']['ResponseParameters']['Applicant'];
                    include_once 'report/nondegreestudentstatus.php';
                    exit;
                }
            }else if($status==7)
            {
                $xml_data = GetApplicantVerificationStatus(TCU_USERNAME, TCU_TOKEN,$programme);
                $response_data = sendXmlOverPost(TCU_DOMAIN.'/applicants/getApplicantVerificationStatus', $xml_data);
                // var_dump($response_data);exit;
                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);
                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                    $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else {
                    $applicants = $joson_data['Response']['ResponseParameters']['Applicant'];
                    include_once 'report/getApplicantVerificationStatus.php';
                    exit;
                }
            }

        }

//        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant Reports');
        $this->data['bscrum'][] = array('link' => 'import/', 'title' => 'Get Applicants Reports');

        $this->data['active_menu'] = 'applicant_list';
        $this->data['programme_list'] = $this->common_model->get_programme(null, $type=2)->result();
        $this->data['content'] = 'panel/applicant_reports';
        $this->load->view('template', $this->data);
    }

    public function receive_payments()
    {
        $current_user = current_user();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Receive payments');
        $this->data['bscrum'][] = array('link' => 'Existing Member/', 'title' => 'Application Payments');

        $this->form_validation->set_rules('reference', 'Reference Number', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');

        if ($this->form_validation->run() == true) {
            $variablereference = $this->input->post('reference');
            $applicant = substr($variablereference, 3);
            $unique = $this->db->query("select * from application where id='$applicant'")->row()->user_id;
            if (is_null($unique)) {
                $this->session->set_flashdata('message', show_alert('Application with this Reference Number does not exist, check it carefully and try again!', 'warning'));
                redirect('reveive_payments', 'refresh');
            } else {
                $data = array(
                  // 'msisdn' => '255656121885',
                  'reference' => trim($this->input->post('reference')),
                  'applicant_id' => $applicant,
                  'timestamp' => date('Y-m-d H:i:s'),
                  'receipt' => generatePIN(6),
                  'amount' => trim($this->input->post('amount')),
                  'createdon' => date('Y-m-d H:i:s'),
                  // 'AYear' => '2018'
                );
                $save = $this->db->insert('application_payment', $data);
                if ($save) {
                    $this->session->set_flashdata('message', show_alert('Information Saved successfully', 'success'));
                    redirect('receive_payments', 'refresh');
                }else{
                  $this->session->set_flashdata('message', show_alert('Failed to save information, Try again', 'warning'));
                  redirect('receive_payments', 'refresh');
                }

          }
        }

        $this->data['active_menu'] = 'feesetup';
        $this->data['content'] = 'panel/receive_payments';
        $this->load->view('template', $this->data);
    }

    function applicant_transfers()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        // validate form input
        $this->form_validation->set_rules('o_level_index_no', 'Form Four Index', 'required');
        $this->form_validation->set_rules('a_level_index_no', 'Form six  Index', 'required');
        $this->form_validation->set_rules('prev_prog_code', 'Previous Programme Code', 'required');
        $this->form_validation->set_rules('current_prog_code', 'Current Programme Code', 'required');

        $this->form_validation->set_rules('status','Transfer Type', 'required');

        if ($this->form_validation->run() == true) {
            $f4indexno = trim($this->input->post('o_level_index_no'));
            $f6indexno = trim($this->input->post('a_level_index_no'));
            $curProCode = trim($this->input->post('current_prog_code'));
            $prevProgCode = trim($this->input->post('prev_prog_code'));
            $status = $this->input->post('status');
            if($status == 1)
            {
                $xml_data = SubmitInternalTransferRequest(TCU_USERNAME, TCU_TOKEN,$f4indexno,$f6indexno,$prevProgCode,$curProCode);
                $response_data = sendXmlOverPost(TCU_DOMAIN.'/admission/submitInternalTransfers', $xml_data);
                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);

                $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';

                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else {
                    $this->session->set_flashdata('message', show_alert($error_message, 'info'));
                }
            }
            else if ($status==2)
            {
                $xml_data = SubmitInterIstitutionalTransferRequest(TCU_USERNAME, TCU_TOKEN,$f4indexno,$f6indexno,$prevProgCode,$curProCode);
                // var_dump($xml_data);exit;
                $response_data = sendXmlOverPost(TCU_DOMAIN.'/admission/submitInterInstitutionalTransfers', $xml_data);
                // var_dump($response_data);exit;
                $joson_data=json_decode(json_encode(simplexml_load_string($response_data)),true);
                if($joson_data['Response']['ResponseParameters']['StatusCode']!=200)
                {
                    $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'warning'));
                }else {
                    $error_message=$joson_data['Response']['ResponseParameters']['StatusDescription'].'('.$joson_data['Response']['ResponseParameters']['StatusCode'].')';
                    $this->session->set_flashdata('message', show_alert($error_message, 'info'));
                }
            }


        }

//        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant Transfers');
        $this->data['bscrum'][] = array('link' => 'applicant_transfers/', 'title' => 'TCU Transfers');

        $this->data['active_menu'] = 'applicant_list';
        $this->data['programme_list'] = $this->common_model->get_programme(null, $type=2)->result();
        $this->data['content'] = 'panel/applicant_transfers';
        $this->load->view('template', $this->data);
    }


    function current_enrolled_list()
    {
        $current_user = current_user();





        $sql = " SELECT * FROM enrolled_student ";

        $config["base_url"] = site_url('invoice_list/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['enrolled_list'] = $this->db->query($sql . " ORDER BY enrolled_student.id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'invoice_list/', 'title' => 'Enrolled List');

        $this->data['active_menu'] = 'applicant_list';
        $this->data['content'] = 'panel/enrolled_list';
        $this->load->view('template', $this->data);

    }


    function SubmitEnrolledStudents()
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        // $this->form_validation->set_rules('course','Course', 'required');


        if ($this->form_validation->run() == true) {
            //echo "hapa nafika";exit;

            //$code_course = $this->input->post('course');
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }

                foreach ($arr_data as $row) {
                    // echo "hapa nafika";exit;
                    $data = array();
                    $courseError = array();
                    if (trim($row['A']) <> '') {
                        $Fname = $row['A'];
                        $Mname = $row['B'];
                        $Surname = $row['C'];
                        $F4indexno=$row['D'];
                        $Gender = $row['E'];
                        $Nationality = $row['F'];
                        $DateOfBirth = $row['G'];
                        $ProgrammeCategory = $row['H'];
                        $Specialization = $row['I'];
                        $AdmissionYear = $row['J'];
                        $ProgrammeCode = $row['K'];
                        $RegistrationNumber = $row['L'];
                        $ProgrammeName = $row['M'];
                        $YearOfStudy = $row['N'];
                        $StudyMode = $row['O'];
                        $IsYearRepeat = $row['P'];
                        $EntryMode = $row['Q'];
                        $Sponsorship = $row['R'];
                        $PhysicalChallenges = $row['S'];
                        $xml_data = SubmitEnrolledStudentsRequest(TCU_USERNAME, TCU_TOKEN,$F4indexno,$Fname,$Mname,$Surname,
                            $Gender,$Nationality,$DateOfBirth,$ProgrammeCategory,$Specialization,$AdmissionYear,$ProgrammeCode,$RegistrationNumber,
                            $ProgrammeName,$YearOfStudy,$StudyMode,$IsYearRepeat,$EntryMode,$Sponsorship,$PhysicalChallenges);
                        $sendRequest = sendXmlOverPost(TCU_DOMAIN.'/applicants/submitEnrolledStudents', $xml_data);
                        $responce=RetunMessageString($sendRequest,'ResponseParameters');
                        $data = simplexml_load_string($responce);
                        $json = json_encode($data);
                        $array_data = json_decode($json,TRUE);
                        $status_code = $array_data['StatusCode'];
                        $regno = $array_data['RegistrationNumber'];
                        $description = $array_data['StatusDescription'];
                        $insert = $this->db->query("insert into enrolled_student(regno,code,description) values('".$RegistrationNumber . "','".$status_code."','".$description."')");
                    }

                }
                //delete excell here
                unlink('./uploads/temp/' . $dest_name);
                $this->session->set_flashdata('message', show_alert('Enrolled students successfully submited ', 'success'));
                redirect('current_enrolled_list', 'refresh');
            }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'SubmitEnrolledStudents/', 'title' => 'Submit Enrolled students');

        $this->data['active_menu'] = 'applicant_list';
        $this->data['content'] = 'panel/submit_enrolled_student';
        $this->load->view('template', $this->data);
    }

    function current_graduate_list()
    {
        $current_user = current_user();





        $sql = " SELECT * FROM graduate_students where status=1 ";

        $config["base_url"] = site_url('graduate_list/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['graduate_list'] = $this->db->query($sql . " ORDER BY id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'invoice_list/', 'title' => 'Graduate List');

        $this->data['active_menu'] = 'SubmitGraduates';
        $this->data['content'] = 'panel/graduate_list';
        $this->load->view('template', $this->data);

    }

    function SubmitGraduates()
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        // $this->form_validation->set_rules('course','Course', 'required');


        if ($this->form_validation->run() == true) {
            //echo "hapa nafika";exit;

            //$code_course = $this->input->post('course');
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_graduates_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }

                $i=0;
                foreach ($arr_data as $row) {
                    // echo "hapa nafika";exit;
                    $data = array();
                    $courseError = array();
                    if (trim($row['A']) <> '') {
                        $Fname = $row['A'];
                        $Mname = $row['B'];
                        $Surname = $row['C'];
                        $F4indexno=$row['D'];
                        $Gender = $row['E'];
                        $specialization = $row['F'];
                        $awardcategory = $row['G'];
                        $awardclass = $row['H'];
                        $awardname = $row['I'];
                        $gpa = $row['J'];
                        $regnumber = $row['K'];
                        $graduateyear = $row['L'];
                        $registrationyear = $row['M'];
                        $programcode = $row['N'];
                        $nationalidnumber = $row['O'];

                        $xml_data = SubmitGraduateRequest(TCU_USERNAME, TCU_TOKEN,$F4indexno,$Fname,$Mname,$Surname,
                            $Gender,$specialization,$awardcategory,$awardclass,$awardname,$gpa,$regnumber,$graduateyear,$registrationyear,$programcode,$nationalidnumber);
                        $sendRequest = sendXmlOverPost(TCU_DOMAIN.'/applicants/submitGraduates', $xml_data);
                        $responce=RetunMessageString($sendRequest,'ResponseParameters');
                        $data = simplexml_load_string($responce);
                        $json = json_encode($data);
                        $array_data = json_decode($json,TRUE);
                        $status_code = $array_data['StatusCode'];
                        $regno = $array_data['RegistrationNumber'];
                        $description = $array_data['StatusDescription'];
                        if($i==0)
                        {
                            $update=$this->db->query("update graduate_students set status=0");
                        }

                        $checkexist=$this->db->query("select * from graduate_students where regno='".$regno."'")->result();
                        if($checkexist)
                        {
                            $update=$this->db->query("update graduate_students set status_code='".$status_code."',status_description='".$description."',status=1 where  regno='".$regnumber."'");
                        }else{
                            $insert = $this->db->query("insert into graduate_students(regno,fname,mname,sname,f4indexnumber,gender,specialization,award_category,awardclass,awardname,gpa,graduateyear,registrationyear,programmecode,nationalid,status_code,status_description) 
                      values('".$regno . "','".$Fname."','".$Mname."','".$Surname."','".$F4indexno."','".$Gender."','".$specialization."','".$awardcategory."','".$awardclass."','".$awardname."','".$gpa."','".$graduateyear."','".$registrationyear."','".$programcode."','".$nationalidnumber."','".$status_code."','".$description."')");

                        }

                        $i+=1;

                    }

                }
                //delete excell here
                unlink('./uploads/temp/' . $dest_name);
                $this->session->set_flashdata('message', show_alert('Graduate students successfully submited ', 'success'));
                redirect('current_graduate_list', 'refresh');
            }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'SubmitGraduates/', 'title' => 'Submit Graduates');

        $this->data['active_menu'] = 'SubmitGraduates';
        $this->data['content'] = 'panel/submit_graduates';
        $this->load->view('template', $this->data);
    }

    function current_staffs_list()
    {
        $current_user = current_user();





        $sql = " SELECT * FROM staffs where status=1 ";

        $config["base_url"] = site_url('current_staff_list');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['staff_list'] = $this->db->query($sql . " ORDER BY id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'invoice_list/', 'title' => 'Staff List');

        $this->data['active_menu'] = 'SubmitStaffs';
        $this->data['content'] = 'panel/staff_list';
        $this->load->view('template', $this->data);

    }

    function SubmitStaffs()
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        // $this->form_validation->set_rules('course','Course', 'required');


        if ($this->form_validation->run() == true) {
            //echo "hapa nafika";exit;

            //$code_course = $this->input->post('course');
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_graduates_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }

                $i=0;
                foreach ($arr_data as $row) {
                    // echo "hapa nafika";exit;
                    $data = array();
                    $courseError = array();
                    if (trim($row['A']) <> '') {
                        $Fname = trim($row['A']);
                        $Mname = trim($row['B']);
                        $Surname = trim($row['C']);
                        $title = trim($row['D']);
                        $Gender = trim($row['E']);
                        $highestqualification = trim($row['F']);
                        $employeestatus = trim($row['G']);
                        $sourceinstitution = trim($row['H']);
                        $yearofbirth = trim($row['I']);
                        $nationality = trim($row['J']);
                        $physicalchallenge = trim($row['K']);
                        $staffrank = trim($row['L']);
                        $email = trim($row['M']);
                        $staffrole = trim($row['N']);
                        $levelofteaching = trim($row['O']);
                        $staffspecialization = trim($row['P']);
                        $staffid = trim($row['Q']);
                        $nationalid = trim($row['R']);


                        $xml_data = SubmitInstitutionStaffRequest(TCU_USERNAME, TCU_TOKEN,$Fname,$Mname,$Surname,$title,
                            $Gender,$highestqualification,$employeestatus,$sourceinstitution,$yearofbirth,$nationality,$physicalchallenge,$staffrank,$email,$staffrole,$levelofteaching,$staffspecialization,$staffid,$nationalid);
                        $sendRequest = sendXmlOverPost(TCU_DOMAIN.'/applicants/submitInstitutionStaff', $xml_data);
                        $responce=RetunMessageString($sendRequest,'ResponseParameters');
                        $data = simplexml_load_string($responce);
                        $json = json_encode($data);
                        $array_data = json_decode($json,TRUE);
                        $status_code = $array_data['StatusCode'];
                        $regno = $array_data['RegistrationNumber'];
                        $description = $array_data['StatusDescription'];
                        if($i==0)
                        {
                            $update=$this->db->query("update staffs set status=0");
                        }

                        $checkexist=$this->db->query("select * from staffs where staff_id='".$staffid."'")->result();
                        if($checkexist)
                        {
                            $update=$this->db->query("update staffs set status_code='".$status_code."',status_description='".$description."',status=1 where  staff_id='".$staffid."'");
                        }else{
                            $insert = $this->db->query("insert into staffs(fname,mname,sname,title,gender,highest_qualification,employment_status,source_Institution,YearOfBirth,nationality,phisical_challenges,rank,email,staff_role,level_of_teaching,staff_specialization,staff_id,national_id_number,status_code,status_description) 
                      values('".$Fname."','".$Mname."','".$Surname."','".$title."','".$Gender."','".$highestqualification."','".$employeestatus."','".$sourceinstitution."','".$yearofbirth."','".$nationality."','".$physicalchallenge."','".$staffrank."','".$email."','".$staffrole."','".$levelofteaching."','".$staffspecialization."','".$staffid."','".$nationalid."','".$status_code."','".$description."')");

                        }

                        $i+=1;

                    }

                }
                //delete excell here
                unlink('./uploads/temp/' . $dest_name);
                $this->session->set_flashdata('message', show_alert('Staffs successfully submited ', 'success'));
                redirect('current_staffs_list', 'refresh');
            }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'SubmitStaffs/', 'title' => 'Submit Staffs');

        $this->data['active_menu'] = 'SubmitStaffs';
        $this->data['content'] = 'panel/submit_staffs';
        $this->load->view('template', $this->data);
    }

    function current_student_dropout_list()
    {
        $current_user = current_user();

        $sql = " SELECT * FROM student_drop_outs where status=1 ";

        $config["base_url"] = site_url('current_student_dropout_list');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['dropout_list'] = $this->db->query($sql . " ORDER BY id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'current_student_dropout_list/', 'title' => 'Student Drop-out List');

        $this->data['active_menu'] = 'SubmitStudentDropOut';
        $this->data['content'] = 'panel/dropout_list';
        $this->load->view('template', $this->data);

    }

    function SubmitStudentDropOut()
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        // $this->form_validation->set_rules('course','Course', 'required');


        if ($this->form_validation->run() == true) {
            //echo "hapa nafika";exit;

            //$code_course = $this->input->post('course');
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_dropout_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }

                $i=0;
                foreach ($arr_data as $row) {
                    // echo "hapa nafika";exit;
                    $data = array();
                    $courseError = array();
                    if (trim($row['A']) <> '') {
                        $Fname = $row['A'];
                        $Mname = $row['B'];
                        $Surname = $row['C'];
                        $Gender=$row['D'];
                        $f4indexno = $row['E'];
                        $yearterminated = $row['F'];
                        $yearofstudy = $row['G'];
                        $terminationreason = $row['H'];
                        $registrationnumber = $row['I'];
                        $programmecategory = $row['J'];
                        $programmename = $row['K'];
                        $programmecode = $row['L'];
                        $xml_data = SubmitStudentsDropOutsRequest(TCU_USERNAME, TCU_TOKEN,$Fname,$Mname,$Surname,$Gender,$f4indexno,$yearterminated,$yearofstudy,$terminationreason,$registrationnumber,$programmecategory,$programmename,$programmecode);
                        $sendRequest = sendXmlOverPost(TCU_DOMAIN.'/applicants/submitStudentsDropOuts', $xml_data);
                        $responce=RetunMessageString($sendRequest,'ResponseParameters');
                        $data = simplexml_load_string($responce);
                        $json = json_encode($data);
                        $array_data = json_decode($json,TRUE);
                        $status_code = $array_data['StatusCode'];
                        $regno = $array_data['RegistrationNumber'];
                        $description = $array_data['StatusDescription'];
                        if($i==0)
                        {
                            $update=$this->db->query("update student_drop_outs set status=0");
                        }

                        $checkexist=$this->db->query("select * from student_drop_outs where registrtionnumber='".$registrationnumber."'")->result();
                        if($checkexist)
                        {
                            $update=$this->db->query("update student_drop_outs set status_code='".$status_code."',status_description='".$description."',status=1 where  registrtionnumber='".$registrationnumber."'");
                        }else{
                            $insert = $this->db->query("insert into student_drop_outs(fname,mname,sname,gender,f4indexno,yearterminated,yearofstudy,terminationreason,registrtionnumber,programmecategory,programmename,programmecode,status_code,status_description) 
                      values('".$Fname."','".$Mname."','".$Surname."','".$Gender."','".$f4indexno."','".$yearterminated."','".$yearofstudy."','".$terminationreason."','".$registrationnumber."','".$programmecategory."','".$programmename."','".$programmecode."','".$status_code."','".$description."')");

                        }

                        $i+=1;

                    }

                }
                //delete excell here
                unlink('./uploads/temp/' . $dest_name);
                $this->session->set_flashdata('message', show_alert('Staffs successfully submited ', 'success'));
                redirect('current_student_dropout_list', 'refresh');
            }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'SubmitStudentDropOut/', 'title' => 'Submit Student Drop Out');

        $this->data['active_menu'] = 'SubmitStudentDropOut';
        $this->data['content'] = 'panel/submit_dropouts';
        $this->load->view('template', $this->data);
    }


   
    function current_student_postponed_list()
    {
        $current_user = current_user();

        $sql = " SELECT * FROM student_postponed where status=1 ";

        $config["base_url"] = site_url('current_student_postponed_list');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['postponed_list'] = $this->db->query($sql . " ORDER BY id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'current_student_postponed_list/', 'title' => 'Student PostPoned List');

        $this->data['active_menu'] = 'SubmitStudentPostPoned';
        $this->data['content'] = 'panel/postponed_list';
        $this->load->view('template', $this->data);

    }

    function SubmitStudentPostPoned()
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        // $this->form_validation->set_rules('course','Course', 'required');


        if ($this->form_validation->run() == true) {
            //echo "hapa nafika";exit;

            //$code_course = $this->input->post('course');
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_dropout_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }

                $i=0;
                foreach ($arr_data as $row) {
                    // echo "hapa nafika";exit;
                    $data = array();
                    $courseError = array();
                    if (trim($row['A']) <> '') {
                        $Fname = $row['A'];
                        $Mname = $row['B'];
                        $Surname = $row['C'];
                        $Gender=$row['D'];
                        $f4indexno = $row['E'];
                        $registrationnumber = $row['F'];
                        $yearofstudy = $row['G'];
                        $postponmentyear = $row['H'];
                        $postponmentreason = $row['I'];
                        $programmecode = $row['J'];
                        $programmename = $row['K'];
                        $xml_data = SubmitStudentsPostponedStudiesRequest(TCU_USERNAME, TCU_TOKEN,$Fname,$Mname,$Surname,$Gender,$f4indexno,$registrationnumber,$yearofstudy,$postponmentyear,$postponmentreason,$programmecode,$programmename);
                        $sendRequest = sendXmlOverPost(TCU_DOMAIN.'/applicants/submitPostponedStudents', $xml_data);
                        $responce=RetunMessageString($sendRequest,'ResponseParameters');
                        $data = simplexml_load_string($responce);
                        $json = json_encode($data);
                        $array_data = json_decode($json,TRUE);
                        $status_code = $array_data['StatusCode'];
                        $regno = $array_data['RegistrationNumber'];
                        $description = $array_data['StatusDescription'];
                        if($i==0)
                        {
                            $update=$this->db->query("update student_postponed set status=0");
                        }

                        $checkexist=$this->db->query("select * from student_postponed where registrtionnumber='".$registrationnumber."'")->result();
                        if($checkexist)
                        {
                            $update=$this->db->query("update student_postponed set status_code='".$status_code."',status_description='".$description."',status=1 where  registrtionnumber='".$registrationnumber."'");
                        }else{
                            $insert = $this->db->query("insert into student_postponed(fname,mname,sname,gender,f4indexno,postponementyear,yearofstudy,postponementreason,registrtionnumber,programmename,programmecode,status_code,status_description) 
                      values('".$Fname."','".$Mname."','".$Surname."','".$Gender."','".$f4indexno."','".$postponmentyear."','".$yearofstudy."','".$postponmentreason."','".$registrationnumber."','".$programmename."','".$programmecode."','".$status_code."','".$description."')");

                        }

                        $i+=1;

                    }

                }
                //delete excell here
                unlink('./uploads/temp/' . $dest_name);
                $this->session->set_flashdata('message', show_alert('Staffs successfully submited ', 'success'));
                redirect('current_student_postponed_list', 'refresh');
            }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'SubmitStudentPostPoned/', 'title' => 'Submit Student PostPonment');

        $this->data['active_menu'] = 'SubmitStudentPostPoned';
        $this->data['content'] = 'panel/submit_postponed';
        $this->load->view('template', $this->data);
    }
    function current_student_non_degree_programme_list()
    {
        $current_user = current_user();

        $sql = " SELECT * FROM student_nondegree where status=1 ";

        $config["base_url"] = site_url('current_student_non_degree_programme_list');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['nondegree_list'] = $this->db->query($sql . " ORDER BY id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'current_student_non_degree_programme_list/', 'title' => 'Non Degree Student  List');

        $this->data['active_menu'] = 'SubmitStudentNonDegreeProgramme';
        $this->data['content'] = 'panel/nondegree_list';
        $this->load->view('template', $this->data);

    }

    function SubmitStudentNonDegreeProgramme()
    {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        // $this->form_validation->set_rules('course','Course', 'required');


        if ($this->form_validation->run() == true) {
            //echo "hapa nafika";exit;

            //$code_course = $this->input->post('course');
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_non_degree_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }

                $i=0;
                foreach ($arr_data as $row) {
                    // echo "hapa nafika";exit;
                    $data = array();
                    $courseError = array();
                    if (trim($row['A']) <> '') {
                        $f4indexno = $row['A'];
                        $f6indexno = $row['B'];
                        $certificateregnum = $row['C'];
                        $Gender=$row['D'];
                        $nationality = $row['E'];
                        $impairment = $row['F'];
                        $dateofbirth = $row['G'];
                        $programmecode = $row['H'];
                        $programmename = $row['I'];
                        $applicationcategory = $row['J'];
                        $xml_data = SubmitStudentsAdmittedIntoNonDegreeProgramRequest(TCU_USERNAME, TCU_TOKEN,$f4indexno,$f6indexno,$certificateregnum,$Gender,$nationality,$impairment,$dateofbirth,$applicationcategory,$programmename,$programmecode);
                        $sendRequest = sendXmlOverPost(TCU_DOMAIN.'/applicants/submitAdmittedNonDegree', $xml_data);
                        $responce=RetunMessageString($sendRequest,'ResponseParameters');
                        $data = simplexml_load_string($responce);
                        $json = json_encode($data);
                        $array_data = json_decode($json,TRUE);
                        $status_code = $array_data['StatusCode'];
                        $regno = $array_data['RegistrationNumber'];
                        $description = $array_data['StatusDescription'];
                        if($i==0)
                        {
                            $update=$this->db->query("update student_nondegree set status=0");
                        }

                        $checkexist=$this->db->query("select * from student_nondegree where f4indexno='".$f4indexno."'")->result();
                        if($checkexist)
                        {
                            $update=$this->db->query("update student_nondegree set status_code='".$status_code."',status_description='".$description."',status=1 where  f4indexno='".$f4indexno."'");
                        }else{
                            $insert = $this->db->query("insert into student_nondegree(f4indexno,f6indexno,certificateregnumb,nationality,gender,impairment,dateofbirth,applicantcategory,programmename,programmecode,status_code,status_description) 
                      values('".$f4indexno."','".$f6indexno."','".$certificateregnum."','".$nationality."','".$Gender."','".$impairment."','".$dateofbirth."','".$applicationcategory."','".$programmename."','".$programmecode."','".$status_code."','".$description."')");

                        }

                        $i+=1;

                    }

                }
                //delete excell here
                unlink('./uploads/temp/' . $dest_name);
                $this->session->set_flashdata('message', show_alert('Non Degree Students successfully submited ', 'success'));
                redirect('current_student_non_degree_programme_list', 'refresh');
            }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'SubmitStudentNonDegreeProgramme/', 'title' => 'Submit Non Degree Students');

        $this->data['active_menu'] = 'SubmitStudentNonDegreeProgramme';
        $this->data['content'] = 'panel/submit_nonedegree';
        $this->load->view('template', $this->data);
    }


    function student_account_statement(){

        if(isset($_GET['pull_transctions']) )
        {

            execInBackground('home CheckFeeStructure ' );

            $this->session->set_flashdata("message", show_alert("Student Balance Successfully generated    you can refresh the page after 5 second to view transactions", 'info'));
            redirect(site_url('student_account_statement/'),'refresh');

        }
        $sarisdb =$this->load->database('saris',TRUE);
        $this->data['campus'] = $sarisdb->query("SELECT * FROM campus")->result();
        $this->data['intake'] = $sarisdb->query("SELECT * FROM intake_values")->result();
        $this->data['ntalevel'] = $sarisdb->query("SELECT * FROM programme")->result();
         
        $current_user = current_user();

        $ayear = $this->common_model->get_account_year()->row()->AYear;

        $where = ' WHERE student_invoice.ayear="'.$ayear.'"';
        
        if (isset($_GET['ntlevel']) && $_GET['ntlevel'] != '') {
            $where .= " AND student_invoice.nta_level='".trim($_GET['ntlevel'])."'";
        }


        if (isset($_GET['intake']) && $_GET['intake'] != '') {
            $where .= " AND student_invoice.intake='".trim(format_date($_GET['intake']))."'";
        }

        if (isset($_GET['campus']) && $_GET['campus'] != '') {
            $where .= " AND student_invoice.campus='".trim(format_date($_GET['campus']))."'";
        }

         
        $sql = " select distinct regno,name from student_invoice  $where ";

        if (isset($_GET['pay_category']) && $_GET['pay_category'] == 1) {

            $where .= " AND  payment.student_id IS NULL";
            $sql = " select distinct student_invoice.regno,student_invoice.name from student_invoice left join payment on payment.student_id=student_invoice.regno  $where ";


        }

          


        $config["base_url"] = site_url('student_account_statement/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");


        $intake_array=array(
            1=>"September",
            2=>"March"
        );

        $campus_array=array(
            1=>"Bagamoyo",
            2=>"Dar es salaam"
        );

        $sql = " select distinct student_invoice.regno,student_invoice.name from student_invoice left join payment on payment.student_id=student_invoice.regno  $where ";


        $this->data['statement_list'] = $this->db->query($sql . " ORDER BY Name")->result();

         
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Account');
        $this->data['bscrum'][] = array('link' => 'student_account_statement/', 'title' => 'Students Balances List');

        $title1 = '';
        if (isset($_GET['campus']) && $_GET['campus'] <> '') {
            $title1 .= " Campus :<strong> ".$_GET['campus']. '</strong>';
        }

        if (isset($_GET['intake']) && $_GET['intake'] <> '') {
            $title1 .= " Intake :<strong> ".$_GET['intake']  . '</strong>';
        }

        if (isset($_GET['ntlevel']) && $_GET['ntlevel'] <> '') {
            $title1 .= " NTA Level :<strong> " . $_GET['ntlevel'] . '</strong>';
        }

        $this->session->set_flashdata('message_account_year', show_alert('Active Account Year: <strong>'.$this->common_model->get_account_year()->row()->AYear. '</strong> ' .$title1, 'warning'));

        $this->data['active_menu'] = 'report';
        $this->data['content'] = 'panel/statement_list';
        $this->load->view('template', $this->data);

    }

    function saris_student()
    { 
        // $ayear= $this->common_model->get_account_year()->row()->AYear;
        $where = " WHERE 1=1  ";
        if (isset($_GET['center']) && $_GET['center'] <> '') {
    
            $where .= " AND application.CenterRegNo='".trim($_GET['center'])."'";
        }
        if (isset($_GET['student_status']) && $_GET['student_status'] <> '') {
    
            $where .= " AND application.student_status='".trim($_GET['student_status'])."'";

        }
       
        $sql = " SELECT * FROM application $where AND RegNo!='' ";

        $this->data['student_list'] = $this->db->query($sql . " ORDER BY application.id DESC ")->result();

        $config["base_url"] = site_url('saris_student');
        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'saris_student/', 'title' => 'Student  List');

        $this->data['active_menu'] = 'report';
        $this->data['content'] = 'panel/saris_student';
        $this->load->view('template', $this->data);
    }

    function approved_center_list()
    { 
   

        $ayear = $this->common_model->get_academic_year()->row()->AYear;
        // $date = "2018-09-24";
        //$where = " WHERE 1=1 AND application.AYear='$ayear' ";
        $where = " WHERE 1=1  ";
        $check_where=0;

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $where .= " AND submitted='" . $_GET['status'] . "' ";
            $check_where+=1;
        }
        if (isset($_GET['entry']) && $_GET['entry'] != '') {
            $where .= " AND Premises='" . $_GET['entry'] . "' ";
            $check_where+=1;

        }

        if (isset($_GET['center']) && $_GET['center'] != '') {
            $where .= " AND application.application_type='" . $_GET['center'] . "' ";
            $check_where+=1;

        }

        if (isset($_GET['from']) && $_GET['from'] != '') {
          $frm = $_GET['from'];
          $from = format_date($frm, true);
            $where .= " AND DATE(application.createdon) >='" . $from . "' ";
            $check_where+=1;
        }

        if (isset($_GET['to']) && $_GET['to'] != '') {
          $t = $_GET['to'];
          $to = format_date($t, true);
            $where .= " AND DATE(application.createdon) <='" . $to . "' ";
            $check_where+=1;
        }

        if (isset($_GET['year']) && $_GET['year'] != '') {
            $where .= " AND application.AYear='" . $_GET['year'] . "' ";
            $check_where+=1;
        }


        if($check_where==0)
        {
             $where .= " AND   application.AYear='$ayear'";
        }
        $sql = " SELECT * FROM application $where AND submitted='3'";

        $this->data['center_list'] = $this->db->query($sql . " ORDER BY application.id DESC ")->result();

        $config["base_url"] = site_url('approved_center_list');
        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'approved_center_list/', 'title' => 'Approved Center List');

        $this->data['active_menu'] = 'report';
        $this->data['content'] = 'panel/approved_center_list';
        $this->load->view('template', $this->data);
    }


    function import_nacte()
    {
        $ayear = $this->common_model->get_academic_year()->row()->AYear;

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        $this->form_validation->set_rules('program', 'Program', 'required');

        if ($this->form_validation->run() == true) {

            $programme = trim($this->input->post('program'));
            $progrmme_details = $this->db->query("select level from programme where programme_id='$programme'")->row();
            $progrmme_level=$progrmme_details->level;
            $programme_code=$progrmme_details->Code;

            //$code_course = $this->input->post('course');
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }


                foreach ($arr_data as $row) {
                    //$request.='<authorization>'.$authorization.'</authorization>';
                    $data = array();
                    $courseError = array();
                    $i = 0;
                    if (trim($row['A']) <> '') {


                        $f4_index = $row['A'];
                        if(trim($f4_index)!='') {
                            $check_equivalent = substr($f4_index, 0, 2);
                            $index_number_tmp = explode('/', $f4_index);
                            if ($check_equivalent != "EQ") {
                                $f4_index = $index_number_tmp[0] . '/' . $index_number_tmp[1];
                            } else {
                                $f4_index = $index_number_tmp[0];
                            }
                        }

                        $f6_index = $row['C'];
                        if(trim($f6_index)!='') {
                            $check_equivalent = substr($f6_index, 0, 2);
                            $index_number_tmp = explode('/', $f6_index);
                            if ($check_equivalent != "EQ") {
                                $f6_index = $index_number_tmp[0] . '/' . $index_number_tmp[1];
                            } else {
                                $f6_index = $index_number_tmp[0];
                            }
                        }

                        $f4_year = $row['B'];
                        $f6_year = $row['D'];
                        $NTA4_reg = $row['E'];
                        $NTA4_grad_year = $row['F'];
                        $NTA5_reg = $row['G'];
                        $NTA5_grad_year = $row['H'];
                        $payment_reference_number = NACTE_API_PAYREF;
                        $payment_reference_number=$row['I'];
                        $application_year = $row['J'];
                        $intake = $row['K'];
                        $index_array = explode(",", $f4_index);
                        $current_index = $index_array[0];
                        $applicant = $this->db->get_where('application_education_authority', array('index_number' => $row['A']))->row()->applicant_id;

                        $applicant2 = $this->db->query('select * from  application where  form4_index="'.trim($row['A']).'"  and submitted=1')->row()->id;

                        if($applicant2)
                        {
                            $applicant= $applicant2;
                        }
                        //echo 'applicabt'.$applicant; exit;
                        if ($applicant) {
                            $applicant_info = $this->db->get_where('application', array('id' => $applicant))->row();
                            $entry = $applicant_info->entry_category;
                            if ($entry == 2) {
                                $category = "A";
                            } elseif ($entry == 4) {
                                $category = "D";
                            } else {
                                $category = "R";
                            }

                            $mobileNumber = $applicant_info->Mobile1;

                            $first_name = $applicant_info->FirstName;
                            $second_name = $applicant_info->MiddleName;
                            $last_name = $applicant_info->LastName;
                            //new added field
                            $otherMobileNumber = $applicant_info->Mobile2;
                            $nationality = $this->db->get_where('nationality', array('id' => 220))->row()->Name;
                            $impairment = $this->db->get_where('disability', array('id' => $applicant_info->Disability))->row()->name;
                            $dateOfbirth = $applicant_info->dob;
                            $emailAddress = $applicant_info->Email;
                            $gender = $applicant_info->Gender;
                            //$nationality='Tanzanian';
                            if ($gender == 'M') $gender = "male";
                            if ($gender == 'F') $gender = 'female';

                            $address = $applicant_info->postal;
                            $region = $applicant_info->region;
                            $district = $applicant_info->district;
                            if ($applicant_info->region == '') {
                                $region = $applicant_info->postal;

                            }
                            if ($applicant_info->district == '') {
                                $district = $applicant_info->postal;
                            }
                            if (trim($region) == '') {
                                $region = $applicant_info->physical;
                                $district = $region;
                            }
                            if (trim($region) == '') {
                                $region = '';
                            }
                            if (trim($district) == '') {
                                $district = '';
                            }



                            $next_of_kin_info = $this->db->query("select * from application_nextkin_info where applicant_id=" . $applicant . "  order by id ")->row();
                            $nextkinname = "";
                            $next_kin_phone = '';
                            $next_kin_region = '';
                            $next_kin_address = '';
                            $nex_kin_email = '';
                            $next_kin_relation = '';
                            if ($next_of_kin_info) {
                                if (trim($next_of_kin_info->name) != '')
                                    $nextkinname = $next_of_kin_info->name;
                                if (trim($next_of_kin_info->mobile1) != '')
                                    $next_kin_phone = $next_of_kin_info->mobile1;

                                if (trim($next_of_kin_info->postal) != '') {
                                    $next_kin_address = $next_of_kin_info->postal;
                                    $next_kin_region = $next_of_kin_info->postal;
                                }

                                if (trim($next_of_kin_info->relation) != '')
                                    $next_kin_relation = $next_of_kin_info->relation;
                                if (trim($next_of_kin_info->email) != '')
                                    $nex_kin_email = $next_of_kin_info->email;

                            }

                            if (trim($next_of_kin_info->region) != '') {
                                $next_kin_region = $next_of_kin_info->region;
                            }

                            if ($address == '') {
                                $address = $next_kin_address;
                            }
                            if ($region == '') {
                                $region = $next_kin_region;
                            }
                            if ($district == '') {
                                $district = $next_kin_address;
                            }


                            $pay_ref = "null";
                            if (trim($row['I']) != '') {
                                $pay_ref = trim($row['I']);
                            } else {

                                $payment_info = $this->db->query("select * from payment where applicant_id=" . $applicant)->row();

                                if ($payment_info) {
                                    $pay_ref = $payment_info->receipt_number;
                                }
                            }


                            $json = CreateUploadJson($first_name, $second_name, $last_name, $dateOfbirth, $gender, $impairment,
                                $f4_index, $f4_year, $f6_index, $f6_year, $NTA4_reg, $NTA4_grad_year, $NTA5_reg, $NTA5_grad_year, $emailAddress, $mobileNumber,
                                $address, $region, $district, $nextkinname, $next_kin_phone, $next_kin_address, $nex_kin_email, $next_kin_relation, $next_kin_region, $nationality, $programme, $payment_reference_number, $application_year, $intake, $progrmme_level);
                            $url = "https://www.nacte.go.tz/nacteapi/index.php/api/upload";

                            echo '<pre>';
                            echo $json;
                            echo '</pre>';
                              
                            $exist_successfully = $this->db->query("select * from nacte_admitted where f4_index='$f4_index' and a_year='" . $ayear . "' and code=200")->row();

                            if (!$exist_successfully) {
                                echo 'result' . $result = sendJsonlOverPost($url, $json);
                                $array = json_decode($result, true);
                                $code = $array['code'];
                                $message = $array['message'];
                                
                                // print($array);
                                // exit;
                                if ($i == 0) {
                                    $update = $this->db->query("update nacte_admitted set status=0");
                                }
                                $exist = $this->db->query("select id from nacte_admitted where f4_index='$f4_index' and a_year='" . $ayear . "'")->row();
                                if ($exist->id) {
                                    $update_array = array(
                                        "status" => 1,
                                        "code" => $code,
                                        "message" => $message,
                                        'request' => $json,
                                        'programme_code'=>$programme_code
                                    );

                                    $this->db->update('nacte_admitted', $update_array, array('f4_index' => $f4_index));
                                } else {
                                    $data_to_import = array(
                                        'f4_index' => $f4_index,
                                        'f4_year' => $f4_year,
                                        'f6_index' => $f6_index,
                                        'f6_year' => $f6_year,
                                        'NTA4_reg' => $NTA4_reg,
                                        'NTA4_grad_year' => $NTA4_grad_year,
                                        'NTA5_reg' => $NTA5_reg,
                                        'NTA5_grad_year' => $NTA5_grad_year,
                                        'payment_reference_number' => $payment_reference_number,
                                        'application_year' => $application_year,
                                        'intake' => $intake,
                                        'code' => $code,
                                        'message' => $message,
                                        'request' => $json,
                                        'a_year' => $ayear,
                                        'programme_code'=>$programme_code,
                                        "status" => 1
                                    );
                                    $this->db->insert('nacte_admitted', $data_to_import);
                                }
                            }else{
                                $update_array=array(
                                  'programme_code'=>$programme_code
                                );
                                $this->db->update('nacte_admitted', $update_array, array('id' => $exist_successfully->id));

                                echo"Already submitted";
                            }

                        }

                    }
                    $i = $i + 1;
                }
                $this->session->set_flashdata('message', show_alert('Student Imported successfully!!', 'success'));
                unlink('./uploads/temp/' . $dest_name);
                redirect('current_nacte_submitted_list', 'refresh');
            }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'import/', 'title' => 'Import Admitted students NACTE');

        $this->data['active_menu'] = 'nacte';
        $this->data['content'] = 'panel/import_nacte';
        $this->load->view('template', $this->data);
    }

    function current_nacte_submitted_list()
    {
        $ayear = $this->common_model->get_academic_year()->row()->AYear;

        $current_user = current_user();


        $sql = " SELECT * FROM nacte_admitted where a_year='".$ayear."' ";

        $config["base_url"] = site_url('current_nacte_submitted_list');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['nacte_list'] = $this->db->query($sql . " ORDER BY id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'invoice_list/', 'title' => 'Staff List');

        $this->data['active_menu'] = 'nacte';
        $this->data['content'] = 'panel/nacte_submitted_list';
        $this->load->view('template', $this->data);

    }

    function nacte_enrollment()
    {
        $ayear = $this->common_model->get_academic_year()->row()->AYear;

        $current_user = current_user();

        $this->data['applicants'] = '';
        $this->data['prog_id'] = '';
        $this->data['year_id'] = '';
        $sql = " SELECT * FROM nacte_admitted where a_year='".$ayear."' ";

        $config["base_url"] = site_url('nacte_enrollment');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['nacte_list'] = $this->db->query($sql . " ORDER BY id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'nacte_enrollment/', 'title' => 'Nacte Enrollment');


        $this->form_validation->set_rules('programme', 'Programme', 'required');

        if ($this->form_validation->run() == true) {
            $programme = $this->input->post('programme');
            $option = $this->input->post('option');
            $intake = $this->input->post('intake');
            $intake = $this->input->post('intake');
            //$Ayear = date("Y")-1;
            $Ayear = $this->input->post('ayear');

                $url = "https://www.nacte.go.tz/nacteapi/index.php/api/verificationresults/".$programme."-".$Ayear."-".$intake."/WXfa9db0dbac235c.9809e1c2358cb34ceb886a9af5453cd7450a35660c6976713e0d350ef5d77685.ccf001e58711e6138b34e44814ea79c0ab4f799a";
                $this->curl->create($url);
                $response = $this->curl->execute();
                if ($response) {
                    $responsedata = json_decode($response, true);
                    $this->data['applicants'] = $responsedata['params'];
                    $this->data['prog_id'] = $programme;
                    $this->data['year_id'] = $Ayear;
                }
    }
    
    $this->data['active_menu'] = 'nacte';
    $this->data['content'] = 'panel/nacte_enrollment';
    $this->load->view('template', $this->data);

   }
    function enroll_nacte(){
        $current_user = current_user();
          print_r($this->input->post('user_id'));
        if(isset($_POST['enroll'])){
            foreach($this->input->post('user_id') as $user_id){
            $url = 'https://www.nacte.go.tz/nacteapi/index.php/api/registerstudent';
            //create a new cURL resource
            $ch = curl_init($url);
            $data = array(
                'authorization' => '1afeaba8fb287facbb701f3c32aee296401cf780',
                'student_verification_id' =>$user_id ,
                'upload_user' => $current_user->username,
                'programme_id' => $this->input->post('programme'),
                'intake' => $this->input->post('intake'),
                'year' => $this->input->post('year'),
            );
            $payload = json_encode(array($data));
            //print_r($payload); exit;
            //attach encoded JSON string to the POST fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            //set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            //return response instead of outputting
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result,true);
            if($result['code'] =='200'){ 
            $this->session->set_flashdata('message', show_alert('Student Enrolled !!'.$user_id, 'success'));
                }else{
            $this->session->set_flashdata('message', show_alert('Error occured while Enrolling  !!', 'danger'));  
                }
                
             }
             
            
             redirect($_SERVER['HTTP_REFERER']);
           }

    }
    function nacte_enrolled_list()
    {
        $ayear = $this->common_model->get_academic_year()->row()->AYear;

        $current_user = current_user();

        $this->data['applicants'] = '';
        $sql = " SELECT * FROM nacte_admitted where a_year='".$ayear."' ";

        $config["base_url"] = site_url('nacte_enrolled_list');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['nacte_list'] = $this->db->query($sql . " ORDER BY id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'nacte_enrolled_list/', 'title' => 'Nacte Enrolled list');

        

        $this->form_validation->set_rules('programme', 'Programme', 'required');

        if ($this->form_validation->run() == true) {
            $programme = $this->input->post('programme');
            $option = $this->input->post('option');
            $intake = $this->input->post('intake');
            $semester = $this->input->post('semester');
            //$Ayear = date("Y")-1;
            $Ayear = $this->input->post('ayear');
            
                $url = "https://www.nacte.go.tz/nacteapi/index.php/api/institutionenrollment/".$programme."-".$Ayear."-".$semester."-".$intake."/lm5da4ce4ac7ba59.c36bff779eeb484d765f9bc7b3356ed67c92375f09c282fe1d008d9590b212c8.f25758d2209ec4d46bf92fa77ab16d1492b1fc58";
                $this->curl->create($url);
                $response = $this->curl->execute();

                //var_dump($response); exit;
                if ($response) {
                    $responsedata = json_decode($response, true);
                    $this->data['applicants'] = $responsedata['params'];
                }
    }
        $this->data['active_menu'] = 'nacte';
        $this->data['content'] = 'panel/nacte_enrolled_list';
        $this->load->view('template', $this->data);

    }

    function import_nacte_verification()
    {
        // echo "hapa nafika";exit;
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();


        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $excel_upload = TRUE;
        $upload_error = '';


        // if (!has_role($this->MODULE_ID, $this->GROUP_ID, 'MANAGE_EXAMINATION', 'grade_book')) {
        //     $this->session->set_flashdata("message", show_alert("MANAGE_COLLEGE_SCHOOL :: Access denied !!", 'info'));
        //     redirect(site_url('dashboard'), 'refresh');
        // }

        // validate form input
        $this->form_validation->set_rules('post_data', 'post_data', 'required');
        $this->form_validation->set_rules('program','Program', 'required');

        if ($this->form_validation->run() == true) {
            $programme = trim($this->input->post('program'));
            $progrmme_details = $this->db->query("select level from programme where programme_id='$programme'")->row();
            $progrmme_level=$progrmme_details->level;
            $programme_code=$progrmme_details->Code;
            if (isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['userfile']['name']) && (get_file_extension($_FILES['userfile']['name']) != 'xlsx' && get_file_extension($_FILES['userfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {
                $dest_name = time() . 'result_sheet.xlsx';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/temp/' . $dest_name);
                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection
                // echo "hapa nafika"; exit;
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = trim($data_value);
                    } else {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }


                foreach ($arr_data as $row) {
                    //$request.='<authorization>'.$authorization.'</authorization>';
                    //echo "hapa nafika";exit;
                    $data = array();
                    $courseError = array();
                    $i=0;
                    if (trim($row['A']) <> '') {
                        $f4_year= $row['B'];
                        $verification_id=$row['A'];
                        $programme=$row['B'];
                        $first_name=$row['C'];
                        $second_name=$row['D'];
                        $sur_name=$row['E'];
                        $mobile=$row['F'];
                        $email=$row['G'];
                        $f4_index= $row['H'];
                        $f4_year= $row['I'];
                        $f6_index= $row['J'];
                        $f6_year= $row['K'];

                        $NTA4_reg= (trim($row['L'])=="")?"":$row['L'];
                        $NTA4_grad_year=(trim($row['M'])=="")?"":$row['M'];
                        $NTA5_reg= (trim($row['N'])=="")?"":$row['N'];
                        $NTA5_grad_year= (trim($row['O'])=="")?"":$row['O'];
                        $ayear=$row['P'];
                        $intake=$row['Q'];
                        $result=CreateVerificationJson($verification_id,$programme,$first_name,$second_name,$sur_name,$mobile,
                            $email,$f4_index,$f4_year,$f6_index,$f6_year,$NTA4_reg,$NTA4_grad_year,$NTA5_reg,$NTA5_grad_year,$intake,$ayear,$progrmme_level);
//                        $url="https://www.nacte.go.tz/nacteapi/index.php/api/addcorrection";
//                        echo '<pre>';
//                        echo $json;
//                        echo '</pre>';


                           // echo'result'. $result= sendJsonlOverPost($url,$json);

                        $array=json_decode($result,true);
                        $code=$array['code'];
                        $message=$array['message'];
                        if($i==0)
                        {
                            $update=$this->db->query("update nacte_verification set status=0");
                        }
                        $exist=$this->db->query("select id from nacte_verification where f4_index='$f4_index'")->row();
                        if($exist->id)
                        {
                            $update_array=array(
                                "status"=>1,
                                "code"=>$code,
                                "message"=>$message,
                                'request'=>$json
                            );

                            $this->db->update('nacte_verification', $update_array, array('f4_index' => $f4_index));
                        }else{
                            $data_to_import = array(
                                'f4_index' => $f4_index,
                                'f4_year' => $f4_year,
                                'f6_index' =>$f6_index,
                                'f6_year' => $f6_year,
                                'NTA4_reg' => $NTA4_reg,
                                'NTA4_grad_year' => $NTA4_grad_year,
                                'NTA5_reg' => $NTA5_reg,
                                'NTA5_grad_year' => $NTA5_grad_year,
                                'firstname' => $first_name,
                                'secondname' => $second_name,
                                'surname' => $sur_name,
                                'mobile' => $mobile,
                                'email' => $email,
                                'code' => $code,
                                'message' => $message,
                                'request'=>$json,
                                "status"=>1,
                                "verification_id"=>$verification_id,
                                "a_year"=>$ayear,
                                "intake"=>$intake
                            );
                            $this->db->insert('nacte_verification', $data_to_import);
                        }




                    }
                    $i=$i+1;
                }
                $this->session->set_flashdata('message', show_alert('Student Verification Imported successfully!!', 'success'));
                unlink('./uploads/temp/' . $dest_name);
                redirect('current_nacte_verification_list', 'refresh');
            }
        }


        $this->data['upload_error'] = $upload_error;
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'import/', 'title' => 'Import Verifications of  students NACTE');

        $this->data['active_menu'] = 'nacte';
        $this->data['content'] = 'panel/import_nacte_verification';
        $this->load->view('template', $this->data);
    }

    function current_nacte_verification_list()
    {
        $current_user = current_user();


        $sql = " SELECT * FROM nacte_verification where status=1 ";

        $config["base_url"] = site_url('current_nacte_verification_list');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);

        $this->data['verification_list'] = $this->db->query($sql . " ORDER BY id")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'current_nacte_verification_list/', 'title' => 'Verification List');

        $this->data['active_menu'] = 'nacte';
        $this->data['content'] = 'panel/nacte_verification_list';
        $this->load->view('template', $this->data);

    }

    function applicant_reports_nacte()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        $current_user = current_user();

        if (isset($_GET['action']) && $_GET['action'] <> '') {
            $this->data['action'] = $_GET['action'];
        }

        $this->form_validation->set_rules('programme', 'Programme', 'required');

        if ($this->form_validation->run() == true) {
            $programme = $this->input->post('programme');
            $option = $this->input->post('option');
            $intake = $this->input->post('intake');
            $intake = $this->input->post('intake');
            $Ayear = $this->input->post('ayear');
           
            if($option==1)
            {
                $url = "https://www.nacte.go.tz/nacteapi/index.php/api/verificationresults/".$programme."-".$Ayear."-".$intake."/WXfa9db0dbac235c.9809e1c2358cb34ceb886a9af5453cd7450a35660c6976713e0d350ef5d77685.ccf001e58711e6138b34e44814ea79c0ab4f799a";
                $this->curl->create($url);
                $response = $this->curl->execute();
               
                if ($response) {
                    $responsedata = json_decode($response, true);
                    $applicants = $responsedata['params'];
                     //var_dump($applicants); exit;
                    include_once 'report/verifiedadmittedstudent.php';
                    exit;
                }
            }elseif ($option==2)
            {

                $url = "https://www.nacte.go.tz/nacteapi/index.php/api/pushedlist/".$programme."-".$Ayear."-".$intake."/TU48faa5af49f971.6e290736cd551928d5c724eb5b956fcaa55b374211cefb7451cfe4ae8185b71d.3c1ebe33809001220b56ed0b5cf4ba7177a94b5b";
               // echo $url; exit;
                $this->curl->create($url);
                $response = $this->curl->execute();

                if ($response) {
                    $responsedata = json_decode($response, true);
                    $applicants = $responsedata['params'];
                    
                    include_once 'report/feedbackerrortocorrect.php';
                    exit;
                }
            }elseif ($option==3)
            {
                $url = "https://www.nacte.go.tz/nacteapi/index.php/api/feedbackcorrection/".$programme."-".$Ayear."-".$intake."/GH4def84a2fc7491.b550c56b5b74890a2c72b0ef7a51cea69fbf2db51c71a48696112430281df577.2f452056d990207a149c1593b9c75ef03d2aef62";
                $this->curl->create($url);
                $response = $this->curl->execute();

                if ($response) {
                    $responsedata = json_decode($response, true);
                    $applicants = $responsedata['params'];
                    include_once 'report/nactepushedlist.php';
                    exit;
                }
            }


           }
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant Reports');
        $this->data['bscrum'][] = array('link' => 'import/', 'title' => 'Get Applicants NACTE Reports');

        $this->data['active_menu'] = 'nacte';
        $this->data['programme_list'] = $this->common_model->get_programme(null, $type = 2)->result();
        $this->data['content'] = 'panel/applicant_reports_nacte';
        $this->load->view('template', $this->data);
    }

     function Nacte_Institutional_programmes()
     {
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Applicant');
        $this->data['bscrum'][] = array('link' => 'Nacte_Institutional_programmes/', 'title' => 'Institutional programmes details');
        
        $url = "https://www.nacte.go.tz/nacteapi/index.php/api/institutions/bcbbd39928a14419-9b926b2b03c1f1e55f1aa28516815a102095dfe8b25b341d644173791c0b127e-ef80cb423bafd9a0d45dc72fdb6c693750bbcbe3";
        $this->curl->create($url);
        $response = $this->curl->execute();


        if ($response) {
            $responsedata = json_decode($response, true);
            $programmes = $responsedata['params'];

            $this->data['programme_list'] = $programmes;
            
        }
        $this->data['active_menu'] = 'nacte';
        $this->data['content'] = 'panel/nacte_programmes_list';
        $this->load->view('template', $this->data);

     }

     function nacte_payment_balance()
     {
      
        $this->form_validation->set_rules('payment_reference', 'Payement Reference Number', 'required');
        if ($this->form_validation->run() == true) {
         $payment_ref = $this->input->post('payment_reference');
    $url = "https://www.nacte.go.tz/nacteapi/index.php/api/payment/".$payment_ref."/klace45a673346d0.06d6e67ba4cf123849f362536680080567c86afeee47f1ff34cdb5ebf673ad78.235cc6c7707a45a8744cbfd515345d27f8eeae1c";
         $this->curl->create($url);
        $response = $this->curl->execute();

      
        if ($response) {
            
            $responsedata = json_decode($response, true);
            if($responsedata['code'] == 200){
                $balance = $responsedata['params'];
                $this->data['balance'] = $responsedata['params'][0]['balance'];
                
            }else{
                $balance = $responsedata['message'];
                $this->data['balance'] = $balance;
            } 
        } 
       
        }
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'import/', 'title' => 'NACTE Payment Balance');

        $this->data['active_menu'] = 'nacte';
        $this->data['content'] = 'panel/nacte_payment_balance';
        $this->load->view('template', $this->data);
     }

     function nacte_particular_NTA_result()
     {
        $this->form_validation->set_rules('registration_number', 'Registration Number', 'required');
        $this->form_validation->set_rules('nta_level', 'NTA Level', 'required');
        if ($this->form_validation->run() == true) {
         $regno = $this->input->post('registration_number');
         $level = $this->input->post('nta_level');
         $arr = explode("/",$regno);
         $new_regno = $arr[0].".".$arr[1].".".$arr[2];
    $url = "https://www.nacte.go.tz/nacteapi/index.php/api/particulars/".$new_regno."-".$level."/WXe5325d07d31349.1f7a77920cce12ff3f599add77c43e197d347bc02b67f104243a28a3ff961b0b.16480dc3369f1daab27131b02f98b8c1971219b6";
         $this->curl->create($url);
        $response = $this->curl->execute();

        // var_dump($response); exit;
        if ($response) {
            $responsedata = json_decode($response, true);
            if($responsedata['code'] == 200){
                $nta_results = $responsedata['params'];
                $this->data['nta_result'] = $nta_results;
                $this->data['code'] = $responsedata['code'];
            }else{
                $this->data['code'] = $responsedata['code'];
                $nta_results = $responsedata['message'];
                $this->data['nta_result'] = $nta_results;
            } 
        } 
       
        }
        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Import');
        $this->data['bscrum'][] = array('link' => 'import/', 'title' => 'NACTE Payment Balance');

        $this->data['active_menu'] = 'nacte';
        $this->data['content'] = 'panel/nacte_nta_result';
        $this->load->view('template', $this->data);
     }
    
    

}
