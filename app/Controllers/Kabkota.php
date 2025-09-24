<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Models\UserDetailModel;
use App\Models\InstitutionsModel;
use App\Models\UsersInstitutionsModel;
use App\Models\ReferenceDataModel;
use App\Models\UsersJobdescModel;
use App\Models\UsersCompetenceModel;
use App\Models\FasyankesModel;
use App\Services\NotificationService;
use CodeIgniter\HTTP\ResponseInterface;

class Kabkota extends BaseController
{

    protected $userModel;
    protected $userDetailModel;
    protected $institutions;
    protected $userInstitutions;


    public function __construct()
    {
        $this->institutions = new InstitutionsModel();
        $this->userInstitutions = new UsersInstitutionsModel;
        $this->userModel = new UserModel();
        $this->userDetailModel = new UserDetailModel();

    }

   public function index($id = null)
    {
        $userDetail = $this->userDetailModel->getUserDetail();

        if (!empty($userDetail['mobile']) && str_starts_with($userDetail['mobile'], '62')) {
            $userDetail['mobile'] = substr($userDetail['mobile'], 2);
        }
$institusi=[];
        if($userDetail['p_institusi']){
            $p_institusi = json_decode($userDetail['p_institusi'], true);

        $institusi = $this->institutions
            ->whereIn('id', $p_institusi)
            ->findAll();
        }

        $selectedId = ($id && in_array($id, $p_institusi, true)) ? $id : ($p_institusi[0] ?? null);

        $institusiDetail = $selectedId ? $this->institutions->detail($selectedId) : null;
        
        $jumlahUserInstitusi = 0;
        if ($institusiDetail) {
            $jumlahUserInstitusi = $this->userInstitutions
                ->countByInstitution($institusiDetail['id']);
        }

        return view('kabkota/index', [
            'title'      => 'Institusi',
            'userDetail' => $userDetail,
            'data'       => [
                'kabkota'         => $institusi,
                'kabkota_selected' => $selectedId,
                'kabkota_detail'   => $institusiDetail,
                'jumlah_user_institusi'=> $jumlahUserInstitusi,
            ],
        ]);
    }



   



}
