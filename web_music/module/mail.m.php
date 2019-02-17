<?php
/**
* �ʼ�������
* ֧�ַ��ʹ��ı��ʼ���HTML��ʽ���ʼ������Զ��ռ��ˣ��೭�ͣ������ܳ��ͣ�������(������������),֧�ֵ���������ssl����
* ��Ҫ��php��չ��sockets��Fileinfo��openssl��
* �����ʽ��UTF-8����������ʽ��base64
* @example
      $mail = new PzhMail();
      $mail->setServer("smtp.163.com", "sohn@163.com", "asdffdsa",465,true,true); //����smtp������������������SSL����
      $mail->setFrom("sohn@163.com"); //���÷�����
      $mail->setReceiver("hzh.888@qq.com"); //�����ռ��ˣ�����ռ��ˣ����ö��
      //$mail->setCc(""); //���ó��ͣ�������ͣ����ö��
      //$mail->setBcc(""); //�������ܳ��ͣ�������ܳ��ͣ����ö��
      //$mail->addAttachment(""); //��Ӹ�����������������ö��
      $mail->setMail("test", "<b>test</b>"); //�����ʼ����⡢����
      $mail->sendMail(); //����
*/
class PzhMail {
    /**
    * @var string �ʼ���������û���
    * @access protected
    */
    protected $_userName;
 
    /**
    * @var string �ʼ������������
    * @access protected
    */
    protected $_password;
 
    /**
    * @var string �ʼ���������������ַ
    * @access protected
    */
    protected $_sendServer;
 
    /**
    * @var int �ʼ��������������˿�
    * @access protected
    */
    protected $_port;
 
    /**
    * @var string ������
    * @access protected
    */
    protected $_from;
 
    /**
    * @var array �ռ���
    * @access protected
    */
    protected $_to = array();
 
    /**
    * @var array ����
    * @access protected
    */
    protected $_cc = array();
 
    /**
    * @var array ���ܳ���
    * @access protected
    */
    protected $_bcc = array();
 
    /**
    * @var string ����
    * @access protected
    */
    protected $_subject;
 
    /**
    * @var string �ʼ�����
    * @access protected
    */
    protected $_body;
 
    /**
    * @var array ����
    * @access protected
    */
    protected $_attachment = array();
 
    /**
    * @var reource socket��Դ
    * @access protected
    */
    protected $_socket;
 
    /**
    * @var reource �Ƿ��ǰ�ȫ����
    * @access protected
    */
    protected $_isSecurity;
 
    /**
    * @var string ������Ϣ
    * @access protected
    */
    protected $_errorMessage;
    
    protected $_debug;
 
 
    /**
    * �����ʼ������������ǿ��������������ʼ��ķ�������ֻ�贫�ݴ����������ַ����
    * @access public
    * @param string $server �����������ip��������
    * @param string $username ��֤�˺�
    * @param string $password ��֤����
    * @param int $port ����������Ķ˿ڣ�smtpĬ��25�Ŷ˿�
    * @param boolean $isSecurity ���������������Ƿ�Ϊ��ȫ���ӣ�Ĭ��false
    * @return boolean
    */
    public function setServer($server, $username="", $password="", $port=25,$security=false ,$debug=false) {
        $this->_sendServer = $server;
        $this->_port = $port;
        $this->_isSecurity = $security;
        $this->_userName = empty($username) ? "" : base64_encode($username);
        $this->_password = empty($password) ? "" : base64_encode($password);
        $this->_debug=$debug;
        return true;
    }
 
    /**
    * ���÷�����
    * @access public
    * @param string $from �����˵�ַ
    * @return boolean
    */
    public function setFrom($from) {
        $this->_from = $from;
        return true;
    }
 
    /**
    * �����ռ��ˣ�����ռ��ˣ����ö��.
    * @access public
    * @param string $to �ռ��˵�ַ
    * @return boolean
    */
    public function setReceiver($to) {
        $this->_to[] = $to;
        return true;
    }
 
    /**
    * ���ó��ͣ�������ͣ����ö��.
    * @access public
    * @param string $cc ���͵�ַ
    * @return boolean
    */
    public function setCc($cc) {
        $this->_cc[] = $cc;
        return true;
    }
 
    /**
    * �������ܳ��ͣ�������ܳ��ͣ����ö��
    * @access public
    * @param string $bcc ���ܳ��͵�ַ
    * @return boolean
    */
    public function setBcc($bcc) {
        $this->_bcc[] = $bcc;
        return true;
    }
 
