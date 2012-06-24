<?php
/* -----------------------------------------------------------------------------
  Plugin     : AStat.2
  Author     : Grum
    email    : grum@piwigo.org
    website  : http://photos.grum.fr

    << May the Little SpaceFrog be with you ! >>
  ------------------------------------------------------------------------------
  See main.inc.php for release information

  AStat_AIM : classe to manage plugin integration into plugin menu

  --------------------------------------------------------------------------- */

if (!defined('PHPWG_ROOT_PATH')) { die('Hacking attempt!'); }

include_once('astat_root.class.inc.php');

class AStat_AIM extends AStat_root
{
  public function __construct($prefixeTable, $filelocation)
  {
    parent::__construct($prefixeTable, $filelocation);
  }

  /*
    initialize events call for the plugin
  */
  public function initEvents()
  {
    parent::initEvents();
    add_event_handler('get_admin_plugin_menu_links', array(&$this, 'pluginAdminMenu') );
  }

} // AStat_Plugin class


?>
