<?php
echo '<!DOCTYPE html>
<html>
<head>
    <title>Test Page</title>
  <link href="bootstrap.css" rel="stylesheet">



    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
</head>
<body>    

	<!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="">
                <a href="/twittergoggles/index.html">Home</a>
              </li>
			  <li class="active">
                <a href="/twittergoggles/group4_reporting/reporting.html">Visualization/Reporting</a>
              </li>
              
              <li class="">
                <a href="/twittergogglesgroup3_administration/Sprint3/index.php">Administration</a>
              </li>
              <li class="">
                <a href="/twittergogglesgroup5_researchercol/sprint3/researcher.php">Research</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
        <br><br>';

//Total Number of Tweets for All Specific Jobs

echo "<h1>Total Number of Tweets for All Specific Jobs</h1>";

//Establishes connection to database
$link= mysql_connect('sociotechnical.ischool.drexel.edu', 'info154', 'info154');

//Added to allow all browsers time to load query results
ini_set('max_execution_time', 1000);


$top1query='select last_count, query, job_id from twitterinblack46.job where query is not null and last_count is not null order by last_count desc limit 1;';
$top5query='select last_count, query, job_id from twitterinblack46.job where query is not null and last_count is not null order by last_count desc limit 5;';
$top10query='select last_count, query, job_id from twitterinblack46.job where query is not null and last_count is not null order by last_count desc limit 10;';
$allquery='select last_count, query, job_id from twitterinblack46.job where query is not null and last_count is not null order by last_count desc;';

$top1result=mysql_query($top1query);
$top5result=mysql_query($top5query);
$top10result=mysql_query($top10query);
$allresult=  mysql_query($allquery);
$top=$_POST['toptweets'];

$CSVarray = array();






//Sets up table

echo '<html><head></head><link href="/twittergoggles/bootstrap.css" rel="stylesheet">';
echo "<table border='1'
<tr>
<th>Job ID</th>
<th>Last Count</th>
<th>Result</th>
</tr>";
if($top=='top1'){
    while($row = mysql_fetch_array($top1result))
{
  $CSVarray[] = array ( 'job_id' => $row['job_id'], 'last_count' => $row['last_count'], 'query' => $row['query'] );
}
    mysql_data_seek($top1result,0);
//Populates table
while($row = mysql_fetch_array($top1result)){
    echo"<tr>";
    echo "<td>" . $row["job_id"] . "</td>";
    echo "<td>" . ltrim($row["last_count"],'0') . "</td>";
    echo "<td>" . str_replace(array('%23', '%40', '%20', 'q='), array('#','@',' ',''), $row['query']) . "</td>";
    echo "<tr>";
}
echo "</table>";
}
elseif($top=='top5'){
    
while($row = mysql_fetch_array($top5result))
{
  $CSVarray[] = array ( 'job_id' => $row['job_id'], 'last_count' => $row['last_count'], 'query' => $row['query'] );
}
    mysql_data_seek($top5result,0);
    //Populates table
while($row = mysql_fetch_array($top5result)){
    echo"<tr>";
    echo "<td>" . $row["job_id"] . "</td>";
    echo "<td>" . ltrim($row["last_count"],'0') . "</td>";
    echo "<td>" . str_replace(array('%23', '%40', '%20', 'q='), array('#','@',' ',''), $row['query']) . "</td>";
    echo "<tr>";
}
echo "</table>";
}

elseif($top=='top10'){
    while($row = mysql_fetch_array($top10result))
{
  $CSVarray[] = array ( 'job_id' => $row['job_id'], 'last_count' => $row['last_count'], 'query' => $row['query'] );
}
    mysql_data_seek($top10result,0);
    //Populates table
while($row = mysql_fetch_array($top10result)){
    echo"<tr>";
    echo "<td>" . $row["job_id"] . "</td>";
    echo "<td>" . ltrim($row["last_count"],'0') . "</td>";
    echo "<td>" . str_replace(array('%23', '%40', '%20', 'q='), array('#','@',' ',''), $row['query']) . "</td>";
    echo "<tr>";
}
echo "</table>";
}

elseif($top=='all'){
    while($row = mysql_fetch_array($allresult))
{
  $CSVarray[] = array ( 'job_id' => $row['job_id'], 'last_count' => $row['last_count'], 'query' => $row['query'] );
}
    mysql_data_seek($allresult,0);
    //Populates table
while($row = mysql_fetch_array($allresult)){
    echo"<tr>";
    echo "<td>" . $row["job_id"] . "</td>";
    echo "<td>" . ltrim($row["last_count"],'0') . "</td>";
    echo "<td>" . str_replace(array('%23', '%40', '%20', 'q='), array('#','@',' ',''), $row['query']) . "</td>";
    echo "<tr>";
}
echo "</table>";
}


outputCSV($CSVarray);

function outputCSV($data) {
    $file = fopen("data.csv", "w+");
    function __outputCSV($vals, $key, $filehandler) {
        fputcsv($filehandler, $vals); // add parameters if you want
    }
    array_walk($data, "__outputCSV", $file);
    echo "CSV file successfully created";
    fclose($file);
}

echo "</html>";

mysql_close($link);


?>