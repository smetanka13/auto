<?php
    # --- Если прошло больше 24 часов, то обновить ТОП --- #
    # --- (если это делать каждый раз когда зоходит юзер, то это замедлит работу сайта) --- #

    require_once 'model/productModel.php';
    require_once 'model/topsModel.php';

    Tops::updateTopProds();

?>

<link rel="stylesheet" type="text/css" href="css/product_block.css">
<script type="text/javascript">
    $(document).ready(function() {
        var offset = [0, 0];

        $('.right_arrow').click(function() {
            var index = $(this).attr('data-index');
            if(offset[index] <= -1500) return;
            offset[index] -= $('.prod_viewport:eq('+index+')').width();
            if(offset[index] <= -1500) offset[index] = -1500;
            $('.prods_slider:eq('+index+')').css('left', offset[index]+'px');
        });
        $('.left_arrow').click(function() {
            var index = $(this).attr('data-index');
            if(offset[index] >= 0) return;
            offset[index] += $('.prod_viewport:eq('+index+')').width();
            if(offset[index] >= 0) offset[index] = 0;
            $('.prods_slider:eq('+index+')').css('left', offset[index]+'px');
        });
        // $('.prods_slider').addClass("hidden").viewportChecker({
        //     classToAdd:'visible animated fadeIn',
        //     offset:100
        // });
    });
</script>

<!-- Топ самых часто продаваемых товаров -->
<div id="product_block">
    <div class="product_cnt">
        <div class="prods_header">ТОП ПРОДАЖ</div>
        <button class="right_arrow" data-index="0">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 292.359 292.359" style="enable-background:new 0 0 292.359 292.359;" xml:space="preserve"><g><path d="M222.979,133.331L95.073,5.424C91.456,1.807,87.178,0,82.226,0c-4.952,0-9.233,1.807-12.85,5.424   c-3.617,3.617-5.424,7.898-5.424,12.847v255.813c0,4.948,1.807,9.232,5.424,12.847c3.621,3.617,7.902,5.428,12.85,5.428   c4.949,0,9.23-1.811,12.847-5.428l127.906-127.907c3.614-3.613,5.428-7.897,5.428-12.847   C228.407,141.229,226.594,136.948,222.979,133.331z"/></g></svg>
        </button>
        <button class="left_arrow" data-index="0">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 292.359 292.359" style="enable-background:new 0 0 292.359 292.359;" xml:space="preserve"><g><path d="M222.979,5.424C219.364,1.807,215.08,0,210.132,0c-4.949,0-9.233,1.807-12.848,5.424L69.378,133.331   c-3.615,3.617-5.424,7.898-5.424,12.847c0,4.949,1.809,9.233,5.424,12.847l127.906,127.907c3.614,3.617,7.898,5.428,12.848,5.428   c4.948,0,9.232-1.811,12.847-5.428c3.617-3.614,5.427-7.898,5.427-12.847V18.271C228.405,13.322,226.596,9.042,222.979,5.424z"/></g></svg>
        </button>
        <div class="prod_viewport">
            <div class="prods_slider">
                <?php
                    # --- Вывод товаров --- #

                    $products = Tops::getTopProds();
                    foreach($products as $product) {
                        $params = Category::getParams($product['category']);
                ?>
                <div class="prods_cnt">
                    <div class="prods_wrapper">
                        <h3 class="title"><?= $product['title'] ?></h3>
                        <div class="prods_img_cnt"><img src="<?=
                            !empty($product['image']) ?
                            'catalog/'.$product['category'].'/'.$product['image'] :
                            'images/icons/no_photo.svg'
                        ?>"></div>
                        <p>
                            <?php
                                # --- Вывод параметров товара (Внутри ПАРАГРАФА) --- #
                                foreach($params as $param) {
                                    if(!empty($product[$param]))
                                        echo $param.': '.$product[$param].'</br>';
                                }
                            ?>
                        </p>
                        <div class="prods_bottom">
                            <a href="product?category=<?= $product['category'] ?>&id=<?= $product['id'] ?>"><button>КУПИТЬ</button></a>
                            <h4><?= $product['price']?> &euro;</h4>
                        </div>
                    </div>
                </div>

                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Топ самых новых товаров -->
    <div class="product_cnt">
        <div class="prods_header">НОВИНКИ</div>
        <button class="right_arrow" data-index="1">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 292.359 292.359" style="enable-background:new 0 0 292.359 292.359;" xml:space="preserve"><g><path d="M222.979,133.331L95.073,5.424C91.456,1.807,87.178,0,82.226,0c-4.952,0-9.233,1.807-12.85,5.424   c-3.617,3.617-5.424,7.898-5.424,12.847v255.813c0,4.948,1.807,9.232,5.424,12.847c3.621,3.617,7.902,5.428,12.85,5.428   c4.949,0,9.23-1.811,12.847-5.428l127.906-127.907c3.614-3.613,5.428-7.897,5.428-12.847   C228.407,141.229,226.594,136.948,222.979,133.331z"/></g></svg>
        </button>
        <button class="left_arrow" data-index="1">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 292.359 292.359" style="enable-background:new 0 0 292.359 292.359;" xml:space="preserve"><g><path d="M222.979,5.424C219.364,1.807,215.08,0,210.132,0c-4.949,0-9.233,1.807-12.848,5.424L69.378,133.331   c-3.615,3.617-5.424,7.898-5.424,12.847c0,4.949,1.809,9.233,5.424,12.847l127.906,127.907c3.614,3.617,7.898,5.428,12.848,5.428   c4.948,0,9.232-1.811,12.847-5.428c3.617-3.614,5.427-7.898,5.427-12.847V18.271C228.405,13.322,226.596,9.042,222.979,5.424z"/></g></svg>
        </button>
        <div class="prod_viewport">

            <div class="prods_slider">
                <?php
                    # --- Вывод товаров --- #

                    $products = Tops::getNewProds();
                    foreach($products as $product) {
                        $params = Category::getParams($product['category']);
                ?>
                <div class="prods_cnt">
                    <div class="prods_wrapper">
                        <h3 class="title"><?= $product['title'] ?></h3>
                        <div class="prods_img_cnt"><img src="<?=
                            !empty($product['image']) ?
                            'catalog/'.$product['category'].'/'.$product['image'] :
                            'images/icons/no_photo.svg'
                        ?>"></div>
                        <p>
                            <?php
                                # --- Вывод параметров товара (Внутри ПАРАГРАФА) --- #
                                foreach($params as $param) {
                                    if(!empty($product[$param]))
                                        echo $param.': '.$product[$param].'</br>';
                                }
                            ?>
                        </p>
                        <div class="prods_bottom">
                            <a href="product?category=<?= $product['category'] ?>&id=<?= $product['id'] ?>"><button>КУПИТЬ</button></a>
                            <h4><?= $product['price']?> &euro;</h4>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
