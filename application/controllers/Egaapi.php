<?php
/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/13/17
 * Time: 9:33 AM
 */
class Egaapi extends  CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function receive_payment()
    {
        // $ayear = $this->common_model->get_academic_year()->row()->AYear; before
        $ayear = $this->common_model->get_account_year()->row()->AYear;

        $data_json = file_get_contents("php://input");
        $data = json_decode($data_json, TRUE);
        if($data['status']==1)
        {
            $reference=$data['reference'];
            $invoice_number = substr($reference, 5);
            $invoice_info=$this->db->query("select * from invoices where id='$invoice_number'")->row();

            $log_data_array=array(
                'responce'=>$data_json,
                'status'=>$data['status'],
                'description'=>$data['description'],
                'type'=>'payment'
            );
            
            $payment_data_array=array(
                'chanell_transaction_id'=>$data['channel_trans_id'],
                'student_id'=>$data['user_id'],
                'invoice_number'=>$invoice_number,
                'ega_refference'=>$data['ega_reference'],
                'control_number'=>$data['CtrNum'],
                'paid_amount'=>$data['amount'],
                'transaction_date'=>$data['created_date'],
                'payment_channell'=>$data['channel'],
                'payer_mobile'=>$data['mobile'],
                'payer_name'=>$data['payer_name'],
                'payer_email'=>$data['payer_email'],
                'receipt_number'=>$data['receipt_number'],
                'channel_name'=>$data['channel_name'],
                'billReference'=>$reference,
                'a_year'=>$ayear,
                'CenterRegNo'=>$invoice_info->CenterRegNo
            );

            if(is_array($payment_data_array['payer_mobile']))
            {
                $payment_data_array['payer_mobile']="";
            }
            if(is_array($payment_data_array['payer_name']))
            {
                $payment_data_array['payer_name']="";
            }
            if(is_array($payment_data_array['payer_email']))
            {
                $payment_data_array['payer_email']="";
            }
            $checkif_exit=$this->db->query("select * from payment where ega_refference='".$data['ega_reference']."'")->row();
            if(!$checkif_exit)
            {
                $update_invoice=array(
                    'status'=>2
                );

                $this->db->insert('payment',$payment_data_array);
                $this->db->insert('ega_logs',$log_data_array);
                $this->db->update('invoices', $update_invoice, array('id'=>$invoice_number));

                //update registration for student after pay
                $student_id = $invoice_info->student_id;
                $student_info=$this->db->query("select * from application where id='$student_id'")->row();
                $application_category = $student_info->application_category;

                if($application_category=="Applicant")
                {
                    $prog_type= $student_info->application_type;
                    $code= $student_info->region;

                    $ayear = date('Y');
                    if($prog_type==1)
                    {
                        $programme = 'IP';
                    }elseif($prog_type==2)
                    {
                        $programme = 'I';
                    $region_info=$this->db->query("select * from regions where id='$code'")->row();
                    $region_code = $region_info->IPCode;

                    }elseif($prog_type==3)
                    {
                        $programme = 'A';
                        $region_info=$this->db->query("select * from regions where id='$code'")->row();
                        $region_code = $region_info->ASCode;
                    }

                    if($student_id<10){
                        $newid = '000'.$student_id;
                    }elseif($id<100){
                        $newid = '00'.$student_id;
                    }elseif($student_id <1000)
                    {
                        $newid = '0'.$student_id;
                    }elseif($student_id>=1000)
                    {
                        $newid = $student_id;
                    }

                    $regno = $ayear.'/'.$programme.'/'.$region_code.'/'.$newid;
                    $this->db->update("application", array('RegNo'=>$regno), array('id'=>$student_id));

                    //update registration number in invoices and payment tables
                    $this->db->update("invoices", array('student_id'=>$regno), array('student_id'=>$student_id));
                    $this->db->update("payment",array('student_id'=>$regno), array('student_id'=>$student_id));
            
                }

                #Sponsored Students
                if($invoice_info)
                {
                    //sponsor
                    if($invoice_info->invoice_type==4)
                    {
                        $payment_data_array_students=array();
                        $payment_data_array_students=$payment_data_array;
                        $sponsered_students=$this->db->query("select * from spoonsored_students_invoice where invoice_number='".$invoice_number."'")->result();
                        if($sponsered_students)
                        {
                            foreach ($sponsered_students as $key=>$value)
                            {
                                $student_id=$value->regno;
                                $student_invoice_number=get_value('invoices',array('student_id'=>$student_id,'control_number'=>$payment_data_array['control_number']),'id');
                                $student_amount=$value->amount;
                                $payment_data_array_students['student_id']=$student_id;
                                $payment_data_array_students['paid_amount']=$student_amount;
                                $payment_data_array_students['invoice_number']=($student_invoice_number)?$student_invoice_number:$invoice_number.$value->regno;
                                $payment_data_array_students['description']=$payment_data_array['student_id'].'-'.$value->batchno;
                                $this->db->insert('payment',$payment_data_array_students);
                            }
                        }
                    }
                }
                $checkif_exit=$this->db->query("select * from payment where ega_refference='".$data['ega_reference']."'")->row();
                if($checkif_exit)
                {
                    echo "success";
                }
            }else{
                echo "Payment exist";
            }

        }



    }



    function ReceiveControlNumber()
    {
        $data_json = file_get_contents("php://input");
        $data = json_decode($data_json, TRUE);
        $reference=$data['reference'];
        $control_number=$data['CtrNum'];
        $invoice_number = substr($reference, 5);
        $log_data_array=array(
            'responce'=>print_r($data,true),
            'status'=>$data['status'],
            'description'=>$data['description'],
            'type'=>'control_number'
        );
        $this->db->insert('ega_logs',$log_data_array);
        if($data['status']==1)
        {
            $update_invoice=array(
                'control_number'=>$control_number,
                'status'=>1,
            );
            $this->db->update('invoices', $update_invoice, array('id'=>$invoice_number));


            $file=$control_number.'.png';
            //$url=base_url()."Qrcode/qrcode.php";
            $url='http://41.59.225.216/qr/';
            $exists = remoteFileExists($url.'/Qrcode/images/'.$file);
            $invoice=$this->db->query("select * from invoices where id=".$invoice_number)->row();
            if($invoice)
            {
                if($invoice->invoice_type==1)
                {
                    $fee_structure=$this->db->query("select * from fee_structure where fee_code=".$invoice->fee_id)->row();
                    $fee_amount=0;
                    if($fee_structure)
                    {
                        $fee_amount=$fee_structure->amount;
                    }

                    if($fee_amount==0)
                    {
                        $fee_amount=$invoice->amount;
                    }
                    $postdata=array(
                        'regno'=>$invoice->student_id,
                        'amount'=>$invoice->amount,
                        'control_number'=>$invoice->control_number,
                        'status'=>$invoice->status,
                        'description'=>$invoice->description,
                        'a_year'=>$invoice->a_year,
                        'fee_id'=>$invoice->fee_id,
                        'fee_name'=>$invoice->fee_name,
                        'invoice_number'=>$invoice->id,
                        'fee_amount'=>$fee_amount
                    );
                    $url = "http://139.162.245.224/ega/ega-iae/student_invoice.php";
                    $data_json = sendDataOverPost($url, $postdata);
                    $data = json_decode($data_json, true);
                    $code = $data['code'];
                    $description=$data['description'];
                    if($code==1)
                    {
                        $update_invoice=array(
                            'sent'=>1,
                        );
                        $this->db->update('invoices', $update_invoice, array('id'=>$invoice_number));

                    }
                }

            }
            //if(!file(base_url().'Qrcode/images/'.$file))
            if(!$exists)
            {
                if($invoice)
                {
                    //$student_info=$this->db->query("select * from application where id=".$invoice->student_id)->row();
                    $date=date("Y-m-d",strtotime($invoice->timestamp));
                    $this->collegeinfo = get_collage_info();
                    $message=array(
                        "opType"=>2,
                        "shortCode"=>"001001",
                        "billReference"=>$control_number,
                        "amount"=>$invoice->amount,
                        "billCcy"=>'TZS',
                        "billExprDt"=>date("Y-m-d",strtotime(($date .' + 360days'))),
                        "billPayOpt"=>3,
                        "billRsv01"=>$this->collegeinfo->Name."|". $invoice->student_name
                    );
                    $message=json_encode($message);

                    $postdata = array(
                        "title" => $message,
                        "control" =>$invoice->control_number ,

                    );

                    sendDataOverPost($url,$postdata);

                }


            }

            //send nortification
            execInBackground('response send_control_number ' . $control_number.' ');
        }

    }

    function ReceiveReconciliation()
    {
        $data_json = file_get_contents("php://input");
        $data = json_decode($data_json, TRUE);
        $log_data_array=array(
            'responce'=>print_r($data,true),
            'type'=>'reconciliation'
        );
        $this->db->insert('ega_logs',$log_data_array);

    }

}

