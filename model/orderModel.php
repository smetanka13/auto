<?php

class Order {
    public static function get($id_order) {
        return Main::select("
            SELECT * FROM `order`
            WHERE `id` = '$id_order'
            LIMIT 1
        ");
    }
    public static function getUnchecked() {
        return Main::select("
            SELECT * FROM `order`
            WHERE `checked` = '0'
        ", TRUE);
    }
    public static function checkUnchecked() {
        Main::query("
            UPDATE `order`
            SET `checked` = '1'
            WHERE `checked` = '0'
        ");
    }
    public static function add($pay_way, $delivery_way, $public, $city, $address, $email, $phone, $text) {
        Main::query("
            INSERT INTO `order` (
                `pay_way`, `delivery_way`, `public`,
                `city`, `address`, `email`,
                `phone`, `text`, `date`
            ) VALUES (
                '$pay_way', '$delivery_way', '$public',
                '$city', '$address', '$email',
                '$phone', '$text', '".TIME."'
            )
        ");

        $id_order = Main::select("
            SELECT `id` FROM `order`
            WHERE `date` = '".TIME."'
            AND `email` = '$email'
            LIMIT 1
        ")['id'];

        Main::query("
            INSERT INTO `order_product` (
                `id_order`, `id_product`, `quantity`, `category`
            ) VALUES (
                '$id_order', '".$COOKIE['id']."', '".$COOKIE['quantity']."', '".$COOKIE['category']."',
            )
        ");
    }
    public static function verify($id_order) {
        Main::query("
            UPDATE `order`
            SET `verified` = '1'
            WHERE `id` = '$id_order'
            LIMIT 1
        ");
    }
}
