<?php
include_once('../../../src/estimator.php');
include_once('../logs.php');
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = "localhost";
$db_name = "api_db";
$username = "root";
$password = "";

try{
  $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $str = file_get_contents('php://input');
  $log = new DumpHTTPRequestToFile();
  $log->execute('log.txt');
  $object = json_decode($str, true);
  if(is_array($object)){
    $name = $object['name'];
    $avg_age = $object["avg_age"];
    $avg_daily_income_in_usd = $object["avg_daily_income_in_usd"];
    $avg_daily_income_population = $object["avg_daily_income_population"];
    $period_type = $object["period_type"];
    $time_to_elapse = $object['time_to_elapse'];
    $reported_cases = $object["reported_cases"];
    $population = $object["population"];
    $total_hospital_beds = $object["total_hospital_beds"];

    $query = "INSERT INTO regions ". "(
      name,
      avg_age,
      avg_daily_income_in_usd,
      avg_daily_income_population,
      period_type, 
      time_to_elapse,
      reported_cases,
      population,
      total_hospital_beds) " . "VALUES " . "(
        '$name',
        '$avg_age',
        '$avg_daily_income_in_usd',
        '$avg_daily_income_population',
        '$period_type', 
        '$time_to_elapse',
        '$reported_cases',
        '$population',
        '$total_hospital_beds')";
    $conn->exec($query);

    $data = array();
    $data['region'] = array(
      "name" => $name,
      "avgAge" => $avg_age,
      "avgDailyIncomeInUsd" => $avg_daily_income_in_usd,
      "avgDailyIncomePopulation" => $avg_daily_income_population,
    );
    $data['periodType'] = $period_type;
    $data['timeToElapse'] = $time_to_elapse;
    $data['reportedCases'] = $reported_cases;
    $data['population'] = $population;
    $data['totalHospitalBeds'] = $total_hospital_beds;

    http_response_code(201);
    echo json_encode(covid19ImpactEstimator($data));
  }else {
    # code...
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create region."));
  }
      
    
 


  }catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
  }


  $conn = null;
?>
