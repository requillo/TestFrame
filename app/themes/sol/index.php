	<?php 
if($this->dashboard == 'index') {
	$this->page_title = __('Dashboard','sol');
} else if($this->page_title == '' && $this->error == 1){
	$this->page_title = __('Page not found','sol');
}
	$this->admin_part('header')?>
	<div id="wrapper" class="pos-rel menu-open">
		<div class="content" id="main-content">
			<div class="container-fluid">
				<div class="page-header">
					<h1 class="text-right">
						<span class="pull-left theme-page-title"><?php echo $this->page_title; ?></span>
							<span class="powedby">
								<img src="<?php echo $themepath ?>/assets/images/petro.png" width="183" height="29" alt="PetroData">
							</span>
					</h1>
				</div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12">&nbsp;</div>
				</div>
				<div class="row">
					 <?php $this->admin_content(array( 'title' => false ));?> 
				</div>
			</div>
		</div>
		<aside class="menu-aside animated slideInLeft">
			 <?php admin_menu('nav side-menu'); ?>
		</aside>
	</div>
<?php $this->admin_part('footer')?>