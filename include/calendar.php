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
 * Affichage d'un calendrier en php et css
 * Code initial : http://www.sutekidane.net/blog/afficher-un-calendrier-en-php-et-en-css.html
 * sous license cc-by http://creativecommons.org/licenses/by/2.0/fr/
 * Modification et publication avec la nouvelle license faite avec l'accord de l'auteur initial
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

	//pour parser un ics
require_once( 'iCalcreator.class.php' );
require_once('string_cal.php');

// Fonction pour afficher le calendrier
function showCalendar($periode,$vcal) {
  $leCalendrier = "<div class=\"cadre_calendrier\">";
  // Tableau des valeurs possibles pour un numéro de jour dans la semaine
  $tableau = Array("0", "1", "2", "3", "4", "5", "6", "0");
  $nb_jour = Date("t", mktime(0, 0, 0, getMonth($periode), 1, getYear($periode)));
  $pas = 0;
  $indexe = 1;
  
  // Affichage du mois et de l'année
  $leCalendrier .= "\n\t<h2>&raquo; " . monthNumToName(getMonth($periode)) . "</h2>";
  // Affichage des entêtes
  $leCalendrier .= "
		<ul class=\"libelle\">
			\t<li>L</li>
			\t<li>M</li>
			\t<li>M</li>
			\t<li>J</li>
			\t<li>V</li>
			\t<li>S</li>
			\t<li>D</li>
		</ul>";
  // Tant que l'on n'a pas affecté tous les jours du mois traité
  while ($pas < $nb_jour) {
    $current_date=Date("Y-m-d", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode)));
    $events_arr = $vcal->selectComponents( getYear($current_date),getMonth($current_date),getDay($current_date));
    $occupe=false;
    if(is_array($events_arr)){
      foreach( $events_arr as $year => $year_arr ) { 
	foreach( $year_arr as $month => $month_arr ) { 
	  foreach( $month_arr as $day => $day_arr ) { 
	    foreach( $day_arr as $event ) { 
	      $trsp= trim( $event->getProperty("TRANSP"));
	      if ($trsp=='OPAQUE'){
		$occupe=true;
	      }
	    }
	  }
	}
      }
      
      } 
    if ($indexe == 1) $leCalendrier .= "\n\t<ul class=\"ligne\">";
    // Si le jour calendrier == jour de la semaine en cours
    if (Date("w", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) == $tableau[$indexe]) {
      // Si jour calendrier == aujourd'hui
      $afficheJour = Date("j", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode)));
      if (Date("Y-m-d", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) == Date("Y-m-d")) {
	if ($occupe) {
	  $class = " class=\"itemCurrentItem_in\"";
	}
	else{
	  $class = " class=\"itemCurrentItem_out\"";	
	}
      }
      else {
	if ($occupe) {
	  $class = " class=\"reserve\"";
	  
	}
	else {
	  $class = "";
	}
      }
      $afficheJour = "" . Date("j", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) . "";
      // Ajout de la case avec la date
      $leCalendrier .= "\n\t\t<li$class>$afficheJour</li>";
      $pas++;
    }
    //
    else {
      // Ajout d'une case vide
      $leCalendrier .= "\n\t\t<li>&nbsp;</li>";
    }
    if ($indexe == 7 && $pas < $nb_jour) { $leCalendrier .= "\n\t</ul>"; $indexe = 1;} else {$indexe++;}
  }
  // Ajustement du tableau
  for ($i = $indexe; $i <= 7; $i++) {
    $leCalendrier .= "\n\t\t<li>&nbsp;</li>";
  }
  $leCalendrier .= "\n\t</ul>\n</div>\n";
  
  // Retour de la chaine contenant le Calendrier
  return $leCalendrier;
}
?>
