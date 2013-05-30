<?php
/*********************************************************************************/
/**
 *
 * copyright (c) 2010 BEstLibre
 * http://github.com/bestlibre/avcalics
 * github+avcalics@bestlibre.org
 *
 *
 * Description:
 * Exemple avec commentaires pour utiliser avcalics
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, see  <http://www.gnu.org/licenses/>
 */
/*********************************************************************************/
//L'affichage se configure avec un fichier css (a inclure depuis la page appelante). Voir cal.css
  require_once('include/calendar.php');
  require_once('include/simplecache.php');//pour ne pas avoir a parser systematiquement le fichier ics. Necessite un acces en ecriture a un fichier sur le serveur
//TODO Alternative sans cache
$cache=new simplecache();
// the calendar file and dir to use
  $ics_file='disponibilites.ics';
  $ics_dir='calendar';
  $check=md5_file($ics_dir . '/' . $ics_file);
  $annee = $var;
  $key='' . $saison . $annee;
  $content = $cache->get($key,$check);
  if ($content == ''){
    $vcal=new vcalendar();
    /* start parse of local file */
    $vcal->setConfig( 'directory', 'calendar' ); // set directory
    $vcal->setConfig( 'filename', $ics_file ); // set file name
    $vcal->parse();
    $vcal->sort();

    $annee_cur=getYear(Date("Y-m-d"));
    $annee1=$annee_cur+1;
    $annee2=$annee_cur+2;
    if ($annee==''){
      $annee=$annee_cur;
    }
    $content .= "<h2>Disponibilités du chalet Les Chanterelles pour l'année ".$annee."</h2>\n";// On commence a h2, le niveau h1 est dans la page appelante (index.php)
    $content .= "<div id=\"legende\">
    <div class=\"box\"></div>
    Période réservée ";
    $content .= "<div id=\"nav\">";
    // On affiche un lien vers pour acceder à l'année courante et aux deux annees suivantes
    if ($annee==$annee_cur){
      $content .= "<a href=\"/" . $saison . "/dispo/" . $annee1 . "\">" . $annee1 . " &gt;&gt;</a>";
    }elseif($annee==$annee1){
      $content .=  "<a href=\"/" . $saison . "/dispo/" . $annee_cur . "\"> &lt;&lt; " . $annee_cur . " </a>";
      $content .=  "<a href=\"/" . $saison . "/dispo/" . $annee2 . "\">" . $annee2 . " &gt;&gt;</a>";
    }else{
      $content .=  "<a href=\"/" . $saison . "/dispo/" . $annee1 . "\"> &lt;&lt; " . $annee1 . " </a>";
    }
    $content .=  "</div>\n</div><br/>";
    $mois=Array("01","02","03","04","05","06","07","08","09","10","11","12");
    foreach($mois as $periode){
      $content .=  showCalendar($annee."-".$periode,$vcal);
    }
    $cache->put($key,$content,$check);
  }
  echo $content;
?>
