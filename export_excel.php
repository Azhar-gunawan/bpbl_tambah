<?php
require 'config/database.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Fetch data from the database
$query = "SELECT ID, USERID, ROLE_CODE, FULLNAME, KD_LIT, KD_INSTALATIR, KD_UPI, KD_AREA, KD_ULP FROM app_userid";
$result = $mysqli->query($query);

if ($result === false) {
    die('Query Error: ' . $mysqli->error);
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add headers to the Excel sheet
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'User ID');
$sheet->setCellValue('C1', 'Role Code');
$sheet->setCellValue('D1', 'Fullname');
$sheet->setCellValue('E1', 'KD_LIT');
$sheet->setCellValue('F1', 'KD_INSTALATIR');
$sheet->setCellValue('G1', 'KD_UPI');
$sheet->setCellValue('H1', 'KD_AREA');
$sheet->setCellValue('I1', 'KD_ULP');

// Populate the data
$rowNumber = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNumber, $row['ID']);
    $sheet->setCellValue('B' . $rowNumber, $row['USERID']);
    $sheet->setCellValue('C' . $rowNumber, $row['ROLE_CODE']);
    $sheet->setCellValue('D' . $rowNumber, $row['FULLNAME']);
    $sheet->setCellValue('E' . $rowNumber, $row['KD_LIT']);
    $sheet->setCellValue('F' . $rowNumber, $row['KD_INSTALATIR']);
    $sheet->setCellValue('G' . $rowNumber, $row['KD_UPI']);
    $sheet->setCellValue('H' . $rowNumber, $row['KD_AREA']);
    $sheet->setCellValue('I' . $rowNumber, $row['KD_ULP']);
    $rowNumber++;
}

// Output to a file
$filename = "user_data_" . date('YmdHis') . ".xlsx";
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');

exit;
?>
