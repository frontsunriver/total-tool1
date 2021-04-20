<?php foreach($individual as $row):?>
<div class="content view_event">
	<div class="container">
		<div class="xxxrow">
			<div class="xxxcol-md-offset-1 xxxcol-md-10">				
				<div class="card card-product">
					<div class="card-content">						
						<h4 class="card-title">
                                   <a href="#"><?php echo $row->noticetitle;?></a>
						</h4>
						<div class="card-description">
							<?php echo $row->noticedescription;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endforeach;?>