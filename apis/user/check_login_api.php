<?php
header("Access-control-allow-origin: *");
header("content-type: application/json; charset=UTF-8");

include_once "./../../databaseconnect.php";
include_once "./../../models/user.php";

$databaseConnect = new DatabaseConnect();
$connDB = $databaseConnect->getConnection();

$user = new user($connDB);

//สร้างตัวแปรเก็บค่าของข้อมูลที่ส่งมาซึ่งเป็น JSON ที่ทำการ decode แล้ว
$data = json_decode(file_get_contents("php://input"));

//เอาข้อมูลที่ถูก Decode ไปเก็บในตัวแปร
$user->user_name = $data->user_name;
$user->user_password = $data->user_password;

//เรียกใช้ Function ตามวัตถุประสงค์ของ API ตัวนี้
$stmt = $user->checkLoginUser();

//นับแถวเพื่อดูว่าได้ข้อมูลมาไหม 
$numrow = $stmt->rowCount();

//สร้างตัวแปรมาเก็บข้อมูลที่ได้จากการเรียกใช้ function เพื่อส่งกับไปยังส่วนที่เรียกใช้ API
$user_arr = array();

//ตรวจสอบผล และส่งกลับไปยังส่วนที่เรียกใช้ API
if ($numrow > 0) {
    //มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user_item = array(
            "message" => "1",
            "user_id" => $user_id,
            "user_fullname" => $user_fullname,
            "user_age" => $user_age,
        );

        array_push($user_arr, $user_item);
    }
} else {
    //ไม่มีข้อมูล เอาข้อมูลใสาตัวแปร และเตรียมส่งกลับ
    $user_item = array(
        "massage" => "0"
    );
        array_push($user_arr, $user_item);
}

//คำสั่งจัดการข้อมูลใหเฃ้เป็น JSON เพื่อส่งกลับ
http_response_code(200);
echo json_encode($user_arr, JSON_UNESCAPED_UNICODE);