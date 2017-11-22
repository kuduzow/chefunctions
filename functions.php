<?php
/**
 * Аналог функции str_split для чеченского алфавита
 * 
 * @param string $word Текст для разбивки
 *
 * @return array Возвращает массив, содержащий разбитый текст 
 */
function che_split( $word ) {

	/** В конец этого массива буду добавлятся буквы */
	$result = array( );

	/** Список двойных букв чеченского алфавита */
	$sholha = array(
		'аь', 'оь', 'уь', 'юь',
		'яь', 'кI', 'пI', 'тI',
		'цI', 'чI', 'хI', 'хь',
		'кх', 'къ', 'Iа', 'гI' );

	/** Длина указанного в параметре слова */
	$size = mb_strlen( $word, 'UTF-8' );

	/**
	 * Цикл перебирает всё слово.
	 * При каждом обходе проверяется текущая и следующая 
	 * буквы. В случае, если текущая и следующая буквы 
	 * совпадают с одной из двойных букв массива $sholha, 
	 * то в конец $result добавляются эти две буквы, а к 
	 * шагу цикла ($i) добавляется +1, чтобы при следующем 
	 * обходе добавленная буква не учитывалась.
	 */
	for( $i = 0; $i < $size; $i++ ) {

		/**
		 * Использование che_strtolower() обусловлено тем,
		 * чтобы сравнение строк происходило без учета 
		 * регистра. Функция che_strtolower() реализована ниже.
		 */
		$double = che_strtolower( mb_substr( $word, $i, 2, 'UTF-8' ) );
		if( in_array( $double, $sholha ) ) {
			$result[] = mb_substr( $word, $i, 2, 'UTF-8' );
			$i++;
		}
		else {
			$result[] = mb_substr( $word, $i, 1, 'UTF-8' );
		}
	}

	return $result;
}

function che_strtolower( $str ) {
	$str = (string) $str;
	$size = mb_strlen( $str, "UTF-8" );

	for( $i = 0, $result = ''; $i < $size; $i++ )
	{
		$current = mb_substr( $str, $i, 1, "UTF-8" );
		if( $current != 'I' )
		{
			$result .= mb_strtolower( $current, "UTF-8" );
	  }
	  else
	  {
	  	$result .= "I";
	  }
	}

	return $result;
}

function che_strlen( $str ) {
	return count( che_split( $str ) );
}

function che_num2str( $num, $replace = false ) {
	$num = preg_replace( "|[^0-9]+|", "", $num );
	$num = preg_replace( "|^[0]+|",   "", $num );

	$nums = array(
		#0 => "нуль",
		1 => "цхьаъ",
		2 => "шиъ",
		3 => "кхоъ",
		4 => "диъ",
		5 => "пхиъ",
		6 => "ялх",
		7 => "ворхI",
		8 => "бархI",
		9 => "исс",
		10 => "итт",
		11 => "цхьайтта",
		12 => "шийтта",
		13 => "кхойтта",
		14 => "дейтта",
		15 => "пхийтта",
		16 => "ялхитта",
		17 => "вуьрхIитта",
		18 => "берхIитта",
		19 => "ткъайоьсна",
		20 => "ткъа",
		40 => "шовзткъе",
		60 => "кхузткъе",
		80 => "дезткъе",
		100 => "бIе",
		1000 => "эзар",
		1000000 => "миллион"
	);
	if( $replace === true ) {
		$nums[1] = "цхьа";
		$nums[2] = "ши";
		$nums[3] = "кхо";
		$nums[5] = "пхи";
	}

	if( array_key_exists( $num, $nums ) ) {
		return $nums[$num];
	}
	if( $num < 20 ) {
		return $nums[$num];
	}

	if( $num < 100 ) {
		$nums[20] = "ткъе";
		$twenty = $num % 20;
		return $nums[$num - $twenty] . chr( 32 ) . $nums[$twenty];
	}

	if( $num < 1000 ) {
		$hundred = $num % 100;
		return che_num2str( ( $num - $hundred ) / 100, true ) . $nums[100] . che_num2str( $hundred );
	}

	if( $num < 1000000 ) {
		$thousand = substr( $num, 0, -3 );
		$hundred  = substr( $num,    -3 );

		return che_num2str( $thousand, true ) . $nums[1000] . che_num2str( $hundred );
	}

	return false;
}

?>