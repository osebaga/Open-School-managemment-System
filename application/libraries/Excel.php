<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** PHPExcel */
/**
* 
*/
class Excel
{

    private  $excel_object = null;
    private  $sheet_object = null;
    private  $filename = null;

    function __construct()
    {
        require_once APPPATH.'/third_party/excel/PHPExcel.php';
        require_once APPPATH.'/third_party/excel/PHPExcel/IOFactory.php';
    }


    function load($excel_path){
        $this->filename = pathinfo($excel_path,PATHINFO_BASENAME);
        $this->excel_object = IOFactory::load($excel_path);
        $this->sheet_object = $this->excel_object->getActiveSheet();
    }

    function get_total_sheet(){
        return $this->excel_object->getSheetCount();
    }

    function excel_row(){
        return $this->sheet_object->getHighestRow();
    }


    function excel_toArray(){
        return $this->sheet_object->toArray(null, true, true, true);
    }


    function get_sheet_instance(){
        return $this->sheet_object;
    }

    function get_instance(){
        return $this->excel_object;
    }

    function create_sheet($sheet_name='Sheet Name',$sheetno=1,$font=12,$merge_column='H'){
        $this->excel_object->createSheet($sheetno);
        $this->excel_object->getSheet($sheetno)->setTitle($sheet_name);
        $this->excel_object->setActiveSheetIndex(1);

        $this->sheet_object = $this->excel_object->getActiveSheet();

        $this->sheet_object->getDefaultRowDimension()->setRowHeight(15);

        $this->sheet_object->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->sheet_object->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $this->sheet_object->getPageSetup()->setFitToWidth(1);
        $this->sheet_object->getPageSetup()->setFitToHeight(0);

        $this->sheet_object->setShowGridlines(false);

        $this->excel_object->getDefaultStyle()->getFont()->setName('helvetica');
        #Set page margins
        $this->sheet_object->getPageMargins()->setTop(0.5);
        $this->sheet_object->getPageMargins()->setRight(0.5);
        $this->sheet_object->getPageMargins()->setLeft(0.5);
        $this->sheet_object->getPageMargins()->setBottom(0.5);
        for ($clo = 'A'; $clo < 'ZZ'; $clo++) {
            $this->sheet_object->getColumnDimension($clo)->setAutoSize(true);
        }

        # Set Rows to repeate in each page
        //$this->sheet_object->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);

        $collegeinfo = get_collage_info();
        #Set footer page numbers
        $this->excel_object->getDefaultStyle()->getFont()->setSize(8);
        $this->sheet_object->getHeaderFooter()->setOddFooter('&L&"-,Italic"'.$collegeinfo->Name. "\n Printed on : &D  , &T".' &C&"-,Italic"Page &P/&N &R&"-,Italic" SIMS SOFTWARE V2');
        $this->sheet_object->getHeaderFooter()->setEvenFooter('&L&"-,Italic"'.$collegeinfo->Name. "\n Printed on :&D  , &T".' &C&"-,Italic"Page &P/&N &R&"-,Italic" SIMS SOFTWARE V2');


        $this->sheet_object->mergeCells('B1:'.$merge_column.'1');
        $this->sheet_object->mergeCells('B2:'.$merge_column.'2');
        $this->sheet_object->mergeCells('B3:'.$merge_column.'3');
        $this->sheet_object->setCellValue('B1', strtoupper($collegeinfo->Name));
        $this->sheet_object->setCellValue('B2', $collegeinfo->PostalAddress.' '.
            $collegeinfo->City.' . Email : '.$collegeinfo->Email.' , Website : '.$collegeinfo->Site);
        $this->sheet_object->getStyle('B1')->getFont()->setSize(18);
        $this->sheet_object->getStyle('B2')->getFont()->setSize(11);
        $this->sheet_object->getStyle('B3')->getFont()->setSize(15);
        $this->sheet_object->getRowDimension('1')->setRowHeight(26);
        $this->sheet_object->getRowDimension('2')->setRowHeight(15);
        $this->sheet_object->getRowDimension('3')->setRowHeight(20);
        $this->sheet_object->getStyle('B1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel_object->getDefaultStyle()->getFont()->setSize($font);
    }

    function startExcel($font=12,$merge_column='H') {
        $this->excel_object = new PHPExcel();

      // Set properties
        $this->excel_object->getProperties()->setCreator("SIMS SOFTWARE")
            ->setLastModifiedBy("SIMS SOFTWARE")
            ->setSubject("SIMS SOFTWARE")
            ->setDescription("SIMS SOFTWARE")
            ->setKeywords("SIMS SOFTWARE")
            ->setCategory("SIMS SOFTWARE");

        $this->sheet_object = $this->excel_object->getActiveSheet();


        $this->sheet_object->getDefaultRowDimension()->setRowHeight(15);


        $this->sheet_object->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->sheet_object->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A3);

        $this->sheet_object->getPageSetup()->setFitToWidth(1);
        $this->sheet_object->getPageSetup()->setFitToHeight(0);

        $this->sheet_object->setShowGridlines(false);

        $this->excel_object->getDefaultStyle()->getFont()->setName('helvetica');
        #Set page margins
        $this->sheet_object->getPageMargins()->setTop(0.5);
        $this->sheet_object->getPageMargins()->setRight(0.5);
        $this->sheet_object->getPageMargins()->setLeft(0.5);
        $this->sheet_object->getPageMargins()->setBottom(0.5);
        for ($clo = 'A'; $clo < 'ZZ'; $clo++) {
            $this->sheet_object->getColumnDimension($clo)->setAutoSize(true);
        }

        # Set Rows to repeate in each page
        //$this->sheet_object->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);

        $collegeinfo = get_collage_info();
        #Set footer page numbers
        $this->excel_object->getDefaultStyle()->getFont()->setSize(8);
        $this->sheet_object->getHeaderFooter()->setOddFooter('&L&"-,Italic"'.$collegeinfo->Name. "\n Printed on : &D  , &T".' &C&"-,Italic"Page &P/&N &R&"-,Italic" SIMS SOFTWARE V2');
        $this->sheet_object->getHeaderFooter()->setEvenFooter('&L&"-,Italic"'.$collegeinfo->Name. "\n Printed on :&D  , &T".' &C&"-,Italic"Page &P/&N &R&"-,Italic" SIMS SOFTWARE V2');


        $this->sheet_object->mergeCells('B1:'.$merge_column.'1');
        $this->sheet_object->mergeCells('B2:'.$merge_column.'2');
        $this->sheet_object->mergeCells('B3:'.$merge_column.'3');
        $this->sheet_object->setCellValue('B1', strtoupper($collegeinfo->Name));
        $this->sheet_object->setCellValue('B2', $collegeinfo->PostalAddress.' '.
            $collegeinfo->City.' . Email : '.$collegeinfo->Email.' , Website : '.$collegeinfo->Site);
        $this->sheet_object->getStyle('B1')->getFont()->setSize(18);
        $this->sheet_object->getStyle('B2')->getFont()->setSize(11);
        $this->sheet_object->getStyle('B3')->getFont()->setSize(15);
        $this->sheet_object->getRowDimension('1')->setRowHeight(26);
        $this->sheet_object->getRowDimension('2')->setRowHeight(15);
        $this->sheet_object->getRowDimension('3')->setRowHeight(20);
        $this->sheet_object->getStyle('B1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel_object->getDefaultStyle()->getFont()->setSize($font);
    }

    function Output($filename='Excel'){
        //Excel 2007
        $objWriter = IOFactory::createWriter($this->excel_object, "Excel2007");
       // header('Content-Type: application/vnd.ms-excel');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
//header('Content-Disposition: attachment; filename="name_of_excel_file.xls"');        
header('Cache-Control: max-age=0');
        ob_end_clean();
       return $objWriter->save('php://output');
    }


} 
?>
