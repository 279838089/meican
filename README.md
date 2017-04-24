## 美餐自动点餐
> lionli 20170424 meican1.0
### 现已经实现的功能
- [x] 定点定时点餐
- [x] 订餐配置，可以提供固定的5份选择，周一到周五，或者提供n份选择，每天随机抽取
- [x] 如果提供邮箱，点餐成功会自动发送邮件
### 环境
1. linux（mac也可以）
2. 基于php5.6
### 步骤
1. cd ~ && git clone   //下载源码
2. 配置账号密码，点餐的id会再下面自动生成
```
//config.php
//配置项如果有多个用;隔开
//账号,多个账号用;隔开
define('USER', '****@****.com;***@*****.com;');
//密码
define('PASSWORD', '****;****;');
//选择，周一到周五，用,隔开
define('CHOICE', '69463546,69463546,69463546,69463546,69450031;69400482,69478131,69373084,69451271,69451272;');
//是否随机，选择数量不等于5，就算不选择也是随机
define('RANDOM', '1;0;');
//邮箱，订餐成功与否都发邮件,为空就不发
define('EMAIL', '***@qq.com;***@qq.com;');
```
3. php login.php 模拟登录
![](http://ww1.sinaimg.cn/large/006tNc79gy1fexuryschoj308801jaa7.jpg)
4. php consult.php > 1.html && open 1.html //生成餐牌，==非必需步骤==，[或者直接参考点击这里](http://note.youdao.com/noteshare?id=292282e0cfdb273b2beba51054cf6ae1),**参考这里的餐牌，把自己喜欢吃的晚餐id放进第一步的配置文件CHOICE**，生成的1.html是最新的，后续可以直接浏览器点开
5. 把点餐加入自动任务cron里面
```
corntab -e
//进入后，加入以下代码，目录需要改为自己的存放目录，15就是下午3点，可以自行修改
0 15 * * 1-5 cd ~/meican && php login.php && php meican.php
```
