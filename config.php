<?php
$conn = mysqli_connect("localhost", "root", "", "portfolio");

if (!$conn) {
    echo "Connection Failed";
}