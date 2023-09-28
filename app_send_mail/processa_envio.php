<?php

    require "./bibliotecas/PHPMailer/Exception.php";
    require "./bibliotecas/PHPMailer/OAuth.php";
    require "./bibliotecas/PHPMailer/PHPMailer.php";
    require "./bibliotecas/PHPMailer/POP3.php";
    require "./bibliotecas/PHPMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //print_r($_POST);

    class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function mensagemValida() {
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
                return false;
            }
            return true;
        }
    }

    $mensagem = new Mensagem();
    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    //print_r($mensagem);

    if(!$mensagem->mensagemValida()) {
        echo 'Mensagem não é válida';
        die(); //mata todo o processamento adiante
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 2;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com ';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'kerrym877@gmail.com';                     //SMTP username
        $mail->Password   = 'lelluzmzppcfelzl';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('kerrym877@gmail.com', 'Kerry Teste Remetente');
        $mail->addAddress('kerrym877@gmail.com', 'Kerry Teste Destinatário');     //Add a recipient
        //$mail->addReplyTo('info@example.com', 'Information'); -> Método que decide pra quem é enviada a resposta do email enviado
        //$mail->addCC('cc@example.com'); -> Método que adiciona destinatários de cópia
        //$mail->addBCC('bcc@example.com'); -> Método que é a cópia oculta

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Oi. Eu sou o assunto';
        $mail->Body    = 'Oi. Eu sou o conteúdo do <strong>e-mail</strong>.'; //o 'Body' suporta tags em html!
        $mail->AltBody = 'Oi. Eu sou o conteúdo do e-mail.';

        $mail->send();
        echo 'Message has been sent';
        } catch (Exception $e) {
        echo "Não foi possível enviar este e-mail! Por favor tente novamente mais tarde.";
        echo "Detalhes do erro: {$mail->ErrorInfo}";
    }

?>