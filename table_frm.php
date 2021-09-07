<?php
include_once('functions.php');
$result = display();
$html_device = null;
header("Refresh:5");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $board=$row["board"];
        $html_device.= '<tr>
        <th scope="row">'.$row["board"].'</th>';
        if  ($row["order_num"] == "0"){
            $html_device.= 
            '<td><input type="int" id="order_num_'.$row["board"].'"  name="order" style="position: relative;">
            <input type="button" value="Ok" class="ok "  onclick="order_click(this)" id="'.$row["board"].'" > </td>
            <td><input type="button" value="Prepare" class="pre" disabled>
                <input type="button" value="Ready for devilvery" class="rdy" disabled>
                <input type="button" value="Alert" class="emg" disabled> 
                <input type="button" value="Reset" class="rst" disabled>
            </td>
        </tr>';
                
        }
        else {
            $html_device.= 
            '<td><input type="int" id="order_num_'.$row["board"].'"  name="order" style="position: relative;"value="'.$row["order_num"].'" disabled >
            <input type="button" value="Ok" class="ok " disabled > </td>';
            

            if ($row["pre_st"] == "0" && $row["rdy_st"] == "0" && $row["emg_st"] == "0"){
                $html_device.=
                '<td>
                    <input type="button" value="Prepare" class="pre"onclick="prepare_click(this)" id="'.$row["board"].'">';
                }
            else{
                $html_device.=
                '<td><input type="button" value="Preparing" class="pre" disabled>';
            }
            if ($row["rdy_st"] == "0" && $row["pre_st"] == "1" && $row["emg_st"] == "0"){
                $html_device.='<input type="button" value="Ready for devilvery" class="rdy" onclick="ready_click(this)" id="'.$row["board"].'">';
            }
            else{
                $html_device.='<input type="button" value="Ready for devilvery" class="rdy" disabled>';
            }
            $html_device.=
                '<input type="button" value="Alert" class="emg" onclick="emg_click(this)" id="'.$row["board"].'"> 
                <input type="button" value="Reset" class="rst"onclick="reset_click(this)" id="'.$row["board"].'">
            </td>
        </tr>';   
    }
            
    }
}

?>

<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="table_style.css">
    <title>AZ electronics</title>
</head>

<body>
    <h1>AZ Restaurant</h1>
    <table class="table ">
    <tr>
    <th scope="col">Device </th>
    <th scope="col">Order no</th>
    <th scope="col">Status</th>
  </tr>
  </thead>
  <tbody>
        <?php 
        
         echo $html_device;
         
        ?>

   </tbody>
    </table>

    <br><br>

    <script>
        function prepare_click(element) {
            debugger;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "http://192.168.0.101/restaurant/convert_json.php?action=btn_web&pre_st=1&rdy_st=0&emg_st=0&board=" + element.id, true);
            xhr.send();

        }

        function ready_click(element) {
            debugger;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "http://192.168.0.101/restaurant/convert_json.php?action=btn_web&pre_st=0&rdy_st=1&emg_st=0&board=" + element.id, true);
            xhr.send();
        }
        function reset_click(element) {
            debugger;

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "http://192.168.0.101/restaurant/convert_json.php?action=rst&board=" + element.id, true);
            xhr.send();
        }
        function emg_click(element) {
            debugger;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "http://192.168.0.101/restaurant/convert_json.php?action=emg&emg_st=1&board=" + element.id, true);
            xhr.send();
        }
        function order_click(element) {
            debugger;
            var b = element.id;
            var a = "order_num_"+b;
            
            var order = document.getElementById(a).value;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "http://192.168.0.101/restaurant/convert_json.php?action=order&board=" + element.id + "&order_num=" + order, true);
            xhr.send();
            //document.getElementById("order_num").value='';
        }




    </script>
</body>

</html>