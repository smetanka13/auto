<?php require_once 'model/categoryModel.php'; ?>
<link rel="stylesheet" type="text/css" href="css/admin.css">
<link rel="stylesheet" type="text/css" href="css/personal_room.css">
<script>
    function callback(data) {
        if(data.status == true) {
            alert('OK');
        } else {
            alert('ERROR');
        }
    }
    function getProd(data) {

        if(data.output != null) {
            $('#upload .alert-danger').hide();
            $('#upload .alert-success').show();
            $('#upload .alert-success a').attr('href', 'product?category='+data.output.category+'&id='+data.output.id);
            $('#upload .alert-success a').html(data.output.title);
            $('#upload #quantity').val(data.output.quantity);
            $('#upload #text').val(data.output.text);
            $('#upload #price').val(data.output.price);

            var cnt = $('#upload #values select');

            for(var i = 0; i < cnt.length; i++) {
                $(cnt[i]).val(data.output[$(cnt[i]).attr('data-param')]);
            }
            $('#upload #found_id').val(data.output.id);
        } else {
            $('#upload .alert-danger').show();
            $('#upload .alert-success').hide();
        }

    }
    function getParams(data) {
        $('#newparamvalues #param').html('<option>Не выбрано</option>');
        if(data.status) {
            for(var i = 0; data.output[i] != null; i++) {
                $('#newparamvalues #param').append('<option>'+data.output[i]+'</option>');
            }
        }
    }
    function getValues(data) {
        if(data.status) {
            for(var i = 0; data.output[i] != null; i++) {
                addInput('#newparamvalues #values_cnt', 'Значение');
                $('#newparamvalues #values_cnt input:eq('+i+')').val(data.output[i]);
            }
        } else {
            addInput('#newparamvalues #values_cnt', 'Значение');
        }

    }
    function getAll(data) {
        if(data.status) {
            for(var key in data.output) {
                $('#upload #values').append('<h4>'+key+'</h4>');
                var str = '';
                for(var i = 0; data.output[key][i] != null; i++) {
                    str += '<option>'+data.output[key][i]+'</option>';
                }
                $('#upload #values').append('<select data-param="'+key+'">'+str+'</select>');
            }
        }
    }
    function invalidParse(id) {
        var len = $(id).length;
        var param_str = '';
        for(var i = 0; i < len; i++) {

            if($(id+':eq('+i+')').val() == '')
                return false;

            if(i > 0)
                param_str += ";" + $(id+':eq('+i+')').val();
            else
                param_str += $(id+':eq('+i+')').val();
        }
        return param_str;
    }
    function addInput(cnt, placeholder) {
        $(cnt).append('<input type="text" placeholder="'+placeholder+' '+($(cnt+' input').length + 1)+'">');
    }
    function removeInput(cnt) {
        $(cnt+' input:eq('+($(cnt+' input').length - 1)+')').remove();
    }
    function paramsParse() {
        var str = invalidParse('#newcategory #params_cnt input');

        if(str === false) {
            alert("Пустой парметр недопустим");
            return;
        }

        ajaxController({
            listener: 'newcategory',
            callback: callback,
            name: $('#newcategory #name').val(),
            params: str
        });
    }
    function valuesParse() {
        var str = invalidParse('#values_cnt input');

        if($('#newparamvalues #category').val() == '') {
            alert("Выберите категорию");
            return;
        }
        if($('#newparamvalues #param').val() == '') {
            alert("Выберите спецификацию");
            return;
        }

        if(!str) {
            alert("Пустое значение недопустимо");
            return;
        }

        ajaxController({
            model: 'category',
            method: 'addValues',
            callback: callback,
            category: $('#newparamvalues #category').val(),
            param: $('#newparamvalues #param').val(),
            values: str
        });
    }
    function upload() {
        var json = {};
        var cnt = $('#upload #values select');

        for(var i = 0; i < cnt.length; i++) {
            json[$(cnt[i]).attr('data-param')] = $(cnt[i]).val();
        }

        json = JSON.stringify(json);

        ajaxController({
            model: 'product',
            method: 'upload',
            callback: callback,
            category: $('#upload #category').val(),
            id: $('#upload #found_id').val(),
            text: $('#upload #text').val(),
            price: $('#upload #price').val(),
            quantity: $('#upload #quantity').val(),
            values: json,
        }, {
            img: $('#upload #img')
        })
    }

    $(document).ready(function() {
        $('#newparamvalues #category').change(function() {
            $('#newparamvalues #values_cnt').html('');
            ajaxController({
                model: 'category',
                method: 'getParams',
                callback: getParams,
                category: $('#newparamvalues #category').val()
            })
        });
        $('#newparamvalues #param').change(function() {
            $('#newparamvalues #values_cnt').html('');
            ajaxController({
                model: 'category',
                method: 'getValues',
                callback: getValues,
                category: $('#newparamvalues #category').val(),
                param: $('#newparamvalues #param').val()
            })
        });
        $('#upload #category').change(function() {
            $('#upload #values').html('');
            ajaxController({
                model: 'category',
                method: 'getFullCategory',
                callback: getAll,
                category: $('#upload #category').val()
            })
        });
        $('#upload #id').keyup(function() {
            if($('#upload #category').val() != 'Не выбрано' && $('#upload #id').val() != '') {
                ajaxController({
                    model: 'product',
                    method: 'get',
                    callback: getProd,
                    category: $('#upload #category').val(),
                    id: $('#upload #id').val()
                })
            }
        });

        $('.ord_but').click(function() {
            var id = $(this).attr('data-id');
            $('.tb_buy tr td .ord_but:eq('+id+')').fadeOut();
            $('.tb_buy tr td .cf_ord:eq('+id+')').fadeIn();
            $('.tb_buy tr .order:eq('+id+')').addClass('success');
        });
    });
