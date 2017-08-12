<?php

error_reporting(-1);
date_default_timezone_set('UTC');

require 'vendor/autoload.php';

use samdark\sitemap\Sitemap;

$host = 'http://test-sitemap.terales.info/';

// create sitemap
$sitemap = new Sitemap(__DIR__ . '/sitemap.xml.gz');
$sitemap->setUseGzip(true);
$sitemap->setBufferSize(1); // force to write several chunks for test purpose


// add some URLs
$sitemap->addItem($host . 'z-first-page.html');
$sitemap->addItem($host . 'z-second-page.html', time());
$sitemap->addItem($host . 'z-third-page.html', time(), Sitemap::HOURLY);
$sitemap->addItem($host . 'z-fourth-page.html', time(), Sitemap::DAILY, 0.3);

// write it
$sitemap->write();

// create reference file
foreach($sitemap->getWrittenFilePath() as $path) {
  $referencePath = str_replace('sitemap.xml.gz', 'sitemap-reference.xml.gz', $path);
  $tempfile = fopen('php://temp/', 'r+');

  $sitemapRead = fopen('compress.zlib://' . $path, 'r');
  stream_copy_to_stream($sitemapRead, $tempfile);
  fclose($sitemapRead);

  rewind($tempfile);

  $sitemapWrite = fopen('compress.zlib://' . $referencePath, 'w');
  stream_copy_to_stream($tempfile, $sitemapWrite);
  fclose($sitemapWrite);

  fclose($tempfile);
}

echo 'Sitemaps written: ' . PHP_EOL;
print_r($sitemap->getSitemapUrls('http://test-sitemap.terales.info/'));
