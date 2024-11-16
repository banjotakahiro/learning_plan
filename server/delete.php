<?php

require_once __DIR__ . '/functions.php';

$id = filter_input(INPUT_GET, 'id');

delete_bt($id);
