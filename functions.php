<?php
$servername = "localhost";
// Your Database name
$dbname = "restaurant";
// Your Database user
$username = "root";
// Your Database user password
$password = "";

function con(){
    global $servername, $username, $password, $dbname;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
     return   die("Connection failed: " . $conn->connect_error);
    }
    else {
        return $conn;
    }
}
function updateOutput($emg_st,$pre_st,$rdy_st,$board) {
    $conn=con ();
    $sql="UPDATE data SET emg_st=$emg_st,pre_st=$pre_st,rdy_st=$rdy_st WHERE board=$board";
    if ($conn->query($sql) === TRUE) {
        return "Output state updated successfully";
    }
    else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    }
function save_order($order_num,$board) {
    $conn=con ();
    $sql="UPDATE data SET order_num=$order_num WHERE board=$board";
    if ($conn->query($sql) === TRUE) {
        return "Output state updated successfully";
    }
    else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    }
function emg_update($emg_st,$board) {
    $conn=con ();
    $sql="UPDATE data SET pre_st=0,rdy_st=0,emg_st=$emg_st WHERE board=$board";
    if ($conn->query($sql) === TRUE) {
        return "Output state updated successfully";
    }
    else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    }
function rst_update($board) {
    $conn=con ();
    $sql="UPDATE data SET pre_st=0,rdy_st=0,emg_st=0 ,order_num=0 WHERE board=$board";
    if ($conn->query($sql) === TRUE) {
        return "Output state updated successfully";
    }
    else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    }

function getAllOutputStates($board) {
    $conn=con ();

    $sql = "SELECT pre_pin, pre_st, rdy_pin, rdy_st, emg_pin, emg_st FROM data WHERE board = $board";
    if ($result = $conn->query($sql)) {
        return $result;
    }
    else {
        return false;
    }
    $conn->close();
}
function display() {
    $conn=con ();
    $sql = "SELECT board, order_num, pre_pin, pre_st, rdy_pin, rdy_st, emg_st, emg_pin FROM data ORDER BY board";
    if ($result = $conn->query($sql)) {
        return $result;
    }
    else {
        return false;
    }
    $conn->close();
}
?>