</script>
<div class="container" style="padding-top: 100px;">
    <div class="row">
         <h4 class="pr_titles_cat">Поступающие заказы</h4>
          <p>Тут будут отображаться все заказы.</p>
            <div class="tb_cnt mbt">
                <table class="table tb_buy table-bordered">
                    <thead>
                        <tr>
                        <th>ФИО клиента</th>
                        <th>Контактный телефон</th>
                        <th>Код товара</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                        <th>Способ доставки</th>
                        <th>Комментарий к заказу</th>
                        <th>Дата</th>
                        <th>Подтверждение заказа</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Фионов Юрий Сергеевич</td>
                            <td>0939463704</td>
                            <td><a href="#">67839992</a></td>
                            <td>10 шт</td>
                            <td>200000 грн</td>
                            <td>Самовывоз</td>
                            <td>Позвонить после принятия заказа</td>
                            <td>20.10.2013</td>
                            <td class="order">
                                <button data-id="0" class="wth_boot_but btn-success ord_but">Подтвердить заказ</button>
                                <div class="cf_ord">Заказ принят</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Фионов Юрий Сергеевич</td>
                            <td>0939463704</td>
                            <td><a href="#">67839992</a></td>
                            <td>10 шт</td>
                            <td>200000 грн</td>
                            <td>Самовывоз</td>
                            <td>Позвонить после принятия заказа</td>
                            <td>20.10.2013</td>
                            <td class="order">
                                <button data-id="1" class="wth_boot_but btn-success ord_but">Подтвердить заказ</button>
                                <div class="cf_ord">Заказ принят</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Фионов Юрий Сергеевич</td>
                            <td>0939463704</td>
                            <td><a href="#">67839992</a></td>
                            <td>10 шт</td>
                            <td>200000 грн</td>
                            <td>Самовывоз</td>
                            <td>Позвонить после принятия заказа</td>
                            <td>20.10.2013</td>
                            <td class="order">
                                <button data-id="2" class="wth_boot_but btn-success ord_but">Подтвердить заказ</button>
                                <div class="cf_ord">Заказ принят</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <div id="excel" class="col-md-12 cnt_all">
            <h1 class="main_title">Excel загрузка</h1>
            <input type="file" id="file" multiple="multiple">
            <button class="wth_boot_but confirm_but" onclick="ajaxController({
                listener: 'excel',
                callback: callback
            }, {
                excel: $('#excel #file')
            })">Загрузить</button>
        </div>
        <div id="newcategory" class="col-md-12 cnt_all">
            <h1 class="main_title">Новая категория</h1>
            <input type="text" id="name" placeholder="Название категории">
            <div id="params_cnt">
                <input type="text" placeholder="Спецификация 1">
            </div>
            <div class="btn-group">
                <button class="btn btn-default" onclick="addInput('#newcategory #params_cnt', 'Спецификация')">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Добавить спецификацию
                </button>
                <button class="btn btn-default" onclick="removeInput('#newcategory #params_cnt')">
                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    Убрать спецификацию
                </button>
            </div>
            <button class="wth_boot_but confirm_but" onclick="paramsParse()">Создать</button>
        </div></br>
        <div id="newparamvalues" class="col-md-12 cnt_all">
            <h1 class="main_title">Добавить значения для спецификации</h1>
            <div class="container-fluid">
                <select id="category">
                    <option>Не выбрано</option>
                    <?php
                        $categories = Category::getCategories();

                        for($i = 0; isset($categories[$i]); $i++) {
                            echo "<option>".$categories[$i]."</option>";
                        }
                    ?>
                </select>
                <select id="param">
                    <option>Не выбрано</option>
                </select>
            </div>
            <div class="btn-group">
                <button class="btn btn-default" onclick="addInput('#newparamvalues #values_cnt', 'Значение')">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Добавить значение
                </button>
                <button class="btn btn-default" onclick="removeInput('#newparamvalues #values_cnt')">
                    <span class="glyphicon glyphicon-minus inverse" aria-hidden="true"></span>
                    Убрать значение
                </button>
            </div>
            <div id="values_cnt"></div>
            <button class="wth_boot_but confirm_but" onclick="valuesParse()">Добавить</button>
        </div>
        <div id="upload" class="col-md-12 cnt_all">
            <h1 class="main_title">Оформить товар</h1>
            <div class="alert alert-danger" role="alert" style="display: none">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                Товара с таким идентификатором не найдено.
            </div>
            <div class="alert alert-success" role="alert" style="display: none">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                Найден товар: <a href=""></a>
            </div>
            <div class="container-fluid">
                <select id="category">
                    <option>Не выбрано</option>
                    <?php
                        $categories = Category::getCategories();

                        for($i = 0; isset($categories[$i]); $i++) {
                            echo "<option>".$categories[$i]."</option>";
                        }
                    ?>
                </select>
            </div>
            <input type="hidden" id="found_id" value="">
            <input type="text" id="id" placeholder="НАЗВАНИЕ / АРТИКУЛ">
            <input type="number" id="quantity" placeholder="Кол-во">
            <input type="number" id="price" placeholder="Цена">
            <textarea style="resize: both" id="text" placeholder="Описание"></textarea>
            Фото товара <br><input type="file" id="img" accept="image/jpeg,image/png">
            <div id="values"></div>
            <button class="wth_boot_but confirm_but" onclick="upload()">Оформить</button>
        </div>
        <div id="" class="col-md-12 cnt_all">
            <h1 class="main_title">Добавить статью</h1>
            <input type="text" id="" placeholder="Заголовок">
            <textarea style="resize: both" id="" placeholder="Описание статьи"></textarea>
            Выберите одну или несколько фотографий <br><input type="file" id="" accept="image/jpeg,image/png">
            <div id="values"></div>
            <button class="wth_boot_but confirm_but" onclick="upload()">Опубликовать</button>
        </div>
    </div>
</div>
