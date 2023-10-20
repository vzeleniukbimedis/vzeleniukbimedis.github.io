<?php

// Include the Composer autoload
require 'vendor/autoload.php';

// Import the PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Turn on error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Your webhook URL for Bitrix24
$webhookUrl = 'https://nbx.bimedis.net/rest/479/n4831ktzqumqih8m/';
$dealId = $_GET['deal_id'];

if (!$dealId) {
    die('Please provide a deal ID.');
}

// 1. Fetch deal data
$dealData = file_get_contents($webhookUrl . 'crm.deal.get?ID=' . $dealId);
$dealData = json_decode($dealData, true);

if (isset($dealData['error'])) {
    die('Error fetching deal data: ' . $dealData['error_description']);
}

// 2. Fetch contact name and email
$contactId = $dealData['result']['CONTACT_ID'];
$contactData = file_get_contents($webhookUrl . 'crm.contact.get?ID=' . $contactId);
$contactData = json_decode($contactData, true);

if (isset($contactData['error'])) {
    die('Error fetching contact data: ' . $contactData['error_description']);
}

$contactName = $contactData['result']['NAME'];
$email = $contactData['result']['EMAIL'][0]['VALUE']; // Assuming first email is what you want

// 3. Fetch creation date of the deal
$dateCreated = $dealData['result']['DATE_CREATE'];

// Fetch product rows
$result = file_get_contents($webhookUrl . 'crm.deal.productrows.get?ID=' . $dealId);
$result = json_decode($result, true);

if (isset($result['error'])) {
    die('Error: ' . $result['error_description']);
}

$productNames = [];
if (!empty($result['result'])) {
    foreach ($result['result'] as $product) {
        if (!preg_match('/[а-яёА-ЯЁ]/u', $product['PRODUCT_NAME'])) {
            $productNames[] = $product['PRODUCT_NAME'];
        }
    }
}

$productsString = implode(' > ', $productNames);

// Your HTML code here
$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="RU">
 <head>
  <title>Новый шаблон</title>
  <style type="text/css">
.rollover:hover .rollover-first {
  max-height:0px!important;
  display:none!important;
  }
  .rollover:hover .rollover-second {
  max-height:none!important;
  display:inline-block!important;
  }
  .rollover div {
  font-size:0px;
  }
  u + .body img ~ div div {
  display:none;
  }
  #outlook a {
  padding:0;
  }
  span.MsoHyperlink,
span.MsoHyperlinkFollowed {
  color:inherit;
  mso-style-priority:99;
  }
  a.es-button {
  mso-style-priority:100!important;
  text-decoration:none!important;
  }
  a[x-apple-data-detectors] {
  color:inherit!important;
  text-decoration:none!important;
  font-size:inherit!important;
  font-family:inherit!important;
  font-weight:inherit!important;
  line-height:inherit!important;
  }
  .es-desk-hidden {
  display:none;
  float:left;
  overflow:hidden;
  width:0;
  max-height:0;
  line-height:0;
  mso-hide:all;
  }
  .es-button-border:hover > a.es-button {
  color:#ffffff!important;
  }
