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
		$session = session();
		$role = $session->get('user_role');
		$access = new Access();
		$router = service('router');
		$controller = $router->controllerName();
		$method = $router->methodName();

		if ($role == UserModel::ROLE_SUPERADMIN) return;

		if (isset($access->access[$controller])) {
			$methodAccess = $access->access[$controller];

			if (isset($access->access[$controller][$method])) {
				if (!in_array($role, $methodAccess[$method])) {
					return redirect()->to('/unauthorized');
				}
			} else {
				// allow access if controller is not defined in access list
				return;
			}
		}

		return;
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Tidak perlu
	}
}