    /**
    * �����ʼ�������������������ö��
    * @access public
    * @param string $file �ļ���ַ
    * @return boolean
    */
    public function addAttachment($file) {
        if(!file_exists($file)) {
            $this->_errorMessage = "file " . $file . " does not exist.";
            return false;
        }
        $this->_attachment[] = $file;
        return true;
    }
 
    /**
    * �����ʼ���Ϣ
    * @access public
    * @param string $body �ʼ�����
    * @param string $subject �ʼ��������ݣ������Ǵ��ı���Ҳ������HTML�ı�
    * @return boolean
    */
    public function setMail($subject, $body) {
        $this->_subject = base64_encode($subject);
        $this->_body = base64_encode($body);
        return true;
    }
 
    /**
    * �����ʼ�
    * @access public
    * @return boolean
    */
    public function sendMail() {
        $command = $this->getCommand();
 
        $this->_isSecurity ? $this->socketSecurity() : $this->socket();
        
        //���뵱ǰ����
        if($this->_debug)
        {
          var_dump($command);
        }
        foreach ($command as $value) {
            $result = $this->_isSecurity ? $this->sendCommandSecurity($value[0], $value[1]) : $this->sendCommand($value[0], $value[1]);
            if($result) {
                continue;
            }
            else{
                return false;
            }
        }
         
        //��ʵ����Ҳû��Ҫ�رգ�smtp���QUIT����֮�󣬷������͹ر������ӣ����ص�socket��Դ���Զ��ͷ�
        $this->_isSecurity ? $this->closeSecutity() : $this->close();
        return true;
    }
 
    /**
    * ���ش�����Ϣ
    * @return string
    */
    public function error(){
        if(!isset($this->_errorMessage)) {
            $this->_errorMessage = "";
        }
        return $this->_errorMessage;
    }
 
