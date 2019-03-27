<?php

function checkBraces($str) {
	$brackets = [];
	$opening = ["<","(","[","{"];
	$closing = [">",")","]","}"];
	for ($i = 0; $i < strlen($str); $i++) {
	    if(in_array($str[$i], $opening)) {
	    	$brackets[] = array_search($str[$i], $opening);
	    }elseif (in_array($str[$i], $closing)) {
	    	if(!empty($brackets) && (end($brackets) == array_search($str[$i],$closing)))
		    	array_pop($brackets);
		    else
		    	return 1;
		    
	    }
	}

	return (empty($brackets)) ? 0 : 1;
	
}

echo 'checkBraces("---(++++)----") == '.checkBraces("---(++++)----")."<br/>";
echo 'checkBraces("") == '.checkBraces("")."<br/>";
echo 'checkBraces("before ( middle []) after ") == '.checkBraces("before ( middle []) after ")."<br/>";
echo 'checkBraces(") (") == '.checkBraces(") (")."<br/>";
echo 'checkBraces("} {") == '.checkBraces("} {")."<br/>";
echo 'checkBraces("<(   >)") == '.checkBraces("<(   >)")."<br/>";
echo 'checkBraces("(  [  <>  ()  ]  <>  )") == '.checkBraces("(  [  <>  ()  ]  <>  )")."<br/>";
echo 'checkBraces("   (      [)") == '.checkBraces("   (      [)")."<br/>";