<?php

namespace App\Models;

use CodeIgniter\Model;

class RespondentDetailModel extends Model
{
	protected $table = 'respondent_detail';
	protected $primaryKey = 'detail_id';
	protected $allowedFields = [
		'detail_id',
		'survey_id',
		'competence_id',
	];
	protected $useAutoIncrement = false;

	public static function getRespondentCompetence($survey_id)
	{
		$builder = \Config\Database::connect();
		return $builder->table('respondent_detail h')
			->select('job_description, nama_pelatihan, c.status')
			->join('users_competence c', 'h.competence_id = c.id')
			->join('users_jobdesc j', 'c._id_users_jobdesc = j.id')
			->join('master_training t', 'c._id_master_training = t.id')
			->where('survey_id', $survey_id)
			->get()
			->getResultArray();
	}
}
