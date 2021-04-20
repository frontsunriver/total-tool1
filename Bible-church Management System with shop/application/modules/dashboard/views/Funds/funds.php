<div class="content gusers">
    <div class="container">

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor  card-header" data-background-color="orange">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_totalcollect'); ?></p>
                        <h3 class="title"><?php
                            echo globalCurrency();
                            echo number_format($sum_collect, 2);
                            ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                                <!-- <i class="material-icons">date_range</i> Last 24 Hours -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor  card-header" data-background-color="green">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_totalspend'); ?></p>
                        <h3 class="title"><?php
                            echo globalCurrency();
                            echo number_format($sum_spend, 2);
                            ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                                <!-- <i class="material-icons">date_range</i> Last 24 Hours -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor  card-header" data-background-color="red">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="card-content">
                        <p class="category"><?php echo $this->lang->line('dash_gpanel_totalbalance'); ?></p>
                        <h3 class="title"><?php
                            echo globalCurrency();
                            echo number_format($sum_collect - $sum_spend, 2);
                            ?></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                                <!-- <i class="material-icons">local_offer</i> Tracked from Github -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="xxxrow">
            <div class="xxxcol-md-offset-0 xxxcol-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_addnewrecord'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="addFundForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/financial/addnewfunds" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_date'); ?> (*)</label>
                                        <input type="text" id="fdate" name="fdate" class="datepicker form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_amount'); ?> (*)</label>
                                        <input type="text" id="amount" name="amount" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_rtype'); ?> (*)</label>
                                        <select id="amounttype" name="amounttype" class="select form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="Collect"><?php echo $this->lang->line('dash_gpanel_collect'); ?></option>
                                            <option value="Spend"><?php echo $this->lang->line('dash_gpanel_spend'); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_verifier'); ?> (*)</label>
                                        <input type="text" id="receivedby" name="receivedby" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_rsource'); ?></label>
                                        <input type="text" id="source" name="source" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_rnote'); ?></label>
                                        <textarea type="text" rows="3" id="description" name="description" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <button id="addFundSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_add_now'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>

        </div>


        <div class="xxxrow">
            <div class="xxxcol-md-offset-0 xxxcol-md-6">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_rbmonth'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="browse_funds_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/financial/browse" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_month'); ?> (*)</label>
                                        <select id="month" name="month" class="select form-control" required>
                                            <option value="">Select Month</option>
                                            <option value="January"><?php echo $this->lang->line('dash_gpanel_jan'); ?></option>
                                            <option value="February"><?php echo $this->lang->line('dash_gpanel_feb'); ?></option>
                                            <option value="March"><?php echo $this->lang->line('dash_gpanel_mar'); ?></option>
                                            <option value="April"><?php echo $this->lang->line('dash_gpanel_apr'); ?></option>
                                            <option value="May"><?php echo $this->lang->line('dash_gpanel_may'); ?></option>
                                            <option value="June"><?php echo $this->lang->line('dash_gpanel_jun'); ?></option>
                                            <option value="July"><?php echo $this->lang->line('dash_gpanel_jul'); ?></option>
                                            <option value="August"><?php echo $this->lang->line('dash_gpanel_aug'); ?></option>
                                            <option value="September"><?php echo $this->lang->line('dash_gpanel_sep'); ?></option>
                                            <option value="October"><?php echo $this->lang->line('dash_gpanel_oct'); ?></option>
                                            <option value="November"><?php echo $this->lang->line('dash_gpanel_nov'); ?></option>
                                            <option value="December"><?php echo $this->lang->line('dash_gpanel_dec'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_year'); ?> (*)</label>
                                        <select id="year" name="year" class="select form-control" required>
                                            <option value="">Select Year</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                            <option value="2012">2012</option>
                                            <option value="2011">2011</option>
                                            <option value="2010">2010</option>
                                            <option value="2009">2009</option>
                                            <option value="2008">2008</option>
                                            <option value="2007">2007</option>
                                            <option value="2006">2006</option>
                                            <option value="2005">2005</option>
                                            <option value="2004">2004</option>
                                            <option value="2003">2003</option>
                                            <option value="2002">2002</option>
                                            <option value="2001">2001</option>
                                            <option value="2000">2000</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary pull-right"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_browse_now'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="xxxcol-md-offset-0 xxxcol-md-6">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_rbyear'); ?></h4>
                        <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                    </div>
                    <div class="card-content">
                        <form id="browse_funds_form" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/financial/browse" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label"><?php echo $this->lang->line('dash_gpanel_year'); ?> (*)</label>
                                        <select id="year" name="year" class="select form-control" required>
                                            <option value="">Select Year</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                            <option value="2012">2012</option>
                                            <option value="2011">2011</option>
                                            <option value="2010">2010</option>
                                            <option value="2009">2009</option>
                                            <option value="2008">2008</option>
                                            <option value="2007">2007</option>
                                            <option value="2006">2006</option>
                                            <option value="2005">2005</option>
                                            <option value="2004">2004</option>
                                            <option value="2003">2003</option>
                                            <option value="2002">2002</option>
                                            <option value="2001">2001</option>
                                            <option value="2000">2000</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary pull-right"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_browse_now'); ?></button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($funds) { ?>
            <div class="xxxrow">
                <div class="xxxcol-lg-12 xxxcol-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_rrecords'); ?> ( <?php
                                $this->db->from('funds');
                                $this->db->limit(10);
                                echo $this->db->count_all_results();
                                ?> )</h4>
                            <p class="category"><?php echo $this->lang->line('dash_gpanel_newrecord'); ?> <?php echo getCreateDate('fundsid','funds'); ?></p>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="dtFunds table table-hover">
                                <thead>
                                <th><?php echo $this->lang->line('dash_gpanel_sl'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_date'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_note'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_rsource'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_rtype'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_amount'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_verifier'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_action'); ?></th>
                                </thead>
                                <tbody>

                                    <?php
                                    if ($this->uri->segment(4)) {
                                        $i = $this->uri->segment(4);
                                    } else {
                                        $i = "";
                                    }
                                    foreach ($funds as $row) {
                                        $i++;
                                        ?>

                                        <tr <?php
                                        if ($row->fundstype == "Spend") {
                                            echo "style='    background: #fffacc; color: #424242;' title='Expense'";
                                        }
                                        ?>>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->fundsdate; ?></td>
                                            <td><?php
                                                $fundsnote = $row->fundsnote;
                                                echo word_limiter($fundsnote, 3);
                                                ?></td>
                                            <td><?php echo $row->fundssource; ?></td>
                                            <td><?php echo $row->fundstype; ?></td>
                                            <td><?php
                                                echo globalCurrency();
                                                echo number_format($row->fundsamount, 2);
                                                ?></td>
                                            <td><?php echo $row->receivedby; ?></td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>dashboard/financial/edit/<?php echo $row->fundsid; ?>" class="btn btn-warning"><i class="material-icons">add</i> <?php echo $this->lang->line('dash_gpanel_edit'); ?></a>
                                                <a href="<?php echo base_url(); ?>dashboard/financial/delete/<?php echo $row->fundsid; ?>" class="btn btn-danger delete"><i class="material-icons">clear</i> <?php echo $this->lang->line('dash_gpanel_delete'); ?></a>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                    <tr>

                                        <td><b></b></td>
                                        <td><b></b></td>
                                        <td><b></b></td>
                                        <td><b></b></td>
                                        <!-- <td><b></b></td> -->
                                        <!-- <td><b></b></td> -->
                                        <!-- <td><b></b></td> -->
                                        <td><b><?php echo $this->lang->line('dash_gpanel_collect'); ?></b></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_spend'); ?></b></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_balance'); ?></b></td>
                                        <td><b></b></td>

                                    </tr>

                                    <tr>

                                        <td><b></b></td>
                                        <td><b></b></td>
                                        <td><b></b></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_total'); ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($sum_collect, 2);
                                                ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($sum_spend, 2);
                                                ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($sum_collect - $sum_spend, 2);
                                                ?></b></td>
                                        <td><b></b></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
