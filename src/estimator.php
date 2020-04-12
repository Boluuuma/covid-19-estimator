<?php
function converter($period_type, $time_to_elapse)
{
  switch ($period_type) {
    case 'weeks':
      # code...
      $y = intval($time_to_elapse * 7/3);
      break;

    case 'months':
      # code...
      $y = intval($time_to_elapse * 10);
      break;
    
    default:
      # code...
      $y = intval($time_to_elapse /3);
      break;
  }
  return pow(2, $y);
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
  $newArray['impact'] ['severeCasesByRequestedTime'] = intval($newArray['impact'] ['infectionsByRequestedTime'] * 0.15);
  $newArray['severeImpact'] ['severeCasesByRequestedTime'] = intval($newArray['severeImpact'] ['infectionsByRequestedTime'] * 0.15);
  $newArray['impact'] ['hospitalBedsByRequestedTime'] = intval(($data['totalHospitalBeds'] * 0.35) - $newArray['impact'] ['infectionsByRequestedTime'] * 0.15);
  $newArray['severeImpact'] ['hospitalBedsByRequestedTime'] = intval(($data['totalHospitalBeds'] * 0.35) - $newArray['severeImpact'] ['infectionsByRequestedTime'] * 0.15);
  $newArray['impact'] ['casesForICUByRequestedTime'] = intval($newArray['impact'] ['infectionsByRequestedTime'] * 0.05);
  $newArray['severeImpact'] ['casesForICUByRequestedTime'] = intval($newArray['severeImpact'] ['infectionsByRequestedTime'] * 0.05);
  $newArray['impact'] ['casesForVentilatorsByRequestedTime'] = intval($newArray['impact'] ['infectionsByRequestedTime'] * 0.02);
  $newArray['severeImpact'] ['casesForVentilatorsByRequestedTime'] = intval($newArray['severeImpact'] ['infectionsByRequestedTime'] * 0.02);
  $newArray['impact'] ['dollarsInFlight'] = intval($newArray['impact'] ['infectionsByRequestedTime'] * $data['region'] ['avgDailyIncomePopulation'] * $data['region'] ['avgDailyIncomeInUSD'] / $data['timeToElapse']);
  $newArray['severeImpact'] ['dollarsInFlight'] = intval($newArray['severeImpact'] ['infectionsByRequestedTime'] * $data['region'] ['avgDailyIncomePopulation'] * $data['region'] ['avgDailyIncomeInUSD'] / $data['timeToElapse']);

  $data = $newArray;

  return $data;
}