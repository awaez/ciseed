<?php

class WelcomeControllerTest extends CIUnit_Framework_TestCase
{
    private $insertedStudentId;



    protected function setUp()
    {
        $this->get_instance()->load->library('../controllers/welcome.php');
    }



    public function testCreateNewStudent()
    {
        $createdStudent = $this->get_instance()->create_new_student($is_test = TRUE);
        $this->insertedStudentId = json_decode($createdStudent)->id;
  
        $this->assertTrue($createdStudent !== 0, 'Student creation test failed.');
    }



    /**
     * @depends testCreateNewStudent
     */
    public function testUpdateStudent()
    {
        $createdStudent = $this->get_instance()->create_new_student($is_test = TRUE);
        $createdStudentObj = json_decode($createdStudent);
        $this->insertedStudentId = $createdStudentObj->id;
        $_GET['id'] = $this->insertedStudentId;

        $updatedStudent = $this->get_instance()->update_student($is_test = TRUE);
        $updatedStudentObj = json_decode($updatedStudent);

        $this->assertTrue($updatedStudent !== 0, 'Student update test failed.');
        $this->assertTrue($createdStudentObj->user_name !== $updatedStudentObj->user_name, 'Student user_name didnot get updated.');
        $this->assertTrue($createdStudentObj->password !== $updatedStudentObj->password, 'Student password didnot get updated.');
    }



    /**
     * @depends testCreateNewStudent
     */
    public function testDeleteStudent()
    {
        $createdStudent = $this->get_instance()->create_new_student($is_test = TRUE);
        $this->insertedStudentId = json_decode($createdStudent)->id;
        $_GET['id'] = $this->insertedStudentId;

        $studentDeletion = $this->get_instance()->delete_student($is_test = TRUE);

        $this->assertTrue($studentDeletion !== 0, 'Student deletion test failed.');
    }



    /**
     * @depends testDeleteStudent
     */
    protected function tearDown()
    {
        $_GET['id'] = $this->insertedStudentId;

        $this->get_instance()->delete_student($is_test = TRUE);
    }

}

?>