    /**
    * ����mail����
    * @access protected
    * @return array
    */
    protected function getCommand() {
        $separator = "----=_Part_" . md5($this->_from . time()) . uniqid(); //�ָ���
 
        $command = array(
                array("HELO sendmail\r\n", 250)
            );
        if(!empty($this->_userName)){
            $command[] = array("AUTH LOGIN\r\n", 334);
            $command[] = array($this->_userName . "\r\n", 334);
            $command[] = array($this->_password . "\r\n", 235);
        }
 
        //���÷�����
        $command[] = array("MAIL FROM: <" . $this->_from . ">\r\n", 250);
        $header = "FROM: <" . $this->_from . ">\r\n";
 
        //�����ռ���
        if(!empty($this->_to)) {
            $count = count($this->_to);
            if($count == 1){
                $command[] = array("RCPT TO: <" . $this->_to[0] . ">\r\n", 250);
                $header .= "TO: <" . $this->_to[0] .">\r\n";
            }
            else{
                for($i=0; $i<$count; $i++){
                    $command[] = array("RCPT TO: <" . $this->_to[$i] . ">\r\n", 250);
                    if($i == 0){
                        $header .= "TO: <" . $this->_to[$i] .">";
                    }
                    elseif($i + 1 == $count){
                        $header .= ",<" . $this->_to[$i] .">\r\n";
                    }
                    else{
                        $header .= ",<" . $this->_to[$i] .">";
                    }
                }
            }
        }
 
        //���ó���
        if(!empty($this->_cc)) {
            $count = count($this->_cc);
            if($count == 1){
                $command[] = array("RCPT TO: <" . $this->_cc[0] . ">\r\n", 250);
                $header .= "CC: <" . $this->_cc[0] .">\r\n";
            }
            else{
                for($i=0; $i<$count; $i++){
                    $command[] = array("RCPT TO: <" . $this->_cc[$i] . ">\r\n", 250);
                    if($i == 0){
                    $header .= "CC: <" . $this->_cc[$i] .">";
                    }
                    elseif($i + 1 == $count){
                        $header .= ",<" . $this->_cc[$i] .">\r\n";
                    }
                    else{
                        $header .= ",<" . $this->_cc[$i] .">";
                    }
                }
            }
        }
 
        //�������ܳ���
        if(!empty($this->_bcc)) {
            $count = count($this->_bcc);
            if($count == 1) {
                $command[] = array("RCPT TO: <" . $this->_bcc[0] . ">\r\n", 250);
                $header .= "BCC: <" . $this->_bcc[0] .">\r\n";
            }
            else{
                for($i=0; $i<$count; $i++){
                    $command[] = array("RCPT TO: <" . $this->_bcc[$i] . ">\r\n", 250);
                    if($i == 0){
                    $header .= "BCC: <" . $this->_bcc[$i] .">";
                    }
                    elseif($i + 1 == $count){
                        $header .= ",<" . $this->_bcc[$i] .">\r\n";
                    }
                    else{
                        $header .= ",<" . $this->_bcc[$i] .">";
                    }
                }
            }
        }
 
        //����
        $header .= "Subject: =?UTF-8?B?" . $this->_subject ."?=\r\n";
        if(isset($this->_attachment)) {
            //���и������ʼ�ͷ��Ҫ���������
            $header .= "Content-Type: multipart/mixed;\r\n";
        }
        elseif(false){
            //�ʼ��庬��ͼƬ��Դ��,�Ұ�����ͼƬ���ʼ��ڲ�ʱ�������������������õ�Զ��ͼƬ���Ͳ���Ҫ��
            $header .= "Content-Type: multipart/related;\r\n";
        }
        else{
            //html���ߴ��ı����ʼ����������
            $header .= "Content-Type: multipart/alternative;\r\n";
        }
 
        //�ʼ�ͷ�ָ���
        $header .= "\t" . 'boundary="' . $separator . '"';
 
        $header .= "\r\nMIME-Version: 1.0\r\n";
 
        //���￪ʼ���ʼ���body���֣�body���ֳַɼ��η���
        $header .= "\r\n--" . $separator . "\r\n";
        $header .= "Content-Type:text/html; charset=utf-8\r\n";
        $header .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $header .= $this->_body . "\r\n";
        $header .= "--" . $separator . "\r\n";
 
        //���븽��
        if(!empty($this->_attachment)){
            $count = count($this->_attachment);
            for($i=0; $i<$count; $i++){
                $header .= "\r\n--" . $separator . "\r\n";
                $header .= "Content-Type: " . $this->getMIMEType($this->_attachment[$i]) . '; name="=?UTF-8?B?' . base64_encode( basename($this->_attachment[$i]) ) . '?="' . "\r\n";
                $header .= "Content-Transfer-Encoding: base64\r\n";
                $header .= 'Content-Disposition: attachment; filename="=?UTF-8?B?' . base64_encode( basename($this->_attachment[$i]) ) . '?="' . "\r\n";
                $header .= "\r\n";
                $header .= $this->readFile($this->_attachment[$i]);
                $header .= "\r\n--" . $separator . "\r\n";
            }
        }
 
        //�����ʼ����ݷ���
        $header .= "\r\n.\r\n";
 
 
        $command[] = array("DATA\r\n", 354);
        $command[] = array($header, 250);
        $command[] = array("QUIT\r\n", 221);
         
        return $command;
    }
 
    /**
    * ��������
    * @access protected
    * @param string $command ���͵���������smtp����
    * @param int $code �������������ص���Ӧ��
    * @return boolean
    */
    protected function sendCommand($command, $code) {
    
        if($this->_debug)
        {
          echo 'Send command:' . $command . ',expected code:' . $code . '<br />';
        }
        //���������������
        try{
            if(socket_write($this->_socket, $command, strlen($command))){
 
                //���ʼ����ݷֶ�η���ʱ��û��$code��������û�з���
                if(empty($code))  {
                    return true;
                }
 
                //��ȡ����������
                $data = trim(socket_read($this->_socket, 1024));
                
                if($this->_debug)
                {
                  echo 'response:' . $data . '<br /><br />';
                }
                if($data) {
                    $pattern = "/^".$code."+?/";
                    if(preg_match($pattern, $data)) {
                        return true;
                    }
                    else{
                        $this->_errorMessage = "Error:" . $data . "|**| command:";
                        return false;
                    }
                }
                else{
                    $this->_errorMessage = "Error:" . socket_strerror(socket_last_error());
                    return false;
                }
            }
            else{
                $this->_errorMessage = "Error:" . socket_strerror(socket_last_error());
                return false;
            }
        }catch(Exception $e) {
            $this->_errorMessage = "Error:" . $e->getMessage();
        }
    }
 
