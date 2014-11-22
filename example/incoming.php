<?php

$jsonStringData = file_get_contents('php://input');

file_put_contents('storage/incoming.txt', $jsonStringData . '\n');