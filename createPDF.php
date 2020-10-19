<?php
require('./fpdf.php');
class createPDF extends FPDF
{
	// Load header, table data, collumn size
	function LoadData($data_arr)
	{
		// Read file lines
		$dat = array();
		$data_array = array();
		$header = array();
		$sizeArray = array();
		
		foreach ($data_arr as $row) {
			foreach ($row as $key => $value) {
				array_push($header, $key);
				$size = 2 * strlen($key) + 7;
				array_push($sizeArray, $size);
			}
			break;
		}
		foreach ($data_arr as $row) {
			$data = array();
			$i = 0;
			foreach ($row as $key => $value) {
				array_push($data, $value);
				$size = 2 * strlen($value) + 1;
				$sizeArray[$i] = $size >= $sizeArray[$i] ? $size : $sizeArray[$i];
				$i++;
			}
			array_push($data_array, $data);
		}
		array_push($dat, $header);
		array_push($dat, $data_array);
		array_push($dat, $sizeArray);
		return $dat;
	}
	// Simple table
	function BasicTable($header, $data, $sizeArray)
	{
		// Header
		$i = 0;
		$this->SetFont('Times', 'B', 10);
		foreach ($header as $col) {
			$col = strtoupper($col);
			$this->Cell($sizeArray[$i++], 7, $col, 1, 0, 'C');
			//array_push($sizeArray, $size);
		}
		$this->Ln();
		// Data
		$this->SetFont('Times', '', 10);
		foreach ($data as $row) {
			$i = 0;
			foreach ($row as $col) {
				$this->Cell($sizeArray[$i++], 6, $col, 1, 0, 'C');
			}
			$this->Ln();
		}
	}
}
$pdf = new createPDF();
// Column headings
// $header = $pdf->LoadHeader();
// Data loading
include("data.php");
$data = $pdf->LoadData($data_arr);
$pdf->AddPage('L');
$pdf->BasicTable($data[0], $data[1], $data[2]);
$pdf->Output('myFile.pdf', 'F');
$pdf->Output();