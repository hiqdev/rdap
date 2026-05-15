<?php
/**
 * Registration Data Access Protocol – core objects implementation package according to the RFC 7483
 *
 * @link      https://github.com/hiqdev/rdap
 * @package   rdap
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2019, HiQDev (http://hiqdev.com/)
 */

error_reporting(E_ALL & ~E_NOTICE);

// Support running both as standalone package and as vendor dependency
$autoloader = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloader)) {
    $autoloader = __DIR__ . '/../../../autoload.php';
}
require_once $autoloader;

/*
 * Ensures compatibility with PHPUnit 6.x
 */
if (!class_exists('PHPUnit_Framework_Constraint') && class_exists('PHPUnit\Framework\Constraint\Constraint')) {
    abstract class PHPUnit_Framework_Constraint extends \PHPUnit\Framework\Constraint\Constraint
    {
    }
}
if (!class_exists('PHPUnit_Framework_TestCase') && class_exists('PHPUnit\Framework\TestCase')) {
    abstract class PHPUnit_Framework_TestCase extends \PHPUnit\Framework\TestCase
    {
    }
}
