<?php
/* -----------------------------------------------------------------------------
  Plugin     : AStat.2
  Author     : Grum
    email    : grum@piwigo.org
    website  : http://photos.grum.dnsalias.com

    << May the Little SpaceFrog be with you ! >>
  ------------------------------------------------------------------------------
  See main.inc.php for release information

  AI classe => manage integration in administration interface

  --------------------------------------------------------------------------- */
if (!defined('PHPWG_ROOT_PATH')) { die('Hacking attempt!'); }

include_once('astat_root.class.inc.php');
include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');
include_once(PHPWG_PLUGINS_PATH.'GrumPluginClasses/classes/GPCAjax.class.inc.php');

class AStat_AIP extends AStat_root
{
  protected $tabsheet;
  protected $list_periods = array('global', 'all', 'year', 'month', 'day');
  protected $list_sortcat = array('page', 'picture', 'nbpicture');
  protected $list_sortimg = array('picture', 'catname');
  protected $list_sortip = array('page', 'picture', 'ip');

  protected $catfilter;    //filter on categories
  protected $max_width;
  protected $seetimerequest;

  function __construct($prefixeTable, $filelocation)
  {
    parent::__construct($prefixeTable, $filelocation);

    $this->loadConfig();
    $this->initEvents();

    $this->tabsheet = new tabsheet();
    $this->tabsheet->add('stats_by_period',
                          l10n('AStat_by_period'),
                          $this->getAdminLink().'-stats_by_period');
    $this->tabsheet->add('stats_by_ip',
                          l10n('AStat_by_ip'),
                          $this->getAdminLink().'-stats_by_ip');
    $this->tabsheet->add('stats_by_category',
                          l10n('AStat_by_category'),
                          $this->getAdminLink().'-stats_by_category');
    $this->tabsheet->add('stats_by_image',
                          l10n('AStat_by_image'),
                          $this->getAdminLink().'-stats_by_image');
    $this->tabsheet->add('config',
                          l10n('AStat_config'),
                          $this->getAdminLink().'-config');
    $this->tabsheet->add('tools',
                          l10n('AStat_tools'),
                          $this->getAdminLink().'-tools');

  }


  /* ---------------------------------------------------------------------------
  Public classe functions
  --------------------------------------------------------------------------- */



  /*
    manage plugin integration into piwigo's admin interface
  */
  public function manage()
  {
    global $template;

    $this->return_ajax_content();

    $template->set_filename('plugin_admin_content', dirname(__FILE__)."/admin/astat_admin.tpl");

    $this->init_request();

    $this->make_filter_list($_REQUEST['fAStat_catfilter']);
    if($_REQUEST['fAStat_catfilter']!="")
    {
      $this->setAdminLink($this->getAdminLink()."&amp;fAStat_catfilter=".$_REQUEST['fAStat_catfilter']);
    }

    if($_GET['tab']=='stats_by_period')
    {
      $this->display_stats_by_period(
          $_REQUEST['fAStat_all'],
          $_REQUEST['fAStat_year'],
          $_REQUEST['fAStat_month'],
          $_REQUEST['fAStat_day'],
          $this->config['AStat_MaxBarWidth'],
          $this->config['AStat_SeeTimeRequests']
      );
    }
    elseif($_GET['tab']=='stats_by_ip')
    {
      if(isset($_REQUEST['fAStat_IP_BL']))
      {
        $this->add_ip_to_filter($_REQUEST['fAStat_IP_BL']);
      }

      $this->display_stats_by_ip(
          $_REQUEST['fAStat_year'],
          $_REQUEST['fAStat_month'],
          $_REQUEST['fAStat_day'],
          $this->config['AStat_MaxBarWidth'],
          $this->config['AStat_NpIPPerPages'],
          $_REQUEST['fAStat_page_number'],
          $_REQUEST['fAStat_SortIP'],
          $this->config['AStat_SeeTimeRequests']
      );
    }
    elseif($_GET['tab']=='stats_by_category')
    {
      $this->display_stats_by_category(
          $_REQUEST['fAStat_year'],
          $_REQUEST['fAStat_month'],
          $_REQUEST['fAStat_day'],
          $this->config['AStat_MaxBarWidth'],
          $this->config['AStat_NpCatPerPages'],
          $_REQUEST['fAStat_page_number'],
          $this->config['AStat_ShowThumbCat'],
          $_REQUEST['fAStat_SortCat'],
          $this->config['AStat_SeeTimeRequests']
      );
    }
    elseif($_GET['tab']=='stats_by_image')
    {
      $this->display_stats_by_image(
          $_REQUEST['fAStat_year'],
          $_REQUEST['fAStat_month'],
          $_REQUEST['fAStat_day'],
          $this->config['AStat_MaxBarWidth'],
          $this->config['AStat_NbImgPerPages'],
          $_REQUEST['fAStat_page_number'],
          $this->config['AStat_ShowThumbImg'],
          $_REQUEST['fAStat_SortImg'],
          $_REQUEST['fAStat_IP'],
          $this->config['AStat_SeeTimeRequests']
      );
    }
    elseif($_GET['tab']=='config')
    {
      $this->display_config();
    }
    elseif($_GET['tab']=='tools')
    {
      $this->display_tools();
    }

    $this->tabsheet->select($_GET['tab']);
    $this->tabsheet->assign();
    $selected_tab=$this->tabsheet->get_selected();
    $template->assign($this->tabsheet->get_titlename(), "[".$selected_tab['caption']."]");

    $template_plugin["ASTAT_VERSION"] = "<i>AStat</i> ".l10n('AStat_version').ASTAT_VERSION;
    $template_plugin["ASTAT_PAGE"] = $_GET['tab'];

    $template->assign('plugin', $template_plugin);
    $template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
  }

  /* ---------------------------------------------------------------------------
  Private classe functions
  --------------------------------------------------------------------------- */

  /*
    return ajax content
  */
  protected function return_ajax_content()
  {
    global $ajax, $template;

    if(isset($_REQUEST['ajaxfct']))
    {
      //$this->debug("AJAXFCT:".$_REQUEST['ajaxfct']);
      $result="<p class='errors'>An error has occured</p>";
      switch($_REQUEST['ajaxfct'])
      {
        case 'astat_listip':
          if(!isset($_REQUEST['ipfilter'])) $_REQUEST['ipfilter']="";
          if(!isset($_REQUEST['exclude'])) $_REQUEST['exclude']="";
          $result=$this->ajax_listip($_REQUEST['ipfilter'], $_REQUEST['exclude']);
          break;
      }
      GPCAjax::returnResult($result);
    }
  }







  private function init_request()
  {
    $default_request = array('all'=>'Y', 'year'=>'', 'month'=>'', 'day'=>'');

    //initialise $REQUEST values if not defined
    if(!array_key_exists('tab', $_GET))
    {
      $_GET['tab']='stats_by_period';
    }
    if(!array_key_exists('fAStat_defper', $_REQUEST))
    {
      $_REQUEST['fAStat_defper']='Y';
    }
    if(!array_key_exists('fAStat_SortCat', $_REQUEST))
    {
      $_REQUEST['fAStat_SortCat']=$this->config['AStat_DefaultSortCat'];
    }
    if(!array_key_exists('fAStat_SortImg', $_REQUEST))
    {
      $_REQUEST['fAStat_SortImg']=$this->config['AStat_DefaultSortImg'];
    }
    if(!array_key_exists('fAStat_SortIP', $_REQUEST))
    {
      $_REQUEST['fAStat_SortIP']=$this->config['AStat_DefaultSortIP'];
    }
    if(!array_key_exists('fAStat_page_number', $_REQUEST))
    {
      $_REQUEST['fAStat_page_number']='1';
    }
    if(!array_key_exists('fAStat_IP', $_REQUEST))
    {
      $_REQUEST['fAStat_IP']="";
    }
    if(!array_key_exists('fAStat_purge_history_date', $_REQUEST))
    {
      $_REQUEST['fAStat_purge_history_date']="";
    }
    if(!array_key_exists('fAStat_catfilter', $_REQUEST))
    {
      $_REQUEST['fAStat_catfilter']="";
    }

    if(($_GET['tab']=='stats_by_period')&&($_REQUEST['fAStat_defper']=='Y'))
    {
      if($this->config['AStat_default_period']!='global')
      {
        $default_request['all'] = 'N';
      }

      if(($this->config['AStat_default_period']=='year')||
        ($this->config['AStat_default_period']=='month')||
        ($this->config['AStat_default_period']=='day'))
      {
        $default_request['year'] = date('Y');
      }

      if(($this->config['AStat_default_period']=='month')||
        ($this->config['AStat_default_period']=='day'))
      {
        $default_request['month'] = date('n');
      }

      if($this->config['AStat_default_period']=='day')
      {
        $default_request['day'] = date('j');
      }
    }

    if(!array_key_exists('fAStat_all', $_REQUEST))
    {
      $_REQUEST['fAStat_all']=$default_request['all'];
    }
    if(!array_key_exists('fAStat_year', $_REQUEST))
    {
      $_REQUEST['fAStat_year']=$default_request['year'];
    }
    if(!array_key_exists('fAStat_month', $_REQUEST))
    {
      $_REQUEST['fAStat_month']=$default_request['month'];
    }
    if(!array_key_exists('fAStat_day', $_REQUEST))
    {
      $_REQUEST['fAStat_day']=$default_request['day'];
    }

    $this->catfilter=$_REQUEST['fAStat_catfilter'];

  } //init_request


  /*
    request functions

    theses functions made SQL requests and returns datas
  */


