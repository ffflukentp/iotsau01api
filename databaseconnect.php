<?php
//เป็นไฟล์กลางที่จะใช้ร่วมกับ Api ต่าง ๆ เพื่อที่จะใช้ติดต่อ และทำงานกับ Database
class DatabaseConnect
{
    //ประกาศตัวแปรเก็บค่าต่างๆ ที่จะต้องใช้ในกาติดต่อกับฐานข้อมูล
    private $host = "localhost";
    private $uname = "root";
    private $pword = "";
    private $dbname = "iotsau_01_db";

    //ประกาศตัวแปรเพื่อใช้สำหรับการติดต่อกับฐานข้อมูล
    public $conn;

    //ฟังก์ชันสำหรับการติดต่อไปยังฐานข้อมูล
    public function getConnection()
    {
        $this->conn = null;

        try {
            //ติดต่อฐานข้อมูล
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->uname, $this->pword);
            //log ดูผลว่าติดต่อฐานข้อมูลได้หรือไม่ได้ แล้วอย่าลืม comment
            //echo "Connect OK";

        } catch (PDOException $ex) {
            //log ดูผลว่าติดต่อฐานข้อมูลได้หรือไม่ได้ แล้วอย่าลืม comment
            //echo "Connect NOT OK";
        }

        return $this->conn;
    }
}
// สร้างอ็อบเจ็กต์ของคลาส DatabaseConnect
 //$db = new DatabaseConnect();

// เรียกใช้งานฟังก์ชัน getConnection() เพื่อเชื่อมต่อกับฐานข้อมูล
 //$connection = $db->getConnection();