@media only screen and (max-width:600px) {.es-m-p25t { padding-top:25px!important } .es-m-p20b { padding-bottom:20px!important } .es-m-p0r { padding-right:0px!important } .es-m-p20b { padding-bottom:20px!important } *[class="gmail-fix"] { display:none!important } p, a { line-height:150%!important } h1, h1 a { line-height:120%!important } h2, h2 a { line-height:120%!important } h3, h3 a { line-height:120%!important } h4, h4 a { line-height:120%!important } h5, h5 a { line-height:120%!important } h6, h6 a { line-height:120%!important } h1 { font-size:30px!important; text-align:left } h2 { font-size:24px!important; text-align:left } h3 { font-size:20px!important; text-align:left } h4 { font-size:24px!important; text-align:left } h5 { font-size:20px!important; text-align:left } h6 { font-size:16px!important; text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px!important } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:24px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important } .es-header-body h4 a, .es-content-body h4 a, .es-footer-body h4 a { font-size:24px!important } .es-header-body h5 a, .es-content-body h5 a, .es-footer-body h5 a { font-size:20px!important } .es-header-body h6 a, .es-content-body h6 a, .es-footer-body h6 a { font-size:16px!important } .es-menu td a { font-size:14px!important } .es-header-body p, .es-header-body a { font-size:14px!important } .es-content-body p, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body a { font-size:14px!important } .es-infoblock p, .es-infoblock a { font-size:12px!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3, .es-m-txt-c h4, .es-m-txt-c h5, .es-m-txt-c h6 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3, .es-m-txt-r h4, .es-m-txt-r h5, .es-m-txt-r h6 { text-align:right!important } .es-m-txt-j, .es-m-txt-j h1, .es-m-txt-j h2, .es-m-txt-j h3, .es-m-txt-j h4, .es-m-txt-j h5, .es-m-txt-j h6 { text-align:justify!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3, .es-m-txt-l h4, .es-m-txt-l h5, .es-m-txt-l h6 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-m-txt-r .rollover:hover .rollover-second, .es-m-txt-c .rollover:hover .rollover-second, .es-m-txt-l .rollover:hover .rollover-second { display:inline!important } .es-m-txt-r .rollover div, .es-m-txt-c .rollover div, .es-m-txt-l .rollover div { line-height:0!important; font-size:0!important } .es-spacer { display:inline-table } a.es-button, button.es-button { font-size:18px!important; line-height:120%!important } a.es-button, button.es-button, .es-button-border { display:inline-block!important } .es-m-fw, .es-m-fw.es-fw, .es-m-fw .es-button { display:block!important } .es-m-il, .es-m-il .es-button, .es-social, .es-social td, .es-menu { display:inline-block!important } .es-adaptive table, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .adapt-img { width:100%!important; height:auto!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } .es-social td { padding-bottom:10px } .h-auto { height:auto!important } }
</style>
 </head>
 <body style="width:100%;height:100%;padding:0;Margin:0">
  <div class="es-wrapper-color" lang="RU" style="background-color:#F6F6F6"><!--[if gte mso 9]>
			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
				<v:fill type="tile" color="#f6f6f6"></v:fill>
			</v:background>
		<![endif]-->
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#F6F6F6">
     <tr>
      <td valign="top" style="padding:0;Margin:0">
       <table cellpadding="0" cellspacing="0" class="es-content" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
         <tr>
          <td align="center" bgcolor="#fafafa" style="padding:0;Margin:0;background-color:#fafafa">
           <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" role="none">
             <tr>
              <td class="es-m-p25t es-m-p20b" align="left" style="Margin:0;padding-top:20px;padding-right:20px;padding-bottom:10px;padding-left:20px">
               <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                 <tr>
                  <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                     <tr>
                      <td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="https://fbihosc.stripocdn.email/content/guids/CABINET_851fecd7fae336910c5f2f4e52ef04e721ba7c20fe10057474d6a7dd83a7b01f/images/2_zVI.png" alt="" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none" width="560"></td>
                     </tr>
                     <tr>
                      <td align="center" class="es-m-txt-c" style="padding:0;Margin:0"><p style="Margin:0;mso-line-height-rule:exactly;font-family:arial,   sans-serif;line-height:24px;letter-spacing:0;color:#333333;font-size:16px"><br></p><p style="Margin:0;mso-line-height-rule:exactly;font-family:arial,   sans-serif;line-height:24px;letter-spacing:0;color:#333333;font-size:16px">Hello, {=Document:CONTACT.NAME}, you were looking</p><p style="Margin:0;mso-line-height-rule:exactly;font-family:arial,   sans-serif;line-height:24px;letter-spacing:0;color:#333333;font-size:16px"><strong>{=Document:UF_CRM_1683024063}</strong></p><p style="Margin:0;mso-line-height-rule:exactly;font-family:arial,   sans-serif;line-height:24px;letter-spacing:0;color:#333333;font-size:16px">on {=Document:DATE_CREATE} at <a href="http://bimedis.com/" target="_blank" style="mso-line-height-rule:exactly;text-decoration:underline;color:#2CB543;font-size:14px">bimedis.com</a>&nbsp;</p></td>
                     </tr>
                     <tr>
                      <td align="center" class="es-m-txt-c" style="padding:0;Margin:0;padding-top:25px;padding-bottom:15px"><p style="Margin:0;mso-line-height-rule:exactly;font-family:arial,   sans-serif;line-height:27px;letter-spacing:0;color:#333333;font-size:18px"><strong>Did you manage to purchase product?</strong></p></td>
                     </tr>
                   </table></td>
                 </tr>
               </table></td>
             </tr>
           </table></td>
         </tr>
       </table>
       <table cellpadding="0" cellspacing="0" class="es-content" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
         <tr>
          <td align="center" bgcolor="#fafafa" style="padding:0;Margin:0;background-color:#fafafa">
           <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
             <tr>
              <td align="left" bgcolor="#fafafa" style="padding:0;Margin:0;background-color:#fafafa"><!--[if mso]><table style="width:600px" cellpadding="0" cellspacing="0"><tr><td style="width:290px" valign="top"><![endif]-->
               <table cellpadding="0" cellspacing="0" class="es-left" align="left" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                 <tr>
                  <td class="es-m-p0r es-m-p20b" align="center" style="padding:0;Margin:0;width:290px">
                   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                     <tr>
                      <td align="center" bgcolor="#fafafa" style="padding:0;Margin:0"><span class="es-button-border" style="border-style:solid;border-color:#2CB543;background:#31CB4B;border-width:0px 0px 2px 0px;display:inline-block;border-radius:0;width:auto"><a href="https://bimedis.com/cooperation-negative-feedback?_ga=2.237563392.1087732862.1689082660-1493332332.1689082660&_gl=1%2a1jr5h4m%2a_ga%2aMTQ5MzMzMjMzMi4xNjg5MDgyNjYw%2a_ga_ZE26R7GE62%2aMTY4OTA4MjY1OS4xLjEuMTY4OTA4Mjc2MC4yOC4wLjA." class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none !important;mso-line-height-rule:exactly;color:#FFFFFF;font-size:18px;padding:10px 20px 10px 20px;display:inline-block;background:#31CB4B;border-radius:0;font-family:arial,   sans-serif;font-weight:normal;font-style:normal;line-height:22px;width:auto;text-align:center;letter-spacing:0;mso-padding-alt:0;mso-border-alt:10px solid #31CB4B">Yes, I have managed to buy</a></span></td>
                     </tr>
                   </table></td>
                 </tr>
               </table><!--[if mso]></td><td style="width:20px"></td><td style="width:290px" valign="top"><![endif]-->
               <table cellpadding="0" cellspacing="0" class="es-right" align="right" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                 <tr>
                  <td align="center" style="padding:0;Margin:0;width:290px">
                   <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#f2f2f2" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#f2f2f2" role="presentation">
                     <tr>
                      <td align="center" bgcolor="#fafafa" style="padding:0;Margin:0"><span class="es-button-border" style="border-style:solid;border-color:#e06666;background:#e06666;border-width:0px 0px 2px 0px;display:inline-block;border-radius:0;width:auto"><a href="https://bimedis.com/cooperation-feedback?_gl=1%2a1a0kpyi%2a_ga%2aMTQ5MzMzMjMzMi4xNjg5MDgyNjYw%2a_ga_ZE26R7GE62%2aMTY4OTA4MjY1OS4xLjEuMTY4OTA4MjgwMy42MC4wLjA.&_ga=2.237563392.1087732862.1689082660-1493332332.1689082660" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none !important;mso-line-height-rule:exactly;color:#FFFFFF;font-size:18px;padding:10px 20px 10px 20px;display:inline-block;background:#e06666;border-radius:0;font-family:arial,   sans-serif;font-weight:normal;font-style:normal;line-height:22px;width:auto;text-align:center;letter-spacing:0;mso-padding-alt:0;mso-border-alt:10px solid #e06666">No, I have not purchase yet</a></span></td>
                     </tr>
                   </table></td>
                 </tr>
               </table><!--[if mso]></td></tr></table><![endif]--></td>
             </tr>
           </table></td>
         </tr>
       </table>
       <table cellpadding="0" cellspacing="0" class="es-content" align="center" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:100%;table-layout:fixed !important">
         <tr>
          <td align="center" bgcolor="#fafafa" style="padding:0;Margin:0;background-color:#fafafa">
           <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" role="none">
             <tr>
              <td align="left" style="padding:0;Margin:0;padding-right:20px;padding-left:20px;padding-top:10px">
               <table cellpadding="0" cellspacing="0" width="100%" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                 <tr>
                  <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                     <tr>
                      <td align="center" class="es-m-txt-c" style="padding:0;Margin:0;padding-top:20px"><p style="Margin:0;mso-line-height-rule:exactly;font-family:arial,   sans-serif;line-height:24px;letter-spacing:0;color:#333333;font-size:16px">Our goal is to make sure that youre able to speak with the seller.</p></td>
                     </tr>
                     <tr>
                      <td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="https://fbihosc.stripocdn.email/content/guids/CABINET_851fecd7fae336910c5f2f4e52ef04e721ba7c20fe10057474d6a7dd83a7b01f/images/4_7Gx.png" alt="" style="display:block;font-size:14px;border:0;outline:none;text-decoration:none" width="560"></td>
                     </tr>
                     <tr>
                      <td align="center" height="11" style="padding:0;Margin:0"></td>
                     </tr>
                   </table></td>
                 </tr>
               </table></td>
             </tr>
           </table></td>
         </tr>
       </table></td>
     </tr>
   </table>
  </div>
 </body>
</html>';  

$html = str_replace('{=Document:CONTACT.NAME}', $contactName, $html);
$html = str_replace('{=Document:DATE_CREATE}', $dateCreated, $html);
$html = str_replace('{=Document:UF_CRM_1683024063}', $productsString, $html);

// Initialize PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'mail2.softimus.org';  // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'info@bimedis.com';  // Replace with your email
    $mail->Password = 'drJeld82hfsGdskdfFw3fdLL';  // Replace with your email password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('info@bimedis.com', 'Info Bimedis');  // Replace with your email and name
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Bimedis Products: ' . $productsString;
    $mail->Body = $html;  // Assuming $html is generated in your existing code

    $mail->send();
    echo 'Email has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
