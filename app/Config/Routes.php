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
$routes->get('/logout', 'Auth::logout', ['as' => 'logout']);

$routes->get('/register', 'Register::index', ['filter' => 'redirectIfAuth']);
$routes->post('/register', 'Register::store');
$routes->post('/register/verifyOtp', 'Register::verifyOtp');
$routes->post('/register/resendOtp', 'Register::resendOtp');

$routes->get('/master-training', 'MasterTraining::index', ['as' => 'master-training.index']);

$routes->group('', ['filter' => ['authweb', 'checkprofile', 'autologin']], function ($routes) {
	// $routes->get('/dashboard', 'Dashboard::index', ['as' => 'dashboard']);
	$routes->get('dashboard', 'Survey::index', ['as' => 'dashboard']);
	$routes->get('/profile', 'Profile::index', ['as' => 'profile']);
});


$routes->group('', ['filter' => ['authweb',  'autologin', 'role']], function ($routes) {
	$routes->get('institusi', 'Institusi::index', ['as' => 'institusi.index']);
	$routes->get('institusi/(:segment)', 'Institusi::index/$1', ['as' => 'institusi.detail']);


	$routes->get('/profile/institutions/data', 'Profile::getUserInstitutions');
	$routes->post('/profile/institutions/delete/(:segment)', 'Profile::deleteUserInstitutions/$1');



	$routes->post('/profile/fasyankes', 'Profile::storeUserFasyankes');
	$routes->get('/profile/fasyankes/data', 'Profile::getUserFasyankes');
	$routes->post('/profile/fasyankes/delete/(:segment)', 'Profile::deleteUserFasyankes/$1');
	$routes->post('/profile/nonfasyankes', 'Profile::storeUserNonFasyankes');
	$routes->get('/profile/nonfasyankes/data', 'Profile::getUserNonFasyankes');
	$routes->post('/profile/nonfasyankes/delete/(:segment)', 'Profile::deleteUserNonFasyankes/$1');
	$routes->post('/profile/jobdesc-competence', 'Profile::storeJobdescCompetence');
	$routes->get('/profile/listjobdesc-competence', 'Profile::listJobDescCompetence');
	$routes->post('/profile/update-status-competence', 'Profile::updateStatusCompetence');
	$routes->post('/profile/delete-competence', 'Profile::deleteCompetence');

	$routes->post('/profile', 'Profile::putDetail', ['as' => 'profile']);

	// Master Question, Questionnaire
	$routes->group('admin', function ($routes) {
		$routes->get('question', 'Admin\Question::index', ['as' => 'question.index']);
		$routes->get('question/create', 'Admin\Question::create', ['as' => 'question.create']);
		$routes->post('question/store', 'Admin\Question::store');
		$routes->post('question/deactivate/(:any)', 'Admin\Question::deactivate/$1', ['as' => 'question.deactivate']);
		$routes->get('question/(:any)', 'Admin\Question::show/$1', ['as' => 'question.show']);

		$routes->get('questionnaire', 'Admin\Questionnaire::index', ['as' => 'questionnaire.index']);
		$routes->get('questionnaire/create', 'Admin\Questionnaire::create', ['as' => 'questionnaire.create']);
		$routes->post('questionnaire/store', 'Admin\Questionnaire::store', ['as' => 'questionnaire.store']);
		$routes->post('questionnaire/activate/(:any)', 'Admin\Questionnaire::activate/$1', ['as' => 'questionnaire.activate']);
		$routes->post('questionnaire/deactivate/(:any)', 'Admin\Questionnaire::deactivate/$1', ['as' => 'questionnaire.deactivate']);
		$routes->get('questionnaire/(:any)', 'Admin\Questionnaire::show/$1', ['as' => 'questionnaire.show']);
	});

	// Survey
	$routes->group('', ['filter' => ['checkprofile']], function ($routes) {
		$routes->get('survey', 'Survey::index', ['as' => 'survey.index']);
		$routes->get('survey/create/(:num)', 'Survey::create/$1', ['as' => 'survey.create']);
		$routes->post('survey/store', 'Survey::store', ['as' => 'survey.store']);
		$routes->get('survey/edit/(:any)', 'Survey::edit/$1', ['as' => 'survey.edit']);
		$routes->post('survey/update', 'Survey::update', ['as' => 'survey.update']);
		$routes->get('survey/approval/(:any)', 'Survey::approval/$1', ['as' => 'survey.approval']);
		$routes->post('survey/postApproval', 'Survey::postApproval', ['as' => 'survey.postApproval']);
		$routes->get('survey/(:any)', 'Survey::show/$1', ['as' => 'survey.show']);
	});
});


$routes->group('api/v1', ['filter' => 'authjwt'], function ($routes) {
	$routes->get('profile', 'Api\Profile::index');
});
$routes->post('api/v1/login', 'Api\Auth::login');
$routes->post('api/v1/logout', 'Api\Auth::logout');

$routes->get('api/institution', 'Api\General::getInstitution');
$routes->get('api/pelatihan_siakpel', 'Api\General::getPelatihanSiakpel', ['as' => 'api.pelatihan_siakpel']);


$routes->get('api/provinsi', 'Api\Area::provinsi');
$routes->get('api/kabupaten', 'Api\Area::kabupaten');
$routes->get('api/kecamatan', 'Api\Area::kecamatan');
$routes->get('api/kelurahan', 'Api\Area::kelurahan');


$routes->post('api/v1/token/refresh', 'Api\Auth::refreshToken');
