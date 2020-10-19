<?php
require('./fpdf.php');
class createPDF extends FPDF
{
	// Load data
	function LoadData()
	{
		// Read file lines
		$data_array = array();
		$sizeArray = array();
		$header = array();
		include("data.php");

		// Header
		foreach ($data_arr as $row) {
			foreach ($row as $key => $value) {
				$size = 2 * strlen($key) + 1;
				array_push($sizeArray, $size);
				array_push($header, $key);
			}
			break;
		}

		// Data
		foreach ($data_arr as $row) {
			$data = array();
			$i = 0;
			foreach ($row as $key => $value) {
				$size = 2 * strlen($value) + 1;
				$sizeArray[$i] = $size >= $sizeArray[$i] ? $size : $sizeArray[$i];
				$i++;
				array_push($data, $value);
			}
			array_push($data_array, $data);
		}


		$result = array();
		array_push($result, $header);
		array_push($result, $data_array);
		array_push($result, $sizeArray);
		return $result;
	}

	// Simple table
	function BasicTable($header, $data, $sizeArray)
	{

		$i = 0;
		foreach ($header as $col) {
			$this->Cell($sizeArray[$i++], 7, $col, 1, 0, 'C');
			//array_push($sizeArray, $size);
		}
		$this->Ln();
		// Data
		foreach ($data as $row) {
			$i = 0;
			foreach ($row as $col) {
				$this->Cell($sizeArray[$i++], 6, $col, 1, 0, 'R');
			}
			$this->Ln();
		}
	}
}
$pdf = new createPDF();
$data = $pdf->LoadData();
$pdf->SetFont('Times', '', 10);
$pdf->AddPage('L');
$pdf->BasicTable($data[0], $data[1], $data[2]);
$pdf->Output('myFile.pdf', 'F');
$pdf->Output();
