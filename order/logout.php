<?php
session_start();

unset($_SESSION['admin']); 

# redirect 
header('Location: ./index_.php');