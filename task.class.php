<?php
/**
 * This class handles the modification of a task object
 */
require('Utility_Function.php');

class Task {
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;

    /*
        public function __construct($Id = null) {
        $this->TaskDataSource = file_get_contents('Task_Data.txt');
        if (strlen($this->TaskDataSource) > 0)
        $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        else
        $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array

        if (!$this->TaskDataSource)
        $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        if (!$this->LoadFromId($Id))
        $this->Create();
    }*/

    public function __construct($taskId = null, $taskName, $taskDescription) {
        //$this->TaskDataSource = file_get_contents('Task_Data.txt');
        $this->readFile_Util(); // read once from the file.

        if (strlen($this->TaskDataSource) > 0){
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects

            if($taskId == null){  // new task

                $taskId = $this->getUniqueId();
                $newTask  = new stdClass();
                $newTask->TaskId = $taskId + 1;
                $newTask->TaskName = $taskName;
                $newTask->TaskDescription = $taskDescription;
                logData("login out the new task");
                $this->TaskDataSource[$taskId] = $newTask; //still an array at this point
            }elseif ($taskId > 0){  // we are updating
                //
                $newTask  = new stdClass();
                $newTask->TaskId =  $taskId;
                $newTask->TaskName = $taskName;
                $newTask->TaskDescription = $taskDescription;
                logData("login out the updating task");
                $this->TaskDataSource[$taskId - 1] = $newTask; ////we updating the array at position $taskId - 1
            }

        }
        else{
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
            $newTask  = new stdClass();
            $newTask->TaskId = 1; // because it is the first task;
            $newTask->TaskName = $taskName;
            $newTask->TaskDescription = $taskDescription;
            logData("login out the new task");
            $this->TaskDataSource[0] = $newTask; //first element since the array is empty.
        }
    }

    //utility to read from the file
     private function readFile_Util(){
         $this->TaskDataSource = file_get_contents('Task_Data.txt');
     }

    protected function Create() {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        $this->TaskId = $this->getUniqueId();
        $this->TaskName = 'New Task';
        $this->TaskDescription = 'New Description';
    }
    protected function getUniqueId() {
        // Assignment: Code to get new unique ID
        $taskArrayLength = sizeof($this->TaskDataSource);
        if ( $taskArrayLength > 0){
            return $taskArrayLength;
        } else{
            return 1;
        }
        return -1; //if we get this far it means something went wrong.
    }
    protected function LoadFromId($Id = null) {
        if ($Id != null && $Id > 0) {
            // Assignment: Code to load details here...
            $arrayTask =  json_decode($this->TaskDataSource);
            return $arrayTask[$Id];

        } else
            return null;
    }

    public static function getTaskDetails($Id = null) {
        if ($Id > 0) {
            // Assignment: Code to load details here...
            $fileContent = file_get_contents('Task_Data.txt');
            logData('BEFORE ENCODING');
            logData($fileContent);
            $arrayTask =  json_decode($fileContent, true);
            return json_encode($arrayTask[$Id - 1]);
        } else
            return null;
    }

    public function Save() {
        //Assignment: Code to save task here
        logData('entering the save function');
        $this->TaskDataSource  = json_encode($this->TaskDataSource);
        file_put_contents('Task_Data.txt', $this->TaskDataSource); // writing to the file.
    }

    /**
     * @param $Id
     */
    public static function Delete($Id) {  // deleting a task required the task id to be deleted.
        //Assignment: Code to delete task here

        logData($Id);

        // Assignment: Code to load details here...
        $fileContent = file_get_contents('Task_Data.txt');
        $arrayTask =  json_decode($fileContent, true);
        $length = sizeof($arrayTask);

        logData('BEFORE LOOPING');
        logData(json_encode($arrayTask));

        for ($i = $Id;  $i < $length ; $i++){
            $arrayTask[$i]["TaskId"]  = $arrayTask[$i]["TaskId"] - 1; // shifting all ids from $Id downward.
        }
        array_splice($arrayTask, $Id-1, 1);
        logData('AFTER SLICING');
        logData(json_encode($arrayTask));
        if(sizeof($arrayTask) == 0){
            file_put_contents('Task_Data.txt', "");
        }else {
            file_put_contents('Task_Data.txt', json_encode($arrayTask));
        }

    }
}
?>