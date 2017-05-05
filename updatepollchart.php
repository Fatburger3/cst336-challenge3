<?php

function getDBConnection()
{
    $dbname = "c9";
    $host = "localhost";
    $username = "api";
    $password = "";
    try
    {
        //Creating database connection
        $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Setting Errorhandling to Exception
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch (PDOException $e)
    {
        echo "There was some problem connecting to the database! Error: $e";
        exit();
    }
    return $dbConn;
}

$db = getDBConnection();

if(!isset($_GET)) die("GET was empty");
if(!isset($_GET['choice'])) die("choice was empty");


$stmt = $db->prepare("SELECT * FROM myquiz;");
$stmt->execute();
$record = $stmt->fetch(PDO::FETCH_ASSOC);
$record[$_GET['choice']]++;
$stmt = $db->prepare("UPDATE myquiz SET yes=".$record['yes'].", maybe=".$record['maybe'].", no=".$record['no'].";");
$stmt->execute();
if($stmt->rowCount() !== 1) die("WHOA SOMETHING BAD HAPPENED");
echo json_encode($record);
?>