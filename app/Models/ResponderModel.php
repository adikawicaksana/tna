<?php

namespace App\Models;

use CodeIgniter\Model;

class ResponderModel extends Model
{
	protected $table = 'responder';
	protected $primaryKey = 'responder_id';
	protected $allowedFields = [
		'survey_id',
		'user_id',
		'jenjang_pendidikan',
		'jurusan_profesi',
	];

	const STAT_CANCELLED = 0;
	const STAT_ACTIVE = 1;

}
