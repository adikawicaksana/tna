<?= $this->extend('layout/main') ?>
<?php

use App\Helpers\CommonHelper;
use App\Models\QuestionModel;
use App\Models\SurveyModel;

?>
<?= $this->section('content'); ?>
<div class="container">
	<h1><?= $title ?></h1>
	<div class="card">
		<div class="card-header">
			<h5><?= $title ?></h5>
		</div>
		<div class="card-body">
			<table class="table table-sm table-responsive table-bordered table-hover w-100 align-top">
				<tr>
					<th width="20%">Tanggal</th>
					<td><?= CommonHelper::formatDate($data->created_at) ?></td>
				</tr>
				<tr>
					<th>Grup</th>
					<td><?= SurveyModel::listGroupType()[$data->group_type] ?></td>
				</tr>
				<tr>
					<th>Instansi</th>
					<td>
						<?= $data->fasyankes_type . ' ' . $data->fasyankes_name ?>
						<?= $data->nonfasyankes_name ?>
					</td>
				</tr>
				<tr>
					<th>Nama</th>
					<td>
						<?= $data->front_title . ' ' . $data->fullname ?><?= (!empty($data->back_title)) ? ', ' . $data->back_title : '' ?>
					</td>
				</tr>
				<tr>
					<th>Status</th>
					<td><?= SurveyModel::listStatus()[$data->survey_status] ?></td>
				</tr>
				<tr>
					<th>Histori</th>
					<td>

					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>