<?php

/* How to make new entries here for non-packaged languages:

-- 'code' should match the name of the directory for the language under \lang
.-- 'name' is the name that will be displayed in the language selection list (in Users and Display Setup)
-- 'rtl' only needs to be set for right-to-left languages like Arabic and Hebrew
-- 'encoding' used in translation file
-- 'version' always set to '' for manually installed languages.
-- 'path' installation path related to FA root (e.g. 'lang/en_US').
*/


$installed_languages = array (
  0 => 
  array (
    'code' => 'C',
    'name' => 'English',
    'encoding' => 'iso-8859-1',
  ),
  1 => 
  array (
    'name' => 'Arabic',
    'package' => 'ar_EG',
    'code' => 'ar_EG',
    'encoding' => 'utf-8',
    'version' => '2.4.1-3',
    'path' => 'lang/ar_EG',
    'rtl' => true,
  ),
  2 => 
  array (
    'name' => 'German',
    'package' => 'de_DE',
    'code' => 'de_DE',
    'encoding' => 'iso-8859-1',
    'version' => '2.4.1-3',
    'path' => 'lang/de_DE',
  ),
  3 => 
  array (
    'name' => 'Australian English',
    'package' => 'en_AU',
    'code' => 'en_AU',
    'encoding' => 'iso-8859-1',
    'version' => '2.4.1-3',
    'path' => 'lang/en_AU',
  ),
  4 => 
  array (
    'name' => 'Dutch',
    'package' => 'nl_NL',
    'code' => 'nl_NL',
    'encoding' => 'iso-8859-1',
    'version' => '2.4.1-4',
    'path' => 'lang/nl_NL',
  ),
  5 => 
  array (
    'name' => 'Portuguese',
    'package' => 'pt_PT',
    'code' => 'pt_PT',
    'encoding' => 'iso-8859-1',
    'version' => '2.4.1-3',
    'path' => 'lang/pt_PT',
  ),
  6 => 
  array (
    'name' => 'Urdu',
    'package' => 'ur_PK',
    'code' => 'ur_PK',
    'encoding' => 'utf-8',
    'version' => '2.4.1-3',
    'path' => 'lang/ur_PK',
    'rtl' => true,
  ),
);

$dflt_lang = 'C';
