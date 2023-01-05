<?php

function url($name, $params = []){
	return \App\HttpEngine::getInstance()->url($name, $params);
}

function odmiana($int, $odmiany){
	return \App\Tools::odmiana($int, $odmiany);
}

function escapeJs($string){
	return \App\Tools::escapeJs($string);
}
