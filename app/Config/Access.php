<?php

namespace Config;

use App\Models\UserModel;

class Access
{
	public array $access = [
		'\App\Controllers\Profile' => [
			'index' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'putDetail' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'storeUserFasyankes' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'getUserInstitutions' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'deleteUserInstitutions' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'storeUserNonFasyankes' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'storeJobdescCompetence' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'listJobDescCompetence' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'updateStatusCompetence' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'deleteCompetence' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
		],
		'\App\Controllers\Admin\Question' => [
			'index' => [UserModel::ROLE_SUPERADMIN],
			'show' => [UserModel::ROLE_SUPERADMIN],
			'create' => [UserModel::ROLE_SUPERADMIN],
			'store' => [UserModel::ROLE_SUPERADMIN],
			'update' => [UserModel::ROLE_SUPERADMIN],
			'deactivate' => [UserModel::ROLE_SUPERADMIN],
		],
		'\App\Controllers\Admin\Questionnaire' => [
			'index' => [UserModel::ROLE_SUPERADMIN],
			'show' => [UserModel::ROLE_SUPERADMIN],
			'create' => [UserModel::ROLE_SUPERADMIN],
			'store' => [UserModel::ROLE_SUPERADMIN],
			'update' => [UserModel::ROLE_SUPERADMIN],
			'activate' => [UserModel::ROLE_SUPERADMIN],
			'deactivate' => [UserModel::ROLE_SUPERADMIN],
		],
		'\App\Controllers\Survey' => [
			'index' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'show' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'create' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'store' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'edit' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'update' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'approval' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
			'postApproval' => [UserModel::ROLE_SUPERADMIN, UserModel::ROLE_ADMIN],
		],
	];
}