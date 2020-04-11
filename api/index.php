<?php
require_once("DB.php");

$db = new DB("127.0.0.1", "movie", "root", "");

if ($_SERVER['REQUEST_METHOD'] == "GET") {

        if ($_GET['url'] == "movies") {
          
          if (isset($_COOKIE['MOVID']))
          {
             $token = $_COOKIE['MOVID'];
             $userid = $db->query('SELECT user_id FROM tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];     
          }
          else
          {
             $userid = NULL;     
          }
            

          $moviesarray = array();      
          $movies = $db->query('SELECT * FROM movies');
          foreach($movies as $key)
          {
                $movie_rate = $db->query('SELECT sum(rate) from rates WHERE movie_id = :movieid',array(':movieid'=>$key['id']))[0]['sum(rate)'];  
                $movie_count = $db->query('SELECT count(rate) from rates WHERE movie_id = :movieid',array(':movieid'=>$key['id']))[0]['count(rate)'];
                if($userid == null)
                {
                  $movie_user_rate = NULL;
                }
                else
                {
                    $movie_user_rate = $db->query('SELECT rate from rates WHERE movie_id = :movieid AND user_id=:userid',array(':movieid'=>$key['id'],':userid'=>$userid));
                }  
                    
                if($movie_user_rate==null)
                {
                     $aus = "rate";
                }
                else
                {
                    $aus = $movie_user_rate[0]['rate'];
                }
                //$albums_user_rate = $db->query('SELECT score from album_rate WHERE album_id = :albumid AND user_id=:userid',array(':albumid'=>$albums[$i]['id'],':userid'=>$userid))[0]['score'];
                
                if($movie_count == 0)
                {
                    $movie_rate = '0';
                }
                else
                {
                    $movie_rate = $movie_rate/$movie_count;
                    $movie_rate = number_format((float)$movie_rate, 1, '.', ''); 
                    $movie_rate = floatval($movie_rate); 
                } 
                $moviesarray[] = array('id'=>$key['id'],'movie_name'=>$key['movie_name'],'director'=>$key['director'],'writer'=>$key['writer'],'stars'=>$key['stars'],'images'=>$key['images'],'rates'=>$movie_rate,'user_rate'=>$aus,'count'=>$movie_count);
          }
          echo json_encode($moviesarray);
          http_response_code(200);
        } 
        else if ($_GET['url'] == "users") {

        }

} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if ($_GET['url'] == "users") {

                $postBody = file_get_contents("php://input");
                $postBody = json_decode($postBody);

                $username = $postBody->username;
                $email = $postBody->email;
                $password = $postBody->password;


                if (!$db->query('SELECT email FROM users WHERE email = :email', array(':email'=>$email))) {

                        if (strlen($username) >= 3 && strlen($username) <= 64) {

                                if(preg_match("/^([a-zA-Z' ]+)$/",$username)) {

                                        if (strlen($password) >= 6 && strlen($password) <= 60) {

                                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                        if (!$db->query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {

                                                $db->query('INSERT INTO users(name,email,password) VALUES (:username, :email, :password)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));
                                                echo '{ "Success": "User Created" }';
                                                if($db->query('SELECT email FROM users WHERE email=:email',array(':email'=>$email)))
                                                {
                                                    $id = $db->query('SELECT id FROM users WHERE email=:email',array(':email'=>$email))[0]['id'];
                                                    $cstrong = True;
                                                    $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
                                                    $db->query('INSERT INTO tokens(token,user_id) VALUES(:token,:user_id)',array(':token'=>sha1($token),':user_id'=>$id));
                                                    setcookie('MOVID',$token,time()+ 60*60*24*3,'/',NULL,NULL,TRUE);
                                                    setcookie('MOVID_','1',time()+ 60*60*24*3,'/',NULL,NULL,TRUE);
                                                }
                                                else
                                                {
                                                    echo '{ "Error": "ERROR" }';
                                                    http_response_code(401);
                                                }
                                                http_response_code(200);
                                        } else {
                                                echo '{ "Error": "Email in use" }';
                                                http_response_code(409);
                                        }
                                } else {
                                        echo '{ "Error": "Invalid Email" }';
                                        http_response_code(409);
                                        }
                                } else {
                                        echo '{ "Error": "Invalid Password" }';
                                        http_response_code(409);
                                }
                                } else {
                                        echo '{ "Error": "Invalid Username" }';
                                        http_response_code(409);
                                }
                        } else {
                                echo '{ "Error": "Invalid Username" }';
                                http_response_code(409);
                        }

                } else {
                        echo '{ "Error": "User exists!" }';
                        http_response_code(409);
                }


        }

        if ($_GET['url'] == "auth") {
                $postBody = file_get_contents("php://input");
                $postBody = json_decode($postBody);
                
                $email = $postBody->email;
                $password = $postBody->password;
                if($db->query('SELECT email FROM users WHERE email=:email',array(':email'=>$email)))
                {
                 if(password_verify($password,$db->query('SELECT password from users where email=:email',array(':email'=>$email))[0]['password']))
                 {
                     $cstrong = True;
                     $token = bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
                     $user_id = $db->query('SELECT id from users WHERE email=:email',array(':email'=>$email))[0]['id'];
                     $db->query('INSERT INTO tokens(token,user_id) VALUES(:token,:user_id)',array(':token'=>sha1($token),':user_id'=>$user_id));
                     setcookie('MOVID',$token,time()+ 60*60*24*3,'/',NULL,NULL,TRUE);
                     setcookie('MOVID_','1',time()+ 60*60*24*3,'/',NULL,NULL,TRUE);
                     
                 }
                 else
                 {
                     echo '{ "Error": "Invalid username or password!" }';
                     http_response_code(401);
                 }
                }
                else
                {
                    echo '{ "Error": "Invalid username or password!" }';
                    http_response_code(401);
                }

        }
        else if($_GET['url'] == 'rates')
        {
            $token = $_COOKIE['MOVID'];
            $userid = $db->query('SELECT user_id FROM tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
            $movid = $_GET['id'];
            //$artist_id = $db->query('SELECT artist_id FROM albums WHERE id=:id',array(':id'=>$albid))[0]['artist_id'];
            $value = $_GET['value'];
            
            if(!$db->query('SELECT user_id FROM rates WHERE user_id=:userid AND movie_id = :movieid',array(":userid"=>$userid,":movieid"=>$movid)))
            {
                
                $db->query('INSERT INTO rates VALUES(\'\',:movieid,:userid,:score)',array(':userid'=>$userid,':movieid'=>$movid,":score"=>$value));
                $newvalue = $db->query('SELECT rate from rates WHERE user_id=:userid AND movie_id = :movieid',array(':userid'=>$userid,':movieid'=>$movid))[0]['rate'];
                $movierates = $db->query('SELECT sum(rate)/count(rate) AS rate from rates WHERE movie_id = :movieid',array(':movieid'=>$movid))[0]['rate'];
                $movierates = number_format((float)$movierates, 1, '.', '');
                if(($movierates == intval($movierates)))
                {
                $movierates = number_format((float)$movierates, 0, '.', '');
                } 
            }
            else
            {
               $oldvalue = $db->query('SELECT rate from rates WHERE user_id=:userid AND movie_id = :movieid',array(':userid'=>$userid,':movieid'=>$movid))[0]['rate'];
               if($value != $oldvalue )
               {
                $db->query('UPDATE rates SET rate=:rate WHERE movie_id=:movieid AND user_id = :userid',array(':rate'=>$value,':movieid'=>$movid,':userid'=>$userid));
               }
               $newvalue = $db->query('SELECT rate from rates WHERE user_id=:userid AND movie_id = :movieid',array(':userid'=>$userid,':movieid'=>$movid))[0]['rate'];
               $movierates = $db->query('SELECT sum(rate)/count(rate) AS rate from rates WHERE movie_id = :movieid',array(':movieid'=>$movid))[0]['rate'];
               $movierates = number_format((float)$movierates, 1, '.', '');
               if(($movierates == intval($movierates)))
               {
                $movierates = number_format((float)$movierates, 0, '.', '');
               } 
            }
            $count = $db->query('SELECT count(rate) AS rate from rates WHERE movie_id = :movieid',array(':movieid'=>$movid))[0]['rate'];
                  
                          
    
                http_response_code(200);
                echo "{";
                echo '"id":';
                echo "\"$movid\"";
                echo ",";
                echo '"value":';
                echo "\"$newvalue\"";
                echo ",";
                echo '"movievalue":';
                echo "\"$movierates\"";
                echo ",";
                echo '"count":';
                echo "\"$count\"";
                echo "}";
        }
        else if($_GET['url'] == 'remove')
    {
        $token = $_COOKIE['MOVID'];
        $userid = $db->query('SELECT user_id FROM tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
        $movid = $_GET['id'];
        if(!$db->query('SELECT user_id FROM rates WHERE user_id=:userid AND movie_id = :movieid',array(":userid"=>$userid,":movieid"=>$movid)))
        {
            http_response_code(409); 
        }
        else
        {
           $db->query('DELETE FROM rates WHERE user_id=:userid AND movie_id=:movieid',array(':movieid'=>$movid,':userid'=>$userid));
           $movie_rates = $db->query('SELECT sum(rate)/count(rate) AS rate from rates WHERE movie_id = :movieid',array(':movieid'=>$movid))[0]['rate'];
           $movie_rates = number_format((float)$movie_rates, 1, '.', '');
           if(($movie_rates == intval($movie_rates)))
           {
            $movie_rates = number_format((float)$movie_rates, 0, '.', '');
           }
            
           
            http_response_code(200);
            echo "{";
            echo '"id":';
            echo "\"$movid\"";
            echo ",";
            echo '"movievalue":';
            echo "\"$movie_rates\"";
            echo "}";        

        }
            
    }

}  else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
        if ($_GET['url'] == "logout") {
            
                $token = $_COOKIE['MOVID'];
                $user_id = $db->query('SELECT user_id FROM tokens WHERE token=:token', array(':token'=>sha1($token)))[0]['user_id'];
                    if (isset($_COOKIE['MOVID'])){
                            
                        if ($db->query("SELECT token FROM tokens WHERE token=:token", array(':token'=>sha1($token)))) {
                            $db->query('DELETE FROM tokens WHERE token=:token', array(':token'=>sha1($token)));
                            echo '{ "Status": "Success" }';
                            http_response_code(200);
                        } 
                        else 
                        {
                            echo '{ "Error": "Invalid token" }';
                            http_response_code(400);
                        }
                            
                            
                            
                    } else {
                            echo '{ "Error": "Malformed request" }';
                            http_response_code(400);
                    }
                    setcookie('MOVID', null, -1, '/'); 
                    setcookie('MOVID_', null, -1, '/');
                    
            }
        }
else {
        http_response_code(405);
}
?>