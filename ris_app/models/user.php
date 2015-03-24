<?php
class User extends DataMapper
{
    
    function __construct($id = NULL) {
        parent::__construct($id);
    }

    function userRoleByID($user_id, $role_id) {
        $this->db->_protect_identifiers = false;
        $this->db->select('roles.permission AS inherit');
        $this->db->from('users');
        $this->db->join('roles', 'FIND_IN_SET(roles.id, users.role_id) > 0');
        $this->db->where('users.id', $user_id);
        $this->db->where('roles.id', $role_id);
        $res = $this->db->get();
        if ($res->num_rows > 0) {
            $result = $res->result();
            return unserialize($result[0]->inherit);
        } else {
            return false;
        }
    }	
}
?>
