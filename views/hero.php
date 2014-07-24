<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>
	
	<div class="carousel-inner">
		<div class="item active">
			<img src="img/slider01.jpg" alt="">
			<div class="container">
				<div class="carousel-caption">
					<h1>St. Edmund Hall</h1>
					<p>Interviews Website</p>
				</div>
			</div>
		</div>
		
		<div class="item">
			<img src="img/slider02.jpg" alt="">
			<div class="container">
				<div class="carousel-caption"></div>
			</div>
		</div>
		<div class="item">
			<img src="img/slider03.jpg" alt="">
			<div class="container">
				<div class="carousel-caption"></div>
			</div>
		</div>
	</div>
	<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="icon-prev"></span></a>
	<a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="icon-next"></span></a>
</div>

<style>
.carousel {
	margin-top: -10px;
	/*height: 500px;*/
}
/* Since positioning the image, we need to help out the caption */
.carousel-caption {
	z-index: 10;
}
</style>