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

if(!defined('PHPWG_ROOT_PATH')) { die('Hacking attempt!'); }

if(!defined('ASTAT_DIR')) define('ASTAT_DIR' , basename(dirname(__FILE__)));
if(!defined('ASTAT_PATH')) define('ASTAT_PATH' , PHPWG_PLUGINS_PATH . ASTAT_DIR . '/');

include_once('astat_version.inc.php');

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', true);

global $gpc_installed, $gpcNeeded, $lang; //needed for plugin manager compatibility

/* -----------------------------------------------------------------------------
AStat-2 needs the Grum Plugin Classe
----------------------------------------------------------------------------- */
$gpc_installed=false;
$gpcNeeded="3.0.0";
if(file_exists(PHPWG_PLUGINS_PATH.'GrumPluginClasses/classes/CommonPlugin.class.inc.php'))
{
  @include_once(PHPWG_PLUGINS_PATH.'GrumPluginClasses/classes/CommonPlugin.class.inc.php');
  // need GPC release greater or equal than 3.0.0
  if(CommonPlugin::checkGPCRelease(3,0,0))
  {
    @include_once("astat_aim.class.inc.php");
    $gpc_installed=true;
  }
}

function gpcMsgError(&$errors)
{
  global $gpcNeeded;
  $msg=sprintf(l10n('To install this plugin, you need to install Grum Plugin Classes %s before'), $gpcNeeded);
  if(is_array($errors))
  {
    array_push($errors, $msg);
  }
  else
  {
    $errors=Array($msg);
  }
}
// -----------------------------------------------------------------------------


load_language('plugin.lang', ASTAT_PATH);

function plugin_install($plugin_id, $plugin_version, &$errors)
{
  global $prefixeTable, $gpc_installed, $gpcNeeded;
  if($gpc_installed)
  {
    $obj = new AStat_AIM($prefixeTable, __FILE__);
    $obj->deleteConfig();
    $obj->initConfig();
    $obj->my_config['installed']=ASTAT_VERSION2;
    $obj->saveConfig();
    GPCCore::register($obj->getPluginName(), ASTAT_VERSION, $gpcNeeded);
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
    $obj->initConfig();
    $obj->loadConfig();
    $obj->my_config['installed']=ASTAT_VERSION2;
    $obj->saveConfig();
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
    $obj->deleteConfig();
    GPCCore::unregister($obj->getPluginName());
  }
  else
  {
    gpcMsgError($errors);
  }
}



?>
