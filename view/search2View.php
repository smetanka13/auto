<?php

    require 'model/searchModel.php';

    /* ---- Setup values ---- */

    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    $srch = isset($_GET['srch']) ? $_GET['srch'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : 'Масла';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
    $from = isset($_GET['from']) ? $_GET['from'] : NULL;

    if(isset($_GET['values'])) {
        $values = json_decode(base64_decode($_GET['values']), TRUE);
        $params = array_keys($values);
    } else {
        $values = [];
        $params = [];
    }


    $result = Search::find($srch, $category, $values, $sort, $from);
    $prods = $result['search_result'];
?>

<link rel="stylesheet" type="text/css" href="css/cart.css">
<link rel="stylesheet" type="text/css" href="css/product_block.css">

<div class="reg_prod col-xs-12 col-sm-5 col-md-4 col-lg-4">
	<div class="reg_prod_cnt">

	</div>
</div>

<!-- БЛОК С ТОВАРАМИ -->
<div class="cart_prod col-xs-12 col-sm-7 col-md-8 col-lg-8">
	<?php
        foreach ($prods as $prod) {
            $img = $prod['image'];
    ?>
        <div class="prods_cnt" style="margin-bottom: 50px;">
            <div class="prods_wrapper">
                <h3 class="title"><?= $prod['title'] ?></h3>
                <div class="prods_img_cnt"><img src="<?= "catalog/$category/$img" ?>"></div>
                <p>
                <?php
                    for($j = 0; isset($list_params[$j]); $j++) {
                        if(empty($prod[$list_params[$j]])) continue;
                        echo $list_params[$j].': '.$prod[$list_params[$j]].'</br>';
                    }
                ?>
                </p>
                <div class="prods_bottom">
                    <a href="<?= 'product?category='.$prod['category'].'&id='.$prod['id'] ?>"><button>КУПИТЬ</button></a>
                    <h4><?= $prod['price'] ?> грн.</h4>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">

</script>
