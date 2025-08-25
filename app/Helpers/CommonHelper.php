<?php

namespace App\Helpers;

use App\Models\QuestionModel;

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

	public static function generateInputField($type, $name, $source = [])
	{
		$result = '';
		switch ($type) {
			case QuestionModel::TYPE_SHORT:
				$result .= "<input type='text' class='form-control field-input' name='$name'>";
				break;
			case QuestionModel::TYPE_TEXT:
				$result .= "<textarea class='form-control field-input' name='$name'></textarea>";
				break;
			case QuestionModel::TYPE_MULTIPLE_CHOICE:
				foreach ($source as $each) {
					$result .= "<div class='form-check form-check-primary'>
						<input name='$name' class='form-check-input' type='radio' value='{$each['question_id']}' />
						<label class='form-check-label'>{$each['option_name']}</label>
						<label>{$each['option_description']}</label>
					</div>";
				}
				break;
			case QuestionModel::TYPE_MULTI_SELECT:
				$result .= "<select class='select2 form-select field-select' multiple>";
				foreach ($source as $each) {
					$result .= "<option value='{$each['question_id']}'>{$each['option_name']}</option>";
				}
				$result .= "</select>";
				break;
			case QuestionModel::TYPE_DROPDOWN:
				$result .= "<select class='form-select field-select' name='$name'>";
				foreach ($source as $each) {
					$result .= "<option value='{$each['question_id']}'>{$each['option_name']}</option>";
				}
				$result .= "</select>";
				break;
		}

		return $result;
	}

	 public static function timeGreeting()
    {
        $jam = (int) date("H");

        if ($jam >= 4 && $jam < 11) {
            return 'pagi';
        } elseif ($jam >= 11 && $jam < 15) {
            return 'siang';
        } elseif ($jam >= 15 && $jam < 18) {
            return 'sore';
        } else {
            return 'malam';
        }
    }

	public static function isRouteExists(string $alias)
	{
		$routes = service('routes');
		$options = $routes->getRoutesOptions();

		foreach ($options as $route => $opts) {
			if (($opts['as'] ?? null) === $alias) {
				return true;
			}
		}

		return false;
	}
}
