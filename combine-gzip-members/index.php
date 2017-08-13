<?php

error_reporting(-1);

$originalFilePath = __DIR__ . '/test-input/sitemap-original.xml';

$uncompressedFile = fopen($originalFilePath, 'r');
$fileToWrite = fopen(__DIR__ . '/sitemap-compressed-without-headers.xml.gz', 'wb');

$deflateContextResource = deflate_init(ZLIB_ENCODING_GZIP);

$eof = true;
$line = fgets($uncompressedFile);

// echo convert(memory_get_usage(true));

while ($eof !== false) {
  $eof = $nextLine = fgets($uncompressedFile);
  $flushMode = ($eof === false) ? ZLIB_FINISH : ZLIB_NO_FLUSH;

  $compressedData = deflate_add($deflateContextResource, $line, $flushMode);
  fwrite($fileToWrite, $compressedData);
  $line = $nextLine;
  // echo convert(memory_get_usage(true));
}

// echo convert(memory_get_usage(true));

/* // write headers manually, don't need this because
   // I've checked on 6mb file that using ZLIB_NO_FLUSH + ZLIB_FINISH would not load it all into a memory

// Write end headers
// crc32
// $crc32 = sprintf('%u', crc32(file_get_contents(c)));
$crc32 = hex2bin(swapEndianness(hash('crc32b', file_get_contents($originalFilePath))));
fwrite($fileToWrite, $crc32);
// Input SIZE modulo 2^32 in little-endian from bget4() http://svn.ghostscript.com/ghostscript/tags/zlib-1.2.3/examples/gzjoin.c
$isize = pack('V', filesize($originalFilePath) & 0xFFFFFFFF);
fwrite($fileToWrite, $isize);

// Thanks https://stackoverflow.com/a/7548355/1363799
function swapEndianness($hex) {
  return implode('', array_reverse(str_split($hex, 2)));
}
*/

fclose($uncompressedFile);
fclose($fileToWrite);


// Just for memory usage monitoring
function convert($size) {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}
