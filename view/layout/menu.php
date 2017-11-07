<link rel="stylesheet" type="text/css" href="css/menu.css">

<div id="menu">
    <div id="close_butt" onclick="trigMenu()"></div>
    <div class="heading">Каталог</div>
    <div class="catalog">
        <div class="name">qwe qwe</div>
        <div class="list">
            <div class="item">123</div>
            <div class="item">123</div>
            <div class="item">123</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function trigMenu() {
        if($('#menu').hasClass('opened')) {
            $('#menu').removeClass('opened');
        } else {
            $('#menu').addClass('opened');
        }
    }
</script>
