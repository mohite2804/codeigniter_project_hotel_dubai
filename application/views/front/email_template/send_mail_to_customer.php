<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sitara Hotel Apartment</title>
    <style type="text/css">
        <!--
        body {
            margin-left: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            margin-top: 0px;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #DBDBDB;
        }

        .maintb {
            width: 600px
        }


        @media (max-width:600px) {
            .maintb {
                width: 100%
            }
        }
        -->

    </style>
</head>


<body>

    <table class="maintb" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EFEFEF">
        <tr>
            <td>
                <!----------maindiv------------------>

                <table class="maintb" border="0" cellspacing="0" cellpadding="0">



                    <tr>
                        <td>
                            <img align="center" border="0" src="https://sitarahotelapartment.com/public/front_css_js/emailtemplate/sitaralogo.png" alt="Image" title="Image" style="display: block !important;border: 0;height: auto;float: none;width: 100%;max-width:600px" width="600">
                        </td>
                    </tr>







                    <tr>
                        <td style="padding: 0px 20px;background-color: #373737;">

                            <img align="center" border="0" src="https://sitarahotelapartment.com/public/front_css_js/emailtemplate/mail.png" alt="Image" title="Image" style="display: block !important;border: 0;height: auto;float: none;width: 100%;max-width:600px" width="600">

                            <p style="font-size: 18px;text-align: center;color: #ffffff;font-weight: bold; line-height: 24px;">Thanks For Booking</p>

                            <p style="font-size: 20px;text-align: center;color: #fff;font-weight: normal; line-height: 24px; margin-bottom:29px;">Welcome to Sitara Apartment </p>

                        </td>
                    </tr>


                    <tr>
                        <td style="padding: 0px 20px;background-color: #fff;">
                            <p style="font-size: 19px;text-align: center;color: #3B4856;font-weight: normal;margin-bottom: 18px;margin-top: 20px;line-height: 29px;">
                                Hi, <strong><?php echo $payment_gateway_response['billing_name']; ?> </strong><br> <br>
                                Room Type, <strong><?php echo $room_type; ?> </strong><br> <br>
                                Arrival : <span><strong><?php echo date('d M Y', strtotime($order_datails->start_date_time)) ; ?></strong></span><br><br>
                                Departure Date : <span><strong><?php echo date('d M Y', strtotime($order_datails->end_date_time)) ; ?></strong></span><br><br>
                                Amount : <span><strong><?php echo $order_datails->after_discount_amount; ?></strong></span><br><br>

                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:10px 20px;background-color: #fff;">
                            <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background-color: #EE353B;height: 32px;text-align: center;color: #fff;font-weight: bold;">
                                        <a href="https://sitarahotelapartment.com/" target="_blank" style="color: #fff;text-decoration: none;">Go to Sitara Apartment</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0px 20px;background-color: #fff;">
                            <p style="font-size: 14px;text-align: center;color: #3B4856;font-style: italic;font-weight: normal;margin-bottom: 20px;margin-top: 20px;">

                                Thanks,<br>

                                The Sitara Team
                            </p>
                        </td>
                    </tr>









                    <tr>
                        <td style="padding: 10px 10px;">
                            <p style="font-size: 14px;text-align: center;color: #585858;font-weight: normal; line-height: 12px; margin-bottom:10px; margin-top:10px; letter-spacing: 3px;">
                                <a href="https://sitarahotelapartment.com/" style="color: #585858;text-decoration: none;">www.sitarahotelapartment.com</a>
                            </p>
                        </td>
                    </tr>


                </table>


            </td>
            <!----------maindiv------------------>
        </tr>
    </table>




</body>

</html>