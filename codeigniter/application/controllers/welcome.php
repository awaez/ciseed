<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$students = $this->user_model->get_students(0,10);

		
		$data['students']	= $students;

		$this->load->view('welcome_message', $data);
	}
	
	
	
	/**
	 * Create new students with random user_name and random password
	 *
	 * @Parameters none
	 * @return inserted_student_id on successful insertion | 0 on insertion failure
	 */
	public function create_new_student($is_test = FALSE){
		$this->load->helper('string');

		$rand_user_name	= random_string('alpha', 8);
		$rand_password	= random_string('alnum', 8);
		
		$user_creation = $this->user_model->insert_student($rand_user_name, $rand_password);
		
		if($user_creation !== FALSE){
			$new_student_info = array('id' => $user_creation, 'user_name' => $rand_user_name, 'password' => $rand_password);
			if($is_test)
				return json_encode($new_student_info);
			else
				echo json_encode($new_student_info);
		}else{	//creation failed
			if($is_test)
				return 0;
			else
				echo 0;
		}
	}
	


	/**
	 * Updating student's user_name and password according to the supplied $id
	 *
	 * @Parameters $_GET[id int]
	 * @return json on successful updation | 0 on updation failure
	 */
	public function update_student($is_test = FALSE){
		$id = $this->input->get('id');
		if($id){
			$this->load->helper('string');
	
			$rand_user_name	= random_string('alpha', 8);
			$rand_password	= random_string('alnum', 8);
			
			$user_updation = $this->user_model->update_student_by_id($id, $rand_user_name, $rand_password);
			
			if($user_updation !== FALSE){
				$updated_student_info = array('user_name' => $rand_user_name, 'password' => $rand_password);
				if($is_test)
					return json_encode($updated_student_info);
				else
					echo json_encode($updated_student_info);
			}else{	//update failed
				if($is_test)
					return 0;
				else
					echo 0;
			}
		}else{	//Id was missing
			if($is_test)
				return 0;
			else
				echo 0;
		}
	}



	/**
	 * Delete student with supplied $id
	 *
	 * @Parameters $_GET[id int]
	 * @return 1 on successful deletion | 0 on deletion failure
	 */
	public function delete_student($is_test = FALSE){
		$id = $this->input->get('id');
		if($id){
			$user_deletion = $this->user_model->delete_student_by_id($id);
			
			if($user_deletion !== FALSE){	//deletion successful
				if($is_test)
					return 1;
				else
					echo 1;
			}else{	//deletion failed
				if($is_test)
					return 0;
				else
					echo 0;
			}
		}else{	//Id was missing
			if($is_test)
				return 0;
			else
				echo 0;
		}
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */