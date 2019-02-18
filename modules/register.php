<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php_mailer/src/Exception.php';
require 'php_mailer/src/PHPMailer.php';
require 'php_mailer/src/SMTP.php';

require_once "konekcija.php";
header("Content-type: application/json");
$code = 404;
$data = null;

if (isset($_POST['success'])):
    $nizGreske = [];

    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $tel = $_POST['tel'];
    $city = $_POST['city'];

    $regIme = "/^[A-ZŽĐŠĆČ][a-zžđšćč]{1,19}$/";
    $regPrezime = "/^[A-ZŽĐŠĆČ][a-zžđšćč]{1,19}(\s[A-ZŽĐŠĆČ][a-zžđšćč]{1,19})*$/";
    $regPassord = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/";
    $regEmail = "/^.{1,30}\@.{2,10}\..{1,5}$/";
    $regTel = "/^[+][\d]{0,3}\/[\d]{4,7}\-[\d]{3}$/";

    if(!preg_match($regIme, $ime)):
        array_push($nizGreske, "Ime nije ok.");
    endif;
    if(!preg_match($regPrezime, $prezime)):
        array_push($nizGreske, "Prezime nije ok.");
    endif;
    if(!preg_match($regPassord, $pass)):
        array_push($nizGreske, "Password ime nije ok.");
    endif;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        array_push($nizGreske, "Email nije ok.");
    endif;
    if(!preg_match($regTel, $tel)):
        array_push($nizGreske, "Tel nije ok.");
    endif;

    if (count($nizGreske) > 0):
        $code = 404;
        $data = $nizGreske;
        else:
        $upit = "INSERT INTO `korisnik`(`id`, `ime`, `prezime`, `email`, `password`, `kontakt`, `grad`, `vremeRegistracije`, `aktivan`, `token`, `uloga_id`) 
VALUES ('', :ime, :prezime, :email, :pass, :tel, :city, :vreme, :aktivan, :token, :uloga)";
        $prepare = $konekcija->prepare($upit);
        $prepare->bindParam(':ime', $ime);
        $prepare->bindParam(':prezime', $prezime);
        $prepare->bindParam(':email', $email);
        $pass = md5($pass);
        $prepare->bindParam(':pass', $pass);
        $prepare->bindParam(':tel', $tel);
        $prepare->bindParam(':city', $city);
        $vreme = time();
        $prepare->bindParam(':vreme', $vreme);
        $aktivan = 0;
        $prepare->bindParam(':aktivan', $aktivan);
        $token = md5(time().rand().$email);
        $prepare->bindParam(':token', $token);
        $uloga = 2;
        $prepare->bindParam(':uloga', $uloga);
            try{
                $code = ($prepare->execute())? 201 : 500;

                if($code == 201):
                    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                    try {
                        //Server settings
                    $mail->SMTPDebug = 2;
                        $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );                                          // Enable verbose debug output
                        $mail->isSMTP();                                      // Set mailer to use SMTP
                        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                        $mail->Username = 'php2sajt1@gmail.com';                 // SMTP username
                        $mail->Password = 'u259Ae8R';                           // SMTP password
                        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                        $mail->Port = 587;                                    // TCP port to connect to

                        //Recipients
                        $mail->setFrom('phpSajt13616ict2018@gmail.com', 'Filip Amanovic');
                        $mail->addAddress($email, "Fica");     // Add a recipient
                        // $mail->addAddress('ellen@example.com');               // Name is optional
                        // $mail->addReplyTo('info@example.com', 'Information');
                        // $mail->addCC('cc@example.com');
                        // $mail->addBCC('bcc@example.com');

                        //Attachments
                        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                        //Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Registracija';
                        $mail->Body    = 'Verifikacija mejla: <a href="http://localhost:8080/php2sajt1/modules/verifikacijaMail.php?abc='.$token.'">LINK VERIFIKACIJE</a>';
                        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                        $mail->send();

                        // echo 'Message has been sent';
                        $code = 200;
                        $data = "Uspesna registracija.";

                    } catch (Exception $e) {
//                        $code = 500;
//                        $data = $mail->ErrorInfo;
                    }
                endif;

            }catch (PDOException $e){
//                $code = 409;
//                $data = $e->getMessage();
            }
    endif;

endif;
http_response_code($code);
echo json_encode($data);
?>