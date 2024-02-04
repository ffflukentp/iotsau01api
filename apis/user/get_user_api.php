<?php
header("Access-control-allow-origin: *");
header("content-type: application/json; charset=UTF-8");

include_once "./../../databaseconnect.php";
include_once "./../../models/user.php";

$databaseConnect = new DatabaseConnect();
$connDB = $databaseConnect->getConnection();

$getallUser = new User($connDB);

//เรียกใช้ Function ตามวัตถุประสงค์ของ API ตัวนี้
$stmt = $getallUser->getUser();

//นับแถวเพื่อดูว่าได้ข้อมูลมาไหม 
$numrow = $stmt->rowCount();

//สร้างตัวแปรมาเก็บข้อมูลที่ได้จากการเรียกใช้ function เพื่อส่งกับไปยังส่วนที่เรียกใช้ API
$getallUser_arr = array();

//ตรวจสอบผล และส่งกลับไปยังส่วนที่เรียกใช้ API
if ($numrow > 0) {
    //มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $getallUser_item = array(
            "user_id" => $user_id,
            "user_fullname" => $user_fullname,
            "user_name" => $user_name,
            "user_age" => $user_age
        );

        array_push($getallUser_arr, $getallUser_item);
    }
} else {
    //ไม่มีข้อมูล เอาข้อมูลใส่ตัวแปร และเตรียมส่งกลับ
    $getallUser_item = array(
        "massage" => "0"
    );
        array_push($getallUser_arr, $getallUser_item);
}

//คำสั่งจัดการข้อมูลใหเฃ้เป็น JSON เพื่อส่งกลับ
http_response_code(200);
echo json_encode($getallUser_arr,JSON_UNESCAPED_UNICODE);