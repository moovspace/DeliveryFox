<?php
global $r;

$r->Set("/login", "MyApp/Web/Auth/Login/Login", "Index");
$r->Set("/register", "MyApp/Web/Auth/Register/Register", "Index");
$r->Set("/password", "MyApp/Web/Auth/Pass/Pass", "Index");
$r->Set("/confirm", "MyApp/Web/Auth/Confirm/Confirm", "Index");
?>