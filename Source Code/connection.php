<?php
define ('MYSQL_HOSTNAME', 'dijkstra.ug.bcc.bilkent.edu.tr');
define ('MYSQL_USERNAME', 'ezgi.cakir');
define ('MYSQL_PASSWORD', 'br1klalz');
define ('MYSQL_DATABASE', 'ezgi_cakir');
$db = @mysqli_connect(MYSQL_HOSTNAME, MYSQL_USERNAME, MYSQL_PASSWORD,MYSQL_DATABASE)
OR die('Could not connect to MySQL' . mysqli_connect_error());
?> 