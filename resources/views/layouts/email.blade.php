<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
    <style type="text/css" media="screen">
        .container{max-width:500px;}
        .container p{font-size:13px; line-height:20px; color:#444; font-weight:normal}
        a{text-decoration:none; color:#5bd4bc;}
        a:hover{text-decoration:underline;}

        /* emailTable */
        .table_email{margin:0 auto;}
        .table_email h3{font-size:14px; font-weight:normal; margin: 0; padding:2px;}
    </style>

</head>
<body>
<table width="100%" height="100%" border="0" bgcolor="#fff" cellspacing="0" cellpadding="0" style="border-spacing:0;">
    <tbody>
    <tr>
        <td style="background-color:#fff;border-collapse:collapse;">

            <table width="600" border="0" bgcolor="#fff" cellspacing="0" cellpadding="0" style="border-spacing:0;" class="table_email">
                <tbody id="">
                <tr id="">
                    <td bgcolor="#fff" align="left" style="background-color:#fff;font-size:13px;line-height:20px;font-family:Helvetica, sans-serif;color:#333;border-collapse:collapse;" class="" id="">

                        <table width="600" border="0" bgcolor="#fff" cellspacing="0" cellpadding="0" style="border-spacing:0;"  class="table_email">
                            <tbody id=""><tr id="">
                                <td style="border-collapse:collapse;" id="">
                                    <a href="http://www.freadynow.com"><img width="60" height="50" style="color:#009999;" alt="FreadyNow" src="freadynow.com/images/fready_logo.png"></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                    </td>
                </tr>
                </tbody>
            </table>



            <table width="600" border="0" bgcolor="#ffffff" cellspacing="0" cellpadding="0" style="border-spacing:0;" class="table_email">
                <tbody id="">

                <tr id="">
                    <td bgcolor="#333333" align="left" style="background-color:#333333;padding:20px 0 17px 50px;border-collapse:collapse;" class="" id="">
                        <span class="" style="color:#fff;font-family:Helvetica, sans-serif;font-size:23px;line-height:1.5;text-decoration:none;" id="">@yield('email_title')</span>
                    </td>
                </tr>

                <tr id="">
                    <td bgcolor="#ffffff" align="left" style="border:1px solid #eee; background-color:#ffffff;padding:35px 50px;font-size:13px;line-height:20px;font-family:Helvetica, sans-serif;color:#333;border-collapse:collapse;">

                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-spacing:0;color:#333333;font-family:Helvetica, sans-serif;font-size:13px;" class="table_email">
                            <tbody id="">
                            <tr id="">
                                <td id="">
                                    @yield('content')
                                </td>
                            </tr>
                            </tbody></table>

                    </td>
                </tr>
                <tr id="">
                    <td style="background:#393633;border-collapse:collapse;" id="">
                        &nbsp;
                    </td>
                </tr>
                </tbody>
            </table>


            <table width="600" border="0" bgcolor="#fff" cellspacing="0" cellpadding="0" style="border-spacing:0;" class="table_email">
                <tbody id="">
                <tr id="">
                    <td bgcolor="#fff" align="left" style="background-color:#fff;padding-left:10px;padding-right:10px;font-size:12px;line-height:20px;font-family:Helvetica, sans-serif;color:#333;border-collapse:collapse;" class="">

                        <table width="580" border="0" bgcolor="#fff" cellspacing="0" cellpadding="0" style="border-spacing:0;" class="" id="">
                            <tbody id="">
                                <tr id="">
                                    <td align="center" class="" style="color:#999999;font-family:Helvetica, sans-serif;font-size:11px;line-height:14px;border-collapse:collapse;padding:15px 0;" id="">
                                        <b>FreadyNow</b>
                                        <br/>Original Impressions, LLC.<br/>
                                        <br/>12900 SW 89 Court Miami, FL 33176<br/>
                                        Website: <a href="http://www.freadynow.com">www.freadynow.com</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

        </td>
    </tr>
    </tbody>
</table>

</body>
</html>

