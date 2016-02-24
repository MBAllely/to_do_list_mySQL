<?php
    class Category
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO categories (name) VALUES ('{$this->getName()}')"); //Adds names into categories table

            $this->id = $GLOBALS['DB']->lastInsertId(); //reassigns id to equal the id of the last thing insterted into the database(?)
        }

        function getTasks()
        {
            $tasks = [];
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks WHERE category_id = {$this->getId()};"); //grabs task objects from DB task table
            foreach($returned_tasks as $task) {
                $description = $task['description']; //grabs description of each task
                $due_date = $task['due_date'];
                $id = $task['id']; //grabs id of each task
                $category_id = $task['category_id']; //grabs category_id of each task
                $new_task = new Task($description, $due_date, $id, $category_id); //intantiates a new Task with the arguments $description, $id, and $category_id
                array_push($tasks, $new_task); //pushes each new intatiation into $tasks array
            }
            return $tasks; //returns array of $tasks from database
        }

        static function getAll() //gets all Category objects
        {
            $returned_categories = $GLOBALS['DB']->query("SELECT * FROM categories;"); //returns everything in the categories table
            $categories = [];
            foreach($returned_categories as $category) {
                $name = $category['name'];
                $id = $category['id'];
                $new_category = new Category($name, $id);
                array_push($categories, $new_category);
            }
            return $categories;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM categories;");
        }

        static function find($search_id)
        {
            $found_category = null;
            $categories = Category::getAll();
            foreach($categories as $category) {
                $category_id = $category->getId();
                if ($category_id == $search_id) {
                  $found_category = $category;
                }
            }
            return $found_category;
        }
    }
?>
