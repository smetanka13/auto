<link rel="stylesheet" type="text/css" href="css/cart.css">
<link rel="stylesheet" type="text/css" href="css/search.css">

<?php
	require_once 'model/categoryModel.php';
	require_once 'model/productModel.php';
?>

<div class="reg_prod col-xs-12 col-sm-5 col-md-4 col-lg-4">
	<div class="reg_prod_cnt prod_cnt_search">
		<h4 class="main_title s_filt_title">Меню товара</h4>
		<div class="dropdown filt_prod_menu">
		    <button class="wth_boot_but dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Товар
		    <span class="caret"></span></button>
		    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
		      <li role="presentation"><p role="menuitem" tabindex="-1">Подтовар</p></li>
		      <li role="presentation" class="divider"></li>
		      <li role="presentation"><p role="menuitem" tabindex="-1">Подтовар</p></li>
		      <li role="presentation" class="divider"></li>
		      <li role="presentation"><p role="menuitem" tabindex="-1">Подтовар</p></li>
		      <li role="presentation" class="divider"></li>
		      <li role="presentation"><p role="menuitem" tabindex="-1">Подтовар</p></li>
		    </ul>
		  </div>
		<h4 class="main_title s_filt_title2">Фильтры</h4>
		<div class="dropdown filt_prod_menu noclose">
		    <button class="wth_boot_but dropdown-toggle" type="button" id="menu2" data-toggle="dropdown">Масла
		    <span class="caret"></span></button>
		    <ul class="dropdown-menu" role="menu" aria-labelledby="menu2">
		    	<div class="form-group filt_cat_select">
				<label for="inputDate">Масла</label>
					<select class="form-control">
						<option>масло1</option>
						<option>масло2</option>
						<option>масло3</option>
						<option>масло3</option>
					</select>
				</div>
		      <li role="presentation" class="divider"></li>
		      <div class="form-group filt_cat_select">
				<label for="inputDate">Масла</label>
					<select class="form-control">
						<option>масло1</option>
						<option>масло2</option>
						<option>масло3</option>
						<option>масло3</option>
					</select>
				</div>
		      <li role="presentation" class="divider"></li>
		      <div class="form-group filt_cat_select">
				<label for="inputDate">Масла</label>
					<select class="form-control">
						<option>масло1</option>
						<option>масло2</option>
						<option>масло3</option>
						<option>масло3</option>
					</select>
				</div>
		    </ul>
		  </div>
	</div>
</div>

<!-- БЛОК С ТОВАРАМИ -->
<div class="cart_prod col-xs-12 col-sm-7 col-md-8 col-lg-8">
	<?php

		$cookie = json_decode($_COOKIE['cart'], TRUE);
		$products = Product::selectFromDiffCategories($cookie);

		foreach($products as $index => $product) {
			$params = Category::getParams($product['category']);
	?>
	<div class="c_prod_part" data-id="<?= $index ?>">
		<div class="img-responsive c_prod_img hidden-xs"><img src="<?=
			!empty($product['image']) ?
			'catalog/'.$product['category'].'/'.$product['image'] :
			'images/icons/no_photo.svg'
		?>"></div>
		<div class="c_prod_txt">
			<a href="#"><h4 class="main_title">Xenum GPR kkkk 3 33</h4></a>
			<table class="table">
				<tbody>

					<?php
						# --- Вывод параметров товара --- #
						foreach($params as $param) {
							if(!empty($product[$param])) {
					?>

					<tr>
						<td><?= $param ?></td>
						<td class="def"><?= $product[$param] ?></td>
					</tr>

					<?php }} ?>

				</tbody>
            </table>
		</div>
		<div class="count">
			<p class="main_title">количество (шт.)</p>
			<div class="form-group">
			    <input type="number" onchange="updateCartQuantity(<?= $index ?>, $(this).val())" class="form-control" value="<?= $cookie[$index]['quantity'] ?>"  min="1" >
			</div>
		</div>
		<div class="c_price">
			<p class="main_title"><?= $product['price'] ?> &euro;</p>
			<a href="product_card?category=<?= $product['category'] ?>&id=<?= $product['id'] ?>">
				<button class="wth_boot_but confirm_but">Подробнее</button>
			</a>
		</div>
		<img onclick="removeCart(<?= $index ?>, deleteProduct)" class="close_img" src="images/icons/close.svg">
	</div>
	<?php } ?>
</div>

<script type="text/javascript">
	function deleteProduct(index) {
		$('.c_prod_part[data-id='+index+']').remove();
	}
</script>

<script type="text/javascript">
	$('.dropdown-toggle').dropdown();
</script>

<script type="text/javascript">
	$(document).on("click.bs.dropdown.data-api", ".noclose", function (e) { e.stopPropagation() });
</script>
