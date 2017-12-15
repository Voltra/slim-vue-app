<?php
$dev_config = require("development.php");

return array_merge_recursive($dev_config, [
    "debug" => false
]);
