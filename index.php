
<?php
include_once('functions.php');

$result = display();

$html_buttons = null;
if ($result) {
    while ($row = $result->fetch_assoc()) {
        if ($row["pre_st"] == "1"){
            $button_checked_1 = "checked";
        }
        else {
            $button_checked_1 = "";
        }
        if ($row["state_2"] == "1"){
            $button_checked_2 = "checked";
        }
        else {
            $button_checked_2 = "";
        }
        $html_buttons.= '<h3>'.'Device '. $row["board"].'</h3>
    
        <label class="switch">
        <input type="checkbox" onchange="buttonClick_1(this)" id="'.$row["board"].'_'.$row["state_2"].'" '. $button_checked_1 . '>
        
        <span class="slider"></span></label>';
        $html_buttons .= '<h3>' .' </h3>
        <label class="switch">
        <input type="checkbox" onchange="buttonClick_2(this)" id="'.$row["board"].'_'.$row["pre_st"].'"  ' . $button_checked_2 . '>
        <span class="slider"></span></label>';
    }
}
//<input type="checkbox" onchange="buttonClick_1(this)" board="'.$row["board"].'"' . $button_checked_1 . '>
?>

<!DOCTYPE HTML>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="esp-style.css">
    <title>AZ electronics</title>
</head>
<body>
<h2>AZ Restaurant</h2>
<?php echo $html_buttons;

?>
<br><br>

<script>
    function buttonClick_1(element) {
        //debugger;
        var a = element.id;
        var b = a.split("_");   //b[0]=board value, b[1]= state value
        var xhr = new XMLHttpRequest();
        if(element.checked){
            xhr.open("GET","http://192.168.0.102/restaurant/convert_json.php?action=btn_web&pre_st=1&state_2="+b[1]+"&board="+b[0], true);
            
        }
        else {
            xhr.open("GET","http://192.168.0.102/restaurant/convert_json.php?action=btn_web&pre_st=0&state_2="+b[1]+"&board="+b[0] ,true) ;
        } 
        xhr.send();
    }
    //setInterval(() => window.location.href="http://az-electronic-nodemcu.000webhostapp.com"
   // setInterval(() => window.location.href="http://192.168.0.105/Two_way_led_control"
   // , 10000);

    function buttonClick_2(element) {
        //debugger;
        var a = element.id;
        var b = a.split("_");   //b[0]=board value, b[1]= state value
        var xhr = new XMLHttpRequest();
        if(element.checked){
            xhr.open("GET","http://192.168.0.102/restaurant/convert_json.php?action=btn_web&pre_st="+b[1]+"&state_2=1&board="+b[0], true);
            
        }
        else {
            xhr.open("GET","http://192.168.0.102/restaurant/convert_json.php?action=btn_web&pre_st="+b[1]+"&state_2=0&board="+b[0], true);
            
        }
        xhr.send();
    }
    //setInterval(() => window.location.href="http://az-electronic-nodemcu.000webhostapp.com"
   // setInterval(() => window.location.href="http://192.168.0.105/Two_way_led_control"
   // , 10000);
    

    
</script>
</body>
</html>
