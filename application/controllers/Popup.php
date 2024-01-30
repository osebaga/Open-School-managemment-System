<?php

/**
 * Created by PhpStorm.
 * User: miltone
 * Date: 6/15/17
 * Time: 1:48 PM
 */
class Popup extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function applicant_byProgramme()
    {
      $date = "2018-09-24";
        $programme = (isset($_GET) && isset($_GET['programme'])) ? $_GET['programme'] : null;
        $application_type = (isset($_GET) && isset($_GET['type'])) ? $_GET['type'] : null;
        $row_year = $this->common_model->get_academic_year(null, 1, 1)->row();
        $ayear = $row_year->AYear;
        $current_round=$this->db->query("select * from application_round")->row();
        if($current_round)
        {
            $round=$current_round->round;
        }else{
            $round=1;
        }

        if (!is_null($programme) && !is_null($application_type)) {
            $this->data['PROGRAMME'] = $programme;
            $this->data['TYPE'] = $application_type;
            $this->data['applicant_list'] = $this->db->query("SELECT ap.*,pc.choice,pc.status as eligible,pc.comment,pc.point FROM application as ap  INNER JOIN application_elegibility as pc ON (ap.id=pc.applicant_id) WHERE ap.application_type='$application_type'
                      AND ap.AYear='$ayear' AND pc.ProgrammeCode='$programme' AND pc.round='$round'  ORDER BY pc.status DESC,pc.point DESC ")->result();
            $this->load->view('panel/popup/applicant_byProgramme', $this->data);
        } else {
            echo '<div style="border-top: 1px solid gray; border-bottom:  1px solid gray; padding: 10px 0px;">No data found </div>';
        }
    }

    function get_programmes()
    {

        $return = array('' => 'No data found');
        if (isset($_GET['department']) && isset($_GET['application_type'])) {
            $department = $_GET['department'];
            $application_type = $_GET['application_type'];
            $programme_list = $this->db->query("SELECT * FROM programme WHERE Departmentid='$department' AND `type`='$application_type' AND active=1")->result();
            if (count($programme_list) > 0) {
                $return[''] = '[ Select Programme ]';
                foreach ($programme_list as $key => $value) {
                    $return[$value->Code] = $value->Name;
                }
            }
        }
        echo json_encode($return);
    }

    function education_view()
    {
        $row_id = $this->input->post('RID');
        $education_bg = $this->applicant_model->get_education_bg($row_id);

        $content = '';
        $hide =1;
        foreach ($education_bg as $rowkey => $rowvalue) {
            $APPLICANT = $this->applicant_model->get_applicant($rowvalue->applicant_id);
            $hide = $rowvalue->hide;
            $content .= '<table class="mytable2_educatiobbg">

                    <tr>
                        <th>Examination Authority :</th>
                        <td>' . $rowvalue->exam_authority . '</td>
                    </tr>';

            if ($rowvalue->technician_type > 0) {

                $content .= '<tr>
                            <th>  Category :</th>
                            <td>' . get_value('technician_type', $rowvalue->technician_type, 'name') . '</td>
                        </tr>';
            }
            if ($rowvalue->programme_title <> '') {
                $content .= ' <tr>
                            <th> Programme Title :</th>
                            <td>' . $rowvalue->programme_title . '</td>
                        </tr>';
            }
            $content .= '<tr>
                        <th>' . ($rowvalue->certificate < 3 ? 'Division' : 'G.P.A') . ' :</th>
                        <td>' . $rowvalue->division . '</td>
                    </tr>
                    <tr>
                        <th>' . ($rowvalue->certificate < 3 ? 'Centre/School' : 'College/Institution') . ' :
                        </th>
                        <td>' . $rowvalue->school . '</td>
                    </tr>
                    <tr>
                        <th>Country :</th>
                        <td>' . get_country($rowvalue->country) . '</td>
                    </tr>

                    <tr>
                        <th>Index Number :</th>
                        <td>' . $rowvalue->index_number . '</td>
                    </tr>

                    <tr>
                        <th>Completed Year:</th>
                        <td>' . $rowvalue->completed_year . '</td>
                    </tr>
                </table>

                <br/>';
            if ($rowvalue->certificate < 3 && $rowvalue->certificate != 1.5) {
                $content .= '<strong>SUBJECT LIST</strong>
                    <br/>
                    <table cellpadding="0" cellspacing="0" class="table table-bordered"
                           id="mytable" style="width: ">
                        <thead>
                        <tr>
                            <th style="width: 70px;">S/No.</th>
                            <th>SUBJECT</th>
                            <th style="width: 150px; text-align: center;">GRADE</th>
                            <th style="width: 150px; text-align: center;">YEAR</th>';
                if ($APPLICANT->status == 0 && $rowvalue->api_status != 1) {
                    $content .= '<th style="width: 100px;">Action</th>';
                }
                $content .= '</tr>

                        </thead>
                        <tbody>';

                $sno = 1;
                $subject_saved = $this->applicant_model->get_education_subject($rowvalue->applicant_id, $rowvalue->id);
                foreach ($subject_saved as $k => $v) {

                    $content .= '<tr>
                                <td style="vertical-align: middle; text-align: center">' . ($k + 1) . '</td>
                                <td>' . get_value('secondary_subject', $v->subject, 'name') . '</td>
                                <td style="text-align: center">' . $v->grade . '</td>
                                <td style="text-align: center">' . $v->year . '</td>';
                    if ($APPLICANT->status == 0 && $rowvalue->api_status != 1) {
                        $content .= '<td><a href="' . site_url('applicant_education/' . encode_id($APPLICANT->id)) . '/?row_id=' . encode_id($v->id) . '" class="remove_delete"><i class="fa fa-remove"></i> Remove</a> </td>';
                    }
                    $content .= '</tr>';
                    $sno++;
                }
                $content .= '</tbody>
                    </table>';
            }
            if($rowvalue->certificate == 4){
                $content.='<strong>SOME OF SUBJECT PERFORMED</strong>
                <br/>
                <table cellpadding="0" cellspacing="0" class="table table-bordered"
                       id="mytable" style="width: ">
                    <thead>
                    <tr>
                        <th style="width: 70px;">S/No.</th>
                        <th>SUBJECT</th>
                        <th style="width: 150px; text-align: center;">GRADE</th>

                    </tr>

                    </thead>
                    <tbody>';
                $sno1 =1;
                $subject_saved = $this->db->where(array('applicant_id'=>$rowvalue->applicant_id,'authority_id'=>$rowvalue->id))->get("application_diploma_nacteresult")->result();
                foreach ($subject_saved as $k => $v) {

                    $content.='<tr>
                            <td style="vertical-align: middle; text-align: center">'.($k+1).'</td>
                            <td>'. $v->subject .'</td>
                            <td style="text-align: center">'.$v->grade.'</td>
                            </tr>';
                }
                $content .='</tbody>
                </table>';
            }

            $comment = '<div class="alert alert-danger">'.($rowvalue->comment == '' ? '<img src="'.base_url().'/icon/loader.gif" style="width: 16px;"/> Please wait...' : $rowvalue->comment ) .'</div>';
            $content .= '<div id="dv_message_' . $rowvalue->id . '">'.($rowvalue->comment <> 'Success' ? $comment :'' ).'</div>';


        }

        echo json_encode(array('content'=>$content,'hide'=>$hide));
    }

}
