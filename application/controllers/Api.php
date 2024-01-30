<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/13/17
 * Time: 9:33 AM
 */
class Api extends  CI_Controller
{

    function __construct()
    {
        parent::__construct();

    }

    function receive_payment()
    {


        $data_json = file_get_contents("php://input");

        $data = json_decode($data_json, TRUE);

        if ($data['ACTION'] == 'VALIDATE') {

            if(isset($data['REFERENCE']))
            {
                $reference = $data['REFERENCE'];
            }elseif(isset($data['reference']))
            {
                $reference = $data['reference'];
            }
            $payments_log = array(
                'data' => print_r($data,true)
            );
            $this->db->insert('payments_log', $payments_log);

            $myreference = substr($reference,3);
            $client = $this->applicant_model->get_applicant($myreference);

            $array = array(
                'MKEY' => $data['MKEY'],
                'REFERENCE' => $data['REFERENCE'],
                'ACTION' => 'VALIDATE',
                'STATUS' => 'SUCCESS'
            );
            if (!$client) {
                $array['STATUS'] = 'NOT_VALID';
            } else {
                $array['STATUS'] = 'SUCCESS';

            }
            echo json_encode($array);

        } else if ($data['ACTION'] == 'TRANS') {
            $check_receipt = $this->db->where("receipt",$data['receipt'])->get("application_payment")->row();
            $return = array(
                'status'=>'',
                'receipt'=>$data['receipt'],
                'clientID'=> $data['reference']
            );

            if(!$check_receipt) {
                $applicant_id = substr($data['reference'],3);
                $client_info=  $client_data = $this->applicant_model->get_applicant($applicant_id);
                if($client_data)
                {
                    //applicant exist
                    //log transaction
                    $payments_log = array(
                        'msisdn' => trim($data['msisdn']),
                        'reference' => trim($data['reference']),
                        'createdon' => $data['timestamp'],
                        'receipt' => trim($data['receipt']),
                        'amount' => trim($data['amount']),
                        'data' => print_r($data,true),
                        'response'=>"SUCCESS"
                    );
                    $this->db->insert('payments_log', $payments_log);
                    $trans_date = date('Y-m-d',strtotime($data['timestamp']));
                    $trans_timestamp = date('Y-m-d H:i:s',strtotime($data['timestamp']));

                    $AYear = $this->common_model->get_academic_year(null, 1, 1)->row()->AYear;

                    $payment = array(
                        'msisdn'=>$data['msisdn'],
                        'reference'=>$data['reference'],
                        'applicant_id'=> $applicant_id,
                        'timestamp'=> $trans_timestamp,
                        'receipt'=>$data['receipt'],
                        'amount'=> ($data['amount']-$data['charges']),
                        'charges'=>$data['charges'],
                        'AYear' =>  $AYear
                    );

                    $this->db->insert('application_payment',$payment);
                    $return['clientID'] = $client_data->FirstName.' '.$client_data->LastName;
                    $return['status'] = 'SUCCESS';

                }else{
                    $payments_log = array(
                        'msisdn' => trim($data['msisdn']),
                        'reference' => trim($data['reference']),
                        'createdon' => $data['timestamp'],
                        'receipt' => trim($data['receipt']),
                        'amount' => trim($data['amount']),
                        'data' => print_r($data,true),
                        'response'=>"APPLICANT NOT VALID"
                    );
                    $this->db->insert('payments_log', $payments_log);
                    $return['clientID'] = "WRONG CLIENT";
                    $return['status'] = 'APPLICANT NOT VALID';

                }



            }else{
                //DUPLICATE
                //log transaction
                $payments_log = array(
                    'msisdn' => trim($data['msisdn']),
                    'reference' => trim($data['reference']),
                    'createdon' => $data['timestamp'],
                    'receipt' => trim($data['receipt']),
                    'amount' => trim($data['amount']),
                    'data' => print_r($data,true),
                    'response'=>"DUPLICATE"
                );
                $this->db->insert('payments_log', $payments_log);
                $applicant_id = substr($check_receipt->reference,3);
                $client_data = $this->applicant_model->get_applicant($applicant_id);
                $return['clientID'] = $client_data->FirstName.' '.$client_data->LastName;
                $return['status'] = 'DUPLICATE';
            }
            echo json_encode($return);
        }
    }

}
