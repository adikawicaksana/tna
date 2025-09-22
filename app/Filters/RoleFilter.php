<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Access;

class RoleFilter implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		$result = self::manualCheck();
		if (!$result) {
			return redirect()->to('/unauthorized');
		}
		return;
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Tidak perlu
	}

	public static function manualCheck(string $controller = null, string $method = null)
	{
		$session = session();
		$role = $session->get('user_role');
		$access = new Access();
		if (empty($controller) && empty($method)) {
			$router = service('router');
			$controller = basename(str_replace('\\', '/', $router->controllerName()));
			$method = $router->methodName();
		}

		if ($role == UserModel::ROLE_SUPERADMIN) return true;

		if (isset($access->access[$controller])) {
			$methodAccess = $access->access[$controller];

			if (isset($access->access[$controller][$method])) {
				if (!in_array($role, $methodAccess[$method])) {
					return false;
				}
			} else {
				// allow access if controller is not defined in access list
				return true;
			}
		}

		return true;
	}
}
