<?php
// +-----------------------------------------------------------------------+
// | Piwigo - a PHP based photo gallery                                    |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2008-2012 Piwigo Team                  http://piwigo.org |
// | Copyright(C) 2003-2008 PhpWebGallery Team    http://phpwebgallery.net |
// | Copyright(C) 2002-2003 Pierrick LE GALL   http://le-gall.net/pierrick |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+
$lang['AStat_tools_deleted_category_nfo0'] = 'Tildeler slettet album til begivenheder i historikken, som ikke længere findes';
$lang['AStat_tools_deleted_picture_nfo3'] = 'Når billeder fysisk flyttes fra en mappe, sletter synkroniseringen billeder fra databasen og genindsætter dem med en ny reference.  Et flyttet billede efterlades dermed i begivenhedshistorikken med en ikke længere eksisterende reference.</p><p><i>AStat</i> kan:<ul><li>huske billedreferencer fra <u><i>før</i></u> synkroniseringen</li><li>linke begivenhedshistorik med nøjagtige billedreferencer <u><i>efter</i></u> en synkronisering</li></p><p><b>Advarsel!</b><br><ul><li>hvis billeder har det samme navn, kan der opstå uforudsigelige resultater</li><li>funktionen kan ikke håndtere billeder, hvis navn er ændret på serveren</li></ul>';
$lang['AStat_tools_deleted_category_nfo1'] = '%s ikke-eksisterende mappe er anført blandt begivenheder i historikken og påvirker %s begivenheder: <ul>%s</ul>';
$lang['AStat_tools_deleted_picture_error0'] = 'Klargøringen mislykkedes';
$lang['AStat_tools_deleted_picture_ok0'] = 'Klargøringen af tabellen er udført, filer kan reorganiseres på serveren';
$lang['AStat_adviser_not_authorized'] = 'Handling afbrudt: denne form for handling tillades ikke.';
$lang['AStat_tools_deleted_picture_nfo0'] = 'Påvirker begivenheder i historikken, som refererer til billeder, der ikke længere findes, et <i>billede [id #0] findes ikke længere i databasen</i>';
$lang['AStat_tools_deleted_picture_nfo1'] = '%s ukendt billedid i begivenhedshistorikken, som påvirker %s begivenheder: <ul>%s</ul>';
$lang['AStat_tools_general_nfo_nfo'] = '<ul><li>%s begivenheder findes i historikken</li>
            <li>Tabelvægte %s (Table: %s; Indeks: %s)</li>
            <li>Dato for første begivenhed: %s</li>
            <li>Date for sidste begivenhed: %s</li>';
