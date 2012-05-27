<?php
/* -----------------------------------------------------------------------------
  Plugin     : AStat.2
  Author     : Grum
    email    : grum@piwigo.org
    website  : http://photos.grum.dnsalias.com

    << May the Little SpaceFrog be with you ! >>
  ------------------------------------------------------------------------------
  See main.inc.php for release information

  --------------------------------------------------------------------------- */

if (!defined('PHPWG_ROOT_PATH')) { die('Hacking attempt!'); }

include(ASTAT_PATH."astat_aip.class.inc.php");

global $prefixeTable;

load_language('plugin.lang', ASTAT_PATH);

$main_plugin_object = get_plugin_data($plugin_id);

$plugin_ai = new AStat_AIP($prefixeTable, $main_plugin_object->getFileLocation());
$plugin_ai->manage();

?>
