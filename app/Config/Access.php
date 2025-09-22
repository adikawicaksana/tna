<?php

namespace Config;

use App\Models\UserModel;

class Access
{
	public array $access = [
		'Profile' => [
			'index' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'putDetail' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'storeUserFasyankes' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'getUserInstitutions' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'deleteUserInstitutions' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'storeUserNonFasyankes' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'storeJobdescCompetence' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'listJobDescCompetence' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'updateStatusCompetence' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'deleteCompetence' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],

			'getUserFasyankes' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'deleteUserFasyankes' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'getUserNonFasyankes' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'getUserFasyankes' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
		],
		'Question' => [
			'index' => [UserModel::ROLE_ADMIN],
			'show' => [UserModel::ROLE_ADMIN],
			'create' => [UserModel::ROLE_ADMIN],
			'store' => [UserModel::ROLE_ADMIN],
			'update' => [UserModel::ROLE_ADMIN],
			'deactivate' => [UserModel::ROLE_ADMIN],
		],
		'Questionnaire' => [
			'index' => [UserModel::ROLE_ADMIN],
			'show' => [UserModel::ROLE_ADMIN],
			'create' => [UserModel::ROLE_ADMIN],
			'store' => [UserModel::ROLE_ADMIN],
			'update' => [UserModel::ROLE_ADMIN],
			'activate' => [UserModel::ROLE_ADMIN],
			'deactivate' => [UserModel::ROLE_ADMIN],
		],
		'Survey' => [
			'index' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'show' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'create' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'store' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'edit' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'update' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'approval' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
			'postApproval' => [UserModel::ROLE_ADMIN, UserModel::ROLE_USER],
		],
	];
}