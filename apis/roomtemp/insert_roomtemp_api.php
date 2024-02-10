<?php
//API ที่ทำหน้าที่รับ Request จาก Client เพื่อนำข้อมูลที่ Client ส่งมาไปบันทึกบน Database แล้ว Response กลับไปยัง Client ว่าบันทึกเรียบร้อยแล้ว
header("Access-control-allow-origin: *");
header("content-type: application/json; charset=UTF-8");

include_once "./../../databaseconnect.php";
include_once "./../../models/roomtemp.php";

$databaseConnect = new DatabaseConnect();
$connDB = $databaseConnect->getConnection();

$roomtemp = new Roomtemp($connDB);

//สร้างตัวแปรเก็บค่าของข้อมูลที่ส่งมาซึ่งเป็น JSON ที่ทำการ decode แล้ว
$data = json_decode(file_get_contents("php://input"));

//เอาข้อมูลที่ถูก Decode ไปเก็บในตัวแปร
$roomtemp->temp1 = $data->temp1;
$roomtemp->temp2 = $data->temp2;
$roomtemp->temp3 = $data->temp3;
$roomtemp->datesave = $data->datesave;
$roomtemp->timesave = $data->timesave;

//เรียกใช้ Function ตามวัตถุประสงค์ของ API ตัวนี้
if($stmt = $roomtemp->insertRoomtemp()){
    //บันทึกข้อมูลสำเร็จ
   http_response_code(200);
   echo json_encode(array("message"=>"1")); 
}else{
    //บันทึกข้อมูลไม่สำเร็จ
    http_response_code(200);
    echo json_encode(array("message"=>"0"));     
}