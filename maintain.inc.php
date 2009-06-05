<?php
/* -----------------------------------------------------------------------------
  Plugin     : AStat.2
  Author     : Grum
    email    : grum@piwigo.org
    website  : http://photos.grum.fr

    << May the Little SpaceFrog be with you ! >>
  ------------------------------------------------------------------------------
  See main.inc.php for release information

  --------------------------------------------------------------------------- */

if (!defined('PHPWG_ROOT_PATH')) { die('Hacking attempt!'); }

define('ASTAT_DIR' , basename(dirname(__FILE__)));
define('ASTAT_PATH' , PHPWG_PLUGINS_PATH . ASTAT_DIR . '/');

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', true);

global $gpc_installed, $lang; //needed for plugin manager compatibility

/* -----------------------------------------------------------------------------
AStat-2 needs the Grum Plugin Classe
----------------------------------------------------------------------------- */
$gpc_installed=false;
if(file_exists(PHPWG_PLUGINS_PATH.'grum_plugins_classes-2/common_plugin.class.inc.php'))
{
  @include_once(PHPWG_PLUGINS_PATH.'grum_plugins_classes-2/main.inc.php');
  // need GPC release greater or equal than 2.0.1
  if(checkGPCRelease(2,0,1))
  {
    @include_once("astat_aim.class.inc.php");
    $gpc_installed=true;
  }
}

function gpcMsgError(&$errors)
{
  array_push($errors, sprintf(l10n('AStat_gpc2_not_installed'), "2.0.1"));
}
// -----------------------------------------------------------------------------


load_language('plugin.lang', ASTAT_PATH);

function plugin_install($plugin_id, $plugin_version, &$errors) 
{
  global $prefixeTable, $gpc_installed;
  if($gpc_installed)
  {
    $obj = new AStat_AIM($prefixeTable, __FILE__);
    $obj->delete_config();
    $obj->init_config();
    $obj->save_config();
  }
  else
  {
    gpcMsgError($errors);
  }
}

function plugin_activate($plugin_id, $plugin_version, &$errors)
{
  global $prefixeTable, $gpc_installed;
  if($gpc_installed)
  {
    $obj = new AStat_AIM($prefixeTable, __FILE__);
    $obj->init_config();
    $obj->load_config();
    $obj->save_config();
    $obj->alter_history_section_enum('deleted_cat');
  }
  else
  {
    gpcMsgError($errors);
  }
}

function plugin_deactivate($plugin_id)
{
}

function plugin_uninstall($plugin_id)
{
  global $prefixeTable, $gpc_installed;
  if($gpc_installed)
  {
    $obj = new AStat_AIM($prefixeTable, __FILE__);
    $obj->delete_config();
  }
  else
  {
    gpcMsgError($errors);
  }
}



?>
