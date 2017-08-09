<?php

/* Multi time write with encoding error in browsers ------------------------- */

$writer = new XMLWriter();
$writer->openMemory();
$writer->startDocument('1.0', 'UTF-8');
$writer->setIndent(true);
$writer->startElement('urlset');
$writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

file_put_contents('compress.zlib://multi-time-write.gz',$writer->flush());

$writer->endElement();
$writer->endDocument();

file_put_contents(
    'compress.zlib://multi-time-write.gz',
    $writer->flush(true),
    FILE_APPEND);



/* One time write from multi-time-write.gz. Solution? ----------------------- */

file_put_contents(
    'compress.zlib://remulti-time-write.gz',
    file_get_contents('compress.zlib://multi-time-write.gz'));



/* Reference: One time write ------------------------------------------------ */

$writer = new XMLWriter();
$writer->openMemory();
$writer->startDocument('1.0', 'UTF-8');
$writer->setIndent(true);
$writer->startElement('urlset');
$writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$writer->endElement();
$writer->endDocument();

file_put_contents(
    'compress.zlib://one-time-write.gz',
    $writer->flush(true));
