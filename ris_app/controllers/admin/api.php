<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');



class api extends CI_Controller {

    //php -f /home/rootigfk/public_html/labs/ris/index.php cron/test
    function __construct() {
        parent::__construct();
    }

    public function trackMailHit($id) {
	$array = array();
	$array['mail_id'] = $id;
	$array['server_detail'] = serialize($_SERVER);
	$array['date_time'] = strtotime(date('Y-m-d H:i:s'));
	$this->db->insert('mail_track', $array);
	
	return 'http://rootitsolutions.com/images/logo.png';
    }
    
    public function sendmail(){
    	$body = '<html xmlns="http://www.w3.org/1999/xhtml"><head>

</head>
<body style="margin: 0;mso-line-height-rule: exactly;padding: 0;min-width: 100%;background-color: #3ac2c4">
<style type="text/css">
</style>
    <center class="wrapper" style="display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #3ac2c4">
    	<table class="gmail" style="border-collapse: collapse;border-spacing: 0;width: 650px;min-width: 650px"><tbody><tr><td style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px">&nbsp;</td></tr></tbody></table>
      <table class="header centered" style="border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 602px">
        <tbody><tr><td class="border" style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px">&nbsp;</td></tr>
        <tr><td class="logo" style="padding: 32px 0;vertical-align: top;mso-line-height-rule: at-least;font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif"><div class="logo-center" style="text-align: center" align="center" id="emb-email-header"><img style="border: 0;-ms-interpolation-mode: bicubic;display: block;Margin-left: auto;Margin-right: auto;max-width: 300px" src="http://labs.rootitsolutions.com/ris/api/track_mail/1" alt="" width="200" height="80"></div></td></tr>
      </tbody></table>
      
          <table class="border" style="border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #e9e9e9;Margin-left: auto;Margin-right: auto" width="602">
            <tbody><tr><td style="padding: 0;vertical-align: top">​</td></tr>
          </tbody></table>
        
          <table class="centered" style="border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto">
            <tbody><tr>
              <td class="border" style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px">​</td>
              <td style="padding: 0;vertical-align: top">
                <table class="one-col" style="border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 600px;background-color: #ffffff;font-size: 14px">
                  <tbody><tr>
                    <td class="column" style="padding: 0;vertical-align: top;text-align: left">
                      <div><div class="column-top" style="font-size: 32px;line-height: 32px">&nbsp;</div></div>
                        <table class="contents" style="border-collapse: collapse;border-spacing: 0;width: 100%">
                          <tbody><tr>
                            <td class="padded" style="padding: 0;vertical-align: top;padding-left: 32px;padding-right: 16px">
						<h1>You Won 1 Core $</h1>
                            </td>
                          </tr>
                        </tbody></table>
                      
                      <div class="column-bottom" style="font-size: 8px;line-height: 8px">&nbsp;</div>
                    </td>
                  </tr>
                </tbody></table>
              </td>
              <td class="border" style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px">​</td>
            </tr>
          </tbody></table>
        
          <table class="border" style="border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #e9e9e9;Margin-left: auto;Margin-right: auto" width="602">
            <tbody><tr><td style="padding: 0;vertical-align: top">​</td></tr>
          </tbody></table>
        
      <div class="spacer" style="font-size: 1px;line-height: 32px;width: 100%">&nbsp;</div>
      <table class="footer centered" style="border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 602px">
        <tbody><tr>
          <td class="social" style="padding: 0;vertical-align: top;padding-top: 32px;padding-bottom: 22px" align="center">
            <table style="border-collapse: collapse;border-spacing: 0">
              <tbody>
              <tr>
                <td class="social-link" style="padding: 0;vertical-align: top">
                  <table style="border-collapse: collapse;border-spacing: 0">
                    <tbody><tr>
                      <td style="padding: 0;vertical-align: top">
                        
                      </td>
                      <td class="social-text" style="padding: 0;vertical-align: middle !important;height: 21px;font-size: 10px;font-weight: bold;text-decoration: none;text-transform: uppercase;color: #ffffff;letter-spacing: 0.05em;font-family: Georgia,serif">
                        <a style="text-decoration: none;transition: all .2s;color: #ffffff;letter-spacing: 0.05em;font-family: Georgia,serif" href="#">
                        	Please do not reply to this message. Replies to this message are routed to an unmonitored mailbox.
                        </a>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
        <tr><td class="border" style="padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px">&nbsp;</td></tr>
      </tbody></table>
    </center>
</body></html>';
 	$option['tomailid'] = 'siddhrajraulji@yopmail.com';
        $option['subject'] = 'Testing';
        $option['message'] = $body;
        send_mail($option);
    } 


}

?>