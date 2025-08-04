<?php

namespace App\Helpers;

class CommonHelper
{
	public static function formatDate($date, $format = 1)
	{
		$return = '';
		if ($format == 1) {
			$return .= date('d-m-Y', strtotime($date));
		}
		return $return;
	}
}
