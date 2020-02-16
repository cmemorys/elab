<?php
class M_Email extends CI_Model {
            

    function verifyEmailAddress($verificationcode){  
        $sql = "update tbl_mahasiswa set active_status='active' WHERE email_verification_code=?";
        $this->db->query($sql, array($verificationcode));
        return $this->db->affected_rows(); 
    }
    
    
}
?>