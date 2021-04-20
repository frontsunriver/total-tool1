<div class="content">
    <div class="container">
        <div class="xxxrow">	                    
            <div class="xxxcol-md-offset-1 xxxcol-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">format_align_center</i> <?php echo $this->lang->line('dash_menu_import'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        
                        <!--Speech Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_speech'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="speech" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/speech.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Events Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_event'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="event" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/event.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Prayer Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_prayer'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="prayer" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/prayer.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Notice Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_notice'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="notice" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/notice.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Funds Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_funds'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="funds" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/funds.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Donation Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_donation'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="donation" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/donation.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        
                        <!--Assets Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_assets'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="assets" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/assets.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Users Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_users'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="users" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/users.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Committee Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_committee'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="committee" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/committee.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Members Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_members'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="members" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/members.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        
                        <!--Pastor Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_pastor'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="pastors" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/pastor.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        
                        <!--Clan Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_clans'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="clans" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/clan.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        
                        <!--Chorus Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_chorus'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="chorus" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/chorus.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Staff Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_staff'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="staff" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/staff.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        <!--Sunday School Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_sschool'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="sschool" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/sschool.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        
                        <!--Seminar Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_seminar'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="seminar" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/seminar.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                        
                        <!--Seminar Applicants Import Form-->
                        <form id="addImportForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/import/import" method="post" enctype="multipart/form-data">
                            <div class="row">								
                                <div class="col-md-offset-0 col-md-4">
                                    <div class="form-group">
                                        <p class="file_import_btn"><i class="material-icons">file_upload</i> <?php echo $this->lang->line('dash_gpanel_seminarapplicants'); ?> (*)</p>													
                                        <input type="file" name="file" class="form-control">
                                        <input type="hidden" name="filetype" value="seminarapplicants" class="form-control">
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <p class="file_import_btn"><a class="colorwhite" href="<?php echo base_url()?>files/seminarapplicants.csv"><i class="material-icons">file_download</i> <?php echo $this->lang->line('dash_gpanel_downloadcsv'); ?></a></p>												
                                    </div>
                                </div>                                        
                                <div class="col-md-offset-1 col-md-3">
                                    <div class="form-group">
                                        <button id="" type="submit" class="btn btn-primary pull-right margin0"><i class="material-icons">backup</i> <?php echo $this->lang->line('dash_gpanel_importnow'); ?></button>
                                    </div>
                                </div>                                        
                            </div> 
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>