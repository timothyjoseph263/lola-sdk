<?php

namespace Controllers;

class Controllers {}

class DatabaseController extends Controllers
{

    public $conn;

    public $allItems;
    public $current_filter;

    public $listofItems;

    public function __construct()
    {
        $this->conn = $this->establishConnection();
    }

    static function establishConnection()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!mysqli_connect_errno()) {
            $status = "Successfully Connected to the database";
        } else {
            $status = "Failed to establish connection to" . DB_NAME . ' via ' . DB_HOST;
            file_put_contents('connection_error_log.txt', $status);
        }
        return $conn;
    }

    // Collect all the stuff or list of things to search from

    public function collectList()  
    {
        // By default the table is declared as 'LIST_TABLE' in the env.php file so you can change it there but for a more manual approach change it here.
        // If you have already changed in the env.php file just uncomment the code below.
        $table = 'blog';
        /*$table = LIST_TABLE; */ 
        $selectQuery = "SELECT * FROM " . $table;
        $results = mysqli_query($this->conn, $selectQuery);
        $result = mysqli_fetch_all($results);
        $this->allItems = $result;
        $this->listofItems = $result;
        return $this->listofItems;
    }

    public function IsfilterApplied()
    {
        if(isset($_POST['type'])) {
            $filter = $_POST['type'];
            $list_table = LIST_TABLE;
            $FilterselectQuery = "SELECT * FROM $list_table WHERE `type` = '$filter'";
            $results = mysqli_query($this->conn, $FilterselectQuery);
            $result = mysqli_fetch_all($results);
            $listofItems = $result;
            $this->listofItems = $listofItems;
            $this->current_filter = $_POST['type'];
            return $this->listofItems;
        }else{ 
            // if no filter is applied ...it should just show everything
            $this->collectList();
            foreach($this->allItems as $item){ 
                return $item;
            }
        }
    }
}


global $conn;
$conn = new DatabaseController();
$conn::establishConnection();

