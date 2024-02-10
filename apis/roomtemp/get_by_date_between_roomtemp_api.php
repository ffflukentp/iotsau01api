<?php
header("Access-control-allow-origin: *");
header("content-type: application/json; charset=UTF-8");

include_once "./../../databaseconnect.php";
include_once "./../../models/roomtemp.php";

$databaseConnect = new DatabaseConnect();
$connDB = $databaseConnect->getConnection();

$Roomtemp = new Roomtemp($connDB);

//สร้างตัวแปรเก็บค่าของข้อมูลที่ส่งมาซึ่งเป็น JSON ที่ทำการ decode แล้ว
$data = json_decode(file_get_contents("php://input"));

//เอาข้อมูลที่ถูก Decode ไปเก็บในตัวแปร
$Roomtemp->strdatesave = $data->strdatesave;
$Roomtemp->enddatesave = $data->enddatesave;

//เรียกใช้ Function ตามวัตถุประสงค์ของ API ตัวนี้
$stmt = $Roomtemp->getbydatebetweenRoomtemp();

//นับแถวเพื่อดูว่าได้ข้อมูลมาไหม 
$numrow = $stmt->rowCount();

//สร้างตัวแปรมาเก็บข้อมูลที่ได้จากการเรียกใช้ function เพื่อส่งกับไปยังส่วนที่เรียกใช้ API
$Roomtemp_arr = array();

//ตรวจสอบผล และส่งกลับไปยังส่วนที่เรียกใช้ API
if ($numrow > 0) {
    //มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $Roomtemp_item = array(
            "roomtemp_id" => $roomtemp_id,
            "temp1" => $temp1,
            "temp2" => $temp2,
            "temp3" => $temp3,
            "datesave" => $datesave,
            "timesave" => $timesave,
        );

        array_push($Roomtemp_arr, $Roomtemp_item);
    }
} else {
    //ไม่มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    $Roomtemp_item = array(
        "massage" => "0"
    );
        array_push($Roomtemp_arr, $Roomtemp_item);
}

//คำสั่งจัดการข้อมูลใหเฃ้เป็น JSON เพื่อส่งกลับ
http_response_code(200);
echo json_encode($Roomtemp_arr, JSON_UNESCAPED_UNICODE);