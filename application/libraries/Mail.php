<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of maildata
 *
 * @author miltone
 */
class Mail
{

    //put your code here

    function __construct()
    {

    }

    public function __get($var)
    {
        return get_instance()->$var;
    }

    function send_email($subject, $message, $recipient = array(), $notify_admin = true, $bcc = array(), $attachment = null)
    {
        $this->load->library('email');
        $this->email->from('instituteoftax@gmail.com', 'SARIS OAS');
        $this->email->subject($subject);
        $this->email->to($recipient);
        if ($notify_admin) {
            //$bcc[] = EMAIL_INFO_ADMIN;
            //$this->email->bcc($bcc);
        }
        if (!is_null($attachment)) {
            if(!is_array($attachment)){
                $attachment = array($attachment);
            }
            foreach($attachment as $k=>$attach){
                $this->email->attach($attach);
            }
        }
        $this->email->message($message);
        if ($this->email->send()) {
            return 1;//TRUE;
        } else {
           // print_r($this->email->print_debugger());
           // exit;
            return 0;
        }
    }

}

?>
