<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>email_template</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;700&display=swap");
    </style>
</head>

<body>
<!-- 비밀번호 재설정 이메일 템플릿 -->
<table border="0" cellpadding="0" cellspacing="0" width="100%"
       style="max-width: 600px; margin: 0 auto; color: #222222; font-size: 16px; font-family: 'Noto Sans KR', sans-serif;">
    <tr>
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="max-width: 600px; margin: 0 auto; color: #222222; font-size: 16px; font-family: 'Noto Sans KR', sans-serif;">
            <tr>
                <th align="center" style="text-align:left; font-weight: 500; font-size: 18px;">
                    비밀번호 재설정
                </th>
                <th align="center" style="width: 20%; text-align: right; font-weight: 500; font-size: 24px;">
                    <img src="https://d7x2ggm74g7nd.cloudfront.net/imgData/logo_222.642ce4a6.svg" alt="비트썸원 로고" style="width: 100px; height: 30px; font-weight: 500; font-size: 24px;">
                </th>
                <th>
                    <span>×</span>
                </th>
                <th align="center" style="width: 20%; font-weight: 500; font-size: 24px;">
                    <img src="https://d7x2ggm74g7nd.cloudfront.net/imgData/logo.svg" alt="바이비츠 로고" style="width: 100px; height: 30px; font-weight: 500; font-size: 24px;">
                </th>
            </tr>
            <tr>
                <td height="30" style="font-size: 0; line-height: 0;">&nbsp;</td>
            </tr>
        </table>
    </tr>
    <tr>
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="max-width: 600px; margin: 0 auto; color: #222222; font-size: 16px; font-family: 'Noto Sans KR', sans-serif;">
            <tr>
                <td align="left"
                    style="padding: 2rem 0 1.5rem 0; font-size:20px; font-family: 'Noto Sans KR', sans-serif;">
                    비트썸원(BEAT SOMEONE) X 바이비츠(BY BEATS) <br>
                    계정의 <b>비밀번호를 재설정</b>해주세요.
                </td>
            </tr>
            <tr>
                <td height="30" style="font-size: 0; line-height: 0;">&nbsp;</td>
            </tr>
        </table>
    </tr>
    <tr>
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="max-width: 600px; width:100%; margin: 0 auto; color: #222222; text-align: left; font-size: 16px; font-family: 'Noto Sans KR', sans-serif; border-collapse: collapse;">
            <tr>
                <td style="font-size: 0; line-height: 0;">&nbsp;</td>
                <td style="width:40%; text-align: center;color: #222222; border: 1px solid #24ce7b; font-family: 'Noto Sans KR', sans-serif;"
                    align="center">

                    <a href="{{env($site_code)}}/?idx={{$idx}}&token={{$_token}}"
                       style="display:block; padding: 10px 20px 10px 20px; color:#24ce7b; font-weight: 600; text-decoration: none !important;">
                        비밀번호 재설정
                    </a>

                </td>
                <td style="font-size: 0; line-height: 0;">&nbsp;</td>
            </tr>
            <tr>
                <td height="30" style="font-size: 0; line-height: 0;">&nbsp;</td>
            </tr>
        </table>
    </tr>
    <tr>
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="max-width: 600px; width:100%; margin: 0 auto; color: #222222; text-align: left; font-size: 16px; font-family: 'Noto Sans KR', sans-serif; border-collapse: collapse;">
            <tr>
                <td style="padding: 0.8rem 0.2rem 0.8rem 0.2rem; color: #888; font-size: 14px;">
                    본 메일은 발송 시점부터 24시간동안 유효하며,이후 만료됩니다. <br/>
                    비밀번호를 변경하고 싶지 않거나 본인이 요청한 것이 아닌 경우, <br/>
                    본 메일을 무시하고 삭제하시기 바랍니다.
                </td>
            </tr>
            <tr>
                <td style="padding: 0.8rem 0.2rem 0.8rem 0.2rem; color: #888; font-size: 14px;">
                    도움이 필요하시면 언제든지 도와드리겠습니다. <br/>
                    <a href="mailto:support@beatsomeone.com" style="color: #888888;">support@beatsomeone.com</a>을 통해 직접 문의해주세요.
                </td>
            </tr>
            <tr>
                <td height="30" style="font-size: 0; line-height: 0;">&nbsp;</td>
            </tr>
        </table>
    </tr>
</table>

</body>

</html>
