<?php

$file = $_GET['file'] . '-time-write.gz';

header('Content-Encoding: gzip');
header('Content-Length: ' . filesize($file));
header('Content-type: application/xml; charset=UTF-8');

readfile($file);
