<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'redirectIfAuth']);
$routes->get('/login', 'Auth::login', ['filter' => 'redirectIfAuth']);
$routes->post('/login', 'Auth::loginPost');
$routes->post('/refresh-token', 'Auth::refreshWebToken');
$routes->get('/captcha', 'Captcha::generate');
$routes->get('/logout', 'Auth::logout');

$routes->get('/register', 'Register::index', ['filter' => 'redirectIfAuth']);
$routes->post('/register', 'Register::store');
$routes->post('/register/verifyOtp', 'Register::verifyOtp');
$routes->post('/register/resendOtp', 'Register::resendOtp');


$routes->group('', ['filter' => ['authweb', 'checkprofile', 'autologin']], function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index', ['as' => 'dashboard']);
    $routes->get('/profile', 'Profile::index', ['as' => 'profile']);
});


$routes->group('', ['filter' => ['authweb',  'autologin']], function ($routes) {
    $routes->post('/profile/fasyankes', 'Profile::storeUserFasyankes', ['as' => 'profile']);
	$routes->get('/profile/fasyankes/data', 'Profile::getUserFasyankes');
	$routes->post('/profile/fasyankes/delete/(:num)', 'Profile::deleteUserFasyankes/$1');

});


$routes->group('api/v1', ['filter' => 'authjwt'], function ($routes) {
	$routes->get('profile', 'Api\Profile::index');
});
$routes->post('api/v1/login', 'Api\Auth::login');
$routes->post('api/v1/logout', 'Api\Auth::logout');

$routes->post('api/fasyankes_check', 'Api\General::postFasyankesCheck');
$routes->post('api/fasyankes_search', 'Api\General::postFasyankesSearch');
$routes->post('api/institution_check', 'Api\General::postInstitutionCheck');
$routes->post('api/institution_search', 'Api\General::postInstitutionSearch');

$routes->get('api/provinsi', 'Api\Area::provinsi');
$routes->get('api/kabupaten', 'Api\Area::kabupaten');
$routes->get('api/kecamatan', 'Api\Area::kecamatan');
$routes->get('api/kelurahan', 'Api\Area::kelurahan');


$routes->post('api/v1/token/refresh', 'Api\Auth::refreshToken');

$routes->group('admin', function ($routes) {
	$routes->get('question', 'Admin\Question::index', ['as' => 'question.index']);
	$routes->get('question/create', 'Admin\Question::create', ['as' => 'question.create']);
	$routes->post('question/store', 'Admin\Question::store');
	$routes->post('question/deactivate/(:num)', 'Admin\Question::deactivate/$1', ['as' => 'question.deactivate']);
	$routes->get('question/(:any)', 'Admin\Question::show/$1', ['as' => 'question.show']);

	$routes->get('questionnaire', 'Admin\Questionnaire::index', ['as' => 'questionnaire.index']);
	$routes->get('questionnaire/create', 'Admin\Questionnaire::create', ['as' => 'questionnaire.create']);
	$routes->post('questionnaire/store', 'Admin\Questionnaire::store', ['as' => 'questionnaire.store']);
	$routes->get('questionnaire/(:any)', 'Admin\Questionnaire::show/$1');
});
