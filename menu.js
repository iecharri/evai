<?php
defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');
?>

$(document).ready(main);

var contador = 1;

function main (){
	$('.bt-menu').click(function(){
		// $('nav').toggle(); Forma Sencilla de aparecer y desaparecer
		
		if (contador == 1){
			$('nav').animate({
				left: '0'
			});
			contador = 0;
		} else {
			contador = 1;
			$('nav').animate({
				left: '-100%'
			});
		};
		
	});
};