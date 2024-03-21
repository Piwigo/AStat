<?php
/*
Plugin Name: AStat.2
Version: 2.4.9
Description: Statistiques avancées / Advanced statistics
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=172
Author: grum@piwigo.org
Author URI: http://www.grum.fr/
Has Settings: true
*/

/*
--------------------------------------------------------------------------------
  Author     : Grum
    email    : grum@piwigo.org
    website  : http://www.grum.fr

    << May the Little SpaceFrog be with you ! >>
--------------------------------------------------------------------------------

:: HISTORY


| release | date       |
| 2.0.0   | 2007/05/07 | * release for piwigo 2.0
|         |            |
| 2.0.1   | 2008/03/01 | * bug corrected (can't open file because plugin directory
|         |            |   was hardcoded...)
|         |            |
| 2.0.2   | 2008/03/09 | * bug referenced
|         |            |    english forum : http://piwigo.org/forum/viewtopic.php?pid=105990#p105990
|         |            |    french forum  : http://fr.piwigo.org/forum/viewtopic.php?pid=107205#p107205
|         |            |    SQL request for stat by categories works with mySQL 4.1.22 and not with mySQL 5
|         |            |
| 2.0.3   | 2008/03/28 | * bug referenced
|         |            |   french forum  : http://fr.piwigo.org/forum/viewtopic.php?pid=107236#p107236
|         |            |   SQL request for stat by categories works with mySQL 4.1.22 and not with mySQL 5
|         |            |
| 2.0.4   | 2009/05/21 | * bug on tools
|         |            |   it was not possible to use tools to manage deleted items
|         |            |
| 2.0.5   | 2009/07/07 | * bug in code - invalid character on line 2194
|         |            |
| 2.1.0   | 2009/07/28 | * add a blacklist for IP and use it for stats
|         |            | * new tools
|         |            |    - possibility to purge history on blacklisted IP address
|         |            |    - use of jQuery datepicker for purge date
|         |            |
| 2.1.1   | 2009/11/15 | * bug on tools (cf. bug #1242 in mantis)
|         |            |   it was impossible to purge items in history due to an invalid regexp in the javascript
|         |            |
| 2.2.0   | 2010/03/28 | * release for compatibility with Piwigo 2.1
|         |            | * mantis: bug 1192
|         |            |   Constant already defined when deactivating the plugin
|         |            | * mantis: bug 1344
|         |            |   In tools, it's allowed to do purge only if checkbox is not checked
|         |            |
| 2.2.1   | 2010/04/11 | * Fixed a minor bug in the display
|         |            | * add languages:
|         |            |   . it_IT
|         |            |
| 2.2.2   | 2010/07/24 | * mantis: bug 1774
|         |            |   Stat by categories doesn't work when IP filter is activated
|         |            |
| 2.3.0   | 2011/04/10 | * mantis: bug 2146
|         |            |   . compatibility with piwigo 2.2
|         |            |
| 2.4.0   | 2011/04/10 | * mantis: bug 2636
|         |            |   . compatibility with piwigo 2.4
|         |            |
| 2.4.1   | 2013/03/29 | * compatibility with piwigo 2.5
|         |            |
| 2.4.2   | 2014/01/30 | * compatibility with piwigo 2.6
|         |            |
| 2.4.3   | 2014/04/18 | * Unexpected character in code breaks execution (view by IP)
|         |            |
| 2.4.4   | 2014/09/22 | * compatibility with piwigo 2.7
|         |            |
| 2.4.5   | 2018/02/09 | * bug fix: avoid title overlap
|         |            |
| 2.4.6   | 2019/09/20 | * compatibility with PHP 7+ (thank you Rasmus Lerdorf)
|         |            |
| 2.4.7   | 2021/11/08 | * compatibility with piwigo 12
|         |            |
| 2.4.8   | 2021/11/08 | * php 8 compatibility
|         |            |
| 2.4.9   | 2021/11/08 | * php 8.1 compatibility

:: TO DO

--------------------------------------------------------------------------------

:: NFO
  AStat_AIM : classe to manage plugin integration into plugin menu
  AStat_AIP : classe to manage plugin admin pages

--------------------------------------------------------------------------------
*/

// pour faciliter le debug :o)
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', true);

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

define('ASTAT_DIR' , basename(dirname(__FILE__)));
define('ASTAT_PATH' , PHPWG_PLUGINS_PATH . ASTAT_DIR . '/');

include_once('astat_version.inc.php'); // => Don't forget to update this file !!

global $prefixeTable;

//AStat loaded and active only if in admin page
if(defined('IN_ADMIN') && !defined('AJAX_CALL'))
{
  include_once("astat_aim.class.inc.php");

  $obj = new AStat_AIM($prefixeTable, __FILE__);
  $obj->initEvents();
  set_plugin_data($plugin['id'], $obj);
}

?>
