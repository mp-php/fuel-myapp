<?php

class My_Func
{

	public static function mk_gravatar_hash($email)
	{
		return md5(strtolower($email));
	}

	public static function auto_link($str, $is_blank = true)
	{
		$target = $is_blank ? ' target="_blank"' : '';
		$patterns = array("/(https?|ftp)(:\/\/[[:alnum:]\+\$\;\?\.%,!#~*\/:@&=_-]+)/i");
		$replacements = array("<a href=\"\\1\\2\"{$target}>\\1\\2</a>");
		return preg_replace($patterns, $replacements, $str);
	}

	public static function errors_to_array($errors)
	{
		$messages = array();
		foreach ($errors as $error)
		{
			$messages[] = $error->__toString();
		}
		return $messages;
	}

	public static function mk_hash($index, $min_length = 0) {

		$ascii_ranges = array(
			array(48,57),  //0 to 9
			array(65,90),  //A to Z
			array(97,122), //a to z
		);

		$asciis = array();
		foreach ($ascii_ranges as $ascii_range)
		{
			$asciis = array_merge($asciis, range($ascii_range[0], $ascii_range[1]));
		}

		$shuffles = array_keys($asciis);
		srand(0);
		shuffle($shuffles);

		$asciis_count = count($asciis);
		$i = 0;
		$hashs = array();
		do
		{
			$hashs[$i] = chr($asciis[$shuffles[(int) (floor($index / pow($asciis_count, $i)) + $i) % $asciis_count]]);
			$i = count($hashs);
		}
		while (($min_length > $i) || (pow($asciis_count, $i) <= $index));

		return implode('', $hashs);
	}

}
