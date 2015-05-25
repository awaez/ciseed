<?php

class User_model extends CI_Model
{

	var $user_name				= '';	
	var $password				= '';


    public function __construct ()
    {
        parent::__construct();
    }
    

    /**
     * Create a new student with the specified info 
     *
     * @access public
     * @param $user_name [str], $password[str]
     * @return TRUE on successful insertion | FALSE on insertion failure
     */
     public function insert_student($user_name, $password){
        $data = array(
           'user_name'  => $user_name,
           'password'   => $password,
        );
        
        $this->db->insert('Student', $data);

		if( $this->db->insert_id() ){
			return $this->db->insert_id();
		}else{
			return FALSE;
		}
     }


    
    /**
     * get Students from the table according to the $limit & $offset variables
     *
     * @access public
     * @param $offset [int OPTIONAL], $limit [int OPTIONAL]
     * @return array on successful retrival | FALSE on no results being found
     */
     public function get_students($offset = 0, $limit = 10){
        $query = $this->db->get('Student', $limit, $offset);

		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return FALSE;
		}
     }



    /**
     * Update the student with $id with the new username and password
     *
     * @access public
     * @param $id id of the user being updated [int], $user_name [str], $password[str]
     * @return TRUE on successful update AND actual rows being affected | FALSE on update failure or no rows getting affected
     */
     public function update_student_by_id($id, $user_name, $password){
        $data = array(
           'user_name'  => $user_name,
           'password'   => $password,
        );
        
        $this->db->where('id', $id);
        $this->db->update('Student', $data);

		if($this->db->affected_rows() > 0){	//Some rows actually got affected
			return TRUE;
		}else{	//Query was run but no rows got affected
			return FALSE;
		}
     }



    /**
     * Delete the student with the supplied $id
     *
     * @access public
     * @param $id id of the user being deleted [int]
     * @return TRUE on successful deletion | FALSE on deletion failure
     */
     public function delete_student_by_id($id){
        $this->db->where('id', $id);
        $this->db->delete('Student');

		if($this->db->affected_rows() > 0){	//Some rows actually got deleted
			return TRUE;
		}else{	//Query run but no rows got deleted
			return FALSE;
		}
     }


}

?>