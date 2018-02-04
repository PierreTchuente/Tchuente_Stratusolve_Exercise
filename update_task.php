<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');

// Assignment: Implement this script


function CreateTaskUpdate ($taskID, $taskName, $taskDescription) {
    $newTask = new Task($taskID, $taskName, $taskDescription);
    $newTask->Save();
    die('save successfully');
}

if($_POST['action'] == "CreateTaskUpdate"){
    logData($_POST);
    CreateTaskUpdate($_POST['taskID'], $_POST['taskname'], $_POST['taskDescription']);
}

if($_POST['action'] == "TaskDetails"){
   $task =  Task::getTaskDetails($_POST['taskID']);
   die($task);
}


if($_POST['action'] == "deleteTask"){
    Task::Delete($_POST['taskID']);
    die("successfully deleted");
}

?>