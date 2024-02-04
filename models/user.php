<?php
class User{
    //ตัวแปรที่ใช้ในการติดต่อ Database
    private $conn;

    //ตัวแปรที่จะทำงานคู่กับแต่ละฟิวล์ในตาราง
    public $user_id;
    public $user_fullname;
    public $user_name;
    public $user_password;
    public $user_age;

    //ตัวแปรที่เก็บข้อความต่าง ๆ เผื่อไว้ใช้งาน เฉย ๆ
    public $message;

    //คอนตรักเตอร์ที่จะมีคำสั่งที่ใช้ในการติดต่อกับ Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

      //function getUser
    function getUser()
      {
          $strSQL = "SELECT * FROM user_tb";
  
          $stmt = $this->conn->prepare($strSQL);
  
          $stmt->execute();
  
          return $stmt;
      } 

    //function insertUser ที่ทำงานกับ insert_user_api.php
    function insertUser(){
        $strSQL = "INSERT INTO user_tb (user_fullname, user_name, user_password, user_age) VALUES(:user_fullname, :user_name, :user_password, :user_age)";

        $stmt = $this->conn->prepare($strSQL);

        //ตรวจสอบข้อมูล
        $this->user_fullname = htmlspecialchars(strip_tags($this->user_fullname));
        $this->user_name = htmlspecialchars(strip_tags($this->user_name));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));
        $this->user_age = htmlspecialchars(strip_tags($this->user_age));

        //กำหนดข้อมูลให้ Parameter
        $stmt->bindParam(":user_fullname", $this->user_fullname);
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":user_password", $this->user_password);
        $stmt->bindParam(":user_age", $this->user_age);

        //สั่งให้ SQL ทำงาน
        if($stmt->execute()){
            //สำเร็จ
            return true;
        }else{
            //ไม่สำเร็จ
            return false;
        }          
    }

    //function checkLoginUser
    function checkLoginUser()
    {
        $strSQL = "SELECT * FROM user_tb WHERE user_name = :user_name and user_password = :user_password";

        //กำหนด Statement ที่จะทำงานกับคำสั่ง SQL
        $stmt = $this->conn->prepare($strSQL);

        //ตรวจสอบข้อมูล
        $this->user_name = htmlspecialchars(strip_tags($this->user_name));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));

        //กำหนดข้อมูลให้ Parameter
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":user_password", $this->user_password);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งผลลัพธ์ที่ได้จากคำสั่ง SQL ไปใช้งาน
        return $stmt;
    } 

    function updateUser(){
        $strSQL = "UPDATE user_tb SET user_fullname = :user_fullname, user_name = :user_name, user_password = :user_password, user_age = :user_age WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($strSQL);

        //ตรวจสอบข้อมูล
        $this->user_id = intval(htmlspecialchars(strip_tags($this->user_id)));
        $this->user_fullname = htmlspecialchars(strip_tags($this->user_fullname));
        $this->user_name = htmlspecialchars(strip_tags($this->user_name));
        $this->user_password = htmlspecialchars(strip_tags($this->user_password));
        $this->user_age = htmlspecialchars(strip_tags($this->user_age));

        //กำหนดข้อมูลให้ Parameter
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":user_fullname", $this->user_fullname);
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":user_password", $this->user_password);
        $stmt->bindParam(":user_age", $this->user_age);

        //สั่งให้ SQL ทำงาน
        if($stmt->execute()){
            //สำเร็จ
            return true;
        }else{
            //ไม่สำเร็จ
            return false;
        }  
    }
}