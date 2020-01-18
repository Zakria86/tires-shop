<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=db_tires', 
   'zakria', 'hussine');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
