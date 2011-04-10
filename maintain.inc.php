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

include_once('astat_version.inc.php'); // => Don't forget to update this file !!


global $gpcInstalled, $lang; //needed for plugin manager compatibility

/* -----------------------------------------------------------------------------
AStat needs the Grum Plugin Classe
----------------------------------------------------------------------------- */
$gpcInstalled=false;
if(file_exists(PHPWG_PLUGINS_PATH.'GrumPluginClasses/classes/CommonPlugin.class.inc.php'))
{
  @include_once(PHPWG_PLUGINS_PATH.'GrumPluginClasses/classes/CommonPlugin.class.inc.php');
  // need GPC release greater or equal than 3.5.0
  if(CommonPlugin::checkGPCRelease(ASTAT_GPC_NEEDED))
  {
    include_once("astat_install.class.inc.php");
    $gpcInstalled=true;
  }
}

function gpcMsgError(&$errors)
{
  $msg=sprintf(l10n('To install this plugin, you need to install Grum Plugin Classes %s before'), ASTAT_GPC_NEEDED);
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
  global $prefixeTable, $gpcInstalled;
  if($gpcInstalled)
  {
    $obj=new AStat_install($prefixeTable, __FILE__);
    $result=$obj->install();
  }
  else
  {
    gpcMsgError($errors);
  }
}

function plugin_activate($plugin_id, $plugin_version, &$errors)
{
  global $prefixeTable, $gpcInstalled;
  if($gpcInstalled)
  {
    $obj=new AStat_install($prefixeTable, __FILE__);
    $result=$obj->activate();
  }
}

function plugin_deactivate($plugin_id)
{
  global $prefixeTable, $gpcInstalled;

  if($gpcInstalled)
  {
    $obj=new AStat_install($prefixeTable, __FILE__);
    $obj->deactivate();
  }
}

function plugin_uninstall($plugin_id)
{
  global $prefixeTable, $gpcInstalled;
  if($gpcInstalled)
  {
    $obj=new AStat_install($prefixeTable, __FILE__);
    $result=$obj->uninstall();
  }
  else
  {
    gpcMsgError($errors);
  }
}





?>
