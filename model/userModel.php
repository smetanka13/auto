<?php

class User {

    private static $data = [
        'logged' => FALSE
    ];

    public static function registrate($login, $email, $pass, $confirm) {

        if(!preg_match("/^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})$/is", $email))
            throw new Exception("Invalid email.");

        if(Main::select("
        	SELECT * FROM `user`
        	WHERE `email` = '$email'
            LIMIT 1
        "))
            throw new InvalidArgumentException("Email is already busy.");

        if(strlen($pass) < 8)
            throw new InvalidArgumentException("Length of the password must be more then 8.");
        if(strlen($pass) > 32)
            throw new InvalidArgumentException("Length of the password must be less then 32.");
        if (preg_match("/'\{\}\[\]\(\)\`\"/", $pass))
            throw new InvalidArgumentException("Some symbols are not allowed.");

        if (preg_match("/'\{\}\[\]\(\)\`\"/", $login))
            throw new InvalidArgumentException("Some symbols are not allowed.");
        if(strlen($pass) < 8)
            throw new InvalidArgumentException("Length of the password must be more then 8.");
        if(strlen($pass) > 32)
            throw new InvalidArgumentException("Length of the password must be less then 32.");

        if($confirm != $pass)
            throw new InvalidArgumentException("Repeat password correctly.");
        if(empty($confirm))
            throw new InvalidArgumentException("Repeat password.");

        if(empty($error_arr)) {

            Main::query("
        		INSERT INTO `user` (
        			`login`, `email`, `pass`
        		) VALUES (
        			'$login', '$email', '".self::hashPass($login, $pass)."'
        		)
        	");

            $key = Main::generateKey();
            try {
                Main::query("
                    INSERT INTO `verify` (
                        `email`, `key`
                    )
                    VALUES (
                        '$email', '$key'
                    )
                ");
            } catch (RuntimeException $e) {
                Main::query("
                    DELETE FROM `user`
                    WHERE `email` = '$email';
                ");
                throw new RuntimeException($e->getMessage());
            }

            $subject = "[".NAME."] registration.";
            $headers = 'From: '.NAME. "\r\n";
            $message = "To activate your account enter this link: ".URL."/remote?model=user&method=verify&key=".$key;
            if(!mail($email, $subject, $message, $headers)) {
                Main::query("
                    DELETE FROM `user`
                    WHERE `email` = '$email'
                ");
                Main::query("
                    DELETE FROM `verify`
                    WHERE `email` = '$email'
                ");
                throw new RuntimeException('Error sending mail.');
            }
        }
    }

    public static function verifyEmail($key) {

        $email = Main::select("
        	SELECT `email` FROM `confirm`
        	WHERE `key` = '$key'
        	LIMIT 1
        ");

        if(Main::query("
        	SELECT `email` FROM `user`
        	WHERE `email` = '".$email['email']."'
        	LIMIT 1
        ")) {
        	Main::query("
        		UPDATE `user`
        		SET `confirmed` = '1'
        		WHERE `email` = '".$email['email']."'
        		LIMIT 1
        	");
        	Main::query("
        		DELETE FROM `confirm`
        		WHERE `key` = '$key'
        		LIMIT 1
        	");

        	header("Location: ".URL."?message=Вы успешно зарегистрировались.");
        } else {
        	header("Location: ".URL."?message=Возникла проблема, попробуйте позже.");
        }
    }

    public static function saveLogged($login, $pass) {
        if(!self::login($login, $pass, TRUE))
            throw new Exception("Wrong login or password.");

        if(!(
            setcookie('login', self::get('login'), 0, "/") &&
    		setcookie('pass', self::get('pass'), 0, "/")
        )) {
    		throw new RuntimeException("Error setting cookies.");
    	}
    }

    public static function hashPass($login, $pass) {
        return crypt($pass, "$6$1000$".sha1("$login~pornhub_sucks"));
    }

    public static function login($login, $pass, $hash = FALSE) {
        if($hash) $pass = self::hashPass($login, $pass);

        $user = Main::select("
            SELECT * FROM `user`
            WHERE `login` = '$login'
            AND `pass` = '$pass'
            AND `confirmed` = '1'
            LIMIT 1
        ");

        if(!empty($user)) {
            foreach($user as $key => $value) {
                self::$data[$key] = $value;
            }
            self::$data['logged'] = TRUE;

            return TRUE;
        }

        return FALSE;
    }
    public static function get($var) {
        return self::$data[$var];
    }
    public static function logged() {
        return self::$data['logged'];
    }
}