  /*
    Stat by period
      Number of Pages
      Number IP
      Number of Images
      by :
        total
        years
        years/months
        years/months/days
        years/months/days/hours
  */
  private function stats_by_period($total, $year, $month, $day)
  {
    $returned = array();
    $delta = 0;

    $sql = " count(id) as NbPages, count(distinct IP) as NbIP,
            count(image_id) as NbImg, count(distinct category_id) as NbCat ";
    $sql_nfomax = ", MaxPages, MaxIP, MaxImg";
    $sql_from = " from ".HISTORY_TABLE." ";
    $sql_where = "";
    $sql_order = "";
    $sql_select = "";
    $sql_group = "";
    $sql_groupdef="";

    if($day!="")
    {
      $sql_groupdef="HOUR(time) as GId,";
      $sql_select="select HOUR(time) as GId, ";
      $sql_where=" where YEAR(date) = $year and MONTH(date) = $month and DAY(date) = $day ";
      $sql_group=" group by GId ";
      $sql_order=" order by GId asc";

      for($i=0;$i<24;$i++)
      {
        $returned[$i] = array(
                          "GId" => $i,
                          "NbPages" => 0,
                          "NbIP" => 0,
                          "NbImg" => 0,
                          "NbCat"=>0,
                          "MaxPages" => 0,
                          "MaxIP" => 0,
                          "MaxImg" => 0
                        );
      }
    }
    elseif($month!="")
    {
      $sql_groupdef="DAY(date) as GId,";
      $sql_select="select DAY(date) as GId, ";
      $sql_where=" where YEAR(date) = $year and MONTH(date) = $month ";
      $sql_group=" group by GId ";
      $sql_order=" order by GId asc";

      $delta = 1;
      $NbDays = strftime('%d', mktime(0,0,0,$month+1,0,$year));
      for($i=0;$i<$NbDays;$i++)
      {
        $returned[$i] = array(
                          "GId" => $i+1,
                          "NbPages" => 0,
                          "NbIP" => 0,
                          "NbImg" => 0,
                          "NbCat"=>0,
                          "MaxPages" => 0,
                          "MaxIP" => 0,
                          "MaxImg" => 0
                        );
      }
    }
    elseif($year!="")
    {
      $sql_groupdef="MONTH(date) as GId,";
      $sql_select="select MONTH(date) as GId, ";
      $sql_where=" where YEAR(date) = $year ";
      $sql_group=" group by GId ";
      $sql_order=" order by GId asc ";

      $delta = 1;
      for($i=0;$i<12;$i++)
      {
        $returned[$i] = array(
                          "GId" => $i+1,
                          "NbPages" => 0,
                          "NbIP" => 0,
                          "NbImg" => 0,
                          "NbCat"=>0,
                          "MaxPages" => 0,
                          "MaxIP" => 0,
                          "MaxImg" => 0
                        );
      }
    }
    elseif($total!="Y")
    {
      $sql_groupdef="YEAR(date) as GId,";
      $sql_select="select YEAR(date) as GId, ";
      $sql_group=" group by GId ";
      $sql_order=" order by GId desc";
    }
    else
    {
      $sql_select="select 'Tout' as GId, "; $sql_nfomax=", 0 as MaxPages, 0 as MaxIP, 0 as MaxImg";
    }

    if($this->catfilter!="")
    {
      $catfilter=$this->make_where_clause($this->catfilter);
      ($sql_where=="")?$sql_where=" where ":$sql_where.=" and ";
      $sql_where.=" category_id IN (".$catfilter.")";
    }

    if(($this->config['AStat_UseBlackList']!="false")&&($this->config['AStat_BlackListedIP']!=""))
    {
      ($sql_where=="")?$sql_where=" where ":$sql_where.=" AND ";
      ($this->config['AStat_UseBlackList']=="true")?$sql_where .= " NOT ":"";
      $sql_where .= $this->make_IP_where_clause($this->config['AStat_BlackListedIP']);
    }

    $sql_max=", (select max(n.MaxPages) as MaxPages, max(n.MaxIP) as MaxIP, max(n.MaxImg) as MaxImg
        from (select ".$sql_groupdef." count(id) as MaxPages, count(distinct IP) as MaxIP, count(image_id) as MaxImg
            from ".HISTORY_TABLE.$sql_where.$sql_group.") as n) as n ";
    $sql=$sql_select.$sql.$sql_nfomax.$sql_from.$sql_max.$sql_where.$sql_group.$sql_order;

    $result = pwg_query($sql);

    $i=0;
    while ($row = pwg_db_fetch_assoc($result))
    {
      if($year.$month.$day=="")
      { $returned[$i] = $row; $i++; }
      else
      { $returned[$row["GId"]-$delta] = $row; }
    }

