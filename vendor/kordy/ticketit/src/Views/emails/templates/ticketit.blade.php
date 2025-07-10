<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style type="text/css">
      @import url(http://fonts.googleapis.com/css?family=Droid+Sans);

      img {
        max-width: 600px;
        outline: none;
        text-decoration: none;
        -ms-interpolation-mode: bicubic;
    }

    a {
        text-decoration: none;
        border: 0;
        outline: none;
        color: #bbbbbb;
    }

    a img {
        border: none;
    }

    td, h1, h2, h3  {
        font-family: Helvetica, Arial, sans-serif;
        font-weight: 400;
    }

    td {
        text-align: center;
    }

    body {
        -webkit-font-smoothing:antialiased;
        -webkit-text-size-adjust:none;
        width: 100%;
        height: 100%;
        color: {{ $setting->grab('email.color_body_bg') }};
        background: #ffffff;
        font-size: 16px;
    }

    table {
        border-collapse: collapse !important;
    }

    .subject {
        color: #ffffff;
        font-size: 36px;
    }

    .force-full-width {
      width: 100% !important;
  }

</style>

<style type="text/css" media="screen">
  @media screen {
    td, h1, h2, h3 {
      font-family: 'Droid Sans', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
  }
}
</style>

<style type="text/css" media="only screen and (max-width: 480px)">
    @media only screen and (max-width: 480px) {

      table[class="w320"] {
        width: 320px !important;
    }
}
</style>
</head>
<body class="body" style="padding:0; margin:0; display:block; background:#fff; -webkit-text-size-adjust:none" bgcolor="#fff">
    <br>
    <table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%" >
      <tr>
        <td align="center" valign="top" bgcolor="#fff"  width="100%">
          <center>
            <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="600" class="w320">
              <tr>
                <td align="center" valign="top">

              <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="100%" bgcolor="{{ $setting->grab('email.color_header_bg') }}">
                <tr>
                    <td class="subject">
                    <br>
                        @yield('subject')
                  </td>
              </tr>
              <tr>
                <td>

                  <center>
                    <table cellpadding="0" cellspacing="0" width="80%">
                      <tr>
                        <td style="margin: 20px; text-align: left color:#187272;" align="left">
                            <br>
                            @yield('content')
                            <br>
                            <br>
                        </td>
                    </tr>
                </table>
            </center>

        </td>
    </tr>
</table>

</td>
</tr>
</table>
</center>
</td>
</tr>
</table>
</body>
</html>
