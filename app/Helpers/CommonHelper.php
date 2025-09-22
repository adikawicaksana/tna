<?php

namespace App\Helpers;

use App\Filters\RoleFilter;
use App\Models\QuestionModel;
use App\Models\UserModel;

class CommonHelper
{
	public static function hasAccess(string $controller, string $method, bool $checkAdministration = false): bool
	{
		$session = session();
		$role = $session->get('user_role');
		$result = RoleFilter::manualCheck($controller, $method);

		// Check based on administration
		if ($checkAdministration) {
			$user = (new UserModel())->find(session()->get('_id_users'));
			$p_institusi = json_decode($user['p_institusi']) ?? [];
			$p_kabkota = json_decode($user['p_kabkota']) ?? [];
			$p_provinsi = json_decode($user['p_provinsi']) ?? [];
			$p_access = array_merge($p_institusi, $p_kabkota, $p_provinsi);
			if ($role == UserModel::ROLE_USER) {
				$result &= !empty($p_access);
			}
		}

		return $result;
	}

	public static function formatDate($date, $format = 1)
	{
		$return = '';
		if (empty($date) || date($date) < date('1970-01-01')) {
			return $return;
		}

		if ($format == 1) {
			$return .= date('d-m-Y', strtotime($date));
		} else if ($format == 2) {
			$return .= date('d-m-Y H:i', strtotime($date));
		}
		return $return;
	}

	public static function generateInputField($type, $name, $source = [], $value = '')
	{
		$result = '';
		switch ($type) {
			case QuestionModel::TYPE_SHORT:
				$result .= "<input type='text' class='form-control field-input' name='$name' value='$value'>";
				break;
			case QuestionModel::TYPE_TEXT:
				$result .= "<textarea class='form-control field-input' name='$name'>$value</textarea>";
				break;
			case QuestionModel::TYPE_MULTIPLE_CHOICE:
				foreach ($source as $each) {
					$checked = ($each['option_name'] == $value) ? 'checked' : '';
					$result .= "<div class='form-check form-check-primary'>
						<input name='$name' class='form-check-input' type='radio' value='{$each['option_name']}' {$checked} />
						<label class='form-check-label'>{$each['option_name']}</label><br>
						<label>{$each['option_description']}</label>
					</div>";
				}
				break;
			case QuestionModel::TYPE_MULTI_SELECT:
				$result .= "<select class='select2 form-select field-select' multiple>";
				foreach ($source as $each) {
					$checked = ($each['option_name'] == $value) ? 'checked' : '';
					$result .= "<option value='{$each['option_name']}' {$checked}>{$each['option_name']}</option>";
				}
				$result .= "</select>";
				break;
			case QuestionModel::TYPE_DROPDOWN:
				$result .= "<select class='form-select field-select' name='$name'>";
				foreach ($source as $each) {
					$checked = ($each['option_name'] == $value) ? 'checked' : '';
					$result .= "<option value='{$each['option_name']}' {$checked}>{$each['option_name']}</option>";
				}
				$result .= "</select>";
				break;
		}

		return $result;
	}

	public static function months($format = 1)
	{
		$result = [];
		if ($format == 1) {
			$result = [
				1 => 'Januari',
				2 => 'Februari',
				3 => 'Maret',
				4 => 'April',
				5 => 'Mei',
				6 => 'Juni',
				7 => 'Juli',
				8 => 'Agustus',
				9 => 'September',
				10 => 'Oktober',
				11 => 'November',
				12 => 'Desember',
			];
		} else {
			$result = [
				1 => 'Jan',
				2 => 'Feb',
				3 => 'Mar',
				4 => 'Apr',
				5 => 'Mei',
				6 => 'Jun',
				7 => 'Jul',
				8 => 'Ags',
				9 => 'Sep',
				10 => 'Okt',
				11 => 'Nov',
				12 => 'Des',
			];
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
