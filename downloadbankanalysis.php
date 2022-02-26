<?php
include 'phpexcel/PHPExcel.php';
include 'config.php';
$bank = $_GET['bank'];
/** Error reporting */
error_reporting( E_ALL );
ini_set( 'display_errors', TRUE );
ini_set( 'display_startup_errors', TRUE );
//date_default_timezone_set( 'Kenya (GMT+3)' );

//create ne PHPExcel object
$objPHPExcel = new PHPExcel();

//set document properties
$objPHPExcel->getProperties()->setCreator( 'Macra Systes' )
->setLastModifiedBy( 'Macra Systems' )
->setTitle( 'Bank Analysis Export' )
->setSubject( 'Bank Analysis Export' )
->setDescription( 'Bank Analysis Document.' )
->setKeywords( 'office 2007 openxml php' )
->setCategory( 'Bank Analysis file' );

//add headings
$objPHPExcel->SetActiveSheetIndex( 0 )
->SetCellValue( 'A1', 'Mno' )
->SetCellValue( 'B1', 'Names' )
->SetCellValue( 'C1', 'Net' )
->SetCellValue( 'D1', 'Month' )
->SetCellValue( 'E1', 'Bank' );

// Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex( 0 )
->setCellValue( 'A4', 'Miscellaneous glyphs' )
->setCellValue( 'A5', 'éàèùâêîôûëïüÿäöüç' );

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle( 'Simple' );

//set active sheet index to the first sheet so Excel opens it at the first sheet
$objPHPExcel->setActiveSheetIndex( 0 );

// Redirect output to a client’s web browser ( Excel5 )
header( 'Content-Type: application/vnd.ms-excel' );
header( 'Content-Disposition: attachment;filename="'.$bank.'.xls"' );
header( 'Cache-Control: max-age=0' );
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age = 1' );

// If you're serving to IE over SSL, then the following may be needed
header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
// Date in the past
header ( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).' GMT' );
// always modified
header ( 'Cache-Control: cache, must-revalidate' );
// HTTP/1.1
header ( 'Pragma: public' );
// HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );
$objWriter->save( 'php://output' );
exit;
?>