    return($returned);
  } //stat by period

  /*
    Stats by IP
      Number of Pages
      Number of Images
      by :
        IP
        IP/years
        IP/years/months
        IP/years/months/days
  */
  private function stats_by_ip($year, $month, $day, $nbipperpage, $pagenumber, $sortip)
  {
    $returned0 = array();
    $sortlist = array(
                  "page" => "NbPages desc",
                  "picture" => "NbImg desc",
                  "ip" => "IP_USER asc"
                );

    $sql_select="select SQL_CALC_FOUND_ROWS ";
    $sql= " if(".HISTORY_TABLE.".user_id = 2, IP, if(".USERS_TABLE.".username is null, ' [".l10n("AStat_deleted_user")."]', CONCAT(' ', ".USERS_TABLE.".username))) as IP_USER, count(".HISTORY_TABLE.".id) as NbPages, count(image_id) as NbImg ";
          $sql_nfomax = ", MaxPages, MaxImg";
    $sql_from = " from ".HISTORY_TABLE." LEFT JOIN ".USERS_TABLE." ON ".HISTORY_TABLE.".user_id = ".USERS_TABLE.".id ";
    $sql_where = "";
    $sql_group=" group by IP_USER ";
    $sql_order=" order by ".$sortlist[$sortip]." ";
    $sql_limit=" limit ".(($pagenumber-1)* $nbipperpage).", ".$nbipperpage;


    if($day!="")
    {
      $sql_where=" where YEAR(date) = $year and MONTH(date) = $month and DAY(date) = $day ";
    }
    elseif($month!="")
    {
      $sql_where=" where YEAR(date) = $year and MONTH(date) = $month ";
    }
    elseif($year!="")
    {
      $sql_where=" where YEAR(date) = $year ";
    }
    else
    {
      $sql_nfomax = ", 0 as MaxPages, 0 as MaxImg";
    }

    if($this->catfilter!="")
    {
      $catfilter=$this->make_where_clause($this->catfilter);
      ($sql_where=="")?$sql_where=" where ":$sql_where.=" and ";
      $sql_where.=" category_id IN (".$catfilter.")";
    }

    if(($this->config['AStat_UseBlackList']!="false")&&($this->config['AStat_BlackListedIP']!=""))
    {
      ($sql_where=="")?$sql_where=" where ":$sql_where.=" AND ";
      ($this->config['AStat_UseBlackList']=="true")?$sql_where .= " NOT ":"";
      $sql_where .= $this->make_IP_where_clause($this->config['AStat_BlackListedIP']);
      $sql.=" , 'N' AS blacklist";
    }
    else
    {
      if($this->config['AStat_BlackListedIP']=='')
      {
        $sql.=" , 'N' AS blacklist";
      }
      else
      {
        $sql.=" , (CASE ";
        $tmp=explode(',', $this->config['AStat_BlackListedIP']);
        foreach($tmp as $key=>$val)
        {
          $sql.=" WHEN IP LIKE '".$val."' THEN 'Y' ";
        }
        $sql.="ELSE 'N' END) AS blacklist ";
      }
    }

    $sql_max=", (select max(n.MaxPages) as MaxPages, max(n.MaxImg) as MaxImg
        from (select if(".HISTORY_TABLE.".user_id = 2, IP, if(".USERS_TABLE.".username is null, '[".l10n("AStat_deleted_user")."]', ".USERS_TABLE.".username)) as IP_USER, count(".HISTORY_TABLE.".id) as MaxPages, count(image_id) as MaxImg
            from ".HISTORY_TABLE." LEFT JOIN ".USERS_TABLE." ON ".HISTORY_TABLE.".user_id = ".USERS_TABLE.".id ".$sql_where.$sql_group.") as n) as n ";
    $sql=$sql_select.$sql.$sql_nfomax.$sql_from.$sql_max.$sql_where.$sql_group.$sql_order.$sql_limit;


    $result = pwg_query($sql);
    $sql="select FOUND_ROWS()";

    $i=0;
    while ($row = pwg_db_fetch_assoc($result))
    {
      $returned0[$i] = $row; $i++;
    }
    $returned[0] = $returned0;

    $result = pwg_query($sql);
    if($result)
    {
      $row = pwg_db_fetch_row($result); $returned[1] = $row[0];
    }
    else
    {
      $returned[1] = -1;
    }

    return($returned);
  } //stat by ip

  /*
    Stats per categories
      %Pages
      %Images
      by :
        Categories
        Categories/years
        Categories/years/months
        Categories/years/months/day
  */
  private function stats_by_category($year, $month, $day, $nbipperpage, $pagenumber, $show_thumb, $sortcat)
  {
    $sortlist = array(
                  "page" => "PctPages desc, PctImg desc",
                  "picture" => "PctImg desc, PctPages desc",
                  "nbpicture" => "RatioImg desc, PctPages desc"
                );
    $returned0 = array();

    $sql_select="SELECT SQL_CALC_FOUND_ROWS ";

    $sql= "category_id, IF(category_id > 0, ".CATEGORIES_TABLE.".name, section) AS IdCat,
  COUNT(".HISTORY_TABLE.".id) AS NbPages, MaxPages.somme, 100*(count(".HISTORY_TABLE.".id)/MaxPages.somme) AS PctPages,
  COUNT(".HISTORY_TABLE.".image_id) AS NbImg, MaxImg.somme, 100*(count(".HISTORY_TABLE.".image_id)/MaxImg.somme) AS PctImg, ic2.nb_images as NbImgCat, (COUNT(".HISTORY_TABLE.".image_id)/ic2.nb_images) AS RatioImg, greatest(100*(COUNT(".HISTORY_TABLE.".id)/MaxPages.somme), 100*(COUNT(".HISTORY_TABLE.".image_id)/MaxImg.somme)) AS MaxPct ";

    if($show_thumb=='true')
    {
      $sql_thumb = ', '.IMAGES_TABLE.'.path as ImgPath, '.IMAGES_TABLE.'.file as ThumbFile, '.IMAGES_TABLE.'.id as ImgId';
      $sql_fromthumb = "LEFT JOIN ".IMAGES_TABLE." ON ic2.representative_picture_id = ".IMAGES_TABLE.".id  ";
    }
    else
    {
      $sql_thumb = "";
      $sql_fromthumb = "";
    }

    $sql_from = " FROM (".HISTORY_TABLE." LEFT JOIN ".CATEGORIES_TABLE." ON ".CATEGORIES_TABLE.".id = ".HISTORY_TABLE.".category_id),
(SELECT category_id AS catid, COUNT(image_id) AS nb_images, representative_picture_id
 FROM ".IMAGE_CATEGORY_TABLE.", ".CATEGORIES_TABLE."
 WHERE ".CATEGORIES_TABLE.".id = ".IMAGE_CATEGORY_TABLE.".category_id group by category_id) AS ic2 ";
    $sql_where = "";
    $sql_group=" GROUP BY category_id, section ";
    $sql_group2="";
    $sql_order=" ORDER BY ".$sortlist[$sortcat];
    $sql_limit=" LIMIT ".(($pagenumber-1)* $nbipperpage).", ".$nbipperpage;

    if($day!="")
    {
      $sql_where=" WHERE YEAR(date) = $year AND MONTH(date) = $month AND DAY(date)= $day ";
    }
    elseif($month!="")
    {
      $sql_where=" WHERE YEAR(date) = $year AND MONTH(date) = $month ";
    }
    elseif($year!="")
    {
      $sql_where=" WHERE YEAR(date) = $year ";
    }
    else { }

    if($this->catfilter!="")
    {
      $catfilter=$this->make_where_clause($this->catfilter);
      ($sql_where=="")?$sql_where=" where ":$sql_where.=" and ";
      $sql_where.=" category_id IN (".$catfilter.")";
    }

    $sql_max=", (SELECT COUNT(id) AS somme FROM ".HISTORY_TABLE.$sql_where.$sql_group2.") AS MaxPages,
          (SELECT COUNT(image_id) AS somme FROM ".HISTORY_TABLE.$sql_where.$sql_group2.") AS MaxImg ";

    ($sql_where=="")?$sql_where=" WHERE ":$sql_where.=" AND ";
    $sql_where .= "  ic2.catid = ".HISTORY_TABLE.".category_id ";

    if(($this->config['AStat_UseBlackList']!="false")&&($this->config['AStat_BlackListedIP']!=""))
    {
      ($this->config['AStat_UseBlackList']=="true")?$sql_where .= " AND NOT ":"";
      $sql_where .= $this->make_IP_where_clause($this->config['AStat_BlackListedIP']);
    }

    $sql=$sql_select.$sql.$sql_thumb.$sql_from.$sql_fromthumb.$sql_max.$sql_where.$sql_group.$sql_order.$sql_limit;

    $result = pwg_query($sql);
    $sql="SELECT FOUND_ROWS()";

    $i=0;
    while ($row = pwg_db_fetch_assoc($result))
    {
      $returned0[$i] = $row; $i++;
    }
    $returned[0] = $returned0;

    $result = pwg_query($sql);
    if($result)
    {
      $row = pwg_db_fetch_row($result); $returned[1] = $row[0];
    }
    else
    {
      $returned[1] = -1;
    }

    return($returned);
  } // stats per categories

  /*
    Stats by image
      Num of view per image
      %view on period
      by :
        Images
        Images/years
        Images/years/months
        Images/years/months/days
  */
  private function stats_by_image($year, $month, $day, $nbipperpage, $pagenumber, $sortimg, $ip)
  {
    $sortlist = array(
                  "picture" => "NbVues desc, CatName asc, ImgName asc, ImgId asc",
                  "catname" => "CatName asc, ImgName asc, ImgId asc"
                );
    $returned0 = array();

    $sql_select="select SQL_CALC_FOUND_ROWS ";


    $sql=" image_id as ImgId, ".IMAGES_TABLE.".name as ImgName,
        if(category_id > 0, ".CATEGORIES_TABLE.".name, section) as CatName,
        ".HISTORY_TABLE.".category_id as IdCat, count(".HISTORY_TABLE.".image_id) as NbVues,
        MaxImg.somme, 100*(count(".HISTORY_TABLE.".image_id)/MaxImg.somme) as PctImg,
        ".IMAGES_TABLE.".path as ImgPath, ".IMAGES_TABLE.".file as ThumbFile,
        MaxImg2.somme as NbVuesMax ";

    $sql_from = " from ((".HISTORY_TABLE." LEFT JOIN ".IMAGES_TABLE." ON
  ".IMAGES_TABLE.".id = ".HISTORY_TABLE.".image_id) LEFT JOIN ".CATEGORIES_TABLE."
  ON ".CATEGORIES_TABLE.".id = ".HISTORY_TABLE.".category_id) ";
    $sql_from_ip="";

    $sql_where = " where ".HISTORY_TABLE.".image_id is not null ";
    $sql_group=" group by image_id, category_id ";
    $sql_order=" order by ".$sortlist[$sortimg];
    $sql_limit=" limit ".(($pagenumber-1)* $nbipperpage).", ".$nbipperpage;

    if($day!="")
    {
      $sql_where.=" and YEAR(date) = $year and MONTH(date) = $month and DAY(date)= $day ";
    }
    elseif($month!="")
    {
      $sql_where.=" and YEAR(date) = $year and MONTH(date) = $month ";
    }
    elseif($year!="")
    {
      $sql_where.=" and YEAR(date) = $year ";
    }
    else { }

    if($ip!="")
    {
      $sql_where.=" and ( ((IP = '$ip') and ( user_id = 2 ))  or (".USERS_TABLE.".username = '$ip') )";
      $sql_from_ip=" LEFT JOIN ".USERS_TABLE." ON ".USERS_TABLE.".id = ".HISTORY_TABLE.".user_id ";
    }

    if($this->catfilter!="")
    {
      $catfilter=$this->make_where_clause($this->catfilter);
      ($sql_where=="")?$sql_where=" where ":$sql_where.=" and ";
      $sql_where.=" category_id IN (".$catfilter.")";
    }

    if(($this->config['AStat_UseBlackList']!="false")&&($this->config['AStat_BlackListedIP']!=""))
    {
      ($sql_where=="")?$sql_where=" where ":$sql_where.=" AND ";
      ($this->config['AStat_UseBlackList']=="true")?$sql_where .= " NOT ":"";
      $sql_where .= $this->make_IP_where_clause($this->config['AStat_BlackListedIP']);
    }


    $sql_max=", (select count(image_id) as somme from ".HISTORY_TABLE.$sql_from_ip.$sql_where.") as MaxImg, (select count(image_id) as somme from ".HISTORY_TABLE.$sql_from_ip.$sql_where." and ".HISTORY_TABLE.".image_id is not null group by image_id order by somme desc limit 0,1) as MaxImg2 ";

    $sql=$sql_select.$sql.$sql_from.$sql_from_ip.$sql_max.$sql_where.$sql_group.$sql_order.$sql_limit;

    $result = pwg_query($sql);
    $sql="select FOUND_ROWS()";

    $i=0;
    while ($row = pwg_db_fetch_assoc($result))
    {
      $returned0[$i] = $row; $i++;
    }
    $returned[0] = $returned0;

    $result = pwg_query($sql);
    if($result)
    {
      $row = pwg_db_fetch_row($result); $returned[1] = $row[0];
    }
    else
    {
      $returned[1] = -1;
    }

    return($returned);
  } //stat by images


  /*
    template related functions

    theses functions call stat function, and display result with template usage
  */



  private function display_stats_by_period($total, $year, $month, $day, $max_width, $seetimerequest)
  {
    global $template;

    $template->set_filename('body_page', dirname(__FILE__)."/admin/astat_by_period.tpl");


    $template_datas=array();
    $template_datarows=array();


    /* requete */
    //calc_time(true);
    $stats = $this->stats_by_period($total, $year, $month, $day);
    //$timerequest=calc_time(false);

    $dir_links = "";
    $a_links=array("global" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=Y",
        "all" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N",
        "year" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year",
        "month" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=$month",
        "day" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=$day");

    $ip_links=array("all" => $this->getAdminLink()."-stats_by_ip",
        "year" => $this->getAdminLink()."-stats_by_ip&amp;fAStat_year=",
        "month" => $this->getAdminLink()."-stats_by_ip&amp;fAStat_year=$year&amp;fAStat_month=",
        "day" => $this->getAdminLink()."-stats_by_ip&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=");

    $cat_links=array("all" => $this->getAdminLink()."-stats_by_category",
        "year" => $this->getAdminLink()."-stats_by_category&amp;fAStat_year=",
        "month" => $this->getAdminLink()."-stats_by_category&amp;fAStat_year=$year&amp;fAStat_month=",
        "day" => $this->getAdminLink()."-stats_by_category&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=");

    $img_links=array("all" => $this->getAdminLink()."-stats_by_image",
        "year" => $this->getAdminLink()."-stats_by_image&amp;fAStat_year=",
        "month" => $this->getAdminLink()."-stats_by_image&amp;fAStat_year=$year&amp;fAStat_month=",
        "day" => $this->getAdminLink()."-stats_by_image&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=");


    /* period label + navigation links */
    if($day!="")
    {
      $template_datas["PERIOD_LABEL"] = l10n("AStat_period_label_hours");
      $template_datas["L_STAT_TITLE"] = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$this->format_link($year, $a_links["year"])." / ".$this->format_link(l10n("AStat_month_of_year_".$month), $a_links["month"])." / ".l10n("AStat_day_of_week_".date("w",mktime(0, 0, 0, $month, $day, $year)))." $day";
    }
    elseif($month!="")
    {
      $template_datas["PERIOD_LABEL"] = l10n("AStat_period_label_days");
      $template_datas["L_STAT_TITLE"] = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$this->format_link($year, $a_links["year"])." / ".l10n("AStat_month_of_year_".$month);
    }
    elseif($year!="")
    {
      $template_datas["PERIOD_LABEL"] = l10n("AStat_period_label_months");
      $template_datas["L_STAT_TITLE"] = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$year;
    }
    elseif($total!="Y")
    {
      $template_datas["PERIOD_LABEL"] = l10n("AStat_period_label_years");
      $template_datas["L_STAT_TITLE"] = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".l10n("AStat_period_label_all");
    }
    else
    {
      $template_datas["PERIOD_LABEL"] = l10n("AStat_period_label_all");
      $template_datas["L_STAT_TITLE"] = l10n("AStat_period_label_global");
    }
    $template_datas["MAX_WIDTH"] = $max_width+10;
    $template_datas["ASTAT_NFO_STAT"] = l10n("AStat_Nfo_Period");

    if($seetimerequest=='true')
    {
      $template_datas["ASTAT_TIME_REQUEST"] = l10n('AStat_time_request_label').' '.$timerequest.'s';
    }

    /* tableau de stat */
    for($i=0;$i<count($stats);$i++)
    {
      if($stats[$i]["MaxPages"] > 0)
      {
        $width_pages = ceil(($stats[$i]["NbPages"] * $max_width) / $stats[$i]["MaxPages"] );
        $width_img = ceil(($stats[$i]["NbImg"] * $max_width) / $stats[$i]["MaxPages"] );
        $width_ip = ceil(($stats[$i]["NbIP"] * $max_width) / $stats[$i]["MaxPages"] );
        $width_cat = ceil(($stats[$i]["NbCat"] * $max_width) / $stats[$i]["MaxPages"] );
      }
      else
      {
        $width_pages = 0;
        $width_img = 0;
        $width_ip = 0;
        $width_cat = 0;
      }


      if($day!="")
      { // si jours sÃ©lectionnÃ©, heures affichÃ©es
        $value=$stats[$i]["GId"];
        $link="";
        $value_ip="";
        $value_cat="";
        $value_img="";
      }
      elseif($month!="")
      { // si mois sÃ©lectionnÃ©, jours affichÃ©s
        $value = $stats[$i]["GId"]." (".l10n("AStat_day_of_week_".date("w",mktime(0, 0, 0, $month, $stats[$i]["GId"], $year))).")";
        $link=$this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=".$stats[$i]["GId"];
        $value_ip=$ip_links["day"].$stats[$i]["GId"];
        $value_cat=$cat_links["day"].$stats[$i]["GId"];
        $value_img=$img_links["day"].$stats[$i]["GId"];
      }
      elseif($year!="")
      { // si annÃ©e sÃ©lectionnÃ©e, mois affichÃ©s
        $value = l10n("AStat_month_of_year_".$stats[$i]["GId"]);
        $link=$this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=".$stats[$i]["GId"];
        $value_ip=$ip_links["month"].$stats[$i]["GId"];
        $value_cat=$cat_links["month"].$stats[$i]["GId"];
        $value_img=$img_links["month"].$stats[$i]["GId"];
      }
      elseif($total!="Y")
      { // si total sÃ©lectionnÃ©, annÃ©es affichÃ©es
        $value = $stats[$i]["GId"];
        $link=$this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=".$stats[$i]["GId"];
        $value_ip=$ip_links["year"].$stats[$i]["GId"];
        $value_cat=$cat_links["year"].$stats[$i]["GId"];
        $value_img=$img_links["year"].$stats[$i]["GId"];
      }
      else
      {
        $value=l10n("AStat_period_label_all");
        $link=$this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N";
        $value_ip=$ip_links["all"];
        $value_cat=$cat_links["all"];
        $value_img=$img_links["all"];
      }


      if((($stats[$i]["NbPages"] + $stats[$i]["NbImg"] + $stats[$i]["NbIP"])>0)&&($link!=""))
      { $value=$this->format_link($value, $link); }

      if((($stats[$i]["NbIP"])>0)&&($value_ip!=""))
      { $value_ip=$this->format_link($stats[$i]["NbIP"], $value_ip); }
      else
      { $value_ip = $stats[$i]["NbIP"]; }

      if((($stats[$i]["NbCat"])>0)&&($value_cat!=""))
      { $value_cat=$this->format_link($stats[$i]["NbCat"], $value_cat); }
      else
      { $value_cat= $stats[$i]["NbCat"]; }

      if((($stats[$i]["NbImg"])>0)&&($value_img!=""))
      { $value_img=$this->format_link($stats[$i]["NbImg"], $value_img); }
      else
      { $value_img= $stats[$i]["NbImg"]; }



      $template_datarows[]=array(
        'VALUE' => $value,
        'PAGES' => $stats[$i]["NbPages"],
        'PICTURES' => $value_img,
        'CATEGORIES' => $value_cat,
        'IPVISIT' => $value_ip,
        'WIDTH1' => $width_ip,
        'WIDTH2' => $width_img,
        'WIDTH3' => $width_pages,
        'WIDTH4' => $width_cat,
      );

    }

    $template->assign('datas', $template_datas);
    $template->assign('datarows', $template_datarows);
    $template->assign_var_from_handle('ASTAT_BODY_PAGE', 'body_page');
  } //display_stats_by_period



  /*
    display stat by ip
  */
  private function display_stats_by_ip($year, $month, $day, $max_width, $nbipperpage, $pagenumber, $sortip, $seetimerequest)
  {
    global $template;

    $template->set_filename('body_page', dirname(__FILE__)."/admin/astat_by_ip.tpl");


    $template_datas=array();
    $template_datarows=array();


    /* requete */
    //calc_time(true);
    $returned = $this->stats_by_ip($year, $month, $day, $nbipperpage, $pagenumber, $sortip);
    //$timerequest=calc_time(false);
    $stats=$returned[0];
    $nbfoundrows=$returned[1];
    $nbpages=ceil($nbfoundrows / $nbipperpage);


    $dir_links = "";
    $page_link = "";
    $a_links=array("global" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=Y",
        "all" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N",
        "year" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year",
        "month" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=$month",
        "day" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=$day");

    $ip_links=array("all" => $this->getAdminLink()."-stats_by_ip",
        "year" => $this->getAdminLink()."-stats_by_ip&amp;fAStat_year=$year",
        "month" => $this->getAdminLink()."-stats_by_ip&amp;fAStat_year=$year&amp;fAStat_month=$month",
        "day" => $this->getAdminLink()."-stats_by_ip&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=$day");

    $img_links=array("all" => $this->getAdminLink()."-stats_by_image",
        "year" => $this->getAdminLink()."-stats_by_image&amp;fAStat_year=$year",
        "month" => $this->getAdminLink()."-stats_by_image&amp;fAStat_year=$year&amp;fAStat_month=$month",
        "day" => $this->getAdminLink()."-stats_by_image&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=$day");


    /* periode label + navigation links */
    if($day!="")
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$this->format_link($year, $a_links["year"])." / ".$this->format_link(l10n("AStat_month_of_year_".$month), $a_links["month"])." / ".l10n("AStat_day_of_week_".date("w",mktime(0, 0, 0, $month, $day, $year)))." $day";
      $page_link=$ip_links["day"];
      $img_link=$img_links["day"];
    }
    elseif($month!="")
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$this->format_link($year, $a_links["year"])." / ".l10n("AStat_month_of_year_".$month);
      $page_link=$ip_links["month"];
      $img_link=$img_links["month"];
    }
    elseif($year!="")
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$year;
      $page_link=$ip_links["year"];
      $img_link=$img_links["year"];
    }
    else
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".l10n("AStat_period_label_all");
      $page_link=$ip_links["all"];
      $img_link=$img_links["all"];
    }


    if($nbpages>1) { $plural="s"; } else { $plural=""; }
    $pages_links=l10n("AStat_page".$plural."_label")." : ";
    for($i=1;$i<=$nbpages;$i++)
    {
      if($i==$pagenumber)
      { $pages_links.=" $i "; }
      else
      {
        $pages_links.=$this->format_link(" $i ", $page_link."&amp;fAStat_page_number=$i&amp;fAStat_SortIP=$sortip");
      }
    }

    $template_datas["L_STAT_TITLE"] = $dir_links;
    $template_datas["MAX_WIDTH"]=$max_width+10;
    $template_datas["NB_TOTAL_IP"] = l10n('AStat_nb_total_ip')." : $nbfoundrows";
    $template_datas["PAGES_LINKS"] = $pages_links;
    $template_datas["ASTAT_NFO_STAT"]= l10n("AStat_Nfo_IP");

    $template_datas["ASTAT_SORT_LABEL"] = l10n("AStat_SortIPLabel").strtolower(l10n("AStat_sortip_$sortip"));

    $template_datas["ASTAT_LABEL_IP_label"] = $this->format_link(l10n("AStat_RefIPLabel"), $page_link."&amp;fAStat_SortIP=ip");
    $template_datas["ASTAT_LABEL_Pages_seen"] = $this->format_link(l10n("Pages seen"), $page_link."&amp;fAStat_SortIP=page");
    $template_datas["ASTAT_LABEL_Pictures_seen"] = $this->format_link(l10n("Pictures_seen"), $page_link."&amp;fAStat_SortIP=picture");

    if($seetimerequest=='true')
    {
      $template_datas["ASTAT_TIME_REQUEST"] = l10n('AStat_time_request_label').' '.$timerequest.'s';
    }

    for($i=0;$i<count($stats);$i++)
    {
        if($stats[$i]["MaxPages"] > 0)
      {
        $width_pages = ceil(($stats[$i]["NbPages"] * $max_width) / $stats[$i]["MaxPages"] );
        $width_img = ceil(($stats[$i]["NbImg"] * $max_width) / $stats[$i]["MaxPages"] );
      }
      else
      {
        $width_pages = 0;
        $width_img = 0;
      }


      if($this->is_ip($stats[$i]["IP_USER"]))
      {
        $ip_geolocalisation='<a href="http://www.geoiptool.com/fr/?IP='.$stats[$i]["IP_USER"].'" title="Geo IP localisation" target="_blank">['.l10n('AStat_IP_geolocalisation').'] </a>';
        $ip_adress='<a href="http://www.ripe.net/whois?form_type=simple&amp;full_query_string=&amp;searchtext='.$stats[$i]["IP_USER"].'+&amp;do_search=Search" title="Ripe Whois" target="_blank">'.$stats[$i]["IP_USER"].'</a>';
        $ip_blacklist=$page_link."&amp;fAStat_IP_BL=".$stats[$i]["IP_USER"];

        if($pagenumber>1)
        {
          $ip_blacklist.="&amp;fAStat_page_number=$pagenumber";
        }

        if($sortip!="page")
        {
          $ip_blacklist.="&amp;fAStat_SortIP=$sortip";
        }

        if($stats[$i]["blacklist"]=='Y')
        {
          $ip_blacklist="[".l10n('AStat_IP_blacklist')."]";
        }
        else
        {
          $ip_blacklist=$this->format_link("[".l10n('AStat_IP_blacklist')."]", $ip_blacklist);
        }
      }
      else
      {
        $ip_geolocalisation='';
        $ip_adress=$stats[$i]["IP_USER"];
        $ip_blacklist='';
      }



      $template_datarows[]=array(
        'ASTAT_IP_BLACKLIST' => $ip_blacklist,
        'ASTAT_IP_GEOLOCALISATION' => $ip_geolocalisation,
        'ASTAT_IP_ADRESS' => $ip_adress,
        'PAGES' => $stats[$i]["NbPages"],
        'PICTURES' => $this->format_link($stats[$i]["NbImg"], $img_link."&amp;fAStat_IP=".trim($stats[$i]["IP_USER"])),
        'WIDTH1' => $width_img,
        'WIDTH2' => $width_pages,
      );
    }

    $template->assign('datas', $template_datas);
    $template->assign('datarows', $template_datarows);
    $template->assign_var_from_handle('ASTAT_BODY_PAGE', 'body_page');
  } // display_stat_by_ip





  /*
    display stat by category
  */
  private function display_stats_by_category($year, $month, $day, $max_width, $nbipperpage, $pagenumber,$showthumb, $sortcat, $seetimerequest)
  {
    global $template, $conf;

    $template->set_filename('body_page', dirname(__FILE__)."/admin/astat_by_category.tpl");

    $template_datas=array();
    $template_datarows=array();

    /* requete */
    //calc_time(true);
    $returned = $this->stats_by_category($year, $month, $day, $nbipperpage, $pagenumber, $showthumb, $sortcat);
    //$timerequest=calc_time(false);
    $stats=$returned[0];
    $nbfoundrows=$returned[1];
    $nbpages=ceil($nbfoundrows / $nbipperpage);


    $dir_links = "";
    $page_link = "";
    $a_links=array("global" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=Y",
        "all" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N",
        "year" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year",
        "month" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=$month",
        "day" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=$day");

    $cat_links=array("all" => $this->getAdminLink()."-stats_by_category",
        "year" => $this->getAdminLink()."-stats_by_category&amp;fAStat_year=$year",
        "month" => $this->getAdminLink()."-stats_by_category&amp;fAStat_year=$year&amp;fAStat_month=$month",
        "day" => $this->getAdminLink()."-stats_by_category&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=$day");

    /* make navigation links */
    if($day!="")
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$this->format_link($year, $a_links["year"])." / ".$this->format_link(l10n("AStat_month_of_year_".$month), $a_links["month"])." / ".l10n("AStat_day_of_week_".date("w",mktime(0, 0, 0, $month, $day, $year)))." $day";
      $page_link=$cat_links["day"];
    }
    elseif($month!="")
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$this->format_link($year, $a_links["year"])." / ".l10n("AStat_month_of_year_".$month);
      $page_link=$cat_links["month"];
    }
    elseif($year!="")
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$year;
      $page_link=$cat_links["year"];
    }
    else
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".l10n("AStat_period_label_all");
      $page_link=$cat_links["all"];
    }


    if($nbpages>1)
    {
      $plural="s";
    }
    else
    {
      $plural="";
    }

    $pages_links=l10n("AStat_page".$plural."_label")." : ";
    for($i=1;$i<=$nbpages;$i++)
    {
      if($i==$pagenumber)
      {
        $pages_links.=" $i ";
      }
      else
      {
        $pages_links.=$this->format_link(" $i ", $page_link."&amp;fAStat_SortCat=$sortcat&amp;fAStat_page_number=$i");
      }
    }


    /* navigation */
    $template_datas["L_STAT_TITLE"] = $dir_links;
    $template_datas["MAX_WIDTH"] = $max_width;
    $template_datas["NB_TOTAL_CATEGORY"] = l10n('AStat_nb_total_category')." : $nbfoundrows";
    $template_datas["PAGES_LINKS"] = $pages_links;
    $template_datas["ASTAT_NFO_STAT"] = l10n("AStat_Nfo_Category");
    $template_datas["ASTAT_SORT_LABEL"] = l10n("AStat_SortCatLabel").strtolower(l10n("AStat_sortcat_$sortcat"));

    $template_datas["ASTAT_LABEL_pct_Pages_seen"] = $this->format_link(l10n("pct_Pages_seen"), $page_link."&amp;fAStat_SortCat=page");
    $template_datas["ASTAT_LABEL_pct_Pictures_seen"] = $this->format_link(l10n("pct_Pictures_seen"), $page_link."&amp;fAStat_SortCat=picture");
    $template_datas["ASTAT_LABEL_ratio_Pictures_seen"] = $this->format_link(l10n("ratio_Pictures_seen"), $page_link."&amp;fAStat_SortCat=nbpicture");

    if($seetimerequest=='true')
    {
      $template_datas["ASTAT_TIME_REQUEST"] = l10n('AStat_time_request_label').' '.$timerequest.'s';
    }

    for($i=0;$i<count($stats);$i++)
    {
      $width_pages = ceil(($stats[$i]["PctPages"] * $max_width)/100);
      $width_img = ceil(($stats[$i]["PctImg"] * $max_width)/100 );

      if($showthumb=='true')
      {
        $filethumb=DerivativeImage::thumb_url(array('id'=>$stats[$i]["ImgId"], 'path'=>$stats[$i]["ImgPath"]));
      }
      else
      {
        $filethumb='';
      }

      if($stats[$i]["category_id"]>0)
      { $category = $this->format_link($stats[$i]["IdCat"], PHPWG_ROOT_PATH."index.php?/category/".$stats[$i]["category_id"]); }
      else
      {
        $category = "<i>".l10n('AStat_section_label').' : ';
        if(l10n('AStat_section_'.$stats[$i]["IdCat"])!='AStat_section_'.$stats[$i]["IdCat"])
        {
          $category.=l10n('AStat_section_'.$stats[$i]["IdCat"]);
        }
        else
        {
          $category.=sprintf(l10n('AStat_section_unknown'), $stats[$i]["IdCat"]);
        }

        $category.="</i>";
      }

      $template_datarows[]=array(
        'THUMBJPG' => $filethumb,
        'CATEGORY' => $category,
        'PCTPAGES' => $stats[$i]["PctPages"],
        'PCTPICTURES' => $stats[$i]["PctImg"],
        'RATIOPICTURES' => $stats[$i]["RatioImg"],
        'WIDTH1' => $width_img,
        'WIDTH2' => $width_pages,
      );
    }

    $template->assign('datas', $template_datas);
    $template->assign('datarows', $template_datarows);
    $template->assign_var_from_handle('ASTAT_BODY_PAGE', 'body_page');
  } // display_stat_by_category



  /* ------------------------------------------------------------------------------------------
      display stats for images
      ------------------------------------------------------------------------------------------ */
  function display_stats_by_image($year, $month, $day, $max_width, $nbipperpage, $pagenumber,$showthumb, $sortimg, $ip, $seetimerequest)
  {
    global $template, $conf;

    $template->set_filename('body_page', dirname(__FILE__)."/admin/astat_by_image.tpl");


    $template_datas=array();
    $template_datarows=array();


    //calc_time(true);
    $returned = $this->stats_by_image($year, $month, $day, $nbipperpage, $pagenumber, $sortimg, $ip);
    //$timerequest=calc_time(false);
    $stats=$returned[0];
    $nbfoundrows=$returned[1];
    $nbpages=ceil($nbfoundrows / $nbipperpage);

    $dir_links = "";
    $page_link = "";
    $a_links=array("global" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=Y",
        "all" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N",
        "year" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year",
        "month" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=$month",
        "day" => $this->getAdminLink()."&amp;fAStat_defper=N&amp;fAStat_all=N&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=$day");

    $img_links=array("all" => $this->getAdminLink()."-stats_by_image",
        "year" => $this->getAdminLink()."-stats_by_image&amp;fAStat_year=$year",
        "month" => $this->getAdminLink()."-stats_by_image&amp;fAStat_year=$year&amp;fAStat_month=$month",
        "day" => $this->getAdminLink()."-stats_by_image&amp;fAStat_year=$year&amp;fAStat_month=$month&amp;fAStat_day=$day");

    /* navigation links */
    if($day!="")
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$this->format_link($year, $a_links["year"])." / ".$this->format_link(l10n("AStat_month_of_year_".$month), $a_links["month"])." / ".l10n("AStat_day_of_week_".date("w",mktime(0, 0, 0, $month, $day, $year)))." $day";
      $page_link=$img_links["day"];
    }
    elseif($month!="")
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$this->format_link($year, $a_links["year"])." / ".l10n("AStat_month_of_year_".$month);
      $page_link=$img_links["month"];
    }
    elseif($year!="")
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".$this->format_link(l10n("AStat_period_label_all"), $a_links["all"])." / ".$year;
      $page_link=$img_links["year"];
    }
    else
    {
      $dir_links = $this->format_link(l10n("AStat_period_label_global"), $a_links["global"])." / ".l10n("AStat_period_label_all");
      $page_link=$img_links["all"];
    }

    if($ip!="")
    {
      $dir_links.= " [IP : $ip]";
    }


    if($nbpages>1) { $plural="s"; } else { $plural=""; }
    $pages_links=l10n("AStat_page".$plural."_label")." : ";
    for($i=1;$i<=$nbpages;$i++)
    {
      if($i==$pagenumber)
      { $pages_links.=" $i "; }
      else
      {
        if($ip!="") { $ip_link="&amp;fAStat_IP=$ip"; } else { $ip_link=""; }
        $pages_links.=$this->format_link(" $i ", $page_link."&amp;fAStat_SortImg=$sortimg&amp;fAStat_page_number=$i".$ip_link);
      }
    }


    /* navigation */
    $template_datas["L_STAT_TITLE"] = $dir_links;
    $template_datas["MAX_WIDTH"] = $max_width;
    $template_datas["NB_TOTAL_IMAGE"] = l10n('AStat_nb_total_image')." : $nbfoundrows";
    $template_datas["PAGES_LINKS"] = $pages_links;
    $template_datas["ASTAT_NFO_STAT"] = l10n("AStat_Nfo_Image");
    $template_datas["ASTAT_SORT_LABEL"] = l10n("AStat_SortImgLabel").strtolower(l10n("AStat_sortimg_$sortimg"));

    $template_datas["ASTAT_LABEL_AStat_RefImageLabel"] = $this->format_link(l10n("AStat_RefImageLabel"), $page_link."&amp;fAStat_SortImg=catname");
    $template_datas["ASTAT_LABEL_Pictures_seen"] = $this->format_link(l10n("Pictures_seen"), $page_link."&amp;fAStat_SortImg=picture");
    $template_datas["ASTAT_LABEL_pct_Pictures_seen"] = l10n("pct_Pictures_seen");

    if($seetimerequest=='true')
    {
      $template_datas["ASTAT_TIME_REQUEST"] = l10n('AStat_time_request_label').' '.$timerequest.'s';
    }

    for($i=0;$i<count($stats);$i++)
    {
      $width_pages = ceil(($stats[$i]["NbVues"] * $max_width)/$stats[$i]["NbVuesMax"] );
      $width_img = ceil(($stats[$i]["PctImg"] * $max_width)/100 );

      if($showthumb=='true')
      {
        $filethumb=DerivativeImage::thumb_url(array('id'=>$stats[$i]["ImgId"], 'path'=>$stats[$i]["ImgPath"]));
      }
      else
      {
        $filethumb='';
      }


      if($stats[$i]["IdCat"]>0)
      {
        $image_links = $this->format_link($stats[$i]["CatName"], PHPWG_ROOT_PATH."index.php?/category/".$stats[$i]["IdCat"])." / ";
        if($stats[$i]["ImgName"]!="")
        {
          $image_links.=$this->format_link($stats[$i]["ImgName"], PHPWG_ROOT_PATH."picture.php?/".$stats[$i]["ImgId"]."/category/".$stats[$i]["IdCat"]);
        }
        else
        {
          if($stats[$i]["ThumbFile"]!="")
          {
            $image_links.=$this->format_link("[ ".$stats[$i]["ThumbFile"]." ]", PHPWG_ROOT_PATH."picture.php?/".$stats[$i]["ImgId"]."/category/".$stats[$i]["IdCat"]);
          }
          else
          {
            $image_links=l10n('AStat_deleted_picture')." [ Id #".$stats[$i]["ImgId"]." ]";
          }
        }
      }
      else
      {
        $image_links = "<i>".l10n('AStat_section_label').' : ';
        if(l10n('AStat_section_'.$stats[$i]["CatName"])!='AStat_section_'.$stats[$i]["CatName"])
        {
          $image_links.=l10n('AStat_section_'.$stats[$i]["CatName"]);
        }
        else
        {
          $image_links.=sprintf(l10n('AStat_section_unknown'), $stats[$i]["CatName"]);
        }

        $image_links.="</i> / ";

        if($stats[$i]["ImgName"]!="")
        {
          $image_links.=$stats[$i]["ImgName"];
        }
        else
        {
          if($stats[$i]["ThumbFile"]!="")
          {
            $image_links.="[ ".$stats[$i]["ThumbFile"]." ]";
          }
          else
          {
            $image_links=l10n('AStat_deleted_picture')." [ Id #".$stats[$i]["ImgId"]." ]";
          }
        }
      }



      $template_datarows[]=array(
        'THUMBJPG' => $filethumb,
        'IMAGE' => $image_links,
        'NBPICTURES' => $stats[$i]["NbVues"],
        'PCTPICTURES' => $stats[$i]["PctImg"],
        'WIDTH1' => $width_img,
        'WIDTH2' => $width_pages,
      );
    }

    $template->assign('datas', $template_datas);
    $template->assign('datarows', $template_datarows);
    $template->assign_var_from_handle('ASTAT_BODY_PAGE', 'body_page');
  } // display_stat_by_image




  private function add_ip_to_filter($ip)
  {
    if(strpos($this->config['AStat_BlackListedIP'].",", $ip.",")===false)
    {
      ($this->config['AStat_BlackListedIP']!='')?$this->config['AStat_BlackListedIP'].=",":"";
      $this->config['AStat_BlackListedIP'].=$ip;
      $this->saveConfig();
    }
  }


  /*
    display config page
  */
  private function display_config()
  {
    global $template, $page;

    $save_status=false;

    if(isset($_POST['submit']))
    {
      if (true) // if(!is_adviser())
      {
        reset($this->config);
        while (list($key, $val) = each($this->config))
        {
          if(isset($_POST['f_'.$key]))
          {
            $this->config[$key] = $_POST['f_'.$key];
          }
        }
        if($this->saveConfig())
        {
          array_push($page['infos'], l10n('AStat_config_saved'));
        }
        else
        {
          array_push($page['errors'], l10n('AStat_adviser_not_authorized'));
        }
      }
      else
      {
        array_push($page['errors'], l10n('AStat_adviser_not_authorized'));
      }
    }

    $template->set_filename('body_page', dirname(__FILE__).'/admin/astat_config.tpl');

    $template_datas=array();
    $template_list_values=array();
    $template_list_labels=array();

    //standards inputs zones
    reset($this->config);
    foreach ($this->config as $key=>$val)
    {
      $template_datas["f_".$key]=$val;
    }

    //
    $template_datas['ajaxurl']=$this->getAdminLink();

    // define selected item for lists zones
    $template_datas['AStat_periods_selected']=$this->config['AStat_default_period'];
    $template_datas['AStat_defaultsortcat_selected']=$this->config['AStat_DefaultSortCat'];
    $template_datas['AStat_defaultsortip_selected']=$this->config['AStat_DefaultSortIP'];
    $template_datas['AStat_defaultsortimg_selected']=$this->config['AStat_DefaultSortImg'];

    $template_datas['AStat_showthumbcat_selected']=$this->config['AStat_ShowThumbCat'];
    $template_datas['AStat_showthumbimg_selected']=$this->config['AStat_ShowThumbImg'];
    $template_datas['AStat_UseBlackList_selected']=$this->config['AStat_UseBlackList'];

    // making lists zones
    // default period
    reset($this->list_periods);
    foreach ($this->list_periods as $key=>$val)
    {
      $template_list_values['periods'][]=$val;
      $template_list_labels['periods'][]=l10n('AStat_PeriodPerDefault_'.$val);
    }
    // default category order
    reset($this->list_sortcat);
    foreach ($this->list_sortcat as $key=>$val)
    {
      $template_list_values['sortcat'][]=$val;
      $template_list_labels['sortcat'][]=l10n('AStat_sortcat_'.$val);
    }
    // default ip order
    reset($this->list_sortip);
    foreach ($this->list_sortip as $key=>$val)
    {
      $template_list_values['sortip'][]=$val;
      $template_list_labels['sortip'][]=l10n('AStat_sortip_'.$val);
    }
    // default picture order
    reset($this->list_sortimg);
    foreach ($this->list_sortimg as $key=>$val)
    {
      $template_list_values['sortimg'][]=$val;
      $template_list_labels['sortimg'][]=l10n('AStat_sortimg_'.$val);
    }

    /* yes/no lists */
    $template_list_values['yesno'][]='true';
    $template_list_labels['yesno'][]=l10n('AStat_yesno_true');
    $template_list_values['yesno'][]='false';
    $template_list_labels['yesno'][]=l10n('AStat_yesno_false');

    $template_list_values['enableddisabled'][]='true';
    $template_list_values['enableddisabled'][]='false';
    $template_list_values['enableddisabled'][]='invert';
    $template_list_labels['enableddisabled'][]=l10n('AStat_enableddisabled_true');
    $template_list_labels['enableddisabled'][]=l10n('AStat_enableddisabled_false');
    $template_list_labels['enableddisabled'][]=l10n('AStat_enableddisabled_invert');

    $template_datas["L_STAT_TITLE"]=l10n('AStat_config_title');

    $template->assign("datas", $template_datas);
    $template->assign("AStat_periods_list_values", $template_list_values['periods']);
    $template->assign("AStat_periods_list_labels", $template_list_labels['periods']);
    $template->assign("AStat_defaultsortip_list_values", $template_list_values['sortip']);
    $template->assign("AStat_defaultsortip_list_labels", $template_list_labels['sortip']);
    $template->assign("AStat_defaultsortcat_list_values", $template_list_values['sortcat']);
    $template->assign("AStat_defaultsortcat_list_labels", $template_list_labels['sortcat']);
    $template->assign("AStat_defaultsortimg_list_values", $template_list_values['sortimg']);
    $template->assign("AStat_defaultsortimg_list_labels", $template_list_labels['sortimg']);
    $template->assign("AStat_yesno_list_values", $template_list_values['yesno']);
    $template->assign("AStat_yesno_list_labels", $template_list_labels['yesno']);
    $template->assign("AStat_enableddisabled_list_values", $template_list_values['enableddisabled']);
    $template->assign("AStat_enableddisabled_list_labels", $template_list_labels['enableddisabled']);

    $template->assign_var_from_handle('ASTAT_BODY_PAGE', 'body_page');
  } // display_config



  /*
    display tools page
  */
  private function display_tools()
  {
    global $template, $page;

    $action_result=array('result' => '', 'action' => '', 'msg' => '', 'nfo' => '');

    $template->set_filename('body_page', dirname(__FILE__).'/admin/astat_tools.tpl');

    $template_datas=array();

    // >> PURGE HISTORY --------------------------------------------------------
    if(isset($_POST['apply_tool_purge_history']))
    {
      if (true) // if(!is_adviser())
      {
        $action_result['action']='AStat_tools_purge_history';
        $action_result['result']='false';
        $action_result['msg']='AStat_tools_result_ko';

        $ok_to_purge=true;
        if($_REQUEST['fAStat_purge_history_type']=='bydate')
        {
          // may be this functionnality could be optimized with pcre functions
          $date=explode('/', $_REQUEST['fAStat_purge_history_date']);
          if(!isset($date[0])) { $date[0]=0; }
          if(!isset($date[1])) { $date[1]=0; }
          if(!isset($date[2])) { $date[2]=0; }

          $purge_date=mktime(0,0,0,$date[1],$date[0],$date[2]);
          $fparam=date("Y-m-d", mktime(0,0,0,$date[1],$date[0],$date[2]));

          if(date("d/m/Y", $purge_date)!=$_REQUEST['fAStat_purge_history_date'])
          {
            $action_result['nfo']='AStat_tools_invalid_date';
            $ok_to_purge=false;
          }
          elseif(date("Ymd", $purge_date)>=date("Ymd"))
          {
            $action_result['nfo']='AStat_tools_invalid_date2';
            $ok_to_purge=false;
          }
        }
        elseif($_REQUEST['fAStat_purge_history_type']=='byipid0')
        {
          $fparam=$this->config['AStat_BlackListedIP'];
        }
        else
        {
          $fparam="";
        }

        if($ok_to_purge)
        {
          $result=$this->do_purge_history( $fparam, $_REQUEST['fAStat_purge_history_type']);
          if($result)
          {
            $action_result['result']='true';
            $action_result['msg']='AStat_tools_result_ok';
          }
        }
      }
      else
      {
        array_push($page['errors'], l10n('AStat_adviser_not_authorized'));
      }
    }
    // << PURGE HISTORY --------------------------------------------------------

    // >> DELETED_PICTURE ------------------------------------------------------
    elseif(isset($_POST['apply_tool_deleted_picture_resync']))
    {
      if (true) // if(!is_adviser())
      {
        $action_result['action']='AStat_tools_deleted_picture';
        $action_result['result']='false';
        $action_result['msg']='AStat_tools_result_ko';

        if($_POST['fAStat_tools_deleted_picture_action']=='prepare')
        {
          if($this->prepare_AStat_picture_table())
          {
            $action_result['result']='true';
            $action_result['msg']='AStat_tools_result_ok';
            $action_result['nfo']='AStat_tools_deleted_picture_ok0';
          }
          else
          {
            $action_result['nfo']='AStat_tools_deleted_picture_error0';
          }
        }
        elseif($_POST['fAStat_tools_deleted_picture_action']=='apply')
        {
          if($this->apply_AStat_picture_table())
          {
            $action_result['result']='true';
            $action_result['msg']='AStat_tools_result_ok';
            $action_result['nfo']='AStat_tools_deleted_picture_ok1';
          }
          else
          {
            $action_result['nfo']='AStat_tools_deleted_picture_error1';
          }
        }
      }
      else
      {
        array_push($page['errors'], l10n('AStat_adviser_not_authorized'));
      }
    }
    //
    elseif(isset($_POST['apply_tool_deleted_picture']))
    {
      if (true) // if(!is_adviser())
      {
        $action_result['action']='AStat_tools_deleted_picture';
        $action_result['result']='false';
        $action_result['msg']='AStat_tools_result_ko';

        $nfo = $this->tools_deleted_picture('to0');
        if($nfo[0]==1)
        {
          $action_result['result']='true';
          $action_result['msg']='AStat_tools_result_ok';
        }
      }
      else
      {
        array_push($page['errors'], l10n('AStat_adviser_not_authorized'));
      }
    }
    // << DELETED_PICTURE ------------------------------------------------------

    // >> DELETED_CATEGORY -----------------------------------------------------
    elseif(isset($_POST['apply_tool_deleted_category']))
    {
      if (true) // if(!is_adviser())
      {
        $action_result['action']='AStat_tools_deleted_category';
        $action_result['result']='false';
        $action_result['msg']='AStat_tools_result_ko';

        $nfo = $this->tools_deleted_category('to0');
        if($nfo[0]==1)
        {
          $action_result['result']='true';
          $action_result['msg']='AStat_tools_result_ok';
        }
      }
      else
      {
        array_push($page['errors'], l10n('AStat_adviser_not_authorized'));
      }
    }
    // << DELETED_CATEGORY -----------------------------------------------------

    // >> DELETED USER ---------------------------------------------------------
    elseif(isset($_POST['apply_tool_deleted_user']))
    {
      if (true) // if(!is_adviser())
      {
        $action_result['action']='AStat_tools_deleted_user';
        $action_result['result']='false';
        $action_result['msg']='AStat_tools_result_ko';

        $nfo = $this->tools_deleted_user('resynchro');
        if($nfo[0]==1)
        {
          $action_result['result']='true';
          $action_result['msg']='AStat_tools_result_ok';
        }
      }
      else
      {
        array_push($page['errors'], l10n('AStat_adviser_not_authorized'));
      }
    }
    // << DELETED USER ---------------------------------------------------------


    // >> DISPLAY DELETED_PICTURE NFO ------------------------------------------
    $table_exists=$this->verify_AStat_picture_table_status();
    if($table_exists==true)
    {
      $template_datas["ASTAT_DELETED_PICTURE_DO_ACTION"] = "checked";
      $template_datas["ASTAT_DELETED_PICTURE_PREPARE"] = "disabled";
    }
    else
    {
      $template_datas["ASTAT_DELETED_PICTURE_PREPARE"]="checked";
      $template_datas["ASTAT_DELETED_PICTURE_DO_ACTION"]="disabled";
    }

    $nfo=$this->count_AStat_picture_table();
    $template_datas["ASTAT_DELETED_PICTURE_NFO_NB"] = sprintf(l10n('AStat_tools_deleted_picture_nfo_nb'), $nfo[1], $nfo[2]);

    $nfo = $this->tools_deleted_picture('analyse');
    if($nfo[0]>0)
    {
      $list='';
      for($i=0;$i<count($nfo[2]);$i++)
      {
        if($nfo[2][$i][0]>1) { $s='s'; } else { $s=''; }
        $list.="<li>image_id #".$nfo[2][$i][1]." : ".$nfo[2][$i][0]." ".l10n("AStat_event$s")."</li>";
      }
      $template_datas["ASTAT_DELETED_PICTURE_NFO"] = sprintf(l10n('AStat_tools_deleted_picture_nfo1'), $nfo[0], $nfo[1], $list);
      //function not yet implemented
      $template_datas['AStat_deleted_picture_submit0'] = 'yes';
    }
    else
    {
      $template_datas["ASTAT_DELETED_PICTURE_NFO"] = l10n('AStat_tools_deleted_picture_nfo2');
    }
    // << DISPLAY DELETED_PICTURE NFO ------------------------------------------

    // >> DISPLAY DELETED_CATEGORY NFO -----------------------------------------
    $nfo = $this->tools_deleted_category('analyse');
    if($nfo[0]>0)
    {
      $list='';
      for($i=0;$i<count($nfo[2]);$i++)
      {
        if($nfo[2][$i][0]>1) { $s='s'; } else { $s=''; }
        $list.="<li>category_id #".$nfo[2][$i][1]." : ".$nfo[2][$i][0]." ".l10n("AStat_event$s")."</li>";
      }
      $template_datas["ASTAT_DELETED_CATEGORY_NFO"] = sprintf(l10n('AStat_tools_deleted_category_nfo1'), $nfo[0], $nfo[1], $list);
      //function not yet implemented
      $template_datas['AStat_deleted_category_submit0'] = 'yes';
    }
    else
    {
      $template_datas["ASTAT_DELETED_CATEGORY_NFO"] = l10n('AStat_tools_deleted_category_nfo2');
    }
    // << DISPLAY DELETED_CATEGORY NFO -----------------------------------------

    // >> DISPLAY DELETED USER NFO ---------------------------------------------
    $nfo = $this->tools_deleted_user('analyse');
    if($nfo[0]>0)
    {
      $list='';
      for($i=0;$i<count($nfo[2]);$i++)
      {
        if($nfo[2][$i][0]>1) { $s='s'; } else { $s=''; }
        $list.="<li>user_id #".$nfo[2][$i][1]." : ".$nfo[2][$i][0]." ".l10n("AStat_event$s")."</li>";
      }
      $template_datas["ASTAT_DELETED_USER_NFO"] = sprintf(l10n('AStat_tools_deleted_user_nfo1'), $nfo[0], $nfo[1], $list);
      $template_datas['AStat_deleted_user_submit'] = 'yes';
    }
    else
    {
      $template_datas["ASTAT_DELETED_USER_NFO"] = l10n('AStat_tools_deleted_user_nfo2');
    }
    // << DISPLAY DELETED USER NFO ---------------------------------------------


    // >> DISPLAY GENERAL NFO --------------------------------------------------
    $nfo = $this->tools_general_nfo();
    if($nfo[0]>0)
    {
      $template_datas["ASTAT_GENERAL_NFO"] = sprintf(l10n('AStat_tools_general_nfo_nfo'),
              $nfo[0],
              $this->formatoctet($nfo[3]+$nfo[4], "A", " ", 2, true),
              $this->formatoctet($nfo[3], "A", " ", 2, true),
              $this->formatoctet($nfo[4], "A", " ", 2, true),
              date(l10n('AStat_date_time_format'), strtotime($nfo[2])),
              date(l10n('AStat_date_time_format'), strtotime($nfo[1])) );
      $template_datas["ASTAT_MINDATE"]=date("m/d/Y",strtotime($nfo[2]));
    }

    $nfo=$this->purge_history_count_imageid0();
    $template_datas["ASTAT_PURGE_HISTORY_IMAGE_NFO"] = sprintf(l10n('AStat_tools_purge_history_imageid0'), $nfo);
    if($nfo==0)
    {
      $template_datas["ASTAT_PURGE_HISTORY_IMAGE_DISABLED"] = " disabled ";
    }
    else
    {
      $template_datas["ASTAT_PURGE_HISTORY_IMAGE_DISABLED"] = '';
    }
    $nfo=$this->purge_history_count_categoryid0();
    $template_datas["ASTAT_PURGE_HISTORY_CATEGORY_NFO"] = sprintf(l10n('AStat_tools_purge_history_categoryid0'), $nfo);
    if($nfo==0)
    {
      $template_datas["ASTAT_PURGE_HISTORY_CATEGORY_DISABLED"] = " disabled ";
    }
    else
    {
      $template_datas["ASTAT_PURGE_HISTORY_CATEGORY_DISABLED"] = '';
    }
    $nfo=$this->purge_history_count_ipid0();
    $template_datas["ASTAT_PURGE_HISTORY_IP_NFO"] = sprintf(l10n('AStat_tools_purge_history_ipid0'), $nfo[1], $nfo[0]);
    if($nfo[0]==0)
    {
      $template_datas["ASTAT_PURGE_HISTORY_IP_DISABLED"] = " disabled ";
    }
    else
    {
      $template_datas["ASTAT_PURGE_HISTORY_IP_DISABLED"] = '';
    }
    // << GENERAL NFO ----------------------------------------------------------


    if($action_result['result']!='')
    {
      if($action_result['result']=='true')
      {
        $value="<p class='infos'>";
      }
      else
      {
        $value="<p class='errors'>";
      }
      $value.="<i>".l10n($action_result['action'])."</i><br>".l10n($action_result['msg'])."<br>";

      if($action_result['nfo']!='')
      {
        $value.="[".l10n($action_result['nfo'])."]</p>";
      }

      $template_datas["ASTAT_RESULT_OK"] = $value;
    }

    $template_datas["L_STAT_TITLE"] = l10n('AStat_tools_title');

    $template->assign('datas', $template_datas);
    $template->assign_var_from_handle('ASTAT_BODY_PAGE', 'body_page');
  } // display_tools


  /*
    tools functions
  */



  /*
    tools : deleted_user
    allow to force HISTORY_TABLE.user_id at  2 (guest) for records with user ident
    doesn't exist anymore in the USERS_TABLE

    Two usages :
      - analyse : return infos about records wich need to be updated
          * number of users
          * number of records in HISTORY_TABLE
          * the users list
      - resynchro : update table
  */
  private function tools_deleted_user($mode)
  {
    $returned = array(-1,0,'');

    if($mode=='analyse')
    {
      $sql="SELECT count(id) as NbRecord, user_id ";
      $sql.=" FROM ".HISTORY_TABLE;
      $sql.=" WHERE ".HISTORY_TABLE.".user_id NOT IN (SELECT id FROM ".USERS_TABLE.") ";
      $sql.=" GROUP BY user_id ORDER BY NbRecord";
      $result=pwg_query($sql);
      if($result)
      {
        $returned[0]=0;
        $returned[1]=0;
        $returned[2]=[];
        while ($row = pwg_db_fetch_row($result))
        {
          $returned[2][$returned[0]][0] = $row[0];
          $returned[2][$returned[0]][1] = $row[1];
          $returned[0]++;
          $returned[1]+=$row[0];
        }

      }
    }
    elseif($mode=='resynchro')
    {
      $sql="UPDATE ".HISTORY_TABLE." SET user_id = 2 ";
      $sql.=" WHERE ".HISTORY_TABLE.".user_id NOT IN (SELECT id FROM ".USERS_TABLE.") ";
      $result=pwg_query($sql);
      if($result)
      { $returned[0]=1; }
    }
    return($returned);
  }


  /*
    tools : deleted_picture
    analyse history to find deleted pictures
    Two functions :
      - analyse : return infos
          * number of pictures
          * number of record in HISTORY_TABLE
          * pictures list
      - to0 : update picture ident to  0
  */
  private function tools_deleted_picture($mode)
  {
    $returned = array(-1,0,'');

    if($mode=='analyse')
    {
      $sql="SELECT count(id) as NbRecord, image_id ";
      $sql.=" FROM ".HISTORY_TABLE;
      $sql.=" WHERE ".HISTORY_TABLE.".image_id NOT IN (SELECT id FROM ".IMAGES_TABLE.") and image_id > 0 ";
      $sql.=" GROUP BY image_id ORDER BY NbRecord";
      $result=pwg_query($sql);

      if($result)
      {
        $returned[0]=0;
        $returned[1]=0;
        $returned[2]=[];
        while ($row = pwg_db_fetch_row($result))
        {
          $returned[2][$returned[0]][0] = $row[0];
          $returned[2][$returned[0]][1] = $row[1];
          $returned[0]++;
          $returned[1]+=$row[0];
        }

      }
    }
    elseif($mode=='to0')
    {
      $sql="UPDATE ".HISTORY_TABLE."
        SET image_id = 0
        WHERE ".HISTORY_TABLE.".image_id > 0
          AND ".HISTORY_TABLE.".image_id NOT IN (SELECT id FROM ".IMAGES_TABLE.")";
      $result=pwg_query($sql);

      if($result)
      {
        $returned[0]=1;
      }
    }
    return($returned);
  }


  /*
    tools : deleted_category
    analyse history to find deleted categories
    Two functions :
      - analyse : return infos
          * number of category
          * number of record in HISTORY_TABLE
          * catgories list
      - to0 : update categories ident to 0
  */
  private function tools_deleted_category($mode)
  {
    $returned = array(-1,0,'');

    if($mode=='analyse')
    {
      $sql="SELECT count(id) as NbRecord, category_id ";
      $sql.=" FROM ".HISTORY_TABLE;
      $sql.=" WHERE ".HISTORY_TABLE.".category_id NOT IN (SELECT id FROM ".CATEGORIES_TABLE.") and category_id > 0";
      $sql.=" GROUP BY category_id ORDER BY NbRecord";
      $result=pwg_query($sql);

      if($result)
      {
        $returned[0]=0;
        $returned[1]=0;
        $returned[2]=[];
        while ($row = pwg_db_fetch_row($result))
        {
          $returned[2][$returned[0]][0] = $row[0];
          $returned[2][$returned[0]][1] = $row[1];
          $returned[0]++;
          $returned[1]+=$row[0];
        }

      }
    }
    elseif($mode=='to0')
    {
      $sql="UPDATE ".HISTORY_TABLE."
        SET category_id = NULL, section = 'deleted_cat'
        WHERE ".HISTORY_TABLE.".category_id > 0
          AND ".HISTORY_TABLE.".category_id NOT IN (SELECT id FROM ".CATEGORIES_TABLE.")";
      $result=pwg_query($sql);

      if($result)
      {
        $returned[0]=1;
      }
    }
    return($returned);
  }


  /*
    tools : general_nfo
    return infos about historic
      0 : nulber of records
      1 : date of newest record
      2 : date of oldesr record
      3 : table size
      4 : index size
  */
  private function tools_general_nfo()
  {
    $returned = array(-1,'','',0,0);

    $sql="SELECT count(id) AS NbRecord, MAX(concat(date,' ', time)) AS LastDate, MIN(concat(date,' ', time)) AS FirstDate ";
    $sql.=" FROM ".HISTORY_TABLE;
    $result=pwg_query($sql);
    if($result)
    {
      $row = pwg_db_fetch_row($result);
      if(is_array($row))
      {
        $returned = $row;
        $sql="SHOW TABLE STATUS LIKE '".HISTORY_TABLE."';";
        $result=pwg_query($sql);
        if($result)
        {
          $row2=pwg_db_fetch_assoc($result);
          array_push($returned, $row2['Data_length'], $row2['Index_length']);
        }
      }
    }
    return($returned);
  }


  /*
    tools : do_purge_history
    do a purge of history table :
    - $purgetype='bydate' : purge all record wich date is less than given date
    - $purgetype='byimageid0' : with and image_id = 0
  ------------------------------------------------------------------------------------ */
  private function do_purge_history($param, $purgetype)
  {
    if($purgetype=='bydate')
    {
      $sql="DELETE FROM ".HISTORY_TABLE." WHERE date < '$param'";
    }
    elseif($purgetype=='byimageid0')
    {
      $sql="DELETE FROM ".HISTORY_TABLE." WHERE image_id = 0";
    }
    elseif($purgetype=='bycategoryid0')
    {
      $sql="DELETE FROM ".HISTORY_TABLE." WHERE category_id is null and section='deleted_cat'";
    }
    elseif($purgetype=='byipid0')
    {
      $sql="DELETE FROM ".HISTORY_TABLE." WHERE ".$this->make_IP_where_clause($param);
    }
    else
    {
      return(false);
    }

    $result=pwg_query($sql);
    if($result)
    {
      $sql="OPTIMIZE TABLE ".HISTORY_TABLE;
      $result=pwg_query($sql);
      return($result);
    }
    return(false);
  }

  private function purge_history_count_imageid0()
  {
    $sql="SELECT COUNT(id) FROM ".HISTORY_TABLE." WHERE image_id = 0";
    $result=pwg_query($sql);
    if($result)
    {
      $row=pwg_db_fetch_row($result);
      return($row[0]);
    }
    return(0);
  }

  private function purge_history_count_categoryid0()
  {
    $sql="SELECT COUNT(id) FROM ".HISTORY_TABLE." WHERE category_id is null and section = 'deleted_cat'" ;
    $result=pwg_query($sql);
    if($result)
    {
      $row=pwg_db_fetch_row($result);
      return($row[0]);
    }
    return(0);
  }

  private function purge_history_count_ipid0()
  {
    if($this->config['AStat_BlackListedIP']!="")
    {
      $list=explode(',', $this->config['AStat_BlackListedIP']);
    }
    else
    {
      $list=array();
    }

    $returned=array(0,count($list));

    if($this->config['AStat_BlackListedIP']!='')
    {
      $sql="SELECT COUNT(id)
            FROM ".HISTORY_TABLE."
            WHERE ".$this->make_IP_where_clause($this->config['AStat_BlackListedIP']);
      $result=pwg_query($sql);
      if($result)
      {
        $row=pwg_db_fetch_row($result);
        $returned[0]=$row[0];
      }
    }
    return($returned);
  }


  /*
    tools : deleted_picture
    > verify_AStat_picture_table_status :
    > prepare_AStat_picture_table :
  */
  private function verify_AStat_picture_table_status()
  {
    global $prefixeTable;

    $sql="SHOW TABLE STATUS LIKE '".$prefixeTable."AStat_picture'";
    $result=pwg_query($sql);
    if($result)
    {
      if(pwg_db_num_rows($result)==1)
      {
        return(true);
      }
    }
    return(false);
  }

  private function prepare_AStat_picture_table()
  {
    global $prefixeTable;

    $sql="CREATE TABLE ".$prefixeTable."AStat_picture (PRIMARY KEY (id), KEY ifile(file))
      SELECT id, file
      FROM ".IMAGES_TABLE;
    $result=pwg_query($sql);
    if($result)
    {
      return(true);
    }
    return(false);
  }

  private function count_AStat_picture_table()
  {
    global $prefixeTable;
    $returned=array(false,0,0);

    if($this->verify_AStat_picture_table_status())
    {
      $sql="SELECT count(DISTINCT ".$prefixeTable."AStat_picture.id), count(".HISTORY_TABLE.".id)
        FROM ".HISTORY_TABLE.", ".$prefixeTable."AStat_picture
        WHERE ".HISTORY_TABLE.".image_id = ".$prefixeTable."AStat_picture.id
        AND ".HISTORY_TABLE.".image_id NOT IN (SELECT id FROM ".IMAGES_TABLE.")
        ORDER BY ".$prefixeTable."AStat_picture.id";
      $result=pwg_query($sql);
      if($result)
      {
        if(pwg_db_num_rows($result)>0)
        {
          $row=pwg_db_fetch_row($result);
          $returned[0]=true;
          $returned[1]=$row[0];
          $returned[2]=$row[1];
        }
      }
    }
    return($returned);
  }

  private function apply_AStat_picture_table()
  {
    global $prefixeTable;
    $returned=false;

    $sql="CREATE TABLE ".$prefixeTable."AStat_picture2 (PRIMARY KEY (OldId))
      SELECT AStat_tmp.id as OldId , ".IMAGES_TABLE.".id as NewId, ".IMAGES_TABLE.".storage_category_id as NewCatId
      FROM (SELECT DISTINCT ".$prefixeTable."AStat_picture.*
        FROM ".HISTORY_TABLE.", ".$prefixeTable."AStat_picture
        WHERE ".HISTORY_TABLE.".image_id = ".$prefixeTable."AStat_picture.id
        AND ".HISTORY_TABLE.".image_id NOT IN (SELECT id FROM ".IMAGES_TABLE.")
        ORDER BY ".$prefixeTable."AStat_picture.id
      ) as AStat_tmp
      LEFT JOIN ".IMAGES_TABLE." ON AStat_tmp.file = ".IMAGES_TABLE.".file";
    $result=pwg_query($sql);
    if($result)
    {
      $sql="UPDATE ".HISTORY_TABLE.", ".$prefixeTable."AStat_picture2, ".IMAGES_TABLE."
        SET ".HISTORY_TABLE.".image_id = ".$prefixeTable."AStat_picture2.NewId,
            ".HISTORY_TABLE.".category_id = ".$prefixeTable."AStat_picture2.NewCatId
        WHERE ".$prefixeTable."AStat_picture2.OldId = ".HISTORY_TABLE.".image_id";
      $result=pwg_query($sql);
      if($result)
      {
        $returned=true;
      }
      $sql="DROP TABLE IF EXISTS ".$prefixeTable."AStat_picture2";
      $result=pwg_query($sql);
      $sql="DROP TABLE IF EXISTS ".$prefixeTable."AStat_picture";
      $result=pwg_query($sql);
    }
    return($returned);
  }




  /*
    generics functions
  */

  /*
    this function make filter list and apply template

      $selected : category_id of selected item ("" if none)
  */
  private function make_filter_list($selected="")
  {
    global $template;

    $template_datarows_values=array();
    $template_datarows_labels=array();
    $template_hiddenrows=array();


    $template_datarows_values[]="";
    $template_datarows_labels[]=l10n("AStat_nofilter");

    $sql="SELECT id, name, global_rank FROM ".CATEGORIES_TABLE." order by global_rank";
    $result = pwg_query($sql);
    if($result)
    {
      while ($row = pwg_db_fetch_assoc($result))
      {
        $text=str_repeat('&nbsp;&nbsp;', substr_count($row['global_rank'], '.'));
        $template_datarows_values[]=$row['id'];
        $template_datarows_labels[]=$text.$row['name'];
      }
    }

    $query=explode('&', $_SERVER['QUERY_STRING']);
    foreach($query as $key => $value)
    {
      $nfo=explode('=', $value);
      $template_hiddenrows[]=array(
          'VALUE' => urldecode($nfo[1]),
          'NAME' => $nfo[0]
      );
    }

    $template->assign('ASTAT_LINK', $_SERVER['SCRIPT_NAME']);
    $template->assign('f_AStat_catfilter_list_values', $template_datarows_values);
    $template->assign('f_AStat_catfilter_list_labels', $template_datarows_labels);
    $template->assign('f_AStat_catfilter_selected', $selected);
    $template->assign('f_AStat_parameters', $template_hiddenrows);
  } //make_filter_list


  /*
    this function make SELECT "WHERE" clause for filter list

      $selected : category_id of selected item ("" if none)
  */
  private function make_where_clause($catfilter)
  {
    $returned=array();
    $sql="SELECT id, ".CATEGORIES_TABLE.".global_rank
          FROM ".CATEGORIES_TABLE.",
               (SELECT global_rank FROM ".CATEGORIES_TABLE." WHERE id = '".$catfilter."') as tmp1
          WHERE ".CATEGORIES_TABLE.".global_rank LIKE CONCAT(tmp1.global_rank, '%')
          ORDER BY ".CATEGORIES_TABLE.".global_rank";
    $result = pwg_query($sql);

    if($result)
    {
      while ($row = pwg_db_fetch_row($result))
      {
        $returned[]=$row[0];
      }
    }

    return(implode(',', $returned));
  }


  /*
    format text : <a href="$link">$value</a>
  */
  private function format_link($value, $link)
  {
    return("<a href='$link'>$value</a>");
  }

  /*
    return true if IP adress is given
  */
  private function is_IP($ip)
  {  //basic test, maybe a pcre will be more appropriate...
    $tmp=explode('.', $ip);
    if(count($tmp)!=4)
    { return (false); }

    for($i=0;$i<4;$i++)
    {
      if(!is_numeric($tmp[$i])) {return (false);}
    }
    return (true);
  }

  /*
      format number $octets with unit
      $format = "A" : auto
                "O" : o
                "K" : Ko
                "M" : Mo
                "G" : Go
      $thsep = thousand separator
      $prec = number of decimal
      $unitevis = true/false > renvoi l'unitÃ© ou non dans le rÃ©sultat
  */
  private function formatoctet($octets, $format="A", $thsep=" ", $prec=2, $unitevis=true)
  {
    if($format=="A")
    {
    if($octets<1024)
    { $format="O"; }
    elseif($octets<1024000)
    { $format="K"; }
    elseif($octets<1024000000)
    { $format="M"; }
    else
    { $format="G"; }
    }
    switch($format)
    {
    case "O":
      $unite="o"; $div=1;
      break;
    case "K":
      $unite="Ko"; $div=1024;
      break;
    case "M":
      $unite="Mo"; $div=1024000;
      break;
    case "G":
      $unite="Go"; $div=1024000000;
      break;
    }

    $retour=number_format($octets/$div, $prec, '.', $thsep);
    if($unitevis)
    { $retour.=" ".$unite; }
    return($retour);
  }

  private function make_IP_where_clause($list)
  {
    $returned="";

    $tmp=explode(",", $list);
    foreach($tmp as $key=>$val)
    {
      if($returned!="") { $returned.=" OR "; }
      $returned.=" IP LIKE '".$val."' ";
    }
    if($returned!="")
    {
      $returned ="(".$returned.")";
    }
    return($returned);
  }


  /* ---------------------------------------------------------------------------
   * AJAX functions
   * ------------------------------------------------------------------------- */
  protected function ajax_listip($filter, $exclude)
  {
    $sql="SELECT IP, COUNT(id) as NbEvents FROM ".HISTORY_TABLE;

    $where=array();
    if($filter!="")
    {
      $where[]=" IP LIKE '".$filter."' ";
    }
    if($exclude!="")
    {
      $where[]=" NOT ".$this->make_IP_where_clause($exclude);
    }
    if(count($where)>0)
    {
      $sql.=" WHERE ".implode(" AND ", $where);
    }
    $sql.=" GROUP BY IP ORDER BY NbEvents desc, IP asc LIMIT 0,100";

    $list="<select multiple id='iipsellist'>";
    $result=pwg_query($sql);
    if($result)
    {
      while($row=pwg_db_fetch_assoc($result))
      {
        $list.="<option value='".$row['IP']."'>".$row['IP'].str_repeat("&nbsp;", 15-strlen($row['IP']))."&nbsp;&nbsp;&nbsp;&nbsp;(".$row['NbEvents'].")</option>";
      }
    }
    $list.="</select>";

    return($list);
  }


} // AStat_AI class


?>
