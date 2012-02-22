<?php 

/*********************************************************************************/
/**
 *
 * copyright (c) 2010 Baptiste
 * http://red.bestlibre.org
 * baptiste@bestlibre.org
 *
 * Description:
 * Fonction pour l'affichage de date
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

	// fonctions utiles, $valeur représente une date au format AAAA-MM-JJ
	function getSecond($valeur) {
		return substr($valeur, 17, 2);
	}
 
	function getMinute($valeur) {
		return substr($valeur, 14, 2);
	}
 
	function getHour($valeur) {
		return substr($valeur, 11, 2);
	}
 
	function getDay($valeur)	{
		return substr($valeur, 8, 2);
	}
 
	function getMonth($valeur)	{
		return substr($valeur, 5, 2);
	}
 
	function getYear($valeur) {
		return substr($valeur, 0, 4);
	}
 
	function monthNumToName($mois) {
		$tableau = Array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aôut", "Septembre", "Octobre", "Novembre", "Décembre");
		return (intval($mois) > 0 && intval($mois) < 13) ? $tableau[intval($mois)] : "Indéfini";
	}
	
	?>