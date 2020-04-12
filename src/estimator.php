<?php
function converter($period_type, $time_to_elapse)
{
  switch ($period_type) {
    case 'weeks':
      # code...
      $y = floor($time_to_elapse * 7/3);
      break;

    case 'months':
      # code...
      $y = floor($time_to_elapse * 10);
      break;
    
    default:
      # code...
      $y = floor($time_to_elapse /3);
      break;
  }
  return 2^$y;
}

function covid19ImpactEstimator($data)
{
  //

  $newArray = array();
  $newArray['data'] = $data;
  $newArray['impact'] ['currentlyInfected'] = $data['reportedCases'] * 10;
  $newArray['severeImpact'] ['currentlyInfected'] = $data['reportedCases'] * 50;
  $newArray['impact'] ['infectionsByRequestedTime'] = $newArray['impact'] ['currentlyInfected'] * converter($data['periodType'], $data['timeToElapse']);
  $newArray['severeImpact'] ['infectionsByRequestedTime'] = $newArray['severeImpact'] ['currentlyInfected'] * converter($data['periodType'], $data['timeToElapse']);
  $newArray['impact'] ['severeCasesByRequestedTime'] = floor($newArray['impact'] ['infectionsByRequestedTime'] * 0.15);
  $newArray['severeImpact'] ['severeCasesByRequestedTime'] = floor($newArray['severeImpact'] ['infectionsByRequestedTime'] * 0.15);
  $newArray['impact'] ['hospitalBedsByRequestedTime'] = floor($data['totalHospitalBeds'] * 0.35);
  $newArray['severeImpact'] ['hospitalBedsByRequestedTime'] = floor($data['totalHospitalBeds'] * 0.35);
  $newArray['impact'] ['casesForICUByRequestedTime'] = floor($newArray['impact'] ['infectionsByRequestedTime'] * 0.05);
  $newArray['severeImpact'] ['casesForICUByRequestedTime'] = floor($newArray['severeImpact'] ['infectionsByRequestedTime'] * 0.05);
  $newArray['impact'] ['casesForVentilatorsByRequestedTime'] = floor($newArray['impact'] ['infectionsByRequestedTime'] * 0.02);
  $newArray['severeImpact'] ['casesForVentilatorsByRequestedTime'] = floor($newArray['severeImpact'] ['infectionsByRequestedTime'] * 0.02);
  $newArray['impact'] ['dollarsInFlight'] = floor($newArray['impact'] ['infectionsByRequestedTime'] * $data['region'] ['avgDailyIncomePopulation'] * $data['region'] ['avgDailyIncomeInUSD'] * $data['timeToElapse']);
  $newArray['severeImpact'] ['dollarsInFlight'] = floor($newArray['severeImpact'] ['infectionsByRequestedTime'] * $data['region'] ['avgDailyIncomePopulation'] * $data['region'] ['avgDailyIncomeInUSD'] * $data['timeToElapse']);

  $data = $newArray;

  return $data;
}