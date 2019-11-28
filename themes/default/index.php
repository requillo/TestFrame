<?php $this->part('header')?>
<div class="ContentWrap">
	<div class="max-width">
		<main>
		    <article class="actueel parent floor">
		    <h1><?php echo $title;?></h1>
		    <?php $this->content();?>
		    </article>
		</main>
		<aside>
			<h3>Advertentie</h3>
			<section>
				<div class="ads-pos04"><img src="<?php echo $theme_url ?>/assets/img/300-250-youtube-min-1.jpg"></div>
			</section>
			<h3>Advertentie</h3>
			<section>
				<div class="ads-pos04"><img src="<?php echo $theme_url ?>/assets/img/300-600-verticle-ractagle-min-1.jpg"></div>
			</section>
			
		</aside>
	</div>
</div>
<?php $this->part('footer')?>
