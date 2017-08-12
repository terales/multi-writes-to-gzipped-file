<?php

ini_set("zlib.output_compression", "Off");
$file = ltrim($_SERVER['REQUEST_URI'], '/') . '.gz';

header('Content-Encoding: gzip');
header('Content-Length: ' . filesize($file));
header('Content-type: application/xml; charset=UTF-8');
readfile($file);
