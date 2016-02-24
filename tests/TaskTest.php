<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class TaskTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Task::deleteAll();
            Category::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "next monday";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $due_date, $id, $category_id);
            $test_task->save();

            //Act
            $result = $test_task->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getDueDate()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "next monday";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $due_date, $id, $category_id);
            $test_task->save();

            //Act
            $result = $test_task->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }


        function test_getCategoryId()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "next monday";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $due_date, $id, $category_id);
            $test_task->save();

            //Act
            $result = $test_task->getCategoryId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "next monday";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $due_date, $id, $category_id);

            //Act
            $test_task->save();

            //Assert
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]); //$test_task will be the first thing in the $result array
        }

        function test_getAll()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "next monday";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $due_date, $id, $category_id);
            $test_task->save();

            $description2 = "Water the lawn";
            $due_date2 = "Christmas";
            $test_task2 = new Task($description2, $due_date, $id, $category_id);
            $test_task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_task, $test_task2], $result); //saved tasks will be the in the $result array
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "next monday";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $due_date, $id, $category_id);
            $test_task->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result); //tasks array will be empty
        }

        function test_find()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = "next monday";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $due_date, $id, $category_id);
            //$test_task is a new instance of Task; an object
            $test_task->save(); //MUST BE SAVED

            $description2 = "Water the lawn";
            $due_date2 = "Christmas";
            $test_task2 = new Task($description2, $due_date2, $id, $category_id);
            $test_task2->save();

            //Act
            $result = Task::find($test_task->getId()); //should return the id of $test_task

            //Assert
            $this->assertEquals($test_task, $result); //$test_task will be the first thing in the $result array
        }

    }

 ?>
