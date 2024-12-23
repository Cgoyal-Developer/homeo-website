<?php
/*
	This file is part of Chikitsa.

    Chikitsa is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Chikitsa is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Chikitsa.  If not, see <https://www.gnu.org/licenses/>.
*/
?>
<html>
    <head>
        <title><?php echo $clinic['clinic_name'];?> - <?php echo $this->lang->line('sign_in'); ?></title>
		<!-- BOOTSTRAP STYLES-->
		<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />
		<!-- FONTAWESOME STYLES-->
		<link href="<?= base_url() ?>assets/css/font-awesome.min.css" rel="stylesheet" />
		<!-- chikitsa STYLES-->
		<link href="<?= base_url() ?>assets/css/chikitsa.min.css" rel="stylesheet" />
		<!-- CUSTOM STYLES-->
		<link href="<?= base_url() ?>assets/css/custom.css" rel="stylesheet" />
	</head>
	<body>
		<div class="container">
			<div class="row text-center">
				<br/><br/><br/><br/><br/>
				<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
					<h1>
					<?php if($clinic['clinic_logo'] != NULL){  ?>
						<img src="<?php echo base_url().$clinic['clinic_logo']; ?>" alt="Logo"  height="60" width="260" />
					<?php  }elseif($clinic['clinic_name'] != NULL){  ?>
						<?= $clinic['clinic_name'];?>
					<?php  } else { ?>
						<?= $software_name;?>
					<?php }  ?>
					</h1>
					<h3><?= $clinic['tag_line'];?></h3>
					<h5>( <?=$this->lang->line('login_yourself_to_get_access');?> )</h5>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
					<div class="panel panel-default">
						<div class="panel-heading">
							<strong><?=$this->lang->line('enter_details_to_login');?></strong>
						</div>
						<?php if(isset($error)) { ?><div class="alert alert-danger"><?=$error;?></div><?php } ?>
						<?php if(isset($message)) { ?><div class="alert alert-info"><?=$message;?></div><?php } ?>
						<div class="panel-body">
							
							<?php echo form_open('login/valid_signin'); ?>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag"></i></span>
								<input type="text" name="username" id="username" class="form-control" placeholder="<?=$this->lang->line('your_username');?>" />
								<?php echo form_error('username','<div class="alert alert-danger">','</div>'); ?>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								<input type="password" class="form-control" name="password" id="password" placeholder="<?=$this->lang->line('your_password');?>" />
								<?php echo form_error('password','<div class="alert alert-danger">','</div>'); ?>
							</div>

							<button type="submit" name="submit" class="btn btn-primary"><?php echo $this->lang->line('sign_in');?></button>

							<?php echo form_close(); ?>
						</div>

					</div>
					<?php if($frontend_active){?>
					<a href="<?=site_url();?>" class="btn btn-primary"><?php echo $this->lang->line('back_to'); ?><?= $clinic['clinic_name'];?></a>
					<a class="btn btn-primary" href="<?=site_url('login/forgot_password');?>"><?php echo $this->lang->line('forgot_password');?></a>

					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>
