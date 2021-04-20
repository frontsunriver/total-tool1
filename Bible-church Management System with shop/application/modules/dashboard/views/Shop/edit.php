<?php foreach ($individual_product as $row): ?>

    <div class="content">
        <div class="container">
            <div class="xxxrow">
                <div class="xxxcol-md-offset-1 xxxcol-md-10">
                    <div class="card">
                        <div class="card-header" data-background-color="purple">
                            <h4 class="title"><i class="material-icons">shop</i> <?php echo $this->lang->line('dash_editproduct_panel_title'); ?></h4>
                            <p class="category">(*) <?php echo $this->lang->line('dash_gpanel_mfar'); ?></p>
                        </div>
                        <div class="card-content">

                            <form id="updateProductForm" class="form-horizontal" action="<?php echo base_url(); ?>dashboard/shop/update" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="productID" value="<?php echo $row->productID; ?>">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-8">

                                        <div class="imageWrapper" style="background-image: url(<?php echo base_url(); ?>assets/assets/images/upload.png);">
                                            <img id="image" src="">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <p class="image_select_text"><i class="material-icons">add_a_photo</i> <?php echo $this->lang->line('dash_gpanel_ppp'); ?></p>
                                            <input type="file" onchange="seminarbanner()" name="productimage" id="productimage">
                                            <input type="hidden" name="x" id="x">
                                            <input type="hidden" name="y" id="y">
                                            <input type="hidden" name="width" id="width">
                                            <input type="hidden" name="height" id="height">
                                        </div>
                                    </div>

                                    <div class="col-md-6 destroy_cropper_div">
                                    	<div class="form-group label-floating">
                                    		<p class="image_select_text destroy_cropper"><i class="material-icons">crop</i> <?php echo $this->lang->line('dash_gpanel_clear_crop'); ?></p>
                                    	</div>
                                    </div>

                                    <div class="col-md-6 ini_cropper_div" style="display:none">
                                    	<div class="form-group label-floating">
                                    		<p class="image_select_text ini_cropper"><i class="material-icons">crop</i> <?php echo $this->lang->line('dash_gpanel_ini_crop'); ?></p>
                                    	</div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_title'); ?> (*)</label>
                                            <input type="text" name="title" class="form-control" value="<?php echo $row->title; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_pprice'); ?> (*)</label>
                                            <input type="number" step="any" min="0.01" name="price" class="form-control" value="<?php echo $row->price; ?>" required>
                                            <span class="material-input"></span></div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_category'); ?></label>
                                            <input type="text" name="category" class="form-control" value="<?php echo $row->category; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_tag'); ?></label>
                                            <input type="text" name="tag" class="form-control" value="<?php echo $row->tag; ?>">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_sale'); ?></label>
                                            <input type="text" name="sale" class="form-control" value="<?php echo $row->sale; ?>">
                                            <span class="material-input"></span></div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"><?php echo $this->lang->line('dash_gpanel_description'); ?></label>
                                            <textarea type="text" rows="5" name="description" class="form-control"><?php echo $row->description; ?></textarea>
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>

                                <button id="updateProductFormSubmit" type="submit" class="btn btn-primary pull-right"><i class="material-icons">shop</i> <?php echo $this->lang->line('dash_editproduct_panel_title'); ?></button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
