<!doctype html>
<html class="no-js">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <title>韩讯联控产品跟进系统</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width">

    <link href="main.css" rel="stylesheet">
    <link href="../main.css" rel="stylesheet">
</head>
<body class="language-sc">

<div class="dynamic-nav-bar">
    <ul>
        <li><a href="./" class='active'><font size="+1"><strong>韩讯联控产品跟进系统</strong></font></a></li>
    </ul>
</div>

<div class="dynamic_content_wrapper">
    <div class="dynamic_content">
        <div id="function">
            <div id="function">
{if 1==$ret}
<div class="route-result" style="">
<div class="bill-title">缺少参数</div>
</div>
{elseif 2==$ret}
<div class="route-result" style="">
<div class="bill-title">找不到记录</div>
</div>
{else}
                <div class="shipping-detail-page">
                    <div class="delivery-view">
                        <!-- 产品信息 -->
                        <div class="route-result" style="">
                            <div class="bill-title">产品信息</div>
                            <div class="delivery-wrapper">
                              <table width="100%" >
                                <tr>
                                  <th>生产地</th>
                                  <th>批次</th>
                                  <th>品种</th>
                                  <th>出厂日期</th>
                                </tr>                               
                                <tr>
                                  <td>{$j.place}</td>
                                  <td>{$j.batch}</td>
                                  <td>{$j.type}</td>
                                  <td>{$j.time}</td>
                                </tr>
                              </table>
                            
                            </div>
                        </div>
                        <div class="route-result" style="">
                            <div class="bill-title">跟进信息</div>
                                <div class="delivery-wrapper">
                                <div class="delivery">
                                    <div class="delivery-item send-out-item">
                                        <div class="routes-wrapper">
                                            <div class="route-list">
                                              {section  name=o loop=$l}
                                                <ul class="route first ">
                                                  <li class="route-status-text">{$smarty.section.o.rownum}</li>
                                                  <li class="route-status-icon"><img src="status-signed.png"></li>
                                                  <li class="route-date-time"><span>{$l[o].time}</span></li>
                                                  <li class="route-desc"><span>{$l[o].mark}</span> - 操作员:<span>{$l[o].operater}</li>
                                                </ul>
                                                {/section}
                                            </div>
                                        </div>
                                        <div class="separation-line"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
{/if}
            </div>
        </div>

    </div>
</div>


</body>
</html>