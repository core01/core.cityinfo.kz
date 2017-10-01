<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<style>
    @media only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }

        .footer {
            width: 100% !important;
        }
    }

    @media only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>
<table class="content" width="100%" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="header">
            <a href="{{ config('app.url') }}" target="_blank">
                {{ config('app.name') }}
            </a>
        </td>
    </tr>
    <tr>
        <td class="body" width="100%" cellpadding="0" cellspacing="0">
            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td class="content-cell">

                        <h1>Hello!</h1>
                        <p>You are receiving this email because we received a password reset request for your
                            account.</p>
                        <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td align="center">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td align="center">
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <a href="{{ $reset_url }}"
                                                               class="button button-blue" target="_blank">Reset
                                                                Password</a>
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
                        <p>If you did not request a password reset, no further action is required.</p>
                        <p>Regards,<br>
                            Laravel</p>

                        <table class="subcopy" width="100%" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td>
                                    <p>
                                        If you’re having trouble clicking the "Reset Password" button, copy and paste
                                        the URL below
                                        into your web browser: <a href="{{ $reset_url }}"
                                                                  target="_blank">{{ $reset_url }}</a>
                                    </p>
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
    <tr>
        <td>
            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td class="content-cell" align="center">
                        <p>
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>
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