<?php
class CurlCookie{
    //存储cookie的位置,必须可写的位置
    private $cookie;

    public function __construct($cookie){
  		$this->cookie = $cookie;
  	}

    //模拟登录
    public function login_post($url, $post) {
        $ch = curl_init();//初始化curl模块
        curl_setopt($ch, CURLOPT_URL, $url);//登录提交的地址
        curl_setopt($ch, CURLOPT_HEADER, 0);//是否显示头信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);//是否自动显示返回的信息
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie); //设置Cookie信息保存在指定的文件中
        curl_setopt($ch, CURLOPT_POST, 1);//post方式提交
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息
        curl_exec($ch);//执行cURL
        curl_close($ch);//关闭cURL资源，并且释放系统资源
    }

    //登录成功后获取数据 get
    public function get_content($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie); //读取cookie
        $rs = curl_exec($ch); //执行cURL抓取页面内容
        curl_close($ch);
        return $rs;
    }

    //登录成功后获取数据  post
    public function post_content($url, $post) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie); //读取cookie
        curl_setopt($ch, CURLOPT_POST, 1);//post方式提交
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息
        $rs = curl_exec($ch); //执行cURL抓取页面内容
        curl_close($ch);
        return $rs;
    }

    //登录
    public function login($user,$password){
      $url = "https://meican.com/account/directlogin";
      $post  = array('username' => $user,
                  'loginType' => 'username',
                  'password' => $password,
                  'remember' => 'true',
                  'redirectUrl' => '');
      $this->login_post($url, $post);
    }

    //获取账号唯一码
    public function get_tabUniqueId(){
      $dates = date("Y-m-d");
      $url = "https://meican.com/preorder/api/v2.1/calendarItems/list?beginDate=$dates&endDate=$dates&withOrderDetail=false";
      $result = json_decode($this->get_content($url));
      return $result->dateList[0]->calendarItemList[0]->userTab->uniqueId;
    }

    //发送邮件
    public function sent_emai($email,$meican){
      if($email == '')
        return 0;
      $to = $email;
      $subject = "message";
      $message = $meican;
      $from = "lionli@example.com";
      $headers = "From: $from";
      mail($to,$subject,$message,$headers);
    }

    //下单
    public function add_order($c,$tabUniqueId){
      $dates = date("Y-m-d");
      $url = "https://meican.com/preorder/api/v2.1/orders/add";
      $post  = array('corpAddressUniqueId' => '772a87d56869',
              'order' => '[{"count":1,"dishId":'.$c.'}]',
              'tabUniqueId' => $tabUniqueId,
              'targetTime' => "$dates 17:00",
              'userAddressUniqueId' => '772a87d56869');
      return $this->post_content($url, $post);
    }

    //自动获取同事常点的餐
    public function get_order_id($tabUniqueId){
      $dates = date("Y-m-d");
      $url = "https://meican.com/preorder/api/v2.1/recommendations/dishes?tabUniqueId=$tabUniqueId&targetTime=$dates+17:00";
      $get_order = $this->get_content($url);
      $res = json_decode($get_order,true);
      $num = count($res['othersRegularDishList']);
      $arr=rand(0,$num-1);
      return $res['othersRegularDishList'][$arr]['id'];
    }
}
