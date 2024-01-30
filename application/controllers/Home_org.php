<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 5/13/17
 * Time: 9:17 AM
 */
class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->data['title'] = 'Home';
        $this->form_validation->set_error_delimiters('<div class="required">', '</div>');

    }

    function index()
    {

        $this->data['content'] = 'auth/login';
        $this->load->view('public_template', $this->data);
    }


    function registration_start()
    {
        $this->data['content'] = 'home/registration_start';
        $this->load->view('public_template', $this->data);
    }

    function valid_ntindexNo($str) {
        $str = trim($str);
        if ($str != "") {
            if(strlen($str) == 15) {
                if (preg_match("/(E)[0-9]{4}\/[0-9]{4}\/[0-9]{4}$/", $str)) {
                    return TRUE;
                } else {
                    $this->form_validation->set_message('valid_ntindexNo', 'The %s field must contain correct format');

                    return FALSE;
                }
            }else{
                $this->form_validation->set_message('valid_ntindexNo', 'The %s field must contain correct format');
                return false;
            }
        }
    }
    function application_start()
    {
        if (isset($_GET) && isset($_GET['type']) && isset($_GET['entry']) && isset($_GET['NT']) && isset($_GET['CSEE'])) {
            $this->data['type'] = $application_type = $_GET['type'];
            $this->data['entry'] = $entry_category = $_GET['entry'];
            $this->data['CSEE'] = $CSEE = $_GET['CSEE'];
            $this->data['NT'] = $NT = $_GET['NT'];
            if($application_type==4)
            {
                $this->form_validation->set_rules('txtRegno', 'Number ya usajili', 'required|callback_RegnoCheckIposa|is_unique[application_iposa.registrationnumber]');
                $this->form_validation->set_rules('txtFirstName', 'Jina La kwanza', 'required');
                $this->form_validation->set_rules('txtLastName', 'Jina La Mwisho', 'required');
                $this->form_validation->set_rules('txtGender', 'Jinsia', 'required');
                $this->form_validation->set_rules('txtDob', 'Tarehe ya Kuzaliwa', 'required');
                $this->form_validation->set_rules('txtTribe', 'Kabila', 'required');
                $this->form_validation->set_rules('txtMerritalStatus', 'Hali ya Ndoa', 'required');
                $this->form_validation->set_rules('txtRegion', 'Mkoa', 'required');
                $this->form_validation->set_rules('district', 'Wilaya', 'required');
                $this->form_validation->set_rules('txtWard', 'Kata', 'required');
                $this->form_validation->set_rules('txVillage', 'Kijiji', 'required');
                $this->form_validation->set_rules('txEducation', 'Kiwango cha Elimu', 'required');
                $this->form_validation->set_rules('txJob', 'Kazi unayofanya kwa sas', 'required');
                $this->form_validation->set_rules('txtWantToLearn', 'Unapenda Kujifunza Mambo Gani', 'required');
                $this->form_validation->set_rules('txtKinName', 'Jina la mtu wa karibu', 'required');
                $this->form_validation->set_rules('txtKinRelation', 'Uhusiano na mtu wa karibu', 'required');
                $this->form_validation->set_rules('txtNextMobile', 'Namba ya simu ya mtu wa kariru', 'required');
                $this->form_validation->set_rules('txtMratibuName', 'Jina la Mratibu Elimu kata', 'required');
                $this->form_validation->set_rules('txtMratibuMobile', 'Namba ya simu ya Mratibu Elimu kata', 'required');
                $this->form_validation->set_rules('txtMratibuDate', 'Tarehe uliyoenda kwa Mratibu Elimu kata', 'required');
                $this->form_validation->set_rules('txtDisability', 'Aina ya ulemavu', 'required');
               // $this->form_validation->set_rules('txKituoAddress', 'Anuani ya kituo', 'required');
//                $this->form_validation->set_rules('txKituoMkuuName', 'Jina la mkuu wa kituo', 'required');
//                $this->form_validation->set_rules('txtKituoMkuuMobile', 'Namba ya Simu ya Mkuu wa kituo ', 'required');
                $this->form_validation->set_rules('txtKituoDate', 'Tarehe ya kituo ', 'required');
                //$this->form_validation->set_rules('file', 'Kuambatanisha form ni lazima ', 'required');
            }else{
                $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
                $this->form_validation->set_rules('firstname', 'First Name', 'required');
                $this->form_validation->set_rules('lastname', 'Last Name', 'required');
                $this->form_validation->set_rules('gender', 'Gender', 'required');
                $this->form_validation->set_rules('dob', 'Birth Date', 'required|valid_date');
                $this->form_validation->set_rules('nationality', 'Nationality', 'required');
                $this->form_validation->set_rules('disability', 'Disability', 'required');
                $this->form_validation->set_rules('birth_place', 'Place of Birth', 'required');
                $this->form_validation->set_rules('marital_status', 'Marital Status', 'required');
                $this->form_validation->set_rules('residence_country', 'Country of Residence', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[application.email]|is_unique[users.email]');
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[conf_password]');
                $this->form_validation->set_rules('conf_password', 'Confirm Password', 'required');
                $this->form_validation->set_rules('region', 'Region of Residence', 'required');
                $this->form_validation->set_rules('district', 'District of Residence', 'required');
                $this->form_validation->set_rules('primary_school', 'primary school', 'required');

            }

            if($entry_category==3)
            {

                $this->form_validation->set_rules('program_title', 'Programme Title', 'required') ;
                $this->form_validation->set_rules('exam_authority1', 'Exam Authority', 'required') ;
                $this->form_validation->set_rules('school', 'Institution/College', 'required') ;
                $this->form_validation->set_rules('country1', 'Country', 'required') ;
                $this->form_validation->set_rules('completed_year', 'Completed year', 'required') ;
                $this->form_validation->set_rules('cert_type', 'Certificate Type', 'required') ;
                if(trim($this->input->post('cert_type'))==1){
                    $this->form_validation->set_rules('ntlevel_index', 'NT level 4 index number required', 'callback_valid_ntindexNo|required') ;

                }else{
                    $this->form_validation->set_rules('ntlevel_index', 'NT level 4 index number required', 'required') ;

                }


            }

            if($entry_category==1 ||  $entry_category==2 || $entry_category==4)
            {
                $this->form_validation->set_rules('o_level_index_no', 'O level Index Number', 'required');
                if($entry_category==2)
                {
                    $this->form_validation->set_rules('school', 'A level School', 'required');
                    $this->form_validation->set_rules('a_level_index_no', 'A level Index Number', 'required');
                }elseif($entry_category==4)
                {
                    $this->form_validation->set_rules('institution', 'Institution', 'required');
                    $this->form_validation->set_rules('avn', 'NACTE Award Verification Number', 'required');

                }
            }

            if($application_type==2 )
            {
                if($entry_category==2){
                    $error_message = 'O level and A level names mismatch';
                }elseif($entry_category==4)
                {
                    $error_message = 'O level and Diploma names mismatch';

                }
                $this->form_validation->set_rules('alevel_name', 'A level Name ', 'required|matches[olevel_name]',
                    array('matches' => $error_message)
                );
                $this->form_validation->set_rules('olevel_name', 'O level Name', 'required');

            }

   /*
            if ($entry_category == 2) {
                $this->form_validation->set_rules('form6_index', 'Form VI Index', 'required|is_unique[application.form6_index]');
            } else if ($entry_category == 3) {
                $this->form_validation->set_rules('diploma_number', 'Certificate Number', 'required');
            } else if ($entry_category == 4) {
                $this->form_validation->set_rules('diploma_number', 'Diploma Number', 'required');
            }
            */
//

            $this->form_validation->set_rules('capture', 'Capture', 'required');
            $capture = $this->session->userdata('capture_code');
            $capture2 = $this->input->post('capture');
            $required = false;
            if ($this->input->post('capture')) {
                if ($capture2 == $capture) {
                    $required = true;
                } else {
                    $required = false;
                    $this->data['message'] = show_alert('Invalid value in capture, Please enter correct value', 'warning');
                    //$this->form_validation->set_rules('capture','Capture','');
                }
            }


            if($required==true and ($entry_category==2 or $entry_category==4) )
            {

                if (trim($this->input->post('olevel_name'))!= trim($this->input->post('alevel_name'))) {
                    $required = false;
                    if($entry_category==2){
                        $this->data['message'] = show_alert('O level and A level names mismatch', 'warning');
                    }else
                    {
                        $this->data['message'] = show_alert('O level and Diploma names mismatch', 'warning');

                    }
                }

            }



            if ($this->form_validation->run() == true && ($required == true)) {

                $row_year = $this->common_model->get_academic_year(null, 1, 1)->row();
                if ($row_year) {

                    if($application_type==4)
                    {
                        $array_data_iposa = array(
                            'AYear' => $row_year->AYear,
                            'Semester' => $row_year->semester,
                            'FirstName' => ucfirst(strtolower(trim($this->input->post('txtFirstName')))),
                            'MiddleName' => ucfirst(strtolower(trim($this->input->post('txtMiddleName')))),
                            'LastName' => ucfirst(strtolower(trim($this->input->post('txtLastName')))),
                            'Gender' => trim($this->input->post('txtGender')),
                            'Disability' => trim($this->input->post('disability')),
                            'marital_status' => trim($this->input->post('txtMerritalStatus')),
                            'dob' => format_date(trim($this->input->post('txtDob'))),
                            'tribe'=> trim($this->input->post('txtTribe')),
                            'children'=> trim($this->input->post('txtChildren')),
                            'region'=> trim($this->input->post('txtRegion')),
                            'district'=>trim($this->input->post('district')),
                            'application_campus' => trim($this->input->post('application_campus')),
                            'ward'=> trim($this->input->post('txtWard')),
                            'villege'=> trim($this->input->post('txVillage')),
                            'education'=>trim($this->input->post('txEducation')),
                            'job'=> trim($this->input->post('txJob')),
                            'wanttolean'=> trim($this->input->post('txtWantToLearn')),
                            'kinname'=> trim($this->input->post('txtKinName')),
                            'kinrelation'=> trim($this->input->post('txtKinRelation')),
                            'kinmobile'=> trim($this->input->post('txtNextMobile')),
                            'mratibuname'=> trim($this->input->post('txtMratibuName')),
                            'mratibumobile'=> trim($this->input->post('txtMratibuMobile')),
                            'mratibudate'=> format_date(trim($this->input->post('txtMratibuDate'))),
                            'kituoname'=> trim($this->input->post('kituo')),
                            'registrationnumber'=>preg_replace('/\s+/', '', $this->input->post('txtRegno')),
                             'Disability'=> trim($this->input->post('txtDisability')),
//                            'kituomkuumobile'=> format_date(trim($this->input->post('txtKituoMkuuMobile'))),
                            'kituodate'=> format_date(trim($this->input->post('txtKituoDate')))
                        );
                        $required = attachment_required(    'file', 'Attachment');

                        if ($required) {
                            $filename = uploadFile($_FILES, 'file', 'attachment/');
                            $extension = getExtension($_FILES['file']['name']);
                            if (in_array($extension, array('pdf'))) {

                                $array_data_iposa['attachment']=$filename;
                                $array_data_iposa['filename']=$_FILES['file']['name'];


                            }else{
                                $this->session->set_flashdata('message', show_alert('Ambatanisha form sahihi katika mfumo wa pdf', 'danger'));

                                redirect('application_start/?type=4&CSEE=0&NT=0&entry=0', 'refresh');
                            }
                        }else{
                            //$this->session->set_flashdata('message', show_alert('Ambatanisha form sahihi', 'danger'));

                            //redirect('application_start/?type=4&CSEE=0&NT=0&entry=0', 'refresh');
                        }

                        $register_iposa = $this->applicant_model->new_applicant_iposa($array_data_iposa);

                        if ($register_iposa) {
                            $this->session->set_flashdata('message', show_alert('Ahsante Usajili wako umekamilika Tutawasiliana nawe utakapo chaguliwa  ', 'success'));

                            redirect('application_start/?type=4&CSEE=0&NT=0&entry=0', 'refresh');
                        }
                    }else{

                        if($entry_category==3) {
                            $required = attachment_required('file1', 'Attachment');

                            if ($required) {

                                $extension = getExtension($_FILES['file1']['name']);
                                if (!in_array($extension, array('pdf', 'jpg', 'jpeg', 'png'))) {
                                    $required = false;
                                    $this->data['upload_error'] = 'The Attachment field must contain file with extension .pdf , .jpg , .jpeg or .png';
                                    redirect('application_start/?type=1&CSEE=0&NT=0&entry=3', 'refresh');

                                }
                            }
                        }
                    $array_data = array(
                        'AYear' => $row_year->AYear,
                        'Semester' => $row_year->semester,
                        'application_type' => $application_type,
                        'entry_category' => $entry_category,
                        'CSEE' => $CSEE,
                        'NT' => $NT,
                        'duration' => programme_duration($application_type, $entry_category),
                        'FirstName' => ucfirst(strtolower(trim($this->input->post('firstname')))),
                        'MiddleName' => ucfirst(strtolower(trim($this->input->post('middlename')))),
                        'LastName' => ucfirst(strtolower(trim($this->input->post('lastname')))),
                        'Email' => strtolower(trim($this->input->post('email'))),
                        'Gender' => trim($this->input->post('gender')),
                        'Disability' => trim($this->input->post('disability')),
                        'Nationality' => trim($this->input->post('nationality')),
                        'birth_place' => trim($this->input->post('birth_place')),
                        'marital_status' => trim($this->input->post('marital_status')),
                        'application_campus' => trim($this->input->post('application_campus')),
                        'residence_country' => trim($this->input->post('residence_country')),
                        'dob' => format_date(trim($this->input->post('dob'))),
                        'region'=>get_value('regions',$this->input->post('region'),'name'),
                        'district'=>get_value('districts',$this->input->post('district'),'name'),
                        'primary_school' =>trim($this->input->post('primary_school')),
                        'createdon' => date('Y-m-d H:i:s'),

                    );


                    // var_dump($array_data);
                    // exit;
                        $array_data['form4_index'] = trim($this->input->post('o_level_index_no'));

//                        if($entry_category == 3)
//                        {
//
//                            $array_data['ntlevel_index']=trim($this->input->post('ntlevel_index'));
//                            $array_data['program_title']=trim($this->input->post('program_title'));
//                            $array_data['gpa']=trim($this->input->post('gpa'));
//
//                        }

                        if($entry_category == 1 || $entry_category == 2 || $entry_category == 4)
                        {
                            if( $entry_category == 2)
                            {
                                $array_data['form6_index'] = trim($this->input->post('a_level_index_no'));
                            }
                            if( $entry_category == 4)
                            {
                                $array_data['diploma_number'] = trim($this->input->post('avn'));
                            }

                        }

                        if($application_type==2)
                        {
                            $array_data['national_identification_number'] = trim($this->input->post('idnumber'));
                        }

                     
                    /* if ($entry_category == 2) {
                         $array_data['form6_index'] = trim($this->input->post('form6_index'));
                     } else if ($entry_category == 3 || $entry_category == 4) {
                         $array_data['diploma_number'] = trim($this->input->post('diploma_number'));
                     }*/
                    $username = trim($this->input->post('username'));
                    $array_data['username'] = $username;
                    $register = $this->applicant_model->new_applicant($array_data, trim($this->input->post('password')));
                    if ($register) {
                        $this->ion_auth_model->login($username, trim($this->input->post('password')), true);
                        $this->session->set_flashdata('message', show_alert('Information saved successfully, Please add Contact Information !!', 'success'));
                        redirect('applicant_contact', 'refresh');
                    } else {
                        $this->data['message'] = show_alert("Fail to save Information, Please try again !!", 'info');
                    }
                }
                } else {
                    $this->data['message'] = show_alert("Configuration not set, Please use " . anchor(site_url('contact'), 'this link', 'style="color:red; text-decoration:underline;"') . "  to report", 'info');
                }
            } else {
                $captcha_num = '1234567890';
                $captcha_num = substr(str_shuffle($captcha_num), 0, 6);
                $this->session->set_userdata('capture_code', $captcha_num);
                $this->data['captcha_num'] = $captcha_num;
            }

            $this->data['campus'] = $this->common_model->get_campus()->result();
            $this->data['gender_list'] = $this->common_model->get_gender()->result();
            $this->data['disability_list'] = $this->common_model->get_disability()->result();
            $this->data['nationality_list'] = $this->common_model->get_nationality()->result();
            $this->data['marital_status_list'] = $this->common_model->get_marital_status()->result();
            $this->data['regions'] = $this->common_model->get_regions()->result();
            $this->data['districts'] = $this->common_model->get_districts()->result();
            $this->data['vituo_list'] = $this->db->query("select * from iposa_vituo")->result();

            $this->data['content'] = 'home/application_start';
            $this->load->view('public_template', $this->data);
        } else {
            redirect('application_start', 'refresh');
        }
    }


    function capture($code)
    {
//        $captcha_num = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        //      $captcha_num = substr(str_shuffle($captcha_num), 0, 6);
        $captcha_num = $code;
        //$_SESSION['capture_code']=$captcha_num;
        $font_size = 20;
        $img_width = 300;
        $img_height = 50;

        header('Content-type: image/jpeg');
        $image = imagecreate($img_width, $img_height); // create background image with dimensions
        imagecolorallocate($image, 255, 255, 255); // set background color
        $text_color = imagecolorallocate($image, 0, 0, 0); // set captcha text color
        imagettftext($image, $font_size, 0, 15, 30, $text_color, './media/NIT.ttf', $captcha_num);
        imagejpeg($image);

    }


    function recommendation()
    {
        if (isset($_GET) && isset($_GET['key']) && isset($_GET['referee_id']) && isset($_GET['code'])) {
            $applicant_id = decode_id($_GET['key']);
            $referee_id = decode_id($_GET['referee_id']);
            $rec_code = $_GET['code'];
            $applicant_info = $this->data['APPLICANT'] = $this->db->where('id', $applicant_id)->get('application')->row();
            $referee_info = $this->data['REFEREE'] = $this->db->where('id', $referee_id)->get('application_referee')->row();
            if ($applicant_info && $referee_info && $applicant_info->id == $referee_info->applicant_id && $rec_code == $referee_info->rec_code) {
                $this->data['recommendation_area'] = $recommendation_area= $this->common_model->get_recommendation_area()->result();

                $this->form_validation->set_rules('recommend_overall', 'above', 'required');
                $this->form_validation->set_rules('applicant_known', 'above', 'required');
                $this->form_validation->set_rules('weakness', 'above', 'required');
                $this->form_validation->set_rules('description_for_qn3', 'above', 'required');
                $this->form_validation->set_rules('other_degree', 'above', 'required');
                $this->form_validation->set_rules('producing_org_work', 'above', 'required');
                 $recommendation_area_value = array();
                foreach ($recommendation_area as $rec_key => $rec_value) {
                    $this->form_validation->set_rules('recommend_'.$rec_value->id, $rec_value->name, 'required');
                    $recommendation_area_value[$rec_value->id] = trim($this->input->post('recommend_'.$rec_value->id));
                }

                if ($this->form_validation->run() == true) {
                    $array = array(
                        'applicant_id'=>$applicant_id,
                        'referee_id' =>$referee_id,
                        'recommend_overall'=>trim($this->input->post('recommend_overall')),
                        'applicant_known'=>trim($this->input->post('applicant_known')),
                        'description_for_qn3'=>trim($this->input->post('description_for_qn3')),
                        'weakness'=>trim($this->input->post('weakness')),
                        'other_degree'=>trim($this->input->post('other_degree')),
                        'producing_org_work'=>trim($this->input->post('producing_org_work')),
                        'other_capability'=>trim($this->input->post('other_capability')),
                        'anything'=>trim($this->input->post('anything')),
                        'recommendation_arrea'=>json_encode($recommendation_area_value)
                    );

                     $record_recommendation = $this->applicant_model->record_referee_recomendation($array);
                     if($record_recommendation){
    $this->session->set_flashdata('message',show_alert('Recommendation saved successfully','success'));
                         redirect(current_full_url(),'refresh');
                     }else{
                         $this->data['message'] = show_alert('Fail to save recomendation, Please try again later','warning');
                     }

                }


             $row_data = $this->applicant_model->get_referee_recomendation($applicant_id,$referee_id)->row();
                if($row_data){
                    $this->data['recommendation_info'] = $row_data;
                }


                $this->data['allowed'] = 1;
            } else {
                $this->data['allowed'] = 0;
            }
        } else {
            $this->data['allowed'] = 0;
        }

        $this->data['applicant_dashboard'] = 'applicant_dashboard';
        $this->data['content'] = 'home/recommendation';
        $this->load->view('public_template', $this->data);
    }

    function loadEducationData()
    {

        $action = trim($this->input->post('action'));
        if($action=='o-level')
        {
            $completed_year="";
            $target=trim($this->input->post('target'));
            $o_index_number=trim($this->input->post('id'));
            $where_array=array('index_number'=>$o_index_number,'api_status'=>1);
            $education_row = $this->db->where($where_array)->get('application_education_authority')->row();
            $check_equivalent = substr($o_index_number, 0,2);
            if($education_row)
            {
                $response=$education_row->response;
                $completed_year=$education_row->completed_year;
                $responsedata =  json_decode($response);
                $full_name=$responsedata->particulars->first_name.$responsedata->particulars->last_name;
                echo $responsedata->particulars->first_name.'_'.$responsedata->particulars->last_name.'_'.$responsedata->particulars->middle_name.'_'.$completed_year.'_'.$full_name;
            }else{
                if($check_equivalent=="EQ" and $target=='') {
                    echo "EQ";
                    exit;
                }elseif($target!=''){
                    $completed_year=$target;

                }
                //$this->curl->create(NECTA_API . 'auth/' . NECTA_KEY);
               // $this->curl->options(
                 //  array(
                  //      CURLOPT_RETURNTRANSFER => 1,
                  //      CURLOPT_SSL_VERIFYPEER=>0
                //    )
                //);
                $response_token = 'xxxxx';
                if ($response_token) {
                    if($check_equivalent=="EQ")
                    {
                        $index_number=$o_index_number;

                    }else{
                        $index_number_tmp = explode('/', $o_index_number);
                        $index_number = $index_number_tmp[0] . '-' . $index_number_tmp[1];
                        $completed_year=$index_number_tmp[2];
                    }

                   // $responsedata_key = json_decode($response_token);
                  //  $this->curl->create(NECTA_API . 'results/' . $index_number . '/1/' . $completed_year . '/' . $responsedata_key->token);

                  //  $this->curl->options(
                   //     array(
                   //        CURLOPT_RETURNTRANSFER => 1,
                     //       CURLOPT_SSL_VERIFYPEER=>0
                     //   )
                   // );
                   // $response = $this->curl->execute();
                   
                   
                       $data = array(
                        'index_number' => $index_number ,
                        'exam_year' => $completed_year,
                        'exam_id' => 1 ,
                        'api_key' => NECTA_KEY
                    );
                    $payload = json_encode($data);
                    // Prepare new cURL resource
                    $ch = curl_init(NECTA_API);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                    // Set HTTP Header for POST request 
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($payload))
                    );
                    // Submit the POST request
                    $response = curl_exec($ch);
                    // Close cURL session handle
                    curl_close($ch);
                                           if ($response) {
                        $responsedata = json_decode($response);
                        if ($responsedata->status->code == 1) {
                            $full_name=$responsedata->particulars->first_name.$responsedata->particulars->last_name;
                            echo $responsedata->particulars->first_name . '_' . $responsedata->particulars->last_name . '_' . $responsedata->particulars->middle_name.'_'.$completed_year.'_'.$full_name;
                            $data = array(
                                'certificate' => 1,
                                'exam_authority' => 'NECTA',
                                'index_number' => $o_index_number,
                                'applicant_id' => 0,
                                'response' => $response,
                                'center_number' => $responsedata->particulars->center_number,
                                'school' => $responsedata->particulars->center_name,
                                'division' => $responsedata->results->division->division,
                                'country' =>220,
                                'division_point' => $responsedata->results->division->points,
                                'api_status' => 1,
                                'createdby' => 0,
                                'comment' => 'Success',
                                'createdon' => date('Y-m-d H:i:s'),
                                'completed_year' => $index_number_tmp[2],
                                'hide'=>1
                            );
                            $check_if_exist = $this->db->where('index_number',$o_index_number)->get('application_education_authority')->row();
                            if($check_if_exist)
                            {
                                $data = array(
                                    'response' => $response,
                                    'api_status' => 1,
                                    'comment' => 'Success',
                                    'hide'=>1
                                );

                                $this->db->update('application_education_authority', $data, array('index_number'=>trim($o_index_number)));
                            }else {
                                $this->db->insert("application_education_authority", $data);
                            }
                        }else
                        {

                            echo $responsedata->status->message;

//                            $this->curl->create(NECTA_API . 'particulars/' . $index_number . '/1/' . $completed_year . '/' . $responsedata_key->token);
//                            $this->curl->options(
//                                array(
//                                    CURLOPT_RETURNTRANSFER => 1,
//                                    CURLOPT_SSL_VERIFYPEER=>0
//                                )
//                            );
//                            $response = $this->curl->execute();
//                            $responsedata = json_decode($response);
//                            if ($responsedata->status->code == 1) {
//                                $full_name=$responsedata->particulars->first_name.$responsedata->particulars->last_name;
//                                echo $responsedata->particulars->first_name . '_' . $responsedata->particulars->last_name . '_' . $responsedata->particulars->middle_name.'_'.$completed_year.'_'.$full_name;
//
//                                //okay
//                            }

                        }
                    }
                }

            }

        }elseif($action=='a-level'){
            $completed_year="";
            $target=trim($this->input->post('target'));
            $a_index_number=trim($this->input->post('id'));
            $where_array=array('index_number'=>$a_index_number,'api_status'=>1);
            $education_row = $this->db->where($where_array)->get('application_education_authority')->row();
            $check_equivalent = substr($a_index_number, 0,2);
            if($education_row)
            {
                $response=$education_row->response;
                $responsedata =  json_decode($response);
                $full_name=$responsedata->particulars->first_name.$responsedata->particulars->last_name;
                if($check_equivalent=="EQ")
                {
                    echo 'EQUIVALENT'.'_'.$full_name.'_'.$education_row->completed_year;
                }else
                echo $responsedata->particulars->center_name.'_'.$full_name.'_'.$education_row->completed_year;
            }else{
                if($check_equivalent=="EQ" and $target=='') {
                    echo "EQ";
                    exit;
                }elseif($target!='' and $check_equivalent=="EQ"){
                    $completed_year=$target;

                }

                $this->curl->create(NECTA_API . 'auth/' . NECTA_KEY);
                $this->curl->options(
                    array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_SSL_VERIFYPEER=>0
                    )
                );
                $response_token = $this->curl->execute();

                if ($response_token) {

                    if($check_equivalent=="EQ")
                    {
                        $index_number=$a_index_number;

                    }else{
                        $index_number_tmp = explode('/', $a_index_number);
                        $index_number = $index_number_tmp[0] . '-' . $index_number_tmp[1];
                        $completed_year=$index_number_tmp[2];
                    }


                    $responsedata_key = json_decode($response_token);
                    $this->curl->create(NECTA_API . 'results/' . $index_number . '/2/' . $completed_year . '/' . $responsedata_key->token);
                    $this->curl->options(
                        array(
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_SSL_VERIFYPEER=>0
                        )
                    );
                    $response = $this->curl->execute();
                    if ($response) {
                        $responsedata = json_decode($response);
                        if ($responsedata->status->code == 1) {
                            $full_name=$responsedata->particulars->first_name.$responsedata->particulars->last_name;
                            if($check_equivalent=="EQ")
                            {
                                echo 'EQUIVALENT'.'_'.$full_name.'_'.$completed_year;
                            }else
                                echo $responsedata->particulars->center_name.'_'.$full_name.'_'.$completed_year;
                            $data = array(
                                'certificate' => 2,
                                'exam_authority' => 'NECTA',
                                'index_number' => $a_index_number,
                                'applicant_id' => 0,
                                'response' => $response,
                                'center_number' => $responsedata->particulars->center_number,
                                'school' => $responsedata->particulars->center_name,
                                'division' => $responsedata->results->division->division,
                                'country' => 220,
                                'division_point' => $responsedata->results->division->points,
                                'api_status' => 1,
                                'createdby' => 0,
                                'comment' => 'Success',
                                'createdon' => date('Y-m-d H:i:s'),
                                'completed_year' => $index_number_tmp[2],
                                'hide'=>1
                            );

                            $check_if_exist = $this->db->where('index_number',$a_index_number)->get('application_education_authority')->row();
                            if($check_if_exist)
                            {
                                $data = array(
                                    'response' => $response,
                                    'api_status' => 1,
                                    'comment' => 'Success',
                                    'hide'=>1
                                );
                                $this->db->update('application_education_authority', $data, array('index_number'=>$a_index_number));

                            }else {
                                $this->db->insert("application_education_authority", $data);
                            }
                        }else{
                            echo $responsedata->status->message;

//                            $this->curl->create(NECTA_API . 'particulars/' . $index_number . '/2/' . $completed_year . '/' . $responsedata_key->token);
//
//                            $response = $this->curl->execute();
//                            $responsedata = json_decode($response);
//                            if ($responsedata->status->code == 1) {
//                                $full_name=$responsedata->particulars->first_name.$responsedata->particulars->last_name;
//                                if($check_equivalent=="EQ")
//                                {
//                                    echo"EQUIVALENT_".$full_name.'_'.$completed_year;
//                                }else
//                                    echo $responsedata->particulars->center_name.'_'.$full_name.'_'.$completed_year;
//                                //okay
//                            }
                        }

                    }
                }

            }


        }elseif($action=='avn')
        {
            //
            $avn=trim($this->input->post('id'));
            $where_array=array('avn'=>$avn,'api_status'=>1);
            $education_row = $this->db->where($where_array)->get('application_education_authority')->row();
            if($education_row)
            {
                $response=$education_row->response;
                $responsedata =  json_decode($response);
                $full_name=$responsedata->params[0]->firstname.$responsedata->params[0]->surname;
                echo $responsedata->params[0]->institution.'_'.$full_name;
            }else{
                $this->curl->create(NACTE_API . NACTE_API_KEY . '/' . NACTE_TOKEN . '/' . NACTE_API_EXTRA . '/' . $avn);
                $response = $this->curl->execute();
                if ($response) {
                    $responsedata = json_decode($response);
                    if ($responsedata->status->code == 200)  {
                        $full_name=$responsedata->params[0]->firstname.$responsedata->params[0]->surname;
                        echo $responsedata->params[0]->institution.'_'.$full_name;
                        $data = array(
                            'certificate' => 4,
                            'exam_authority' => "NACTE",
                            'applicant_id' => 0,
                            'school' => $responsedata->params[0]->institution,
                            'division' => $responsedata->params[0]->diploma_gpa,
                            'country' =>220,
                            'index_number' => $responsedata->params[0]->registration_number,
                            'createdby' => 0,
                            'createdon' => date('Y-m-d H:i:s'),
                            'programme_title' => $responsedata->params[0]->programme,
                            'programme_category' => $responsedata->params[0]->diploma_category,
                            'completed_year' => $responsedata->params[0]->diploma_graduation_year,
                            'avn'=>$avn,
                            'response'=>$response,
                            'center_number' => '',
                            'diploma_code' => $responsedata->params[0]->diploma_code,
                            'division_point' => '',
                            'api_status' => 1,
                            'comment' => 'Success',
                            'hide'=>1
                        );
                        $check_if_exist = $this->db->where('avn',$avn)->get('application_education_authority')->row();
                        if($check_if_exist)
                        {
                            $data = array(
                                'response' => $response,
                                'api_status' => 1,
                                'comment' => 'Success',
                                'hide'=>1
                            );
                            $this->db->update('application_education_authority', $data, array('avn' => $avn));

                        }else{
                            $this->db->insert("application_education_authority", $data);
                        }
                    }

                }


            }



        }if($action == 'nt')
        {
            //Education Title Array
            $education_programme_array=array(
                '10'=>"Grade A  Teachers Certificate Examination (GATCE)",
                '12'=>"GRADE A TEACHER SPECIAL COURSE CERTIFICATE  (GATSCC)",
                '14'=>"DIPLOMA IN SECONDARY EDUCATION"
            );

            $completed_year="";
            $exam_id=trim($this->input->post('target'));
            $nt_index_number=trim($this->input->post('id'));
            $where_array=array('index_number'=>$nt_index_number,'api_status'=>1);
            $education_row = $this->db->where($where_array)->get('application_education_authority')->row();
            if($education_row)
            {
                $response=$education_row->response;
                $completed_year=$education_row->completed_year;
                $responsedata =  json_decode($response);
                echo $responsedata->particulars->center_name.'_'.$responsedata->results->division->points.'_'.$completed_year;
            }else{

                $this->curl->create(NECTA_API . 'auth/' . NECTA_KEY);
                $this->curl->options(
                    array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_SSL_VERIFYPEER=>0
                    )
                );
                $response_token = $this->curl->execute();
                if ($response_token) {
                    $index_number_tmp = explode('/', $nt_index_number);
                    $index_number = $index_number_tmp[0] . '-' . $index_number_tmp[1];
                    $completed_year=$index_number_tmp[2];
                    $responsedata_key = json_decode($response_token);
                    $this->curl->create(NECTA_API . 'results/' . $index_number . '/'.$exam_id.'/' . $completed_year . '/' . $responsedata_key->token);
                    $this->curl->options(
                        array(
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_SSL_VERIFYPEER=>0
                        )
                    );
                    $response = $this->curl->execute();
                    if ($response) {
                        $responsedata = json_decode($response);
                        if ($responsedata->status->code == 1) {
                            echo $responsedata->particulars->center_name . '_' . $responsedata->results->division->points . '_' . $completed_year;
                            $data = array(
                                'certificate' => 3,
                                'exam_authority' => 'NECTA',
                                'index_number' => $nt_index_number,
                                'applicant_id' => 0,
                                'response' => $response,
                                'center_number' => $responsedata->particulars->center_number,
                                'school' => $responsedata->particulars->center_name,
                                'division' => $responsedata->results->division->division,
                                'country' =>220,
                                'division_point' => $responsedata->results->division->points,
                                'api_status' => 1,
                                'createdby' => 0,
                                'comment' => 'Success',
                                'createdon' => date('Y-m-d H:i:s'),
                                'completed_year' => $index_number_tmp[2],
                                'hide'=>1,
                                'programme_title'=>$education_programme_array[$exam_id]
                            );
                            $check_if_exist = $this->db->where('index_number',$o_index_number)->get('application_education_authority')->row();
                            if($check_if_exist)
                            {
                                $data = array(
                                    'response' => $response,
                                    'api_status' => 1,
                                    'comment' => 'Success',
                                    'hide'=>1
                                );

                                $this->db->update('application_education_authority', $data, array('index_number'=>trim($o_index_number)));
                            }else {
                                $this->db->insert("application_education_authority", $data);
                            }
                        }else
                        {

                            echo $responsedata->status->message;


                        }
                    }
                }

            }

        }



    }



    function TestApplicant_status()
    {
        $o_index_number="S1186/0028/2009";
        //$o_index_number="P4007/0507/2020";
        $index="P5077/0088/2018";

        $xml=CheckSingleApplicantStatusRequest(TCU_USERNAME,TCU_TOKEN,$index);

        $url=TCU_DOMAIN."/applicants/checkStatus";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string( $responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array);
        echo"description=".$array['StatusDescription'];
        echo"<br/><br/>";
        print_r($responce);
        exit;
    }

    function TestAddApplicant()
    {

       $f4index="S5097/0020/2017";
       $f6index="S0526/0618/2020";
       $category="A";
       $other_f6="";
       $other_f4="";
       $xml=AddApplicantRequest(TCU_USERNAME,TCU_TOKEN,$f4index,$f6index,$category,$other_f4,$other_f6);
       $url=TCU_DOMAIN."/applicants/add";
       $responce=sendXmlOverPost($url,$xml);
       $responce2=$responce;

       //print_r($responce);

        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce2);
        echo"this is json=".$json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array);
        echo"description=".$array['Response']['ResponseParameters']['StatusDescription'];
        echo"<br/><br/>";
        print_r($responce);
        exit;

    }

    function TestAddApplicantProgramChoice()
    {

        $f4index="S4002/0138/2010";
        $f6index="19NA1023888ME";
        $category="D";
        $other_f6="";
        $other_f4="";
        $selected_program='UD023, UD038, UD022';
        $mobilenumber='0712677004';
        $othermobilenumber='0785469198';
        $email='mudi_sam@yahoo.com';
        $category='A';
        $admission_status='provisional admission';
        $program_admited='UD038';
        $reason='eligible';
        $nationality='Tanzanian';
        $impairment='none';
        $dob='1981-03-04';
        $xml=SubmitApplicantProgramChoicesRequest(TCU_USERNAME,TCU_TOKEN,$f4index,$f6index,$selected_program,
            $mobilenumber,$othermobilenumber,$email,$category,$admission_status,$program_admited,$reason,$nationality,$impairment,
            $dob,$other_f4,$other_f6);
        $url=TCU_DOMAIN."/applicants/add";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);

        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        echo"description=".$array['StatusDescription'];
        echo"<br/><br/>";
        print_r($responce);
        exit;
    }
    function TestResubmitApplicantDetails()
    {

        $f4index="S0738/0032/2002";
        $f6index="S0137/1000/2005";
        $category="A";
        $other_f6="";
        $other_f4="";
        $selected_program='UD023, UD038, UD022';
        $mobilenumber='0712677004';
        $othermobilenumber='0785469198';
        $email='mudi_sam@yahoo.com';
        $category='A';
        $admission_status='provisional admission';
        $program_admited='UD038';
        $reason='eligible';
        $nationality='Tanzanian';
        $impairment='none';
        $dob='1981-03-04';
        $xml=ResubmitApplicantDetailsRequest(TCU_USERNAME,TCU_TOKEN,$f4index,$f6index,$selected_program,
            $mobilenumber,$othermobilenumber,$email,$category,$admission_status,$program_admited,$reason,$nationality,$impairment,
            $dob,$other_f4,$other_f6);
        $url=TCU_DOMAIN."/applicants/resubmit";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);

        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        echo"description=".$array['StatusDescription'];
        echo"<br/><br/>";
        print_r($responce);
        exit;
    }


    function TestComfirmApplication()
    {

        $f4index="S0738/0032/2002";
        $code='A5267Y';
        echo $xml=ConfirmApplicationRequest(TCU_USERNAME,TCU_TOKEN,$f4index,$code);
        $url=TCU_DOMAIN."/admission/confirm";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);

        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        echo"description=".$array['StatusDescription'];
        echo"<br/><br/>";
        print_r($responce);
        exit;
    }

    function TestGetAdmitedApplicant()
    {

        $f4index="S0738/0032/2002";
        $code='A5267Y';
        echo $xml=GetAdmittedApplicantRequest(TCU_USERNAME,TCU_TOKEN,'DM023');
        $url=TCU_DOMAIN."/admission/getAdmitted";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        echo"description=".$array['StatusDescription'];
        echo"<br/><br/>";
        print_r($responce);
        exit;
    }

    function TestGetComfirmedApplicant()
    {

        $f4index="S0738/0032/2002";
        $code='A5267Y';
        echo $xml=GetListOfConfirmedApplicantsRequest(TCU_USERNAME,TCU_TOKEN,'DM023');
        $url=TCU_DOMAIN."/applicants/getConfirmed";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        echo"description=".$array['StatusDescription'];
        echo"<br/><br/>";
        print_r($responce);
        exit;
    }

    function TestRejectAdmission()
    {

        $f4index="S0738/0032/2002";

        echo $xml=RejectAdmissionRequest(TCU_USERNAME,TCU_TOKEN,$f4index);
        $url=TCU_DOMAIN."/admission/reject";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        echo"description=".$array['StatusDescription'];
        echo"<br/><br/>";
        print_r($responce);
        exit;
    }

    function TestPopulateDashBoard()
    {

        $f4index="S0738/0032/2002";
        $program='DM038';
        $male=45;
        $female=60;
        echo $xml=PopulateDashboardRequest(TCU_USERNAME,TCU_TOKEN,$program,$male,$female);
        $url=TCU_DOMAIN."/dashboard/populate";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        echo"description=".$array['StatusDescription'];
        echo"<br/><br/>";
        print_r($responce);
        exit;
    }
    function TestGetProgramWithAdmitedApplicant()
    {

        $f4index="S0738/0032/2002";
        $program='DM038';
        $male=45;
        $female=60;
        $xml=GetProgrammesWithAdmittedCandidatesRequest(TCU_USERNAME,TCU_TOKEN);
        $url=TCU_DOMAIN."/admission/getProgrammes";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array['Programme']);
        //echo"description=".$array['StatusDescription'];
       // echo"<br/><br/>";
       // print_r($responce);
        exit;
    }

    function TestGetApplicantAdmissionStatus()
    {

        $f4index="S0738/0032/2002";
        $program='DM038';
        $male=45;
        $female=60;
        $xml=GetApplicantsAdmissionStatusRequest(TCU_USERNAME,TCU_TOKEN,$program);
        $url=TCU_DOMAIN."/applicants/getStatus";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
         $responce=RetunMessageString($responce,'ResponseParameters');

        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array);
        echo"description=".$array['StatusDescription'];
        // echo"<br/><br/>";
        // print_r($responce);
        exit;
    }
    function TestGetComfirmationCode()
    {

        $f4index="S0743/0049/2008";
        $program='DM038';
        $male=45;
        $female=60;
        $xml=GetApplicantComfirmationCodeRequest(TCU_USERNAME,TCU_TOKEN,$f4index,'0712677004');
        $url=TCU_DOMAIN."/admission/requestConfirmationCode";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');

        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array);
        echo"description=".$array['StatusDescription'];
        // echo"<br/><br/>";
        // print_r($responce);
        exit;
    }

    function TestSubmitInternalTransferRequest()
    {

        $f4index="S0738/0032/2002";
        $f6index="S0137/1000/2005";
        $prev_pro='DM001';
        $cur_pro="DM002";
        $xml=SubmitInternalTransferRequest(TCU_USERNAME,TCU_TOKEN,$f4index,$f6index,$prev_pro,$cur_pro);
        $url=TCU_DOMAIN."/admission/submitInternalTransfers";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array);
        echo"description=".$array['StatusDescription'];
        // echo"<br/><br/>";
        // print_r($responce);
        exit;
    }

    function TestSubmitInterInstitutionalTransferRequest()
    {

        $f4index="S0738/0032/2002";
        $f6index="S0137/1000/2005";
        $prev_pro='DM001';
        $cur_pro="DM002";
        $xml=SubmitInterIstitutionalTransferRequest(TCU_USERNAME,TCU_TOKEN,$f4index,$f6index,$prev_pro,$cur_pro);
        $url=TCU_DOMAIN."/admission/submitInterInstitutionalTransfers";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array);
        echo"description=".$array['StatusDescription'];
        // echo"<br/><br/>";
        // print_r($responce);
        exit;
    }

    function TestGetApplicantVerificationStatus()
    {
        $program='DM001';
        $xml=GetApplicantVerificationStatus(TCU_USERNAME,TCU_TOKEN,$program);
        $url=TCU_DOMAIN."/applicants/getApplicantVerificationStatus";
        $responce=sendXmlOverPost($url,$xml);
        print_r($responce);
        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        print_r($array);
        echo"description=".$array['StatusDescription'];
        // echo"<br/><br/>";
        // print_r($responce);
        exit;
    }

    function TestWhere($id)
    {
        $where_array=array(
            'id'=>$id,
            'status !='=>1
        );

        $data=array(
            'fullname'=>"Msingwa",
            'status'=>1
        );

        $this->db->where($where_array);
        $this->db->update('testing',$data);
    }


    function SubmitAllToTCU_ON_Background()
    {
        execInBackground("home SubmitAllToTCU");
        echo "successfully";
    }
    function SubmitAllToTCU()
    {
        $ayear = $this->common_model->get_academic_year()->row()->AYear;
        $submited_applicants=$this->db->query("select * from application inner join tcu_records on tcu_records.applicant_id=application.id where application.submitted=1 and application.AYear='$ayear' and application_type=2 and tcu_records.status<>200 ")->result();
        if($submited_applicants){

            foreach ($submited_applicants as $key=>$value)
            {
                $applicant_id=$value->id;
                $tcu_records=$this->db->query("select * from tcu_records  where  	applicant_id='".$applicant_id."'")->row();

                if($tcu_records)
                {
                    if($tcu_records->error_code==200 or $tcu_records->error_code==208)
                    {
                        continue;
                    }
                }
                if($value->entry_category==2)
                {
                    $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' =>$applicant_id, 'certificate' => 1))->row()->index_number;
                    $f6indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $applicant_id, 'certificate' => 2))->row()->index_number;
                    $entry_category = "A";
                }elseif($value->entry_category==4)
                {
                    $f4indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $applicant_id, 'certificate' => 1))->row()->index_number;
                    $f6indexno = $this->db->get_where('application_education_authority', array('applicant_id' => $applicant_id, 'certificate' => 4))->row()->avn;
                    $entry_category = "D";
                }

                $xml_data = AddApplicantRequest(TCU_USERNAME, TCU_TOKEN, $f4indexno, $f6indexno, $entry_category, '', '');
                $Response = sendXmlOverPost('http://api.tcu.go.tz/applicants/add', $xml_data);
                echo $Response_orign= $Response;
                $Response=RetunMessageString($Response,'ResponseParameters');
                $data = simplexml_load_string($Response);
                $json = json_encode($data);
                $json2 = json_encode(simplexml_load_string($Response_orign));
                $array = json_decode($json,TRUE);

                $error_code = $array['StatusCode'];
                $f4index = $f4indexno;
                $status = $array['StatusCode'];
                $description = $array['StatusDescription'];
                $date = date('Y-m-d H:i:s');
                if ($status == 200 || $status == 208) {
                    $request_status = 1;
                    $tcu_status=$this->db->query("update application set tcu_status=1,tcu_status_description='Registered' where id=". $applicant_id);
                } else {
                    $request_status = 0;
                }

                /* $result = str_replace(array("\n", "\r", "\t"), '', $Response);
                 $xml = simplexml_load_string($result);
                 $object = new stdclass();
                 $object = $xml;*/
                //$response_result = json_encode($object);
                $insert = $this->db->query("insert into tcu_records values('','" .$applicant_id . "','Add','$error_code','$f4index','$status','$description','$request_status','$xml_data','$json2','$date')");
                if ($insert) {
                    if($request_status == 1)
                    {
                        $datatoupdate = array(
                            'response' => 1,
                        );
                        $this->db->where('id', $applicant_id);
                        $this->db->update('application', $datatoupdate);
                    }


                }

            }
        }

    }




    function  CheckAVN()
    {
        $avn="17NA11880KE";
        $this->curl->create(NACTE_API . NACTE_API_KEY . '/' . NACTE_TOKEN . '/' . NACTE_API_EXTRA . '/' . $avn);
        echo $response = $this->curl->execute();
    }




    function LoadFeeBYNTALevel()
    {
        $category = trim($this->input->post('category'));
        $ntlevel = trim($this->input->post('ntlevel'));
        $feeinfo=$this->db->query("select * from fee_structure where fee_category='$category' and ntlevel=1 and ntlevel_value='$ntlevel'")->row();
        if($feeinfo){
            $amount=$feeinfo->amount;

            if($category==4)
            {
                $tuitionfee_amount=$this->db->query("select * from fee_structure where fee_category=2 and ntlevel=1 and ntlevel_value='$ntlevel'")->row();
                if($tuitionfee_amount->id)
                {
                    $amount=(0.5* $tuitionfee_amount->amount);
                }

            }

            echo $amount."_".$feeinfo->percentage."_".$feeinfo->parcentage_value.'_'.$feeinfo->carryover_quality_assurance_value;
        }

    }



    function student_invoices()
    {
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

                    if($invoice_info->status==0) {
                        $refference=$ega_auth->prefix.$invoice_id;
                        $fee_type=$invoice_info->type;
                        $invoice_student_info=$this->db->query("select * from application where id=".$invoice_info->student_id)->row();
                        $student_name=$invoice_student_info->FirstName. ''.$invoice_student_info->MiddleName. ''.$invoice_student_info->LastName;
                        $student_email=$invoice_student_info->Email;
                        $postdata = array(
                            "customer" => $ega_auth->username,
                            "reference" => $ega_auth->prefix.$invoice_id,
                            "student_name" =>$student_name,
                            "student_id" => $invoice_student_info->id,
                            "student_email"=>$student_email,
                            "student_mobile"=>$invoice_student_info->Mobile1,
                            "GfsCode"=>GetFeeTypeDetails(2)->gfscode,
                            "amount"=>$invoice_info->amount,
                            "type"=>GetFeeTypeDetails(2)->name,
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
                redirect(site_url('student_invoices/'),'refresh');
            }else
            {
                $this->session->set_flashdata("message", show_alert("Please select at  list one invoice", 'danger'));
                redirect(site_url('student_invoices/'),'refresh');
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
                redirect(site_url('student_invoices/'),'refresh');
            }else
            {
                $this->session->set_flashdata("message", show_alert("Please select at  list one invoice", 'danger'));
                redirect(site_url('student_invoices/'),'refresh');
            }

        }


        $where = ' WHERE student_id="'.$_GET['regno'].'" and status<>2 ';


        $sql = " SELECT * FROM invoices  $where ";

        $sql2 = "SELECT count(id) as counter FROM invoices $where ";

        $config["base_url"] = site_url('student_invoices/');

        $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
        if (count($_GET) > 0)
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");


        $config["total_rows"] = $this->db->query($sql2)->row()->counter;
        $config["per_page"] = 50;
        $config["uri_segment"] = 2;


        $this->data['invoice_list'] = $this->db->query($sql . " ORDER BY invoices.id DESC")->result();

        $this->data['bscrum'][] = array('link' => '#', 'title' => 'Member');
        $this->data['bscrum'][] = array('link' => 'student_invoices/', 'title' => 'Invoice List');


        $this->data['middle_content'] = 'home/invoicelist2';
        $this->data['sub_link'] = 'invoicelist';
        $this->data['content'] = 'home/home2';
        $this->load->view('public_template_student', $this->data);
    }



    function print_student_receipt($id)
    {
    
    
        if (isset($_GET['receipt_no'])) {
            $id = $_GET['receipt_no'];
          
            $payment = $this->db->query("SELECT payment.*,student_name,type,name, fee_name FROM payment LEFT JOIN invoices ON invoices.control_number=payment.control_number LEFT JOIN fee_structure ON fee_structure.id=invoices.fee_id  WHERE payment.ega_refference='" . $id . "'")->row();
        } elseif (isset($_GET['regno'])) {
                $id = decode_id($id);
             
                $payment = $this->db->query("SELECT payment.*,student_name,type, name, fee_name FROM payment LEFT JOIN invoices ON invoices.id=payment.invoice_number LEFT JOIN fee_structure ON fee_structure.id=invoices.fee_id WHERE payment.id=" . $id)->row();
    
            }
    
    //        if($payment)
    //            $invoice=$this->db->query("select * from invoices where control_number=".$payment->control_number)->row();
        // $user=current_user();
    
        // echo $APPLICANT->user_id;exit;
        if ($payment) {
            include_once 'report/print_receipt.php';
        } else {
            $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
            $current_user_group = get_user_group();
            if ($current_user_group->id == 4) {
                redirect(site_url('dashboard'), 'refresh');
            } else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }
    
        function print_student_invoice($id)
        {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            } else {
                $id = decode_id($id);
            }
            $invoice = $this->db->query("SELECT invoices.*,name FROM invoices LEFT JOIN fee_structure ON fee_structure.id=invoices.fee_id where invoices.id='" . $id . "'")->row();
            $ega_auth = $this->db->query("select * from ega_auth")->row();
            //$user=current_user();
    
            $payer = $this->db->query("select * from application where id='" . $invoice->student_id . "'")->row();
            // echo $APPLICANT->user_id;exit;
            if ($invoice) {
                include_once 'report/print_invoice2.php';
            } else {
                $this->session->set_flashdata('message', show_alert('This request did not pass our security checks.', 'info'));
                $current_user_group = get_user_group();
                if ($current_user_group->id == 4) {
                    redirect(site_url('applicant_dashboard'), 'refresh');
                } else {
                    redirect(site_url('dashboard'), 'refresh');
                }
            }
        }