    /**
    * ��ȫ���ӷ�������
    * @access protected
    * @param string $command ���͵���������smtp����
    * @param int $code �������������ص���Ӧ��
    * @return boolean
    */
    protected function sendCommandSecurity($command, $code) {
        if($this->_debug)
        {
            echo 'Send command:' . $command . ',expected code:' . $code . '<br />';
        }
        try {
            if(fwrite($this->_socket, $command)){
                //���ʼ����ݷֶ�η���ʱ��û��$code��������û�з���
                if(empty($code))  {
                    return true;
                }
                //��ȡ����������
                $data = trim(fread($this->_socket, 1024));
                if($this->_debug)
                {
                  echo 'response:' . $data . '<br /><br />';
                }
                if($data) {
                    $pattern = "/^".$code."+?/";
                    if(preg_match($pattern, $data)) {
                        return true;
                    }
                    else{
                        $this->_errorMessage = "Error:" . $data . "|**| command:";
                        return false;
                    }
                }
                else{
                    return false;
                }
            }
            else{
                $this->_errorMessage = "Error: " . $command . " send failed";
                return false;
            }
        }catch(Exception $e) {
            $this->_errorMessage = "Error:" . $e->getMessage();
        }
    } 
 
    /**
    * ��ȡ�����ļ����ݣ�����base64�������ļ�����
    * @access protected
    * @param string $file �ļ�
    * @return mixed
    */
    protected function readFile($file) {
        if(file_exists($file)) {
            $file_obj = file_get_contents($file);
            return base64_encode($file_obj);
        }
        else {
            $this->_errorMessage = "file " . $file . " dose not exist";
            return false;
        }
    }
 
    /**
    * ��ȡ����MIME����
    * @access protected
    * @param string $file �ļ�
    * @return mixed
    */
    protected function getMIMEType($file) {
        if(file_exists($file)) {
            $mime = mime_content_type($file);
            /*if(! preg_match("/gif|jpg|png|jpeg/", $mime)){
                $mime = "application/octet-stream";
            }*/
            return $mime;
        }
        else {
            return false;
        }
    }
 
    /**
    * ����������������������
    * @access protected
    * @return boolean
    */
    protected function socket() {
        //����socket��Դ
        $this->_socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
         
        if(!$this->_socket) {
            $this->_errorMessage = socket_strerror(socket_last_error());
            return false;
        }
 
        socket_set_block($this->_socket);//��������ģʽ
 
        //���ӷ�����
        if(!socket_connect($this->_socket, $this->_sendServer, $this->_port)) {
            $this->_errorMessage = socket_strerror(socket_last_error());
            return false;
        }
        $str = socket_read($this->_socket, 1024);
        if(!preg_match("/220+?/", $str)){
            $this->_errorMessage = $str;
            return false;
        }
         
        return true;
    }
 
    /**
    * ��������������SSL��������
    * @access protected
    * @return boolean
    */
    protected function socketSecurity() {
        $remoteAddr = "tcp://" . $this->_sendServer . ":" . $this->_port;
        $this->_socket = stream_socket_client($remoteAddr, $errno, $errstr, 30);
        if(!$this->_socket){
            $this->_errorMessage = $errstr;
            return false;
        }
 
        //���ü������ӣ�Ĭ����ssl�������Ҫtls���ӣ����Բ鿴php�ֲ�stream_socket_enable_crypto�����Ľ���
        stream_socket_enable_crypto($this->_socket, true, STREAM_CRYPTO_METHOD_SSLv23_CLIENT);
 
        stream_set_blocking($this->_socket, 1); //��������ģʽ
        $str = fread($this->_socket, 1024);
        if(!preg_match("/220+?/", $str)){
            $this->_errorMessage = $str;
            return false;
        }
 
        return true;
    }
 
    /**
    * �ر�socket
    * @access protected
    * @return boolean
    */
    protected function close() {
        if(isset($this->_socket) && is_object($this->_socket)) {
            $this->_socket->close();
            return true;
        }
        $this->_errorMessage = "No resource can to be close";
        return false;
    }
 
    /**
    * �رհ�ȫsocket
    * @access protected
    * @return boolean
    */
    protected function closeSecutity() {
        if(isset($this->_socket) && is_object($this->_socket)) {
            stream_socket_shutdown($this->_socket, STREAM_SHUT_WR);
            return true;
        }
        $this->_errorMessage = "No resource can to be close";
        return false;
    }
}
