<?php
// Load router
global $r;

// Add route
$r->Set("/welcome/email/{id}", "PhpApix/Api/Sample/SampleClass", "Index");
?>