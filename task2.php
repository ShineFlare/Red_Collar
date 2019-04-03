<?php
$source_file = $argv[1];
$result_file = $argv[2];
$config_file = $argv[3];
if (file_exists($config_file) && is_readable ($config_file))
	require $config_file;
	$result_str = "";

	if (file_exists($source_file) && is_readable ($source_file)) {
	     
	    $lines = explode(";", file_get_contents($source_file));
	 
	    if (!empty($lines)) {
	        foreach ($lines as $line) {
	            if (!empty($line) && strlen($line) > 1) {
	            	if (preg_match('#INSERT INTO#', $line)) {

	            		$str_params = substr($line, 0, strpos($line, "VALUES"));
	            		preg_match('#`.*`\s?\(#', $str_params,$table);
	            		$table = str_replace(['(','`',' '], '', $table);
	            		if(!empty($conf[$table[0]])){
		            		$str_values = substr($line, strpos($line, "VALUES")+6, strlen($line));
		            		$params = explode(',',substr($str_params, stripos($str_params,"(")+1,stripos($str_params,")")-stripos($str_params,"(")-1));
		            			foreach ($params as $index => $param) {
		            				if (in_array(str_replace("`", "", trim($param)), $conf[$table[0]])) {
		            					$numField[] = $index;
		            				}
		            			}
		            		$result_str.= "INSERT INTO `".$table[0]."` (".implode(",", $params).")";
			            	$result_str.=PHP_EOL."VALUES ";
							preg_match_all("#\(.*\)#", $str_values, $values, PREG_PATTERN_ORDER);

							foreach ($values[0] as $key => $value) {
							 	$valueField = explode(',',str_replace([ '(', ')' ], '', $value));
							 	if (!empty($numField)) {
							 		foreach ($valueField as $i => $field) {
							 			if (in_array($i, $numField)) {
							 				$fields[] = "''";
							 			} else {
							 				$fields[] = $field;
							 			}
							 			 
							 		}
							 		$result_str.= "(".implode(",", $fields).")";
								} 
								if ($key < count($values[0])-1)
									$result_str.= ",".PHP_EOL;
								else $result_str.= ";".PHP_EOL;
								 	
							}
						}
		            	
	            	} else {
	            		$result_str.= $line.";".PHP_EOL;
	            	}
	            	 
	            	
	                
	            }
	        }
	        file_put_contents($result_file, $result_str);
	    }
	    else echo "Проверьте имя файла, файл не существует!";
	}
else echo "Требуется указать файл конфигурации";

