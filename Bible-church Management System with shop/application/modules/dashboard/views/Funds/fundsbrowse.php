<div class="content gusers">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="gIconColor card-header" data-background-color="orange">
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
                    <div class="gIconColor card-header" data-background-color="green">
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
                    <div class="gIconColor card-header" data-background-color="red">
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

        <div class="row">
            <div class="col-md-offset-0 col-md-6">
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
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
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


            <div class="col-md-offset-0 col-md-6">
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

        <?php if ($funds_browse) { ?>
            <div class="xxxrow">
                <div class="xxxcol-lg-12 xxxcol-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_rbmonth'); ?> ( <?php
                                $this->db->from('funds');
                                echo $this->db->count_all_results();
                                ?> )</h4>
                            <p class="category"><?php echo $this->lang->line('dash_gpanel_newrecord'); ?> <?php echo getCreateDate('fundsid','funds'); ?></p>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="dtFBMonth table table-hover">
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
                                    foreach ($funds_browse as $row) {
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
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <!-- <td></td> -->
                                        <!-- <td></td> -->
                                        <td><b></b></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_collect'); ?></b></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_spend'); ?></b></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_balance'); ?></b></td>

                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_total'); ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($browse_collect, 2);
                                                ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($browse_spend, 2);
                                                ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($browse_collect - $browse_spend, 2);
                                                ?></b></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } elseif ($funds_browse == '') {

        } else {
            ?>
            <div class="xxxrow">
                <div class="xxxcol-lg-12 xxxcol-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title">No Records Found!<?php echo $this->lang->line('dash_allfunds_panel_title'); ?> </h4>
                            <p class="category">No Records Found On Your Selected month <b><?php echo $month; ?></b> and year <b><?php echo $year; ?></b></p>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                <h3><i class="fa fa-exclamation-triangle"></i> No Records Found!</h3>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($funds_browse_year !== '') { ?>
            <div class="xxxrow">
                <div class="xxxcol-lg-12 xxxcol-md-12">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title"><i class="material-icons">attach_money</i> <?php echo $this->lang->line('dash_gpanel_rbyear'); ?> ( <?php echo $year; ?> )</h4>
                            <p class="category"><?php echo $this->lang->line('dash_gpanel_newrecord'); ?> <?php echo getCreateDate('fundsid','funds'); ?></p>
                        </div>
                        <div class="card-content table-responsive">
                            <table class="dtFBYear table table-striped">
                                <thead>
                                <th><?php echo $this->lang->line('dash_gpanel_sl'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_month'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_collect'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_spend'); ?></th>
                                <th><?php echo $this->lang->line('dash_gpanel_balance'); ?></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_jan'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_jan, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_jan, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_jan - $browse_spend_jan, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>02</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_feb'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_feb, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_feb, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_feb - $browse_spend_feb, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>03</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_mar'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_mar, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_mar, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_mar - $browse_spend_mar, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>04</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_apr'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_apr, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_apr, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_apr - $browse_spend_apr, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>05</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_may'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_may, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_may, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_may - $browse_spend_may, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>06</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_jun'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_jun, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_jun, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_jun - $browse_spend_jun, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>07</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_jul'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_jul, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_jul, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_jul - $browse_spend_jul, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>08</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_aug'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_aug, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_aug, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_aug - $browse_spend_aug, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>09</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_sep'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_sep, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_sep, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_sep - $browse_spend_sep, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>10</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_oct'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_oct, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_oct, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_oct - $browse_spend_oct, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>11</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_nov'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_nov, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_nov, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_nov - $browse_spend_nov, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td>12</td>
                                        <td><?php echo $this->lang->line('dash_gpanel_dec'); ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_dec, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_spend_dec, 2);
                                            ?></td>
                                        <td><?php
                                            echo globalCurrency();
                                            echo number_format($browse_collect_dec - $browse_spend_dec, 2);
                                            ?></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td><b><?php echo $this->lang->line('dash_gpanel_total'); ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($browse_collect_year, 2);
                                                ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($browse_spend_year, 2);
                                                ?></b></td>
                                        <td><b><?php
                                                echo globalCurrency();
                                                echo number_format($browse_collect_year - $browse_spend_year, 2);
                                                ?></b></td>
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
