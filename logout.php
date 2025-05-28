<?php
include_once 'inc/funcoes.php';
session_destroy();
header("Location: login.php");
