<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}��Ҫȥ����֮��--�û�����ҳ��{/block}</title>
    <link rel="stylesheet" href="/res/css/center.css" />
    <script src="/res/js/jquery.min.js"></script>
    <script src="/res/js/layer/layer.js"></script>
    <script src="/res/js/autocomplete.js"></script>
    <script src="/res/js/common.js"></script> 
    <script src="/res/js/userhome.js"></script> 
		<script src="/res/js/adminhome.js"></script> 
		<script src="/res/js/shoperhome.js"></script> 
	<!--<script src="/res/js/site.js"></script> // res�ļ���û�д�Ŀ¼�����console����̨����-->
	  <script src="/res/js/layer/layer.js"></script> 
	  <script src="/res/js/area_one.js"></script>
    <script src="/res/js/class_one.js"></script>
  </head>
  <body>
  {block name="head"}
    <header>
      <div>
        <div id="top_navigation">
          <div><span></span><a href="/city">�л�����</a><a href="/">��ҳ</a></div>
          <ul>
            <li><a href="/help">��������</a></li>
            <li><a href="/usercenter/order/list" target="_blank">�ҵĶ���</a></li>
            <li><a href="/usercenter/finance/index">��Ա����</a></li>
            <li><a href="/cart">���ﳵ</a></li>
            {if empty($smarty.session.bmzj.uno)}
            <li><a href="/reg">ע��</a></li>
            <li><a href="/login">��¼</a></li>
            {else}
            <li><span>Hi,{$smarty.session.bmzj.uname}</span><a href="/login/loginout">�˳�</a><a href="/usercenter/other/message">��Ϣ(<span style="color: red; margin-right: 0;">{if $messcount}$messcount{else}0{/if}</span>)</a></li>
            {/if}
          </ul>
        </div>
      </div>
      <div>
        <div id="index_logo_part" >
          <div><img src="/res/img/logo.png"></div>
          <form action="/search" method="get">
            <ul>
              <li><input type="text" name="sword" placeholder="���̡���Ʒ����Ƹ����"></li>
              <li style="border-left: none;"><button type="submit">����</button></li>
            </ul>
          </form>
        </div>
      </div>
    </header>
   {/block}
    <section id="main">    
      {block name="main"}
      {/block}
      <ul id="aside">
        <li><a href="/"><img src="/res/img/home.png"><br>��վ��ҳ</a></li>
        <li><a href="/help"><img src="/res/img/help.png"><br>��������</a></li>
        <li><a href="/about"><img src="/res/img/service.png"><br>��ϵ����</a></li>
        <li><a href="#"><img src="/res/img/top.png"><br>���ض���</a></li>
      </ul>
    </section>
    <footer>
      <div>
        <ul>
          <li>xxx���޹�˾</li>
          <li>�Ĵ��ɶ����½��������½���������99�ţ�SBI��302</li>
          <li>��ICP��14029689��</li>
          <li>Copyright&nbsp;&nbsp;&nbsp;2016-2016</li>
        </ul>
        <img src="/res/img/weidian.jpg">
      </div>
    </footer>
    {block name="js"}
    {/block}
  </body> 
</html>