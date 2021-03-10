<?php
include 'includes/db_connect.php';
require_once 'Classes/PHPExcel.php';
$excel = new PHPExcel();

$excel->setActiveSheetIndex(0); 
$excel->getActiveSheet()->SetCellValue('A1', 'Uploaded By');
$excel->getActiveSheet()->SetCellValue('B1', 'Document Type/Name');
$excel->getActiveSheet()->SetCellValue('C1', 'Expired On');
$excel->getActiveSheet()->SetCellValue('D1', 'Province');
$excel->getActiveSheet()->SetCellValue('E1', 'Current Status');
$excel->getActiveSheet()->getStyle("A1:E1")->getFont()->setBold( true );

/// SALES REORDS
										$sr = 1;
															$today = date('Y-m-d');												
															if($sess_user_type == 'admin'){
															$insql = "";
															}
															else {
															$insql = "`user_id` IN (SELECT `id` FROM `users` WHERE `parent_id`='".$_SESSION['portal_id']."') AND";	
															}

                                                            $file_q = mysqli_query($db, "SELECT * FROM `user_license` WHERE $insql `expiry_date`<='".$today."' AND `status`='1'");
                                                            while($file_f = mysqli_fetch_assoc($file_q)){
                                                            $sr++;
															
															/*if($file_f['status'] == '1'){
															$label = 'label-success';
															$status_txt = 'Approved';
															}
															else if($file_f['status'] == '0'){
															$label = 'label-info';	
															$status_txt = 'Pending';
															}
															else if($file_f['status'] == '2'){
															$label = 'label-warning';
															$status_txt = 'Rejected';	
															}*/
															
															$license_type = $file_f['license_type'];
															if($license_type == 'eo'){
															$license_type = 'Error`s and Omission (E&O)';
															}
															//uploaded by name
															$u_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$file_f['user_id']."'");
                                                            $u_f = mysqli_fetch_assoc($u_q);
															$uploadedby = $u_f['fname'].' '.$u_f['lname'];
															
															//approved by name
															$a_q = mysqli_query($db, "SELECT * FROM `users` WHERE `id`='".$file_f['approved_by']."'");
                                                            $a_f = mysqli_fetch_assoc($a_q);
															$approvedby = $a_f['fname'].' '.$a_f['lname'];
										
										
//SALES RECORDS
$excel->getActiveSheet()->SetCellValue('A'.$sr, $uploadedby.' '.$file_f['dated']);
$excel->getActiveSheet()->SetCellValue('B'.$sr, $license_type);
$excel->getActiveSheet()->SetCellValue('C'.$sr, $file_f['expiry_date']);
$excel->getActiveSheet()->SetCellValue('D'.$sr, $file_f['province']);
$excel->getActiveSheet()->SetCellValue('E'.$sr, 'Expired');
}

$file = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$file->save('documentsreport.xlsx');
//$file->save("php://output");
?>
<script>
window.location='documentsreport.xlsx';
</script>