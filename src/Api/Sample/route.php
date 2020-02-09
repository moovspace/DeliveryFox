<?php
// Load router
global $r;

// Add route
$r->Set("/welcome/email/{id}", "Api/Sample/SampleClass", "Index");
?>