
<?php $user_position = $this->session->userdata('user_position');?> 
<div class="content">
    <div class="container-fluid">
        <?php if($user_position == "Admin"){ ?>          
        <div class="row">
            <div class="col-md-offset-0 col-md-12">
                <div class="card card-stats">
                    <div class="gIconColor card-header card-header-icon" data-background-color="blue">
                        <i class="material-icons">timeline</i> 
                    </div>
                    <div class="card-content">
                        <h4 class="card-title"><?php echo $this->lang->line('dash_finchart'); ?>
                        </h4>
                    </div>
                    <div id="simpleBarChart" class="ct-chart"></div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="green">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_collect'); ?></p>
                        <h3 class="title"><?php echo globalCurrency(); ?><?php echo number_format($fundsCollect, 2); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> <?php echo globalCurrency(); ?><?php echo number_format($mFundsCollect, 2); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="green">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_spend'); ?></p>
                        <h3 class="title"><?php echo globalCurrency(); ?><?php echo number_format($fundsSpend, 2); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_this_month'); ?> <?php echo globalCurrency(); ?><?php echo number_format($mFundsSpend, 2); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="green">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_balance'); ?></p>
                        <h3 class="title"><?php echo globalCurrency(); ?><?php echo number_format($fundsCollect - $fundsSpend, 2); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_total_balance'); ?> <?php echo globalCurrency(); ?><?php echo number_format($fundsCollect - $fundsSpend, 2); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="green">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_donations'); ?></p>
                        <h3 class="title"><?php echo globalCurrency(); ?><?php echo number_format($totalDonation, 2); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_this_month'); ?> <?php echo globalCurrency(); ?><?php echo number_format($mDonation, 2); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="green">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_cassets'); ?></p>
                        <h3 class="title"><?php echo globalCurrency(); ?><?php echo number_format($totalAssets, 2); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_this_month'); ?> <?php echo globalCurrency(); ?><?php echo number_format($mAssets, 2); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="green">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_sfunds'); ?></p>
                        <h3 class="title"><?php echo globalCurrency(); ?><?php echo number_format(00, 2); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_this_month'); ?> <?php echo globalCurrency(); ?><?php echo number_format(00, 2); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div> 
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_user'); ?></p>
                        <h3 class="title"><?php echo $user; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $user; ?> <?php echo $this->lang->line('dash_users'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_committee'); ?></p>
                        <h3 class="title"><?php echo $committee; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $committee; ?> <?php echo $this->lang->line('dash_committee'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_pastor'); ?></p>
                        <h3 class="title"><?php echo $pastor; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $pastor; ?> <?php echo $this->lang->line('dash_pastors'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_member'); ?></p>
                        <h3 class="title"><?php echo $member; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $member; ?> <?php echo $this->lang->line('dash_members'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_clan'); ?></p>
                        <h3 class="title"><?php echo $clan; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $clan; ?> <?php echo $this->lang->line('dash_clans'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_chorus'); ?></p>
                        <h3 class="title"><?php echo $chorus; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $chorus; ?> <?php echo $this->lang->line('dash_choruses'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_staff'); ?></p>
                        <h3 class="title"><?php echo $staff; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $staff; ?> <?php echo $this->lang->line('dash_staffs'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
                        <i class="material-icons">group</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_total_student'); ?></p>
                        <h3 class="title"><?php echo $student; ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">people</i> <?php echo $this->lang->line('dash_total'); ?> <?php echo $student; ?> <?php echo $this->lang->line('dash_students'); ?>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <?php }else{ ?>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="blue">
                        <i class="material-icons">short_text</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_allposts_panel_title'); ?></p>
                        <h3 class="title"><?php $this->db->from('blog');
                            $this->db->where('author', $this->session->userdata('user_id'));
                            echo $this->db->count_all_results(); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">speaker_notes</i> <?php echo $this->lang->line('dash_allposts_panel_title'); ?> <?php $this->db->from('blog');
                            $this->db->where('author', $this->session->userdata('user_id'));
                            echo $this->db->count_all_results(); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="blue">
                        <i class="material-icons">short_text</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_menu_allorders'); ?></p>
                        <h3 class="title"><?php $this->db->from('orders');
                            $this->db->where('orderUserID', $this->session->userdata('user_id'));
                            echo $this->db->count_all_results(); ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_menu_allorders'); ?> <?php $this->db->from('orders');
                            $this->db->where('orderUserID', $this->session->userdata('user_id'));
                            echo $this->db->count_all_results(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>            
        <?php } ?>
    </div>
</div>

