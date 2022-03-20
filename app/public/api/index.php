<?php

require_once __DIR__ . '/../../config/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
echo json_encode($_REQUEST);
