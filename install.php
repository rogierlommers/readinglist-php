<?php
header("Content-Type: text/plain");
include("config.inc.php");

$con = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Create database
$sql = "CREATE DATABASE " . $mysqlDatabase;
if (mysqli_query($con, $sql)) {
  echo "Database '" . $mysqlDatabase . "' created successfully\n";
} else {
  echo "Error creating database: " . mysqli_error($con) . "\n";
}

// Create table
$con = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $mysqlDatabase);
$sql = "CREATE TABLE " . $mysqlTable . "( id int(11) NOT NULL AUTO_INCREMENT,
                                                        timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                        title varchar(255) CHARACTER SET utf8 DEFAULT NULL,
                                                        url varchar(4000) CHARACTER SET latin1 NOT NULL,
                                                        host varchar(255) CHARACTER SET latin1 DEFAULT NULL,
                                                        PRIMARY KEY (id)
													  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8";

// Execute query
if (mysqli_query($con, $sql)) {
  echo "Table ". $mysqlTable ." created successfully\n";
} else {
  echo "Error creating table: " . mysqli_error($con) . "\n";
}
echo ("End of script...\n")
?>
