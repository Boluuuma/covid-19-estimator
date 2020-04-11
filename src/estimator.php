<?php

function covid19ImpactEstimator($data)
{
  //

  $newArray = array();
  $newArray['data'] = $data;
  $newArray['impact'] ['currentlyInfected'] = $data['reportedCases'] * 10;
  $newArray['severeImpact'] ['currentlyInfected'] = $data['reportedCases'] * 50;
  $newArray['impact'] ['infectionsByRequestedTime'] = $data['currentlyInfected'] * 512;
  $newArray['severeImpact'] ['infectionsByRequestedTime'] = $data['currentlyInfected'] * 512;
  $newArray['impact'] ['severeCasesByRequestedTime'] = $data['infectionsByRequestedTime'] * 0.15;
  $newArray['severeImpact'] ['severeCasesByRequestedTime'] = $data['currentlyInfected'] * 0.15;
  $newArray['impact'] ['hospitalBedsByRequestedTime'] = $data['totalHospitalBeds'] * 0.35;
  $newArray['severeImpact'] ['hospitalBedsByRequestedTime'] = $data['totalHospitalBeds'] * 0.35;
  $newArray['impact'] ['casesForICUByRequestedTime'] = $data['$infectionsByRequestedTime'] * 0.5;
  $newArray['severeImpact'] ['casesForICUByRequestedTime'] = $data['$infectionsByRequestedTime'] * 0.5;
  $newArray['impact'] ['casesForVentilatorsByRequestedTime'] = $data['$infectionsByRequestedTime'] * 0.2;
  $newArray['severeImpact'] ['casesForVentilatorsByRequestedTime'] = $data['$infectionsByRequestedTime'] * 0.2;
  $newArray['impact'] ['dollarsInFlight'] = $data['$infectionsByRequestedTime'] * 0.65 * 1.5 * 30;
  $newArray['severeImpact'] ['dollarsInFlight'] = $data['$infectionsByRequestedTime'] * 0.65 * 1.5 * 30;

  $data = $newArray;

  return $data;
}