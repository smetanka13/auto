<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" type="text/css" href="css/slick.css">

<div id="slider_cnt">
	<div style="background-image: url(images/slider/qwe.jpeg)">
		<span>Hello</span>
	</div>
	<div style="background-image: url(images/slider/asd.jpg)">
		<span></span>
	</div>
	<div style="background-image: url(images/slider/zxc.jpg)">
		<span></span>
	</div>
</div>

<div id="logo_cnt">
	<!-- <div>
		<a href="http://www.elf.ua"><img src="images/logos/elf.png"></a>
		<a href="http://www.castrol.com"><img src="images/logos/castrol.png"></a>
		<a href="#"><img src="images/logos/total.png"></a>
		<a href="#"><img src="images/logos/agip.png"></a>
		<a href="http://idemitsu.com.ua"><img src="images/logos/idemitsu.png"></a>
		<a href="http://mol-ukraine.com.ua"><img  src="images/logos/mol.png"></a>
		<a href="https://motulmarket.com.ua"><img src="images/logos/motul.png"></a>
		<a href="http://www.shell.ua"><img src="images/logos/shell.png"></a>
		<a href="#"><img src="images/logos/xado.png"></a>
	</div> -->
	<div class="img_cnt">
		<div id="s_lf" style="background-image: url('images/icons/lar.png');"></div>
		<div id="s_rg" style="background-image: url('images/icons/rar.png');"></div>
		<div class="sl_vp">
			<ul class="list-inline">
				<li><div><img src="images/logos/elf.png"></div></li>
				<li><div><img src="images/logos/motul.png"></div></li>
				<li><div><img src="images/logos/elf.png"></div></li>
				<li><div><img src="images/logos/idemitsu.png"></div></li>
				<li><div><img src="images/logos/castrol.png"></div></li>
				<li><div><img src="images/logos/motul.png"></div></li>
				<li><div><img src="images/logos/elf.png"></div></li>
				<li><div><img src="images/logos/idemitsu.png"></div></li>
				<li><div><img src="images/logos/castrol.png"></div></li>
				<li><div><img src="images/logos/elf.png"></div></li>
				<li><div><img src="images/logos/idemitsu.png"></div></li>
				<li><div><img src="images/logos/castrol.png"></div></li>
				<li><div><img src="images/logos/motul.png"></div></li>
				<li><div><img src="images/logos/elf.png"></div></li>
				<li><div><img src="images/logos/idemitsu.png"></div></li>
				<li><div><img src="images/logos/castrol.png"></div></li>
			</ul>
		</div>
	</div>
</div>

<?php require_once 'view/layout/tops.php'; ?>

<script type="text/javascript" src="js/slide.js" ></script>
<script type="text/javascript" src="js/slick.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		/* --- SLIDER SENSOR --- */
		var size = window.innerWidth;
		$('#slider_cnt').slick({
			speed: 200,
			arrows: false,
			autoplay: true,
			infinite: true
		});
	});
</script>

<script type="text/javascript">
		$(document).ready(function(){

			var rightArr = $('#s_rg');
			var leftArr = $('#s_lf');
			var contSl = $('.img_cnt ul');
			var offset = 0;
			var n=5;//кол-во блоков в строке
			var maxOffset = (Math.ceil($('.img_cnt ul li').length / n)-1)*100;

			// $('.img_cnt ul li').length;
			rightArr.click(function(){
				if (offset >= maxOffset) return;
				offset += 100;
				contSl.css('left','-' + offset + '%');
			});

			leftArr.click(function(){
				if (offset <= 0) return;
				offset -= 100;
				contSl.css('left','-' + offset + '%');
			});

			if ($('body').css('width') <= 767) {

				n=4;
			}
		});
	</script>