$lang['AStat_tools_purge_history_ipid0'] = 'For at tømme begivenheder knyttet til IP-adresser fra sortlisten (%s elementer i sortlisten, %s begivenheder i historikken)';
$lang['AStat_tools_purge_history_categoryid0'] = 'For at tømme begivenheder knyttet til slettede albummer (%s begivenheder i historikken)';
$lang['AStat_tools_purge_history_date'] = 'For at tømme alle tidligere begivenheder';
$lang['AStat_tools_purge_history_imageid0'] = 'For at tømme alle begivenheder knyttet til slettede billeder (%s begivenheder i historikken)';
$lang['ratio_Pictures_seen'] = 'Viste billeder';
$lang['CATEGORY_LABEL'] = 'Album';
$lang['Categories_seen'] = 'Viste albummer';
$lang['IP_label'] = 'IP-adresse';
$lang['IP_visit'] = 'IP-adresser';
$lang['Pictures_seen'] = 'Viste billeder';
$lang['pct_Pages_seen'] = '% sider';
$lang['pct_Pictures_seen'] = '% billeder';
$lang['AStat_tools_purge_history_nfo'] = 'Funktionen tømmer historikken vedrørende alle forudgående begivenheder fra en given dato, og vil optimere tabellen.<br><b>Handlingen kan ikke fortrydes</b>.';
$lang['AStat_tools_result_ko'] = 'Der opstod en fejl. Handlingen blev ikke udført korrekt';
$lang['AStat_tools_result_ok'] = 'Handling udført korrekt';
$lang['AStat_tools_title'] = 'Vedligeholdelsesværktøjer';
$lang['AStat_version'] = 'version';
$lang['AStat_yesno_false'] = 'No';
$lang['AStat_yesno_true'] = 'Ja';
$lang['AStat_tools_deleted_picture_prepare_action'] = '<u>Før</u> synkronisering: forbered <i>AStat</i>';
$lang['AStat_tools_deleted_user'] = 'Opdater historik med brugers referencer';
$lang['AStat_tools_deleted_user_apply'] = 'Opdater';
$lang['AStat_tools_deleted_user_nfo0'] = 'Funktionen tvinger en brugerid, som siden er blevet slettet, til at blive <i>gæst</i>, hvis den er genereret som en begivenhed i historikken';
$lang['AStat_tools_deleted_user_nfo1'] = '%s ukendt brugerid i blandt historikbegivenheder, påvirker %s begivenheder: <ul>%s</ul>';
$lang['AStat_tools_deleted_user_nfo2'] = 'Alle brugerid\'er i begivenhedens historik findes. Ingen handlinger udføres.';
$lang['AStat_tools_general_nfo'] = 'Generelle oplysninger om historik';
$lang['AStat_tools_invalid_date'] = 'Den angivne dato er ugyldig!';
$lang['AStat_tools_invalid_date2'] = 'Den angivne dato er senere eller lig med dags dato';
$lang['AStat_tools_purge_history'] = 'Tømning af historikken';
$lang['AStat_tools_purge_history_apply'] = 'Tøm';
$lang['AStat_Nfo_Category'] = 'For det valgte interval, repræsenterer antal procent af sider og billeder set i albummer, som gennemsnitligt antal visninger pr. billede';
$lang['AStat_Nfo_IP'] = 'For det valgte interval, repræsenterer antal sider og billeder set af en IP-adresse';
$lang['AStat_Nfo_Image'] = 'For det valgte interval, antal visninger af hvert billede, repræsenteret i procent af antal visninger af det totale antal visninger';
$lang['AStat_Nfo_Period'] = 'For det valgte interval, repræsenterer antal viste sider og billeder, som antal forskellige forbundne IP-adresser';
$lang['AStat_PeriodPerDefault'] = 'Valgt standardinterval';
$lang['AStat_sortcat_page'] = 'Repræsentation i procent af viste sider';
$lang['AStat_sortcat_picture'] = 'Repræsentation i procent af viste billeder';
$lang['AStat_tools_deleted_category_nfo2'] = 'Alle begivenhedsalbummer findes i historikken. Der udføres ingen handling.';
$lang['AStat_tools_deleted_picture_do_action'] = '<u>Efter</u> synkronisering: link igen nye billedid\'er til begivenheder i historikken';
$lang['AStat_tools_deleted_picture_error1'] = 'Ny tilknytning af begivenheder i historikken mislykkedes';
$lang['AStat_tools_deleted_picture_nfo2'] = 'Alle billedid\'er i en begivenheds historik findes. Der udføres ingen handling.';
$lang['AStat_tools_deleted_picture_ok1'] = 'Linkning af begivenhed i historikken er udført';
$lang['AStat_tools_deleted_picture_nfo_nb'] = '(%s billedid\'er kan ikke linkes til %s begivenheder i historikken)';
$lang['AStat_section_most_visited'] = ' ';
$lang['AStat_tools_deleted_category'] = 'Opdater albummer i historikken';
$lang['AStat_tools_deleted_category_apply'] = 'Opdater';
$lang['AStat_tools_deleted_picture'] = 'Opdater historikken med billedreferencer';
$lang['AStat_tools_deleted_picture_apply'] = 'Opdater';
$lang['AStat_tools_deleted_picture_do'] = 'Udfør processen';
$lang['AStat_sortimg_picture'] = 'Billedes antal visninger';
$lang['AStat_sortip_ip'] = 'Bruger / IP-adresse';
$lang['AStat_sortip_page'] = 'Antal viste sider';
$lang['AStat_sortip_picture'] = 'Antal viste billeder';
$lang['AStat_specific_category_config'] = 'Specifikke indstillinger af statistik efter albummer';
$lang['AStat_specific_image_config'] = 'Specifikke indstillinger af statistik efter billeder';
$lang['AStat_specific_ip_config'] = 'Specifikke indstillinger af statistik efter IP-adresser';
$lang['AStat_specific_period_config'] = 'Specifikke indstillinger af statistik efter intervaller';
$lang['AStat_time_request_label'] = 'Forespørgsel udført på';
$lang['AStat_title_page'] = 'Advanced Statistics';
$lang['AStat_tools'] = 'Værktøjer';
$lang['AStat_section_list'] = ' ';
$lang['AStat_section_most_commented'] = 'Plugin\'en <a href="http://phpwebgallery.net/ext/extension_view.php?eid=145">Most Commented</a>';
$lang['AStat_section_old_deleted_cat'] = 'Gammelt album kunne ikke importeres';
$lang['AStat_section_recent_cats'] = ' ';
$lang['AStat_section_recent_pics'] = ' ';
$lang['AStat_section_search'] = ' ';
$lang['AStat_section_tags'] = ' ';
$lang['AStat_section_unknown'] = 'Ukendt [%s]';
$lang['AStat_section_web_services'] = 'Plugin\'en <a href="http://phpwebgallery.net/ext/extension_view.php?eid=171">Web Services Statistics</a>';
$lang['AStat_sortcat_nbpicture'] = 'Gennemsnitligt antal visninger pr. billede';
$lang['AStat_sortimg_catname'] = 'Alfabetisk rækkefølge - Album / billednavn';
$lang['AStat_page_label'] = 'Side';
$lang['AStat_pages_label'] = 'Sider';
$lang['AStat_period_label_all'] = 'Alle år';
$lang['AStat_period_label_days'] = 'Dage';
$lang['AStat_period_label_global'] = 'Global';
$lang['AStat_period_label_hours'] = 'Timer';
$lang['AStat_period_label_months'] = 'Minutter';
$lang['AStat_period_label_years'] = 'År';
$lang['AStat_section_additional_page'] = 'Plugin\'en <a href="http://phpwebgallery.net/ext/extension_view.php?eid=153">Additional Pages</a>';
$lang['AStat_section_best_rated'] = ' ';
$lang['AStat_section_categories'] = ' ';
$lang['AStat_section_deleted_cat'] = 'Album slettet';
$lang['AStat_section_favorites'] = ' ';
$lang['AStat_section_label'] = 'Afsnit';
$lang['AStat_month_of_year_11'] = 'november';
$lang['AStat_month_of_year_12'] = 'december';
$lang['AStat_month_of_year_2'] = 'februar';
$lang['AStat_month_of_year_3'] = 'marts';
$lang['AStat_month_of_year_4'] = 'april';
$lang['AStat_month_of_year_5'] = 'maj';
$lang['AStat_month_of_year_6'] = 'juni';
$lang['AStat_month_of_year_7'] = 'juli';
$lang['AStat_month_of_year_8'] = 'august';
$lang['AStat_month_of_year_9'] = 'september';
$lang['AStat_nb_total_category'] = 'Totalt antal albummer';
$lang['AStat_nb_total_image'] = 'Totalt antal billeder';
$lang['AStat_nb_total_ip'] = 'Totalt antal IP-adresser';
$lang['AStat_nofilter'] = '--- Intet filter ---';
$lang['AStat_SeeTimeRequests'] = 'Vis hvor lang tid det tager at udføre forespørgsler';
$lang['AStat_ShowThumbCat'] = 'Vis det repræsentative albums miniaturebillede';
$lang['AStat_ShowThumbImg'] = 'Vis billedes miniaturebillede';
$lang['AStat_by_image'] = 'Pr. billede';
$lang['AStat_catfilter_list'] = 'Benyt filter på albummer';
$lang['AStat_enableddisabled_false'] = 'Filter deaktiveret';
$lang['AStat_enableddisabled_invert'] = 'Filter vendt om';
$lang['AStat_enableddisabled_true'] = 'Filter aktiveret';
$lang['AStat_event'] = 'begivenhed';
$lang['AStat_events'] = 'begivenheder';
$lang['AStat_general_config'] = 'Globale indstillinger';
$lang['AStat_gpc2_not_installed'] = 'Plugin\'en \'Grum Plugins Classes 2\' (version >= %s) er krævet for at installere AStat';
$lang['AStat_month_of_year_1'] = 'januar';
$lang['AStat_month_of_year_10'] = 'oktober';
$lang['AStat_day_of_week_1'] = 'mandag';
$lang['AStat_day_of_week_2'] = 'tirsdag';
$lang['AStat_day_of_week_3'] = 'onsdag';
$lang['AStat_day_of_week_4'] = 'torsdag';
$lang['AStat_day_of_week_5'] = 'fredag';
$lang['AStat_day_of_week_6'] = 'lørdag';
$lang['AStat_deleted_picture'] = 'Billedet findes ikke længere';
$lang['AStat_deleted_user'] = 'Slettet bruger';
$lang['AStat_do_save'] = 'Gem';
$lang['AStat_by_ip'] = 'Efter IP-adresse';
$lang['AStat_by_period'] = 'Efter interval';
$lang['AStat_config'] = 'Indstillinger';
$lang['AStat_config_colors_and_graph'] = 'Indstillinger af farve og grafik';
$lang['AStat_config_saved'] = 'Indstillinger er gemt!';
$lang['AStat_config_title'] = 'AStat-indstillinger';
$lang['AStat_confignotsaved'] = 'Der opstod en fejl, indstillingerne blev ikke gemt';
$lang['AStat_date_time_format'] = 'Y/d/m H:i:s';
$lang['AStat_day_of_week_0'] = 'søndag';
$lang['AStat_PeriodPerDefault_all'] = 'Alle år';
$lang['AStat_PeriodPerDefault_day'] = 'Aktuel dag';
$lang['AStat_PeriodPerDefault_global'] = 'Global';
$lang['AStat_PeriodPerDefault_month'] = 'Aktuel måned';
$lang['AStat_PeriodPerDefault_year'] = 'Aktuelt år';
$lang['AStat_RefIPLabel'] = 'Bruger/IP-adresse';
$lang['AStat_RefImageLabel'] = 'Album/billednavn';
$lang['AStat_SortCatLabel'] = 'Sorteret efter';
$lang['AStat_SortIPLabel'] = 'Sorteret efter';
$lang['AStat_SortImgLabel'] = 'Sorteret efter';
$lang['AStat_by_category'] = 'Efter album';
$lang['AStat_AddIP'] = 'Tilføj til sortlisten';
$lang['AStat_BarColor_Cat'] = 'Antal albummer';
$lang['AStat_BarColor_IP'] = 'Antal IP-adresser';
$lang['AStat_BarColor_Img'] = 'Antal billeder';
$lang['AStat_BarColor_Pages'] = 'Antal sider';
$lang['AStat_BlackListedIP'] = 'Sortlistet IP-adresse';
$lang['AStat_DefaultSortCat'] = 'Standardsortering';
$lang['AStat_DefaultSortIP'] = 'Standardsortering';
$lang['AStat_DefaultSortImg'] = 'Standardsortering';
$lang['AStat_DelIP'] = 'Slet fra sortlisten';
$lang['AStat_IP_blacklist'] = 'Tilføj til sortlisten';
$lang['AStat_IP_geolocalisation'] = 'Geoplacering';
$lang['AStat_MaxBarWidth'] = 'Maksimal bjælkebredde (pixels)';
$lang['AStat_MouseOverColor'] = 'Mus over række';
$lang['AStat_NbCatPerPages'] = 'Antal albummer pr. side';
$lang['AStat_NbIPPerPages'] = 'Antal IP-adresser pr. side';
$lang['AStat_NbImgPerPages'] = 'Antal billeder pr. side';
?>