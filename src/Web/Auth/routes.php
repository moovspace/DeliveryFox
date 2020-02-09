<?php
global $r;

$r->Set("/login", "Web/Auth/Login/Login", "Index");
$r->Set("/register", "Web/Auth/Register/Register", "Index");
$r->Set("/password", "Web/Auth/Pass/Pass", "Index");
$r->Set("/confirm", "Web/Auth/Confirm/Confirm", "Index");
?>