<?php

/**
 * Database operations including CREATE USER, UPDATE USER, DELETE USER.
 */
class DbOperation
{
    public function __construct()
    {
        require_once dirname(__FILE__).'/DbConnection.php';
        $db = new DBConnection();
        $this->con = $db->connect();
        
    }

    public function createPAuser($phone_id, $phone_number)
    {
            $stmt = $this->con->prepare('INSERT INTO `PA_user` (`phone_id`, `phone_number`)
            VALUES (?,?);');

            $stmt->bind_param('ss', $phone_id, $phone_number);

            if ($stmt->execute()) {
                return 1;
            } else {
                return 2;
            }
        
    }
     public function createStdCode($s_code, $phone_id)
    
    {
            $stmt = $this->con->prepare('UPDATE `PA_user` SET `s_code`=? WHERE `phone_id`=?');

            $stmt->bind_param('ss', $s_code, $phone_id);

            if ($stmt->execute()) {
                return 1;
            } else {
                return 2;
            }
        
    }
     public function createStdBrand($s_brand, $phone_id)
    {
            $stmt = $this->con->prepare('UPDATE `PA_user` SET `s_brand`=? WHERE `phone_id`=?');

            $stmt->bind_param('ss', $s_brand, $phone_id);

            if ($stmt->execute()) {
                return 1;
            } else {
                return 2;
            }
        
        
    }
     public function createDCode($d_code, $phone_id)
    {
            $stmt = $this->con->prepare('UPDATE `PA_user` SET `d_code`=? WHERE `phone_id`=?');

            $stmt->bind_param('ss', $d_code, $phone_id);

            if ($stmt->execute()) {
                return 1;
            } else {
                return 2;
            }
        
    }
     public function createDBrand($d_brand, $phone_id)
    {
             $stmt = $this->con->prepare('UPDATE `PA_user` SET `d_brand`=? WHERE `phone_id`=?');

            $stmt->bind_param('ss', $d_brand, $phone_id);

            if ($stmt->execute()) {
                return 1;
            } else {
                return 2;
            }
        
    }
     public function createFCode($f_code, $phone_id)
    {
            $stmt = $this->con->prepare('UPDATE `PA_user` SET `f_code`=? WHERE `phone_id`=?');

            $stmt->bind_param('ss', $f_code, $phone_id);

            if ($stmt->execute()) {
                return 1;
            } else {
                return 2;
            }
        
    }
     public function createFBrand($f_brand, $phone_id)
    {
             $stmt = $this->con->prepare('UPDATE `PA_user` SET `f_brand`=? WHERE `phone_id`=?');

            $stmt->bind_param('ss', $f_brand, $phone_id);

            if ($stmt->execute()) {
                return 1;
            } else {
                return 2;
            }
    }

    public function findFirmByIdSMark($s_brand)
    {
        $sql = "SELECT * FROM firmlisting WHERE product_name='$s_brand' OR product_brand='$s_brand' OR product_id='$s_brand' LIMIT 0,1";
        // var_dump($sql);
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
                return 0;
        }

        
    }
    public function findFirmByIdDMark($d_brand)
    {
        $sql = "SELECT * FROM dmark WHERE product='$d_brand'OR product_id='$d_brand' LIMIT 0,1";
        // var_dump($sql);
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
                return 0;
        }

        
    }

    public function findFirmByIdFMark($f_brand)
    {
        $sql = "SELECT * FROM fortification WHERE product_name='$f_brand' OR product_brand='$f_brand' OR  fortification_id='$f_brand' LIMIT 0,1";
        // var_dump($sql);
        $result = $this->con->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
                return 0;
        }

        
    }



    public function phoneExistsCheck($phone_id)
    {
        $checkStmt = $this->con->prepare('SELECT user_id FROM PA_user WHERE phone_id=?');
        $checkStmt->bind_param('s', $phone_id);
        $checkStmt->execute();
        $checkStmt->store_result();

        return $checkStmt->num_rows;
    }
}
