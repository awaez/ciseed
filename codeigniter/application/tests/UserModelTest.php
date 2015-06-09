<?php

class UserModelTest extends CIUnit_Framework_TestCase
{
    private $user;
    private $insertedStudentID;



    protected function setUp()
    {
        $this->get_instance()->load->model('User_model', 'user');
        $this->user = $this->get_instance()->user;
    }



    public function testInsertStudent()
    {
        $data = array(
           'user_name'  => 'John',
           'password'   => 'JohnSecret',
        );

        $this->insertedStudentID = $this->user->insert_student($user_name = 'John', $password = 'JohnSecret');
        
        $this->assertGreaterThan(0, $this->insertedStudentID, 'Insertion Test Failed');
    }



    /**
     * @depends testInsertStudent
     */
    public function testGetStudents(){
        $this->testInsertStudent();

        $this->assertTrue(count($this->user->get_students($offset = 0, $limit = 10)) >= 1, 'Getting-Students Test Failed.');
    }



    /**
     * @depends testInsertStudent
     */
    public function testUpdateStudentById(){
        $this->testInsertStudent();
        
        $this->user->update_student_by_id($this->insertedStudentID, $user_name = 'New_John', $password = 'New_JonhSecret');
        
        $studentsDS = $this->user->get_students($offset = 0, $limit = 10000);
        $studentsDS_count = count($studentsDS);
        
        $this->assertTrue($studentsDS_count > 0, 'Retrival of the students failed');
        
        if($studentsDS_count > 0){
            foreach($studentsDS as $student){
                if($student['id'] == $this->insertedStudentID){
                    $this->assertEquals('New_John', $student['user_name'], 'Updating username failed.');
                    $this->assertEquals('New_JonhSecret', $student['password'], 'Updating password failed.');
                }
            }
        }

    }



    /**
     * @depends testInsertStudent
     */
    public function testDeleteStudentById()
    {
        $this->testInsertStudent();

        $this->assertTrue( $this->user->delete_student_by_id($this->insertedStudentID), 'Deletion Test Failed.');
    }



    /**
     * @depends testDeleteStudentById
     */
    protected function tearDown()
    {
        $this->user->delete_student_by_id($this->insertedStudentID);
    }
    
}

?>