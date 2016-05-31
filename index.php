<?php
/*
Plugin Name: MarsPack
*/

if ( !defined('WPINC') ) 
{
    exit;
}

// PLUGIN PATH
$curdir=__DIR__;

// LOAD FUNCTIONS
require_once("$curdir/functions.php");
// LOAD CLASS DECLARATION
require_once("$curdir/MarsPack.php");

// CREATE AN OBJECT FROM MarsPack CLASS
$objMarsPack = new MarsPack;

