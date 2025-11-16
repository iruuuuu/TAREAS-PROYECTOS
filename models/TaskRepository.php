<?php 

class TaskRepository{

    public static function getTaskByProyectId($id){
        $db = Connection::connect();
        $q = "SELECT * FROM tasks WHERE project_id=" . $id . " ORDER BY datetime DESC";
        $result = $db->query($q);

        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = new Task($row['id'], $row['name'], $row['description'], $row['datetime'], $row['project_id'], $row['user_id']);
        }
        return $tasks;
    }

    public static function getTasks(){
        $db = Connection::connect();
        $q = "SELECT * FROM tasks ORDER BY datetime DESC";
        $result = $db->query($q);
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = new Task($row['id'], $row['name'], $row['description'], $row['datetime'], $row['project_id'], $row['user_id']);
        }
        return $tasks;
    }

    public static function create($task){
        $db = Connection::connect();
        $q = "INSERT INTO tasks (name, description, datetime, project_id, user_id) VALUES ('" . $task->getName() . "', '" . $task->getDescription() . "', '" . $task->getDatetime() . "', " . $task->getProjectId() . ", " . $task->getUserId() . ")";
        $db->query($q);
    }

    public static function delete($id){
        $db = Connection::connect();
        $q = "DELETE FROM tasks WHERE id = " . $id;
        $db->query($q);
    }
}