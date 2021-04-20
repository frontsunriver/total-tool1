<div class="content gusers">
    <div class="container">
        <div class="xxxrow">	                    
            <div class="xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">sms</i> <?php echo $this->lang->line('dash_gpanel_sms'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        
                        <form id="smsForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/communication/sendsms" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_phones'); ?> (*)</label>
                                        <input type="text" name="numbers" class="form-control" required>
                                        <span class="material-input"></span></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_description'); ?></label>
                                        <textarea maxlength="160" rows="5" type="text" name="description" class="form-control"></textarea>
                                        <span class="material-input"></span></div>
                                </div>
                            </div>

                            <button id="smsSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">send</i> <?php echo $this->lang->line('dash_gpanel_send'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
        

        <div class="xxxrow">
            <div class="xxxcol-lg-12 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">
                            <?php echo $this->lang->line('dash_gpanel_sms'); ?>
                            ( <?php
                            $this->db->from('sms');
                            echo $this->db->count_all_results();
                            ?> ) 
                        </h4>
                        <p class="category">---</p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="dtSMS table table-hover">
                            <thead class="text-default">
                            <th><?php echo $this->lang->line('dash_gpanel_no'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_time'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_phone'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_message'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_messageid'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_network'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_price'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_remainingbalance'); ?></th>
                            <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($this->uri->segment(4)) {
                                    $i = $this->uri->segment(4);
                                } else {
                                    $i = "";
                                }
                                foreach ($smss as $row) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>                                        
                                        <td><?php echo $row->time; ?></td>
                                        <td><?php echo $row->to; ?></td>
                                        <td><?php echo character_limiter(strip_tags($row->message), 160); ?></td>
                                        <td><?php echo $row->messageid; ?></td>                                        
                                        <td><?php echo $row->network; ?></td>
                                        <td><?php echo $row->messageprice; ?></td>
                                        <td><?php echo $row->remainingbalance; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>dashboard/communication/deletesms/<?php echo $row->smsID; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        
      
        