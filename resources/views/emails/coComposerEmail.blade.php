<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css"
    />
</head>
<body>
<!-- 초대 안내 메일 작업 페이지입니다. 이슈 사항 있으면 말씀 부탁 드립니다. -->
<div
    style="
        font-family: 'pretendard';
        max-width: 1046px;
        width: 92%;
        margin: 0 auto;
        padding: 50px 20px;
        box-sizing: content-box;
      "
>
    <div style="margin-bottom: 30px; box-sizing: content-box">
        <div style="text-align: right">
            <img
                style="max-width: 106px; width: 100%"
                src="https://d7x2ggm74g7nd.cloudfront.net/imgData/logo_bybeats.png"
                alt="바이비츠 로고"
            />
        </div>
        <h2 style="font-size: 20px; font-weight: 500; color: #222; margin: 0">
            공동 작곡가 초대 안내
        </h2>
    </div>

    <div style="margin-bottom: 70px; box-sizing: content-box">
        <p
            style="
            margin-bottom: 30px;
            background: linear-gradient(
              92.62deg,
              #13e880 3.65%,
              #80e8ff 102.01%
            );
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            font-size: 30px;
            font-weight: 500;
          "
        >
            <span style="font: inherit">{{$title}}</span>의 공동 작곡가로
            초대되었습니다.
        </p>
        <p style="font-size: 18px; color: #222; font-weight: 500">
            바이비츠에서 <span style="font: inherit">{{$nickname}}</span
            >님과 함께 공동 음원 작업을 진행해보세요!
        </p>
    </div>

    <div style="margin-bottom: 70px; box-sizing: content-box">
        <h3
            style="
            font-size: 20px;
            font-weight: 600;
            color: #222;
            margin-bottom: 30px;
          "
        >
            음원정보
        </h3>
        <ul
            style="
            list-style: none;
            border-width: 3px 0 3px 0;
            border-style: solid;
            border-color: transparent;
            border-image: linear-gradient(
              92.62deg,
              #13e880 3.65%,
              #80e8ff 102.01%
            );
            border-image-slice: 1;
            padding-left: 0;
          "
        >
            <li style="display: flex; align-items: center">
            <span
                style="
                width: 27.72%;
                padding: 20px;
                font-weight: 500;
                font-size: 16px;
                color: #000;
                background: rgba(102, 102, 102, 0.07);
              "
            >음원제목</span
            >
                <span
                    style="
                padding: 0 20px;
                font-weight: 500;
                font-size: 16px;
                color: #000;
              "
                >{{$title}}</span
                >
            </li>
            <li style="display: flex; align-items: center">
            <span
                style="
                width: 27.72%;
                padding: 20px;
                font-weight: 500;
                font-size: 16px;
                color: #000;
                background: rgba(102, 102, 102, 0.07);
              "
            >초대한 작곡가</span
            >
                <span
                    style="
                padding: 0 20px;
                font-weight: 500;
                font-size: 16px;
                color: #000;
              "
                >{{$nickname}}</span
                >
            </li>
            <li style="display: flex; align-items: center">
            <span
                style="
                width: 27.72%;
                padding: 20px;
                font-weight: 500;
                font-size: 16px;
                color: #000;
                background: rgba(102, 102, 102, 0.07);
              "
            >초대받은 공동 작곡가</span
            >
                <span
                    style="
                padding: 0 20px;
                font-weight: 500;
                font-size: 16px;
                color: #000;
              "
                >{{$send_emails}}</span
                >
            </li>
        </ul>
    </div>

    <div style="margin-bottom: 70px; box-sizing: content-box">
        <p
            style="
            font-weight: 500;
            font-size: 14px;
            color: #666;
            margin-bottom: 50px;
          "
        >
            본 메일은 발송 시점부터 72시간동안 유효하며, 이후 만료됩니다.
        </p>
        <p
            style="
            font-weight: 500;
            font-size: 14px;
            color: #666;
            line-height: 1.5;
          "
        >
            공동작곡가 초대를 받으시는 분들 중 회원가입을 하지 않으신 분들은<br />
            <span style="font: inherit; color: #ff1e1e"
            >정상적인 서비스 이용을 위해 회원가입을 진행해주세요.</span
            >
        </p>
    </div>

    <div
        style="
          display: flex;
          justify-content: center;
          align-items: center;
          box-sizing: content-box;
        "
    >

        <a style="
            font-weight: 500;
            font-size: 18px;
            color: #ffffff;
            width: 300px;
            height: 50px;
            background: linear-gradient(
              92.62deg,
              #13e880 3.65%,
              #80e8ff 102.01%
            );
            border-radius: 5px;
            border: none;
          " href="{{env($site_code)}}/?music_head_idx={{$music_head_idx}}">공동 작곡가 참여</a>
    </div>
</div>
</body>
</html>
