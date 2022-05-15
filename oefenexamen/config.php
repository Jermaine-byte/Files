<?php
$conn = new mysqli('127.0.0.1', '84645', '#1Geheim', '84645_examen');

if ($conn->connect_errno) {
    echo "Error: " . $conn->connect_error;
}
