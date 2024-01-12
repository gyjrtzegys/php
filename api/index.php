<?

echo "====== https://himera-search.net/report/72a23b6a-d883-4ac9-9aed-8394a2fbf17a ======== <br><br>";

sleep(1);

$main = file_get_contents('https://himera-search.net/report/72a23b6a-d883-4ac9-9aed-8394a2fbf17a');

$arr_kadry = regParse('<section class="report-card" id=', '</section>', $main);

// записи с Кадрами
for ($i=0;$i<count($arr_kadry);$i++) {
	
	$element = $arr_kadry[$i];
	$element = iconv('utf-8', 'windows-1251', $element);
	if (substr_count($element, '<h2 class="report-card__title">КАДРЫ') >0 ) {
		
		// два массива: заголовок и значение
		$arr_kadry_title = regParse('<dt>', '</dt>', $element);
		$arr_kadry_value = regParse('<dd>', '</dd>', $element);
		
			// только 3 необходимые поля
			for ($y=0;$y<count($arr_kadry_title);$y++) {
				if (substr_count($arr_kadry_title[$y], 'Имя') >0 ) $name = iconv('windows-1251', 'utf-8', $arr_kadry_value[$y]);
				if (substr_count($arr_kadry_title[$y], 'Дата рождения') >0 ) $data = iconv('windows-1251', 'utf-8', $arr_kadry_value[$y]);
				if (substr_count($arr_kadry_title[$y], 'Общая_сумма_дохода') >0 ) $dohod = iconv('windows-1251', 'utf-8', $arr_kadry_value[$y]);
			}
			
			// целое значение дохода
			$dohod_integer = str_replace(',', '.', $dohod);
			$dohod_integer = floor($dohod_integer);
			
			// год рождения
			$last_dot_pos = strrpos($data, '.');
			$god = substr($data, $last_dot_pos+1);
			
				// фильтр
				if ($dohod_integer >= 400000 && $god<=1980) {
					echo $name."<br>".$data."<br>".$dohod."<br><br>";
				}

		
	}
	
}


// Functions
function regParse($a,$b,$data) {
			if (
				preg_match_all (
				'#'.preg_quote($a).'(.+?)'.preg_quote($b).'#is', $data, $arr_result
				)
			)
			return $arr_result[1];
}



?>
