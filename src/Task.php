<?php
class Task
{
    private $description;
    private $due_date;
    private $category_id;
    private $id;

    function __construct($description, $due_date, $id = null, $category_id)
    {
        $this->description = $description;
        $this->due_date = $due_date;
        $this->id = $id;
        $this->category_id = $category_id;
    }


    function setDescription($new_description)
    {
        $this->description = (string) $new_description;
    }

    function setDueDate($new_due_date)
    {
        $this->due_date = (string) $new_due_date;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getDueDate()
    {
        return $this->due_date;
    }

    function getId()
    {
        return $this->id;
    }

    function getCategoryId()
    {
        return $this->category_id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO tasks (description, due_date, category_id) VALUES ('{$this->getDescription()}', '{$this->getDueDate()}', {$this->getCategoryId()})");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll() //gets all task objects
    {
        $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;"); //queries everything in the 'tasks' table and sets it equal to $returned_tasks
        $tasks = [];
        foreach($returned_tasks as $task) { //each $task is an object with 'description', 'category_id', and 'id' properties
            $description = $task['description']; //returns 'description' property
            $due_date = $task['due_date'];
            $id = $task['id']; //returns 'id' property
            $category_id = $task['category_id']; //returns 'category_id' property
            $new_task = new Task($description, $due_date, $id, $category_id); //intantiates a new Task with $description, $id, and $category_id as the arguments
            array_push($tasks, $new_task); //pushes $new_task into empty $tasks array.  $new_task is created each time the loop runs
        }
        return $tasks; //returns associative array of  $task objects
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM tasks");
    }

    static function find($search_id) //takes a search item as an argument
    {
        $found_task = null;
        $tasks = Task::getAll(); //gets all tasks
        foreach($tasks as $task) {
            $task_id = $task->getId(); //gets the id of each task
            if ($task_id == $search_id) { //if the task id matches the search id, it's added to $found_task
                $found_task = $task;
            }
        }
        return $found_task;
    }

}
?>
