<?php

/**
 * Handy function to compile the Blur::SLD array
 */
include 'vendor/autoload.php';
use League\Csv\Reader as CsvReader;

const INPUT = 'https://raw.githubusercontent.com/gavingmiller/second-level-domains/6443804ed7719991f2d560bbe1fd12641c464740/SLDs.csv';

$csv = CsvReader::createFromString(file_get_contents(INPUT));

$slds = iterator_to_array($csv->fetchColumnByOffset(1));
$quoted = implode(',', array_map(function ($i) {return "'{$i}'";}, $slds));
$code = <<<PHP
    // copy and paste into Blur.php
    const SLD = [{$quoted}];

PHP;
echo $code;
