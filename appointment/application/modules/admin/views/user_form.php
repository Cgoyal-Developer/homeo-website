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
<!-- JQUERY SCRIPTS -->
<script src="<?= base_url() ?>assets/js/jquery-1.11.3.js"></script>
<!-- JQUERY UI SCRIPTS -->
<script src="<?= base_url() ?>assets/js/jquery-ui.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="<?= base_url() ?>assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="<?= base_url() ?>assets/js/custom.js"></script>
<script src="<?= base_url() ?>assets/js/chosen.jquery.min.js"></script>
<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $this->lang->line('user');?>
			</div>
			<?php 
			if(isset($user)){
				$level =set_value('level',$user['level']); 
				$user_username =set_value('username',$user['name']); 
				//$user_name =set_value('user_name',$user['username']) ;
				$user_is_active =set_value('user_is_active',1);
				$edit = TRUE;
				$centers =set_value('center',$user['centers']);
				$title =set_value('title',$contact['title']) ;
				$first_name =set_value('first_name',$contact['first_name']) ;
				$middle_name =set_value('middle_name',$contact['middle_name']);
				$last_name =set_value('last_name',$contact['last_name']);
			}else{
				$level =set_value('level',""); 
				$user_username =set_value('username',""); 
				//$user_name =set_value('user_name',"") ;
				$user_is_active =set_value('user_is_active',1);
				$edit = FALSE;
				$centers =set_value('center',"");
				$title =set_value('title',"") ;
				$first_name =set_value('first_name',"") ;
				$middle_name =set_value('middle_name',"");
				$last_name =set_value('last_name',"");
			}
			
			$admin_name="admin";
			$centers = explode(",",$centers);
			?>
			<div class="panel-body">
				<?php 
					if($edit){
						echo form_open('admin/edit_user/'. $user['userid']); 
					}else{
						echo form_open('admin/add_user'); 
					}
					
				?>
					<div class="col-md-12">
						<div class="form-group">
							<label for="level"><?php echo $this->lang->line('category');?></label>
							<select name="level" class="form-control" >  <option></option>
										<?php  foreach ($categories as $category) { ?>
											<?php  if (($this->session->userdata('category') == 'System Administrator') || ($category['category_name'] != 'System Administrator')){ ?>
												<option value="<?php echo $category['category_name'];?>" <?php if($category['category_name']== $level) {echo 'selected';}?>><?= $category['category_name']; ?></option>
											<?php } ?>
										<?php } ?>
							</select>
							<?php echo form_error('level','<div class="alert alert-danger">','</div>'); ?>
						</div>
					</div>
					
					<div class="col-md-3">
						<label for="level"><?php echo $this->lang->line('title');?></label>
						<input type="input" name="title" placeholder="Title" class="form-control" value="<?=$title;?>"/>
						<?php echo form_error('title','<div class="alert alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-3">
						<label for="level"><?php echo $this->lang->line('first_name');?></label>
						<input type="input" name="first_name" placeholder="First Name" class="form-control" value="<?=$first_name;?>"/>
						<?php echo form_error('first_name','<div class="alert alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-3">
						<label for="level"><?php echo $this->lang->line('middle_name');?></label>
						<input type="input" name="middle_name" placeholder="Middle Name" class="form-control" value="<?=$middle_name;?>"/>						
						<?php echo form_error('middle_name','<div class="alert alert-danger">','</div>'); ?>
					</div>
					<div class="col-md-3">
						<label for="level"><?php echo $this->lang->line('last_name');?></label>
						<input type="input" name="last_name" placeholder="Last Name" class="form-control" value="<?=$last_name;?>"/>
						<?php echo form_error('last_name','<div class="alert alert-danger">','</div>'); ?>
					</div>
					
					<div class="col-md-12">
						<div class="form-group">					
							<label for="username"><?php echo $this->lang->line('username');?></label> 
							<input type="text" name="username" id="username" value="<?php echo $user_username; ?>" class="form-control"/>
							<?php echo form_error('username','<div class="alert alert-danger">','</div>'); ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">						
							<label for="password"><?php echo $this->lang->line('password');?></label> 
							<input type="password" name="password" id="password" value="" class="form-control"  />
							<?php echo form_error('password','<div class="alert alert-danger">','</div>'); ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">						
							<label for="passconf"><?php echo $this->lang->line('confirm_password');?></label> 
							<input type="password" name="passconf" id="passconf" value="" class="form-control" />
							<?php echo form_error('passconf','<div class="alert alert-danger">','</div>'); ?>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">		
							<div class="col-md-2">
								<label for="is_active"><?php echo $this->lang->line('is_active');?></label> 
							</div>
							<div class="col-md-2">
								<input type="checkbox" name="is_active" id="is_active" value="1" <?php if($user_is_active) echo "checked"; ?> class="form-control"/>
							</div>
							<div class="col-md-8">
								&nbsp;
							</div>
							<div class="col-md-12">
								<?php echo form_error('is_active','<div class="alert alert-danger">','</div>'); ?>
							</div>
						</div>
					</div>
					<div class="col-md-12">
					<div class="form-group">
						<label for="prefered_language"><?php echo $this->lang->line('prefered_language');?></label>
						<select name="prefered_language" class="form-control" >
							<?php foreach ($languages as $key=>$language) { ?>
							<option value="<?php echo $key; ?>" <?php if($user['prefered_language'] == $key) { ?>selected="selected"<?php } ?>><?php echo $key; ?></option>
							<?php }?>
						</select>
					</div>
					</div>
					<?php if (in_array("centers", $active_modules)) { ?>
					<div class="col-md-12">
						<label for="center"><?=$this->lang->line('center');?></label>
						<select id="center" class="form-control" multiple="multiple" tabindex="4" name="center[]">
							<?php foreach ($clinics as $clinic) { ?>
								<?php $selected = ""; ?>
								<?php if (in_array($clinic['clinic_id'], $centers)){ ?>
									<?php $selected = "selected"; ?>
								<?php } ?>
								<option value="<?=$clinic['clinic_id'];?>" <?=$selected;?> ><?= $clinic['clinic_name']; ?></option>
							<?php } ?>
						</select>
						<script>jQuery('#center').chosen();</script>
					</div>
					<?php } ?>
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" name="submit" class="btn btn-primary square-btn-adjust" /><?php echo $this->lang->line('save');?></button>
						</div>
					</div>
			<?php echo form_close(); ?>
			</div>
			</div>
		</div>
	</div>
</div>
