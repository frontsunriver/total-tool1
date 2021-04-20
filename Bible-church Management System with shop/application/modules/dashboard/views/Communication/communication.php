<div class="content gusers">
    <div class="container">
        <div class="xxxrow">	                    
            <div class="xxxcol-md-offset-1 xxxcol-md-10">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">sms</i> Communication</h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        
                         <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                              <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                              <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="home">
                                  <form id="communicationForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/communication/send" method="post" enctype="multipart/form-data">
                            
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_phones'); ?> (*)</label>
                                                <input type="text" id="eventlocation" name="eventlocation" class="form-control" required>
                                                <span class="material-input"></span></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"><?php echo $this->lang->line('dash_gpanel_description'); ?></label>
                                                <textarea rows="5" type="text" id="eventdescription" name="eventdescription" class="form-control"></textarea>
                                                <span class="material-input"></span></div>
                                        </div>
                                    </div>

                                    <button id="communicationSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">send</i> <?php echo $this->lang->line('dash_gpanel_send'); ?></button>
                                    <div class="clearfix"></div>
                                </form>
                                  
                              </div>
                              <div role="tabpanel" class="tab-pane" id="profile">...</div>
                              <div role="tabpanel" class="tab-pane" id="messages">...</div>
                              <div role="tabpanel" class="tab-pane" id="settings">...</div>
                            </div>
  
  
                        
                        
                    </div>
                </div>
            </div>
        </div>