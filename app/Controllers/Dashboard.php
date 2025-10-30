<?php

namespace App\Controllers;

use App\Models\SurveyTrainingPlanModel;
use App\Models\UserDetailModel;

class Dashboard extends BaseController
{
    protected $userDetailModel;
    public function __construct()
    {
        $this->userDetailModel = (new UserDetailModel())->getUserDetail();
    }

    public function index()
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'userDetail' => $this->userDetailModel,
        ]);
    }

    public function getCompetencyPercentage()
    {
        $builder = \Config\Database::connect();
        $builder = $builder->table('users_competence c')
            // ->select('(sum(case when c.status = 1 then 1 else 0 end) * 100 / count(*)) AS percentage')
            ->select("
                (sum(case when c.status = 1 then 1 else 0 end)) AS complete,
                (sum(case when c.status = 0 then 1 else 0 end)) AS incomplete
            ")
            ->join('users_jobdesc j', 'c._id_users_jobdesc = j.id')
            ->where('_id_users', session()->get('_id_users'))
            ->get();
        $result = $builder->getRow();

        return $this->response->setJSON([
            'percentage' => $result->complete * 100 / ($result->complete + $result->incomplete),
            'incomplete' => $result->incomplete,
        ]);
    }

    public function countIncompleteCompetence()
    {
        $stat_inactive = (int) SurveyTrainingPlanModel::STAT_INACTIVE;
        $stat_active = (int) SurveyTrainingPlanModel::STAT_ACTIVE;

        // Set query latest data
        $sql_latest = "SELECT DISTINCT ON (training_id)
                    training_id, plan_status, plan_year, plan_month
                FROM survey_training_plan
                WHERE user_id = :user_id:
                AND (
					(plan_year > EXTRACT(YEAR FROM CURRENT_DATE)) OR
					(plan_year = EXTRACT(YEAR FROM CURRENT_DATE) AND plan_month > EXTRACT(MONTH FROM CURRENT_DATE))
				)
                ORDER BY training_id,
                    CASE WHEN plan_status = {$stat_active} THEN 1
                        WHEN plan_status = {$stat_inactive} THEN 2 END,
                    created_at DESC";

        // Count submitted and approved competence
        $sql = "SELECT
                COUNT(*) FILTER (WHERE plan_status = {$stat_inactive}) AS submitted,
                COUNT(*) FILTER (WHERE plan_status = {$stat_active}) AS approved
            FROM ({$sql_latest}) AS latest_plan";
        $builder = \Config\Database::connect();
        $query = $builder->query($sql, ['user_id' => session()->get('_id_users')]);
        $result = $query->getRow();

        return $this->response->setJSON([
            'approved' => $result->approved,
            'submitted' => $result->submitted,
        ]);
    }
}