//     function print_student_receipt($id){


//         if(isset($_GET['receipt_no'])) {
//             $id=$_GET['receipt_no'];
//             // $payment=$this->db->query("select payment.*,student_name,type from payment left join invoices on invoices.id=payment.invoice_number where payment.ega_refference='".$id."'")->row();
//         }else
//         if(isset($_GET['regno']))
//         {
//             $id = decode_id($id);
//             // $payment=$this->db->query("select payment.*,student_name,type from payment left join invoices on invoices.id=payment.invoice_number where payment.id=".$id)->row();

//         }

// //        if($payment)
// //            $invoice=$this->db->query("select * from invoices where control_number=".$payment->control_number)->row();
//         // $user=current_user();

//         // echo $APPLICANT->user_id;exit;
//         if($payment ) {
//             include_once 'report/print_receipt.php';
//         }else{
//             $this->session->set_flashdata('message',show_alert('This request did not pass our security checks.','info'));
//             $current_user_group = get_user_group();
//             if($current_user_group->id == 4){
//                 redirect(site_url('dashboard'), 'refresh');
//             }else {
//                 redirect(site_url('dashboard'), 'refresh');
//             }
//         }
//     }

//     function print_student_invoice($id){
//         if(isset($_GET['id']))
//         {
//             $id=$_GET['id'];
//         }else{
//             $id = decode_id($id);
//         }
//         $invoice=$this->db->query("select * from invoices where id='".$id."'")->row();
//         $ega_auth=$this->db->query("select * from ega_auth")->row();
//         //$user=current_user();

