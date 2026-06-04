<!DOCTYPE html>
<html lang="id" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Delix Studio</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style type="text/css">
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            outline: none;
            text-decoration: none;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f5;
        }

        a {
            color: inherit;
        }

        @media only screen and (max-width: 600px) {
            .wrapper {
                width: 100% !important;
                padding: 16px !important;
            }

            .card {
                border-radius: 8px !important;
            }
        }
    </style>
</head>

<body
    style="margin:0; padding:0; background-color:#f4f4f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;">

    <!-- Wrapper -->
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
        style="background-color:#f4f4f5; padding: 40px 16px;">
        <tr>
            <td align="center">

                <!-- Card -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="560"
                    style="max-width:560px; width:100%; background:#ffffff; border-radius:12px; border:1px solid #e4e4e7; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#010101; padding:24px 32px;">
                            <a href="{{ config('app.url') }}"
                                style="font-size:16px; font-weight:600; color:#ffffff; text-decoration:none; letter-spacing:-0.02em;">
                                delix<span style="color:rgba(255,255,255,0.4);">studio</span>
                            </a>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color:#fafafa; border-top:1px solid #e4e4e7; padding:20px 32px; text-align:center;">
                            <p style="margin:0; font-size:11px; color:#a1a1aa; line-height:1.6;">
                                © {{ date('Y') }} Delix Studio. All rights reserved.<br>
                                Kamu menerima email ini karena terdaftar di Delix Studio.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- End Card -->

            </td>
        </tr>
    </table>
    <!-- End Wrapper -->

</body>

</html>
