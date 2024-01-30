<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
$this->load->library('pdf');
$pdf = $this->pdf->startPDF('A4');
$pdf->SetHTMLHeader($this->pdf->PDFHeader());
$pdf->SetHTMLFooter($this->pdf->PDFFooter());
$html = '<style>' . file_get_contents('./media/css/pdf_css.css') . '</style>';
$html .= '<h3 style="text-align: center; padding: 0px; margin: 0px;">APPLICATION FORM IPOSA</h3>';
$kituoinfo=get_value('iposa_vituo', $APPLICANT->kituoname,'');

$html .= ' <div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
         TAARIFA BINAFSI
     </div>';
$html .= '<table style="width: 100%;">
<tr>
<td style="width: 40%; vertical-align: top;">
<label>Namba ya Usajili : </label> ' . $APPLICANT->registrationnumber . '<br/>
 <label>Jina la kwanza : </label> ' . $APPLICANT->FirstName . '<br/>
     <label>Jina la ukoo : </label> ' . $APPLICANT->LastName . '<br/>
 <label>Jina la kati : </label> ' . $APPLICANT->MiddleName . '<br/>
 <label>Jinsia : </label> ' . $APPLICANT->Gender . '<br/>
 <label>Kiwango cha elimu : </label> ' . iposa_eduction_type($APPLICANT->education) . '<br/>
 <label>Tarehe ya Kuzaliwa : </label> ' . format_date($APPLICANT->dob, false) . '<br/>
  <label>Kabila : </label> ' . $APPLICANT->tribe . '<br/>
  <label>Hali ya Ndoa : </label> ' . (($APPLICANT->marital_status=='Single')?(($APPLICANT->Gender=='Male')?'Sijaoa':'Sijaolewa'):(($APPLICANT->Gender=='Male')?'Nimeoa':'Nimeolewa  ')) . '<br/>
    <label>Idadi ya watoto : </label> ' . $APPLICANT->children . '<br/>
 </td>
<td style="width: 40%; vertical-align: top;">
 <label>Mkoa : </label> ' . get_value('regions', $APPLICANT->region, 'name') . '<br/>
 <label>District : </label> ' . get_value('districts', $APPLICANT->district, 'name') . '<br/>
 <label>Kata : </label> ' . $APPLICANT->ward . '<br/>
 <label>Kijiji : </label> ' . $APPLICANT->villege . '<br/>
 <label>Mwaka wa usajili : </label> ' . $APPLICANT->AYear . '<br/>
    <label>Kazi unayofanya kwa sasa : </label> ' . iposa_job_type($APPLICANT->job) . '<br/>
    <label>Aina ya ulemavu(Kama ipo) : </label> ' . iposa_disability_type($APPLICANT->Disability) . '<br/>
    <label>Mambo unayopenda kujifunza : </label> ' . $APPLICANT->wanttolean . '<br/>
</tr>
</table>';


$html .= '<br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            TAARIFA ZA MTU WA KARIBU
        </div>';

$html .= '<table style="width: 100%;">
<tr>
<td style="width: 50%; vertical-align: top;">
 <label>Jina la mtu wa karibu : </label> ' . $APPLICANT->kinname . '<br/>
 <label>Uhusiano : </label> ' . $APPLICANT->kinrelation . '<br/>
 <label>Namba ya Simu ya mtu wa karibu : </label> ' . $APPLICANT->kinmobile . '<br/>
</td>
</tr>
</table>';

$html .= '<br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            UTHIBITISHO KUTOKA SERIKALI YA MTAA/KIJIJI 
        </div>';

$html .= '<table style="width: 100%;">
<tr>
<td style="width: 50%; vertical-align: top;">
 <label>Jina la Mratibu Elimu Kata : </label> ' . $APPLICANT->mratibuname . '<br/>
 <label>Namba ya Simu Mratibu : </label> ' . $APPLICANT->mratibumobile . '<br/>
 <label>Tarehe : </label> ' . $APPLICANT->mratibudate . '<br/>
</td>
</tr>
</table>';

$html .= '<br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
            TAARIFA ZA KITUO
        </div>';

$html .= '<table style="width: 100%;">
<tr>
<td style="width: 50%; vertical-align: top;">
 <label>Jina la Kituo : </label> ' . $kituoinfo->name . '<br/>
 <label>Anuani : </label> ' . $kituoinfo->anuani . '<br/>
 <label>Jina la Mkuu wa Kituo : </label> ' . $kituoinfo->jinalamkuu . '<br/>
 <label>Namba ya Simu ya Mkuu wa kituo : </label> ' . $kituoinfo->simuyamkuu . '<br/>
 <label>Tarehe : </label> ' . $kituoinfo->kituodate . '<br/>
</td>
</tr>
</table>';














$html .= '<br/><div style="font-weight: bold; font-size: 15px; margin-bottom: 15px; color: brown; border-bottom: 1px solid brown">
    DECLARATION
</div>';
$html .= 'I, ' . $APPLICANT->FirstName . ' ' . $APPLICANT->LastName . ' Nathibitisha ya kwama taarifa nilizotoa ni za kweli kwa ufahamu wangu nikiwa mwenye akili timamu.';


$pdf->WriteHTML($html);
$fileArray = array();
if($APPLICANT->attachment)
        $fileArray[] = UPLOAD_FOLDER . 'attachment/' . $APPLICANT->attachment;



$outputName = UPLOAD_FOLDER . 'attachment/' . current_user()->id . '_MERGE.pdf';
if (file_exists($outputName)) {
    unlink($outputName);
}
$cmd = "gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=$outputName ";

if (count($fileArray) > 0) {
    foreach ($fileArray as $file) {
        $cmd .= $file . " ";
    }

    $result = shell_exec($cmd);

    $pdf->AddPage();
    $pdf->SetImportUse();
    $pagecount = $pdf->SetSourceFile($outputName);
    for ($i = 1; $i <= $pagecount; $i++) {
        $tplId = $pdf->ImportPage($i);
        $pdf->UseTemplate($tplId, 5, 17, 200);
        if ($i < $pagecount)
            $pdf->AddPage();
    }


}

if (file_exists($outputName)) {
    unlink($outputName);
}

//Close and output PDF document
$pdf->Output('APPLICATION_FORM' . '.pdf', 'D');
exit;
?>