//         $payer = $this->db->query("select * from application where id='".$invoice->student_id."'")->row();
//         // echo $APPLICANT->user_id;exit;
//         if($invoice) {
//             include_once 'report/print_invoice2.php';
//         }else{
//             $this->session->set_flashdata('message',show_alert('This request did not pass our security checks.','info'));
//             $current_user_group = get_user_group();
//             if($current_user_group->id == 4){
//                 redirect(site_url('applicant_dashboard'), 'refresh');
//             }else {
//                 redirect(site_url('dashboard'), 'refresh');
//             }
//         }
//     }

    function print_student_transfer($id){
        $id = decode_id($id);
        $invoice=$this->db->query("select * from invoices where id='".$id."'")->row();
        $ega_auth=$this->db->query("select * from ega_auth")->row();


        $payer = $this->db->query("select * from application where id='".$invoice->student_id."'")->row();
        // echo $APPLICANT->user_id;exit;
        if($invoice) {
            include_once 'report/print_transfer2.php';
        }else{
            $this->session->set_flashdata('message',show_alert('This request did not pass our security checks.','info'));
            $current_user_group = get_user_group();
            if($current_user_group->id == 4){
                redirect(site_url('applicant_dashboard'), 'refresh');
            }else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }

    function maximumCheck($num)
    {
        if ($num < 1000)
        {
            $this->form_validation->set_message('maximumCheck', 'The %s field must be at least 1000 '
            );
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    function RegnoCheck($regno)
    {
        $regno_array=explode("/",$regno);
        $first_two_characters = substr($regno, 0, 2);
        $first_four_characters = substr($regno, 0, 4);
        $first_five_characters = substr($regno, 0, 5);


      
        if( $first_two_characters== $first_two_characters || $first_four_characters==$first_four_characters || $first_five_characters==$first_four_characters)
        {
            return TRUE;
        }


        // if (count($regno_array)!=3 or (($first_two_characters!='NS') and ($first_two_characters!='NP')) )
        // {
        //     $this->form_validation->set_message('RegnoCheck', 'The %s field is not in a correct format');
        //     return FALSE;
        // }
        // else
        // {
        //     return TRUE;
        // }
    }



    function print_student_statement($id){
        if(isset($_GET['regno']))
        {
            $id=$_GET['regno'];
        }else{
            $id = decode_id($id);
        }
        $ayear = $this->common_model->get_account_year()->row()->AYear;
        $invoice=$this->db->query("select * from student_invoice where regno='$id' order by amount DESC")->row();
//        $user=current_user();
        // echo $APPLICANT->user_id;exit;
        if($invoice) {
            include_once 'report/print_balace.php';
        }else{
            $this->session->set_flashdata('message',show_alert('This request did not pass our security checks.','info'));
            $current_user_group = get_user_group();
            if($current_user_group->id == 4){
                redirect(site_url('applicant_dashboard'), 'refresh');
            }else {
                redirect(site_url('dashboard'), 'refresh');
            }
        }
    }


    function student_create_invoice($id=null)
    {
      
        $otherdb = $this->load->database('saris', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $accademic_year_active=$otherdb->query("select * from academicyear where Status=1")->row();
        $ayear = $accademic_year_active->AYear;
        if (!is_null($id)) {
            $id = decode_id($id);
            $this->data['student_id'] = $id;

            $check_student = $otherdb->query("select * from student where RegNo='" . $id . "' ")->row();
            if ($check_student->RegNo) {
                $full_name = $check_student->Name;
                $surname_othernames_array = explode(', ', $full_name);
                $s_name = $surname_othernames_array[0];
                $f_m_names_array = explode(' ', $surname_othernames_array[1]);
                $f_name = $f_m_names_array[0];
                $m_name = $f_m_names_array[1];
                $this->data['s_name'] = $s_name;
                $this->data['m_name'] = $m_name;
                $this->data['f_name'] = $f_name;
                $this->data['email'] = $check_student->Email;
                $this->data['phone'] = $check_student->Phone;
                $this->data['campus'] = $check_student->Campus;

            }
            $results = $otherdb->query("select student.RegNo,student.Name,Email,Phone,class.YearOfStudy,OAS_NTALEVEL,programme.Title as programme,Campus  from ((programme inner join class on programme.programmecode = class.programme) inner join student on student.RegNo=class.RegNo) where class.Ayear='".$ayear."' and student.RegNo='".$id."'")->row();
            if ($results) {
                $nta_level = $results->OAS_NTALEVEL;
                // $nta_level= str_replace(['+', '-'],'', filter_var($nta, FILTER_SANITIZE_NUMBER_INT));

                if($nta_level==8 and $results->YearOfStudy==1)
                {
                    $ntal=7;
                }elseif($nta_level==8 and $results->YearOfStudy==2) {
                    $ntal=7.2;
                }elseif($nta_level==8 and $results->YearOfStudy==3) {
                    $ntal = 8;
                }elseif($nta_level==5) {
                    $ntal = 5;
                }elseif($nta_level==6 and $results->YearOfStudy==1) {
                    $ntal = 5;
                }elseif($nta_level==6 and $results->YearOfStudy==2) {
                    $ntal = 6;
                }elseif($nta_level=='TODL') {
                    $ntal = 'ODL1';
                }elseif($nta_level=='ODL' and $results->YearOfStudy==1) {
                    $ntal = 'ODL1';  
                }elseif($nta_level=='ODL' and $results->YearOfStudy==2) {
                    $ntal = 'ODL2';  
                }elseif($nta_level=='ODL' and $results->YearOfStudy==3) {
                    $ntal = 'ODL3';  
                }elseif($nta_level=='BODL' and $results->YearOfStudy==1) {
                    $ntal = 'BODL1'; 
                }elseif($nta_level=='BODL' and $results->YearOfStudy==2) {
                    $ntal = 'BODL2'; 
                }elseif($nta_level=='BODL' and $results->YearOfStudy==3) {
                    $ntal = 'BODL3'; 
                }else {
                    $ntal = 4; 
                }

                $fee_structure = $this->db->query("select * from fee_structure where ntlevel_value='" . $ntal. "' or (fee_category=0 and for_student=1)  order by ntlevel_value DESC")->result();
                $this->data['fee_structure'] = $fee_structure;
            
            }else //echeck previous accademic year
            {
                // echo 'herrrrrrr'; exit;
                $year_array = explode('/', $ayear);
                $previouse_a_year = ($year_array[0] - 1) . '/' . $year_array[0];
                $results = $otherdb->query("select student.RegNo,student.Name,Email,Phone,class.YearOfStudy,OAS_NTALEVEL,programme.Title as programme,Campus  from ((programme inner join class on programme.programmecode = class.programme) inner join student on student.RegNo=class.RegNo) where class.Ayear='" . $previouse_a_year . "' and student.RegNo='" . $id . "'")->row();

                if ($results) {
                    $nta_level = $results->OAS_NTALEVEL;
                    // $ntalevel= str_replace(['+', '-'],'', filter_var($ntal, FILTER_SANITIZE_NUMBER_INT));
                    if($nta_level==8 and $results->YearOfStudy==1)
                    {
                        $ntal=7;
                    }elseif($nta_level==8 and $results->YearOfStudy==2) {
                        $ntal=7.2;
                    }elseif($nta_level==8 and $results->YearOfStudy==3) {
                        $ntal = 8;
                    }elseif($nta_level==5) {
                        $ntal = 5;
                    }elseif($nta_level==6 and $results->YearOfStudy==1) {
                        $ntal = 5;
                    }elseif($nta_level==6 and $results->YearOfStudy==2) {
                        $ntal = 6;
                    }elseif($nta_level=='TODL') {
                        $ntal = 'ODL1';
                    }elseif($nta_level=='ODL' and $results->YearOfStudy==1) {
                        $ntal = 'ODL1';  
                    }elseif($nta_level=='ODL' and $results->YearOfStudy==2) {
                        $ntal = 'ODL2';  
                    }elseif($nta_level=='ODL' and $results->YearOfStudy==3) {
                        $ntal = 'ODL3';  
                    }elseif($nta_level=='BODL' and $results->YearOfStudy==1) {
                        $ntal = 'BODL1'; 
                    }elseif($nta_level=='BODL' and $results->YearOfStudy==2) {
                        $ntal = 'BODL2'; 
                    }elseif($nta_level=='BODL' and $results->YearOfStudy==3) {
                        $ntal = 'BODL3'; 
                    }else {
                        $ntal = 4; 
                    }
                    $fee_structure = $this->db->query("select * from fee_structure where ntlevel_value='" .$ntal . "' or (fee_category=0 and for_student=1)  order by ntlevel_value DESC")->result();
                    $this->data['fee_structure'] = $fee_structure;
                }

            }


        }

        if($this->input->post('loadsheet')) {
            //$otherdb = $this->load->database('saris', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

            $excel_upload = TRUE;
            $this->form_validation->set_rules('studentfile', 'Student Sheet', 'required');
            if (isset($_FILES['studentfile']['name']) && empty($_FILES['studentfile']['name'])) {
                $upload_error = '<div class="required">You must upload excel file.</div>';
                $excel_upload = FALSE;
            } elseif (isset($_FILES['studentfile']['name']) && (get_file_extension($_FILES['studentfile']['name']) != 'xlsx' && get_file_extension($_FILES['studentfile']['name']) != 'xls')) {
                $upload_error = '<div class="required">File uploaded must be in xls or xlxs format.</div>';
                $excel_upload = FALSE;
            }

            if ($excel_upload == TRUE) {

                $dest_name = time() .'sponsored_sheet.xlsx';
                move_uploaded_file($_FILES['studentfile']['tmp_name'], 'uploads/temp/' . $dest_name);

                // set file path
                $file = './uploads/temp/' . $dest_name;

                //load the excel library
                $this->load->library('excel');

                //read file from path
                $objPHPExcel = IOFactory::load($file);
                //get only the Cell Collection

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
                    $data = array();
                    $courseError = array();
                    if (trim($row['A']) <> '') {
                        $f4_index = $row['B'];
                        $f4_index=str_replace(".","/",$f4_index);
                        $RegNo = $row['E'];
                        $amount=$row['G'];
                        $postdata=array(
                            "regno"=>  $RegNo
                        );

                        $url = "http://139.162.245.224/ega/ega-iae/checkregno.php";
                        $data_json = sendDataOverPost($url, $postdata);
                        $data = json_decode($data_json, true);
                        $code = $data['code'];
                        if($code!=0)
                        {

                            $name=$data['name'];
                            $email=$data['email'];
                            $students_sponsored[$i]['regno']=$RegNo;
                            $students_sponsored[$i]['name']=$name;
                            $students_sponsored[$i]['email']=$email;
                            $students_sponsored[$i]['amount']=$amount;
                            $students_sponsored[$i]['f4_index']=trim($row['B']);
                            $this->data['students_sponsored']=$students_sponsored;

                        }


                    }
                    $i=$i+1;
                }
                unlink('./uploads/temp/' . $dest_name);

            }
        }else {
            $ayear = $this->common_model->get_academic_year()->row()->AYear;

            $this->form_validation->set_rules('invoice_type', 'Invoice Category/Type', 'required');
            $this->form_validation->set_rules('amount', 'Invoice Amount', 'required');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');

            if ($this->input->post('invoice_type') == 4) {
                $this->form_validation->set_rules('pregno[]', 'Registration Number', 'required');
                $this->form_validation->set_rules('name[]', 'Student Name', 'required');
                $this->form_validation->set_rules('pamount[]', 'Amount', 'required');
                $this->form_validation->set_rules('sponsor_code', 'Sponsor Name', 'required');

            } else {
                $this->form_validation->set_rules('mobile', 'Mobile', 'required');

                //$this->form_validation->set_rules('firstname', 'First Name', 'required');


                if ($this->input->post('invoice_type') != 3) {

                    $this->form_validation->set_rules('firstname', 'First Name', 'required');

                    if ($this->input->post('invoice_type') != 1) {
                        $this->form_validation->set_rules('surname', 'Surname', 'required');
                    }

                    if ($this->input->post('invoice_type') == 1) {
                        $this->form_validation->set_rules('regno', 'Registration Number', 'required|callback_RegnoCheck');

                    }

                } else {

                    $this->form_validation->set_rules('institutionname', 'Institution Name', 'required');
                }

                if ($this->input->post('fee_category') != 0) {
                    $this->form_validation->set_rules('nta_level', 'NTA Level', 'required');
                } else {
                    $this->form_validation->set_rules('txtFeeName', 'Fee Name', 'required');

                }
                if ($this->input->post('fee_category') == '') {
                    $this->form_validation->set_rules('txtFeeName', 'Fee Name', 'required');
                }
                if ($this->input->post('is_fixed') != 1) {

                    $this->form_validation->set_rules('specify_amount', 'Fee Amount', 'required|callback_maximumCheck');
                    $this->form_validation->set_rules('specify_name', 'Fee Name', 'required');
                    //$this->form_validation->set_rules('mobile2', 'Mobile 2', 'regex_match[/^0[0-9]{9}$/]');

                }
            }
            if ($this->form_validation->run() == true) {
                $fee_category = trim($this->input->post('fee_category'));
                $nta_level = trim($this->input->post('nta_level'));

                // exit;
                $reg_no = trim($this->input->post('regno'));
                $amount = trim($this->input->post('amount'));

                if (trim($this->input->post('mobile')) != '') {
                    $mobile = '255' . ltrim(trim($this->input->post('mobile')), '0');

                }
                $firstname = trim($this->input->post('firstname'));
                if ($this->input->post('invoice_type') == 3) {
                    $firstname = trim($this->input->post('institutionname'));
                }

                $sponsore_code = trim($this->input->post('sponsor_code'));
                $surname = trim($this->input->post('surname'));
                $othername = trim($this->input->post('othername'));
                $email = trim($this->input->post('email'));
                $address = trim($this->input->post('address'));
                $description = trim($this->input->post('description'));
                $feeid = trim($this->input->post('txtFeeName'));
                $student_fee_array = explode('_', $feeid);
                $student_fee_id = $student_fee_array[0];
                $student_fee_name = $student_fee_array[4].' '.$student_fee_array[5];

                $invoice_type = $this->input->post('invoice_type');
                if($invoice_type==1 and $fee_category!=0)
                {
                    $fee_details=$this->db->query("select * from fee_structure where fee_category='$fee_category' and ntlevel_value='$nta_level' and ntlevel=1")->row();
                    $student_fee_id=$fee_details->id;
                    $student_fee_name=$fee_details->name;
                   
                }


                $current_fee_details = $this->db->query("select * from fee_structure where id='$student_fee_id'")->row();
                $fee_category = $current_fee_details->fee_category;
                if($this->input->post('is_fixed')!=1)
                {

                    $student_fee_name=$this->input->post('specify_name');


                }
                if ($reg_no == '') {
                    $reg_no = time();
                }

//
                $postdata = array(
                    "regno" => $reg_no
                );
                $code = 1;

                // its original contents 
                // if ($this->input->post('invoice_type') == 1) {
                //     $code = 0;
                //     $url = "http://139.162.245.224/ega/ega-iae/checkregno.php";
                //     $data_json = sendDataOverPost($url, $postdata);
                //     $data = json_decode($data_json, true);
                //     $code = $data['code'];
                //     $code_description = $data['description'];
                //     $sponsored_amount = $data['sponsored_amount'];
                // }

                //pasted for testing
                if ($this->input->post('invoice_type') == 1) {
                    $code = 1;
                    $sponsored_amount = 0;

                }


                $batchno = "";
                if ($code == 1) {
                    $name = trim(ucfirst($firstname) . ' ' . ucfirst($othername) . ' ' . ucfirst($surname));
                    if ($this->input->post('invoice_type') == 4) {
                        $name = get_value("sponsors", array("code" => $sponsore_code), 'name');
                        $reg_no = $sponsore_code;
                        $batchno = $this->input->post('batch_number');

                    }


//                for($i=0;$i<count($txtFeeName);$i++)
//                {
//                    $student_fee_array=explode('_',$txtFeeName[$i]);
//                    $student_fee_id=$student_fee_array[0];
//                    $check_fee_exist=$this->db->query("select * from student_fee where student_regno='$reg_no' and fee_id=".$student_fee_id)->row();
//                    if($check_fee_exist){
//                        $amount=$amount-get_value('fee_structure',$check_fee_exist->fee_id,'amount');
//                    }
//
//                }
//
//                if((int)$amount==0)
//                {
//
//                    $this->session->set_flashdata('message',show_alert("The invoice/invoices for  elected fees exist  please choose another fees", 'warning'));
//                    redirect('student_create_invoice', 'refresh');
//                    exit;
//
//                };

                    //CREATE INVOICE
                    $ega_auth = $this->db->query("select * from ega_auth")->row();
                    $url = $ega_auth->call_url;
                    //create new invoice

                    $fee_code = 2;
                    $select_fee_cod = $this->db->query("select * from fee_structure where id='$student_fee_id'")->row();
                    if ($select_fee_cod) {
                        $fee_code = $select_fee_cod->fee_code;
                    }

                    if ($fee_category == 2 and (int)$sponsored_amount != 0) {
                        $amount = ($amount - $sponsored_amount);
                    }

                    if ($amount <= 0) {
                        $this->data['message'] = show_alert("Invoice Amount Should not be zero", 'warning');
                    } else {

                        if ($this->input->post('invoice_type') == 4) {

                            $check_if_batch_exist= $this->db->query("select * from spoonsored_students_invoice where  	batchno='$batchno'")->result();

                            if($check_if_batch_exist)
                            {

                                $this->session->set_flashdata('message', show_alert('Batch Number ('.$batchno.') Exist ', 'warning'));
                                redirect('student_create_invoice', 'refresh');

                            }else{
                                $student_fee_name = "Tuition Fee";
                                $fee_details = get_value('fee_structure', array('name' => $student_fee_name), "");
                                $student_fee_id = $fee_details->id;
                                $fee_code = $fee_details->fee_code;
                                $fee_category = 2;
                            }

                        }

                        $invoice_data_array = array(
                            'student_id' => $reg_no,
                            'type' => GetFeeTypeDetails($fee_code)->name,
                            'amount' => $amount,
                            'GfsCode' => GetFeeTypeDetails($fee_code)->gfscode,
                            'student_name' => $name,
                            'student_mobile' => $mobile,
                            'student_email' => $email,
                            'student_address' => $address,
                            'description' => $description,
                            'fee_id' => $student_fee_id,
                            'fee_name' => $student_fee_name,
                            'a_year' => $ayear,
                            'invoice_type' => $invoice_type,
                            'fee_category' => $fee_category,
                            'nta_level' => $nta_level,
                            'batchno' => $batchno
                        );


                        $this->db->insert('invoices', $invoice_data_array);
                        $invoice_id = $this->db->insert_id();
                        if ($this->input->post('invoice_type') == 4) {
                            $pamount = $this->input->post('pamount');
                            $pregno = $this->input->post('pregno');
                            $name = $this->input->post('name');
                            $f4_index_numbers=$this->input->post('f4_index');

                            for ($i = 0; $i < count($pregno); $i++) {
                                $current_student_info= $otherdb->query("select Address,Email,Phone,OAS_NTALEVEL,programme.Title as programme,student.IntakeValue  from ((programme inner join class on programme.programmecode = class.programme) inner join student on student.RegNo=class.RegNo) where class.Ayear='".$ayear."' and student.RegNo='".$pregno[$i]."'")->result();
                                $invoice_array=array(
                                        'student_id' => $pregno[$i],
                                        'type' => GetFeeTypeDetails($fee_code)->name,
                                        'amount' => $pamount[$i],
                                        'GfsCode' => GetFeeTypeDetails($fee_code)->gfscode,
                                        'student_name' => $name[$i],
                                        'student_mobile' => $current_student_info->Phone,
                                        'student_email' => $current_student_info->Email,
                                        'student_address' => $current_student_info->Address,
                                        'description' => $reg_no.'-'.$batchno,
                                        'fee_id' => $student_fee_id,
                                        'fee_name' => $student_fee_name.'-'.$reg_no.'-'.$batchno,
                                        'a_year' => $ayear,
                                        'invoice_type' => $invoice_type,
                                        'fee_category' => $fee_category,
                                        'nta_level' => $current_student_info->OAS_NTALEVEL,
                                    );
                                $this->db->insert('invoices', $invoice_array);


                                $this->db->query("insert into spoonsored_students_invoice(invoice_number,regno,amount,name,batchno,f4_index) values('$invoice_id','$pregno[$i]','$pamount[$i]','$name[$i]','$batchno','".$f4_index_numbers[$i]."') ");

                            }

                        }


//
//                //student fee
//                for($i=0;$i<count($txtFeeName);$i++)
//                {
//                    if((int)$txtAmount[$i]==0)
//                        continue;
//                    $student_fee_array=explode('_',$txtFeeName[$i]);
//                    $student_fee_id=$student_fee_array[0];
//                    $student_fee=array(
//                        'invoice_number'=>$invoice_id,
//                        'student_regno'=>$reg_no,
//                        'fee_id'=>$student_fee_id
//
//                    );
//                    $this->db->insert('student_fee',$student_fee);
//
//                }


                        $postdata = array(
                            "customer" => $ega_auth->username,
                            "reference" => $ega_auth->prefix . $invoice_id,
                            "student_name" => $name,
                            "student_id" => $reg_no,
                            "student_email" => $email,
                            "student_mobile" => $mobile,
                            "GfsCode" => trim(GetFeeTypeDetails($fee_code)->gfscode),
                            "amount" => $amount,
                            "type" => trim(GetFeeTypeDetails($fee_code)->name),
                            "secret" => $ega_auth->api_secret,
                            "pay_option" => $current_fee_details->pay_option,
                            "exp_days" => $current_fee_details->exp_days,
                            "action" => 'SEND_INVOICE'
                        );
                        /*  $postdata = array(
                          "customer" => "IAE",
                          "reference" => $ega_auth->prefix.$invoice_id,
                          "student_name" =>$name,
                          "student_id" => $reg_no,
                          "student_email"=>$email,
                          "student_mobile"=>$mobile,
                          "GfsCode"=>GetFeeTypeDetails(2)->gfscode,
                          "amount"=> $amount,
                          "type"=> GetFeeTypeDetails(2)->name,
                          "secret"=>"sevr/EQLtQvJgrsq1LsPxLGLeYp/IRS687Q5GguNtro=",
                          "action"=>'SEND_INVOICE'
                          );*/
                        $url = $ega_auth->call_url;
                        $result = sendDataOverPost($url, $postdata);
                        $result_array = json_decode($result, true);
                        $log_data_array = array(
                            'request' => print_r($postdata, true),
                            'responce' => $result,
                            'status' => $result_array['status'],
                            'description' => $result_array['description'],
                            'type' => 'invoice'
                        );
                        $this->db->insert('ega_logs', $log_data_array);

                        //end create invoice

                        $this->data['message'] = show_alert("Invoice successfully created", 'info');
                        redirect('student_invoices/?regno=' . $reg_no, 'refresh');
                    }
                } else {
                    $this->data['message'] = show_alert($description, 'warning');
                }

            }
        }
        $this->data['middle_content'] = 'home/createinvoice2';
        $this->data['sub_link'] = 'createinvoice';
        $this->data['content'] = 'home/home2';
        $this->load->view('public_template_student', $this->data);
    }


    function student_dashboard()
    {
        //$current_user = current_user();
        $this->data['middle_content'] = 'home/dashboard2';
        $this->data['content'] = 'home/home2';
        $this->load->view('public_template_student', $this->data);
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
                $response_data = sendXmlOverPost('https://api.tcu.go.tz/admission/submitInternalTransfers', $xml_data);
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
                $response_data = sendXmlOverPost('https://api.tcu.go.tz/admission/submitInterInstitutionalTransfers', $xml_data);
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

    function loadDistrict()
    {

        $id = trim($this->input->post('id'));
        $results=$this->db->where(" region_id", $id)->get("districts")->result();

        echo'<select name="district" id="district" class="form-control  " onchange="loadVituo(this.value,\'populate_vituo\',\'populate_vituo\',\'populate_vituo\');">
                                              <option value=""> [ Chagua Wilaya ]</option>';
        foreach ($results as $current_row)
        {
            echo"<option value='".$current_row->id."'>".$current_row->name."</option>";
        }
        echo" </select>";


    }
    function loadVituo()
    {

        $id = trim($this->input->post('id'));
        $results=$this->db->where("district", $id)->get("iposa_vituo")->result();

        echo'<select name="kituo" class="form-control  ">
                                              <option value=""> [ Chagua Kituo ]</option>';
        foreach ($results as $current_row)
        {
            echo"<option value='".$current_row->id."'>".$current_row->name."</option>";
        }
        echo" </select>";


    }




    function RegnoCheckIposa($regno)
    {

        $regno=preg_replace('/\s+/', '',$regno);
        $regno_array=explode("-",$regno);
        //$first_four_characters = substr($regno, 0, 2);


        if (count($regno_array)!=3 or strlen($regno_array[0])!=4 or $regno_array[1]!='IPOSA' or strlen($regno_array[2])!=5 or !is_numeric($regno_array[0]) or !is_numeric($regno_array[2]))
        {
            $this->form_validation->set_message('RegnoCheckIposa', 'The %s field is not in a correct format');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    function test_server()
    {

        $otherdb = $this->load->database('saris', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $query = $otherdb->select('*')->get('student')->result();
        print_r($query);
    }
    function CheckFeeStructure_old()
    {

        $ayear = $this->common_model->get_account_year()->row()->AYear;
        $postdata=array(
            "ayear"=>  $ayear
        );
        $otherdb = $this->load->database('saris', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $select="select class.YearOfStudy,class.Programme,ProgrammeofStudy,student.Name as name,student.regno from class inner join student on student.regno=class.regno  where class.ayear='".$ayear."'";
        $result_class=$otherdb->query($select)->result();

        foreach ($result_class as $key=>$result){
            echo"<br/>Regno=".$regno=$result->regno;
            echo"<br/>Name=".$name=$result->name;
            echo"<br/>Programme=".$programme=$result->ProgrammeofStudy;
            echo"<br/>Year of study=".$year_of_study=$result->YearOfStudy;
            exit;

            $select_fee_rate="select fees.name,fees.feecode,amount from feesrates inner join fees on fees.feecode=feesrates.feecode where ayear='".$ayear."' and programmecode='".$result->Programme."' and yearofstudy='".$result->YearOfStudy."'";
            $result_fee_rate=$otherdb->query($select_fee_rate)->result();

            foreach ($result_fee_rate as $result=>$fee_rate)
            {
                echo"<br/>fee=".$fee=$fee_rate->name;
                echo"<br/>amount=".$amount=$fee_rate->amount;

                $check_if_invoice_exist=$this->db->query("select * from student_invoice where regno='$regno' and ayear='$ayear'  and `type`='$fee' and side='DR'")->result();

                if(!$check_if_invoice_exist){
                    $insert=$this->db->query("insert into student_invoice(regno,ayear,amount,name,`type`,side,programme,year_of_study)
                    values('$regno','$ayear','$amount','".$name."','".$fee."','DR','$programme','$year_of_study')");
                }else{
                    $update=$this->db->query("update student_invoice set amount='$amount',programme='$programme',year_of_study='$year_of_study' where regno='$regno' and ayear='$ayear'  and `type`='".$fee."' and side='DR' ");
                }
            }

        }
        echo"Record Successfully created";

    }

    function CheckFeeStructure()
    {

        $ayear = $this->common_model->get_account_year()->row()->AYear;
        $postdata=array(
            "ayear"=>  $ayear
        );

        $otherdb = $this->load->database('saris', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        $results= $otherdb->query("select student.RegNo,student.Name,OAS_NTALEVEL as NTALevel,programme.Title as programme,Campus,student.IntakeValue,class.YearOfStudy as YearOfStudy  from ((programme inner join class on programme.programmecode = class.programme) inner join student on student.RegNo=class.RegNo) where class.Ayear='".$ayear."'")->result();

            foreach ($results as $key=>$value)
            {
                 $regno=$value->RegNo;
                 $name=$value->Name;
                 $ntlevel=$value->NTALevel;
                 $yearofstudy=$value->YearOfStudy;
                 if($ntlevel=='ODL' or $ntlevel=='BODL')
                 {
                     $ntlevel=$ntlevel.$yearofstudy;
                 }
                 $programme=$value->programme;
                 $campus=$value->Campus;
                 $intake=$value->IntakeValue;

                 $fee_structure=$this->db->query("select * from fee_structure where ntlevel_value='".$ntlevel."'")->result();

                foreach ($fee_structure as $fee=>$structure){

                    $current_accommodation=0;
                    $current_carry_over=0;
                    $has_pay_accommodation=$this->db->query("select * from invoices  where student_id='".$regno."' and fee_category=3")->result();

                    $has_pay_carry_over_subject=$this->db->query("select * from invoices  where student_id='".$regno."' and  fee_category=4")->result();

                    if($structure->fee_category==3 and !$has_pay_accommodation )
                    {
                        continue;

                    }else{
                        $current_accommodation=1;
                    }

                    if($structure->fee_category==4 and !$has_pay_carry_over_subject )
                    {
                        continue;

                    }else{
                        $current_carry_over=1;
                    }

                    if($current_accommodation==0)
                    {
                        $has_pay_accommodation=$this->db->query("select * from payment  where student_id='".$regno."' and  	fee_category=3")->result();

                        if($structure->fee_category==3 and !$has_pay_accommodation )
                        {
                            continue;

                        }
                    }

                    if($current_carry_over==0) {
                        $has_pay_carry_over_subject = $this->db->query("select * from payment  where student_id='" . $regno . "' and  fee_category=3")->result();
                        if($structure->fee_category==4 and !$has_pay_carry_over_subject )
                        {
                            continue;

                        }

                    }



                    $fee = $structure->name;
                    $amount =$structure->amount;
                    if($structure->fee_category==4)//cary_over
                    {
                        $amount +=$structure->carryover_quality_assurance_value;
                    }


                    $invoice_array=array(
                        "regno"=>$regno,
                        "ayear"=>$ayear,
                        "amount"=>$amount,
                        "name"=>$name,
                        "type"=>$fee,
                        "side"=>'DR',
                        "programme"=>$programme,
                        "nta_level"=>$ntlevel,
                        "campus"=>$campus,
                        "intake"=>$intake,
                    );

                    $check_if_invoice_exist = $this->db->query("select * from student_invoice where regno='".$regno."' and ayear='".$ayear."'  and type ='".$fee."' and side='DR'")->result();
                    if (!$check_if_invoice_exist) {
                        //$insert = $this->db->query("insert into student_invoice(regno,ayear,amount,name,`type`,side,programme)
                   // values('".$regno."','".$ayear."','".$amount."','" . $name . "','" . $fee . "','DR','".$programme."')");
                        $this->db->insert('student_invoice',$invoice_array);
                    }else {
                        $update_array=array(
//                            "amount"=>$amount,
                            "programme"=>$programme,
                            "campus"=>$campus,
                            "intake"=>$intake
                        );

                        $condition_array=array(
                            "regno"=>$regno,
                            "ayear"=>$ayear,
                            "type"=>$fee,
                            "side"=>"DR"
                        );

                        $this->db->update("student_invoice",$update_array,$condition_array);

                       // $update = $this->db->query("update student_invoice set amount='".$amount."',programme='".$programme."' where regno='".$regno."' and ayear='".$ayear."'  and `type`='" . $fee . "' and side='DR' ");
                    }
                }

            }

            echo"Record Successfully created";
//        }
//
//        else{
//            echo $array_json['description'];
//        }
    }
    function GetFeeByCategory()
    {

        $category = trim($this->input->post('category'));
        echo '<select class="form-control" style="width: 100%;" name="txtFeeName" id="txtFeeName"  onchange="ShowAmount(this.value,\'txtGrandTotal\')">
                <option value="">Select Fee  </option>';

        if($category=='')
        {
            $fee_list=$this->db->query("select * from fee_structure where fee_category<>0 and hidden=0")->result();

        }else{
            $fee_list=$this->db->query("select * from fee_structure where fee_category='$category' and hidden=0")->result();

        }
        foreach($fee_list as $key=>$value)
        {
            echo'<option value="'. $value->id.'_'.$value->amount.'_'.$value->percentage.'_'.$value->fixed.'_'.$value->name.'_'.$value->parcentage_value.'">'.$value->name.'</option>';


        }

        echo '</select>';

    }

    function LoadStudentDetailsByID()
    {

        $regno = trim($this->input->post('regno'));


        $otherdb = $this->load->database('saris', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.


        $select="select * from student where RegNo='".$regno."'";
        $students_list=$otherdb->query($select)->row();
        if($students_list->RegNo)
        {

            $name=$students_list->Name;
            $mobile=$students_list->Phone;
            $email=$students_list->Email;
            $sponsored_amount=$students_list->sponsored_amount;
            //$sponsored_amount=$students_list->sponsor_name;
            echo '1'.'_'.$name.'_'.$mobile.'_'.$email.'_'.$sponsored_amount.'_'.'Success'.'_'.encode_id($students_list->RegNo);;

        }else{
            $name='';
            $mobile='';
            $email='';
            $sponsored_amount='';

            echo '0'.'_'.$name.'_'.$mobile.'_'.$email.'_'.$sponsored_amount.'_'.'Registration Number not exist';
        }

    }
    function LoadStudentDetailsByID1()
    {

         $regno = trim($this->input->post('regno'));

        $postdata=array(
            "regno"=>  $regno
        );

        if($regno!='')
        {

            $url = "http://212.71.252.209/ega/ega-iae/checkregno.php";
            $data_json = sendDataOverPost($url, $postdata);
            $data = json_decode($data_json, true);
            $code = $data['code'];
            $code_description=$data['description'];
            $sponsored_amount=$data['sponsored_amount'];
            echo $code.'_'.$data['name'].'_'.$data['mobile'].'_'.$data['email'].'_'.$data['sponsored_amount'].'_'.$data['description'];
        }

    }


   
        function loadCampus()
        {
              $programme = trim($this->input->post('id'));   
              $campuses = $this->db->query("select campus_id  from programme where Code='$programme'")->result();   
                foreach($campuses as $ca){
                  $c =  $ca->campus_id;
                   $arr = str_replace(array( '[', ']','"' ), '', $c);
                   $explode = explode(",",$arr);
                    
                }

               echo'<select id="campus" name="application_campus" class="form-control tag" required>
                        <option value="">[ Campus  ]</option>';
                        foreach($explode as $ca){
                       echo'<option value="'.$ca.'">'.'<br>'.$ca.'</option>';
                        }
          echo '  </select>';           
        }



    function AddApplicantTCU($applicantid,$category)
    {


        $f4index = $this->db->get_where('application_education_authority', array('applicant_id'=>$applicantid, 'certificate'=>1))->row()->index_number;

        if($category==4)
        {
            $f6index = $this->db->get_where('application_education_authority', array('applicant_id'=>$applicantid, 'certificate'=>4))->row()->avn;

            $category='D';
        }
        if($category==2)
        {
            $f6index = $this->db->get_where('application_education_authority', array('applicant_id'=>$applicantid, 'certificate'=>2))->row()->index_number;

            $category='A';
        }



//        $f4index="S1085/0001/2018";
//        $f6index="S5682/0501/2021";
//        $category="A";
        $other_f6="";
        $other_f4="";
        $xml=AddApplicantRequest(TCU_USERNAME,TCU_TOKEN,$f4index,$f6index,$category,$other_f4,$other_f6);
        $url=TCU_DOMAIN."/applicants/add";
        $responce=sendXmlOverPost($url,$xml);
        // print_r($responce);

        $responce=RetunMessageString($responce,'ResponseParameters');
        $xml=simplexml_load_string($responce);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $description=$array['StatusDescription'];
        $status = $array['StatusCode'];
        $error_code = $array['StatusCode'];
        $date = date('Y-m-d H:i:s');

        if ($status == 200 || $status == 208) {
            $error_code=200;
            $status=200;
            $request_status = 1;
            $insert = $this->db->query("insert into tcu_records values('','" . $applicantid . "','Add','$error_code','$f4index','$status','$description','$request_status','$xml','$json','$date')");

        }
        $this->session->set_flashdata("message", show_alert($description, 'info'));
        redirect(site_url('applicant_list'), 'refresh');

    }


   function TestNECTAAPI($ype=1,$index_number)
   {
       $type=1; // 1 =olevel,2= Alevel, 14 for DSEE= DIPLOMA IN SECONDARY EDUCATION
       // 10 for GATCE=GRADE A TEACHER SPECIAL COURSE CERTIFICATE  (GATSCC)
       // 12 for GATSCEE GRADE A TEACHER SPECIAL COURSE CERTIFICATE  (GATSCC)

       $index_number="E0515/0100/2010";
       $index_number_tmp = explode('/', $index_number);
       $index_number = $index_number_tmp[0] . '-' . $index_number_tmp[1];
       $completed_year=$index_number_tmp[2];

       $this->curl->create(NECTA_API . 'auth/' . NECTA_KEY);
       $this->curl->options(
           array(
               CURLOPT_RETURNTRANSFER => 1,
               CURLOPT_SSL_VERIFYPEER=>0
           )
       );
       $response_token = $this->curl->execute();
       if ($response_token) {

           $responsedata_key = json_decode($response_token);
           $this->curl->create(NECTA_API . 'results/' . $index_number . '/10/' . $completed_year . '/' . $responsedata_key->token);

           $this->curl->options(
               array(
                   CURLOPT_RETURNTRANSFER => 1,
                   CURLOPT_SSL_VERIFYPEER=>0
               )
           );
           echo $response = $this->curl->execute();
           if ($response) {
               echo $responsedata = json_decode($response);
           }


       }


   }


}

