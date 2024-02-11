<?php
class Roomtemp
{
    //ตัวแปรที่ใช้ในการติดต่อ Database
    private $conn;

    //ตัวแปรที่จะทำงานคู่กับแต่ละฟิวล์ในตาราง
    public $roomtemp_id;
    public $temp1;
    public $temp2;
    public $temp3;
    public $datesave;
    public $timesave;
    public $strdatesave;
    public $enddatesave;

    //ตัวแปรที่เก็บข้อความต่าง ๆ เผื่อไว้ใช้งาน เฉย ๆ
    public $message;

    //คอนตรักเตอร์ที่จะมีคำสั่งที่ใช้ในการติดต่อกับ Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //function getallRoomtemp
    function getallRoomtemp()
    {
        $strSQL = "SELECT * FROM roomtemp_tb";

        $stmt = $this->conn->prepare($strSQL);

        $stmt->execute();

        return $stmt;
    }

    //function insertUser ที่ทำงานกับ insert_roomtemp_api.php
    function insertRoomtemp()
    {
        $strSQL = "INSERT INTO roomtemp_tb (temp1, temp2, temp3, datesave, timesave) VALUES(:temp1, :temp2, :temp3, :datesave, :timesave)";

        $stmt = $this->conn->prepare($strSQL);

        //ตรวจสอบข้อมูล
        $this->temp1 = htmlspecialchars(strip_tags($this->temp1));
        $this->temp2 = htmlspecialchars(strip_tags($this->temp2));
        $this->temp3 = htmlspecialchars(strip_tags($this->temp3));
        $this->datesave = htmlspecialchars(strip_tags($this->datesave));
        $this->timesave = htmlspecialchars(strip_tags($this->timesave));

        //กำหนดข้อมูลให้ Parameter
        $stmt->bindParam(":temp1", $this->temp1);
        $stmt->bindParam(":temp2", $this->temp2);
        $stmt->bindParam(":temp3", $this->temp3);
        $stmt->bindParam(":datesave", $this->datesave);
        $stmt->bindParam(":timesave", $this->timesave);

        //สั่งให้ SQL ทำงาน
        if ($stmt->execute()) {
            //สำเร็จ
            return true;
        } else {
            //ไม่สำเร็จ
            return false;
        }
    }

    //function getbytimeRoomtemp
    function getbytimeRoomtemp()
    {
        $strSQL = "SELECT * FROM roomtemp_tb WHERE timesave = :timesave";

        // กำหนด Statement ที่จะทำงานกับคำสั่ง SQL
        $stmt = $this->conn->prepare($strSQL);

        // ตรวจสอบข้อมูล
        $this->timesave = htmlspecialchars(strip_tags($this->timesave));

        // กำหนดข้อมูลให้ Parameter
        $stmt->bindParam(":timesave", $this->timesave);

        // สั่งให้ SQL ทำงาน
        $stmt->execute();
        // ส่งผลลัพธ์ที่ได้จากคำสั่ง SQL ไปใช้งาน
        return $stmt;
    }

    //function getbydateRoomtemp
    function getbydateRoomtemp()
    {
        $strSQL = "SELECT * FROM roomtemp_tb WHERE datesave = :datesave";

        // กำหนด Statement ที่จะทำงานกับคำสั่ง SQL
        $stmt = $this->conn->prepare($strSQL);

        // ตรวจสอบข้อมูล
        $this->datesave = htmlspecialchars(strip_tags($this->datesave));

        // กำหนดข้อมูลให้ Parameter
        $stmt->bindParam(":datesave", $this->datesave);

        // สั่งให้ SQL ทำงาน
        $stmt->execute();
        // ส่งผลลัพธ์ที่ได้จากคำสั่ง SQL ไปใช้งาน
        return $stmt;
    }

    //function getbydateRoomtemp
    function getbydatebetweenRoomtemp()
    {
        $strSQL = "SELECT * FROM roomtemp_tb WHERE datesave between :strdatesave AND :enddatesave";

        // กำหนด Statement ที่จะทำงานกับคำสั่ง SQL
        $stmt = $this->conn->prepare($strSQL);

        // ตรวจสอบข้อมูล
        $this->strdatesave = htmlspecialchars(strip_tags($this->strdatesave));
        $this->enddatesave = htmlspecialchars(strip_tags($this->enddatesave));

        // กำหนดข้อมูลให้ Parameter
        $stmt->bindParam(":strdatesave", $this->strdatesave);
        $stmt->bindParam(":enddatesave", $this->enddatesave);

        // สั่งให้ SQL ทำงาน
        $stmt->execute();
        // ส่งผลลัพธ์ที่ได้จากคำสั่ง SQL ไปใช้งาน
        return $stmt;
    }
}