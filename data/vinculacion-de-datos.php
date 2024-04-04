<?php 

require_once __DIR__ . '/conexion-mysql.php';

$query = "SELECT * FROM productos";

$stmt = $db->prepare($query);

$stmt->execute();