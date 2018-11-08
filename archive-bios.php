<?php

use Inter\Twig as Twig;

global $post;

$context = array(	
	'bios'       => Inter\API::get_all_bios()	
);

echo Twig::render('archive-bios.twig', $context);