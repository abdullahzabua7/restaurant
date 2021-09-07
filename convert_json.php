<?php
include_once('functions.php');

$board= $action = $gpio = $state = "";

header('Access-Control-Allow-Origin: *');



if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = test_input($_GET["action"]);
    $board = test_input($_GET["board"]);

    if ($action == "btn_web") 
    { 
        $emg_st = test_input($_GET["emg_st"]);
        echo $emg_st;
        $pre_st = test_input($_GET["pre_st"]);
        echo $pre_st;
        $rdy_st = test_input($_GET["rdy_st"]);
        echo $rdy_st;
        $result = updateOutput($emg_st,$pre_st,$rdy_st,$board);
        echo $result;
    }
    else if ($action == "order") 
    { 
        $order_num = test_input($_GET["order_num"]);
        $result = save_order($order_num,$board);
        echo $result;
    }
    else if ($action == "emg") 
    { 
        $emg_st = test_input($_GET["emg_st"]);
        echo $emg_st;
        $result = emg_update($emg_st,$board);
        echo $result;
    }
    else if ($action == "rst") 
    { 
        $result = rst_update($board);
        echo $result;
    }
    //node MCU code will call this with action outputs_state
    else if($action == "outputs_state")
    {
        $result = getAllOutputStates($board);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                
                $row3 = array($row["pre_pin"] =>$row["pre_st"],$row["rdy_pin"] =>$row["rdy_st"],$row["emg_pin"] =>$row["emg_st"]   );
            }
        }
        echo json_encode($row3);
    }
    
    else {
        echo "Invalid HTTP request.";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
