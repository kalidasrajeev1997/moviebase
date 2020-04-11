<?php

class Login {
        public static function isLoggedIn() {

                if (isset($_COOKIE['MOVID'])) {
                        if (DB::query('SELECT user_id FROM tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['MOVID'])))) {
                                $userid = DB::query('SELECT user_id FROM tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['MOVID'])))[0]['user_id'];

                                if (isset($_COOKIE['MOVID_'])) {
                                        return $userid;
                                } else {
                                        $cstrong = True;
                                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                        DB::query('INSERT INTO tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$userid));
                                        DB::query('DELETE FROM tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['MOVID'])));

                                        setcookie("MOVID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                                        setcookie("MOVID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                                        return $userid;
                                }
                        }
                }

                return false;
        }
}

?>
