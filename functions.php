<?php
function che_split($word)
{
  $sholha = array(
            'аь',
            'оь',
            'уь',
            'юь',
            'яь',
            'кI',
            'пI',
            'тI',
            'цI',
            'чI',
            'хI',
            'хь',
            'кх',
            'къ',
            'Iа',
            'гI');
  $size = mb_strlen($word, 'UTF-8');
  for($i = 0; $i < $size; $i++)
  {
  	if(in_array(che_strtolower(mb_substr($word, $i, 2, 'UTF-8')), $sholha))
  	{
  		$result[] = mb_substr($word, $i, 2, 'UTF-8');
  		$i++;
  	}
  	else
  	{
  		$result[] = mb_substr($word, $i, 1, 'UTF-8');
  	}
  }
  return $result;
}

function che_strtolower($str)
{
	$str = (string)$str;
	$size = mb_strlen($str, "UTF-8");

	for($i = 0, $result = ''; $i < $size; $i++)
	{
		$current = mb_substr($str, $i, 1, "UTF-8");
		if($current != 'I')
		{
			$result .= mb_strtolower($current, "UTF-8");
	  }
	  else
	  {
	  	$result .= "I";
	  }
	}

	return $result;
}

function che_strlen($str)
{
	return count(che_split($str));
}


function che_mysql_soundex($word)
{
	$word = (string)$word;
  $size = che_strlen($word);
  $elpash = che_split($word);

      $sholha = array(
            'аь',
            'оь',
            'уь',
            'юь',
            'яь',
            'кI',
            'пI',
            'тI',
            'цI',
            'чI',
            'хI',
            'хь',
            'кх',
            'къ',
            #'Iа',
            'гI');

  for($i = 0; $i < $size; $i++)
  {
  	$temp = $elpash;
  	$temp[$i] = "_";
  	$result[] = join($temp);
  	if(mb_strlen($word, "UTF-8") >= 3)
  	{
  		$temp[$i] = "__";
  	  $result[] = join($temp);
  	}
  	unset($temp[$i]);
  	$result[] = join($temp);

  	/*for($j = 0; $j < count($sholha); $j++)
  	{
  		$temp = $elpash;
  		$temp[$i] = $sholha[$j];
  		$result[] = join($temp);
  	}*/

  }

  return $result;
}

function che_num2str($num, $replace = false)
{
	$num = preg_replace("|[^0-9]+|", "", $num);
	$num = preg_replace("|^[0]+|",   "", $num);

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
  if($replace === true)
  {
  	$nums[1] = "цхьа";
    $nums[2] = "ши";
  	$nums[3] = "кхо";
  	$nums[5] = "пхи";
  }

  if(array_key_exists($num, $nums))
  {
  	return $nums[$num];
  }
  if($num < 20)
  {
  	return $nums[$num];
  }

  if($num < 100)
  {
  	$nums[20] = "ткъе";
  	$twenty = $num % 20;
  	return $nums[$num - $twenty] ."\x20". $nums[$twenty];
  }

  if($num < 1000) #821
  {
  	$hundred = $num % 100;
    return che_num2str( ($num - $hundred) / 100, true) ." бIе " . che_num2str($hundred);
  }

  if($num < 1000000)
  {
  	$thousand = substr($num, 0, -3);
  	$hundred  = substr($num,    -3);

  	return che_num2str($thousand, true) . " эзар " . che_num2str($hundred);
  }

  return false;
}

?>