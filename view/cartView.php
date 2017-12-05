<?php
	require_once 'model/categoryModel.php';
	require_once 'model/productModel.php';
?>

<link rel="stylesheet" type="text/css" href="css/cart.css">

<div class="reg_prod col-xs-12 col-sm-5 col-md-4 col-lg-4">
	<div class="reg_prod_cnt">
		<h4 class="main_title">Оформление заказа</h4>
		<div class="form-group">
		  <select class="form-control">
		    <option>Выберите способ оплаты</option>
		    <option>1</option>
		    <option>2</option>
		    <option>3</option>
		  </select>
		</div>
		<div class="form-group">
		  <select class="form-control">
		    <option>Выберите способ доставки</option>
		    <option>1</option>
		    <option>2</option>
		    <option>3</option>
		  </select>
		</div>
		<div class="form-group">
		    <label>ФИО:</label>
		    <input value="<?php if(User::logged()) echo User::get("public") ?>" type="text" class="form-control" placeholder="Введите ФИО">
		</div>
		<div class="form-group">
		    <label>Город:</label>
		    <input type="text" class="form-control" placeholder="Введите город">
		</div>
		<div class="form-group">
		    <label>Адрес:</label>
		    <input type="text" class="form-control" placeholder="Введите адрес">
		</div>
		<div class="form-group">
		    <label>Email:</label>
		    <input value="<?php if(User::logged()) echo User::get("email") ?>" type="email" class="form-control" placeholder="Введите email">
		</div>
		<div class="form-group">
		    <label>Телефон:</label>
		    <input value="<?php if(User::logged()) echo User::get("phone") ?>" type="tel" class="form-control" placeholder="Введите телефон">
		</div>
		<div class="form-group">
		  <textarea class="form-control" rows="5" placeholder="Комментарий к заказу"></textarea>
		</div>
		<button class="wth_boot_but confirm_but" onclick="ajaxController({
			model: 'order',
			method: 'add',
			callback: callback,
			pay_way: $('...').val(),
			delivery_way: ,
			public: ,
			city: ,
			address: ,
			email: ,
			phone: ,
			text:
		})">Оформить заказ</button>
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
		<div class="img-responsive c_prod_img hidden-xs cent_img"><img src="<?=
			!empty($product['image']) ?
			'catalog/'.$product['category'].'/'.$product['image'] :
			'images/icons/no_photo.svg'
		?>"></div>
		<div class="c_prod_txt">
			<h4 class="main_title"><?= $product['title'] ?></h4>
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
			<a href="product?category=<?= $product['category'] ?>&id=<?= $product['id'] ?>">
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
