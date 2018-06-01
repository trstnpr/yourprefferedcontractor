<?php
define('BASEPATH',__DIR__);
include('application/config/database.php');
ini_set('memory_limit','512M');
if (ob_get_level() == 0) ob_start();

$con=mysql_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password']);
mysql_select_db($db['default']['database']);

//get all cities
$result = mysql_query("SELECT name,state,area_code,slug,phone FROM cities");

//get tollfree
$tollFreeDataset = mysql_query("SELECT `value` FROM `options` WHERE `key` = 'default_phone'");
$tollFree = mysql_fetch_array($tollFreeDataset);


//get states list
$stateRes = mysql_query("SELECT * FROM states");
$statesList = mysql_fetch_array($stateRes);

//echo "statelist" ; debug($statesList);


echo "<table border=1 width=100%>";
echo "<tr>";
echo "<td>#</td>";
echo "<td>URL</td>";
echo "<td>City</td>";
echo "<td>State</td>";
echo "<td>Area Code</td>";
echo "<td>Phone</td>";
echo "</td>";

$ctr=1;
$withNum=0;
$noNum=0;
while ($row = mysql_fetch_array($result)) {
  $link = $_SERVER['SERVER_NAME'].'/'.$row['state'].'/'.$row['slug'];

  //$phone = $row['phone']?$row['phone']:$tollFree[0];
  $phone = $row['phone'];
  if(empty($phone)) { 
    $style="style='background-color:#FF7B7B;'"; 
    $phone ="<strong>Phone doesn't exists!</strong>"; 
    $noNum++;
  } else { 
    $style=""; 
    $withNum++;
  }

  echo "<tr {$style}>";
  echo "<td>{$ctr}</td>";
  echo "<td>{$link}</td>";
  echo "<td>{$row['name']}</td>";
  echo "<td>".strtoupper($row['state'])."</td>";
  echo "<td>{$row['area_code']}</td>";
  echo "<td>{$phone}</td>";
  echo "</tr>";
  ini_set('max_execution_time', 0);
  ob_flush();
  flush();
  $ctr++;
}
$ctr=$ctr-1;
echo "</table>";
echo "-end of records-<br>";
echo "-hakunamatata-";
echo "<h4>Records <strong>WITH</strong> Phone #: <strong>{$withNum}</strong></h4>";
echo "<h4>Records <strong>WITHOUT</strong> Phone #: <strong>{$noNum}</strong></h4>";
echo "<h4>Total Number of Records: <strong>{$ctr}</strong></h4>";





function debug($var,$name=null,$file=null,$line=null){

  echo "<div  style='margin: 10px; background: #FCFCFC; padding: 10px;'>";
  if(isset($name)){echo "<div style='padding-bottom: 10px; font-weight: bold; border-bottom: 1px solid #DDD'>".$name."</div>"; }
  if(isset($var)){
    echo "<pre>"; 
    print_r($var);
    echo '</pre>';
  }else{
    echo 'Not Set';
  }
  echo "</div>";
}