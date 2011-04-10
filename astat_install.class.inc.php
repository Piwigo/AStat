<?php
/* -----------------------------------------------------------------------------
  Plugin     : AStat.2
  Author     : Grum
    email    : grum@piwigo.org
    website  : http://photos.grum.fr

    << May the Little SpaceFrog be with you ! >>
  ------------------------------------------------------------------------------
  See main.inc.php for release information

  AStat_install classe => manage install process

  --------------------------------------------------------------------------- */
  include_once('astat_version.inc.php');
  include_once('astat_root.class.inc.php');

  class AStat_install extends AStat_root
  {
    /**
     * function for installation process
     *
     * @return Bool : true if install process is ok, otherwise false
     */
    public function install()
    {
      $this->initConfig();
      $this->loadConfig();
      $this->config['installed']=ASTAT_VERSION2;
      $this->config['newInstall']='y';
      $this->saveConfig();

      GPCCore::register($this->getPluginName(), ASTAT_VERSION, ASTAT_GPC_NEEDED);

      return(true);
    }


    /**
     * function for uninstall process
     */
    public function uninstall()
    {
      $this->deleteConfig();
      GPCCore::unregister($this->getPluginName());
    }

    public function activate()
    {
      global $template;

      $this->initConfig();
      $this->loadConfig();
      $this->config['newInstall']='n';
      $this->config['installed']=ASTAT_VERSION2; //update the installed release number
      $this->saveConfig();

      GPCCore::register($this->getPluginName(), ASTAT_VERSION, ASTAT_GPC_NEEDED);

      $this->alter_history_section_enum('deleted_cat');
    }

    public function deactivate()
    {
      $this->initConfig();
      $this->loadConfig();
    }
  } //class

?>
