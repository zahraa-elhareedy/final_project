<?php 
    session_start();
    $status="available";
    $car_plate=$_GET['car'];
    $start_date=$_POST['returndate'];
    $register_no=$_POST['register_no'];
    $date = date_create($start_date);
    date_add($date,date_interval_create_from_date_string("4 years"));
    $end_date = date_format($date,"Y-m-d");
    $conn = new mysqli('localhost','root','','car_rental');
    if($conn->connect_error){
        echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} 
 else{
    $statement = $conn->prepare("insert into car_status (car_plate,status,start_date,end_date) values(?, ?, ?,?)");
    $statement->bind_param("ssss", $car_plate,$status, $start_date, $end_date);
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("update car SET status = ? where car_plate = ?");
    $statement->bind_param("ss",$status, $car_plate);
    $execval = $statement->execute();
    $statement->close();
    $statement = $conn->prepare("update registration SET return_date = ? where register_no=?");
    $statement->bind_param("sd", $start_date,$register_no);
    $execval = $statement->execute(); 


    $conn->close();
    echo'<script>
    alert("Return Done");
    window.location = "customer_home.php";
    </script>';
 }