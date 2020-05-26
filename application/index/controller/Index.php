<?php
namespace app\index\controller;

use think\Db;
use think\facade\Session;

class Index
{
    public function getReturn($code = 1,$msg = "成功",$data = null){
        return array("code"=>$code,"msg"=>$msg,"data"=>$data);
    }
    //后台菜单
    public function getMenu(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }

        $menu = array(
            array(
                "name"=>"主页",
                "type"=>"url",
                "url"=>"pages/admin/main.html?t=".time(),
            ), array(
                "name"=>"配置",
                "type"=>"url",
                "url"=>"pages/admin/setting.html?t=".time(),
            ),array(
                "name"=>"分类",
                "type"=>"menu",
                "node"=>array(
                    array(
                        "name"=>"管理分类",
                        "type"=>"url",
                        "url"=>"pages/admin/shoptypeList.html?t=".time(),
                    )
                ),
            ),array(
                "name"=>"商品",
                "type"=>"menu",
                "node"=>array(
                    array(
                        "name"=>"添加商品",
                        "type"=>"url",
                        "url"=>"pages/admin/shopAdd.html?t=".time(),
                    ),
                    array(
                        "name"=>"管理商品",
                        "type"=>"url",
                        "url"=>"pages/admin/shopList.html?t=".time(),
                    )
                ),
            ),array(
                "name"=>"卡密",
                "type"=>"menu",
                "node"=>array(
                    array(
                        "name"=>"添加卡密",
                        "type"=>"url",
                        "url"=>"pages/admin/kmAdd.html?t=".time(),
                    ),
                    array(
                        "name"=>"管理卡密",
                        "type"=>"url",
                        "url"=>"pages/admin/kmList.html?t=".time(),
                    )
                ),
            ),array(
                "name"=>"订单",
                "type"=>"menu",
                "node"=>array(
                    array(
                        "name"=>"管理订单",
                        "type"=>"url",
                        "url"=>"pages/admin/orderList.html?t=".time(),
                    )
                ),
            )
        );



        return json($menu);

    }
    public function getMe(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        return json($this->getReturn(1,"成功",Session::get("user")));
    }
    public function loginOut(){
        Session::delete("admin");
        return "<html><script>window.location.href = 'index.html';</script></html>";

    }
    public function login(){
        $user = input("username");
        $pass = input("password");
        $row = Db::name("setting")->where("vkey","user")->find();
        if ($row['vvalue']!=$user){
            return $this->getReturn(-1,"账号或密码错误");
        }
        $row = Db::name("setting")->where("vkey","pass")->find();
        if ($row['vvalue']!=$pass){
            return $this->getReturn(-1,"账号或密码错误");
        }
        Session::set("admin",$user);
        return $this->getReturn(1,"登录成功");

    }


    public function getShopType(){


        $res = Db::name("shoptype")->select();
        return $this->getReturn(1,"登录成功",$res);

    }
    public function getShop(){


        $res = Db::name("shop");
        if (input("typeId")){
            $res = $res->where("typeid",input("typeId"));
        }
        $res = $res->select();

        return $this->getReturn(1,"登录成功",$res);

    }

    public function getWebConfig(){
        $gg = Db::name("setting")->where("vkey","gg")->find();
        $name = Db::name("setting")->where("vkey","name")->find();


        return $this->getReturn(1,"登录成功",array(
            "gg"=>$gg['vvalue'],
            "name"=>$name['vvalue'],
        ));

    }



    //购买
    public function buy(){


        $shopId=input("shopid");
        $num = input("num");
        $qq = input("qq");
        $paytype = input("paytype");

        if ($shopId==""){
            return json($this->getReturn(-1,"商品编号不正确"));
        }
        if (!$num>0){
            return json($this->getReturn(-1,"购买数量不正确"));
        }
        if ($qq==""){
            return json($this->getReturn(-1,"请输入联系方式"));
        }
        if ($paytype=="" || $paytype<1 || $paytype>2){
            return json($this->getReturn(-1,"请选择正确的支付方式"));
        }

        $shop = Db::name("shop")->where("id",$shopId)->find();
        if (!$shop){
            return json($this->getReturn(-1,"商品编号不正确"));
        }
        $money = $shop['money'];

        if ($shop['kucun']<$num){
            return json($this->getReturn(-1,"商品库存不足"));
        }

        $price = bcmul($num,$money,2);




        Db::name("shop")->where("id",$shopId)->setDec("kucun",$num);
        $orderId = Db::name("orders")->insertGetId(array(
            "shopid"=>$shopId,
            "shopname"=>$shop['shopname'],
            "cards"=>"",
            "date"=>time(),
            "qq"=>$qq,
            "paytype"=>$paytype,
            "num"=>$num,
            "money"=>$price,
            "state"=>0
        ));

        Db::name("kucun")->where("vkey","vmq")->find();

        $key = Db::name("setting")->where("vkey","pass")->find();

        $osign = md5($orderId.$key['vvalue']);


        $key = Db::name("setting")->where("vkey","vmq")->find();
        $sz = explode("/",$key['vvalue']);
        $sign = md5($orderId.$osign.$paytype.$price.$sz[1]);

        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $payReturn = $http_type.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $payReturn = str_replace("buy","payReturn",$payReturn);

        $p = "payId=".$orderId.'&param='.$osign.'&type='.$paytype."&price=".$price.'&sign='.$sign.'&isHtml=1'."&payReturn=".$payReturn;
        $url = "http://".$sz[0]."/createOrder?".$p;

//        $this->test($orderId);
//        $url = "index.html?orderId=".$orderId."&sign=".$osign;

        return $this->getReturn(1,"成功",$url);
    }

    private function test($orderId){
        $order = Db::name("orders")->where("id",$orderId)->find();
        $res = Db::name("orders")
            ->where("state",0)
            ->where("id",$orderId)
            ->update(array("state"=>1));

        if ($res){


            Db::name("cards")
                ->where("shopid",$order['shopid'])
                ->where("state",1)
                ->limit($order['num'])
                ->update(array(
                    "orderid"=>$order['id'],
                    "state"=>0,
                ));

            $cards = Db::name("cards")->where("orderid",$order['id'])->select();
            $card = "";
            for ($i=0;$i<sizeof($cards);$i++){
                $card.=$cards[$i]['content']."\r\n";
            }

            Db::name("orders")->where("id",$order['id'])->update(array("cards"=>$card));

        }
    }


    private function checkPay(){
        ini_set("error_reporting","E_ALL & ~E_NOTICE");
        $key = Db::name("setting")->where("vkey","vmq")->find();
        $sz = explode("/",$key['vvalue']);
        $key = $sz[1];//通讯密钥
        $payId = $_GET['payId'];//商户订单号
        $param = $_GET['param'];//创建订单的时候传入的参数
        $type = $_GET['type'];//支付方式 ：微信支付为1 支付宝支付为2
        $price = $_GET['price'];//订单金额
        $reallyPrice = $_GET['reallyPrice'];//实际支付金额
        $sign = $_GET['sign'];//校验签名，计算方式 = md5(payId + param + type + price + reallyPrice + 通讯密钥)
        //开始校验签名
        $_sign =  md5($payId . $param . $type . $price . $reallyPrice . $key);
        if ($_sign != $sign) {
            return false;
        }

        return true;
    }

    //同步跳转支付完成
    public function payReturn(){

        try{
            $isok = $this->checkPay();
        }catch (\Exception $exception){
            $isok = false;
        }

        if ($isok){
            $res = Db::name("orders")
                ->where("state",0)
                ->where("id",input("payId"))
                ->update(array("state"=>1));

            if ($res){

                $order = Db::name("orders")->where("id",input("payId"))->find();

                Db::name("cards")
                    ->where("shopid",$order['shopid'])
                    ->where("state",1)
                    ->limit($order['num'])
                    ->update(array(
                        "orderid"=>$order['id'],
                        "state"=>0,
                    ));

                $cards = Db::name("cards")->where("orderid",$order['id'])->select();
                $card = "";
                for ($i=0;$i<sizeof($cards);$i++){
                    $card.=$cards[$i]['content']."\r\n";
                }

                Db::name("orders")->where("id",$order['id'])->update(array("cards"=>$card));

            }
            return "<html><script>window.location.href = 'index.html?orderId=".$order['id']."&sign=".input("param")."';</script></html>";


        }else{
            echo "error";
        }

    }

    //异步支付处理
    public function payNotify(){

        try{
            $isok = $this->checkPay();
        }catch (\Exception $exception){
            $isok = false;
        }

        if ($isok){
            echo "success";

            $res = Db::name("orders")
                ->where("state",0)
                ->where("id",input("payId"))
                ->update(array("state"=>1));

            if ($res){
                $order = Db::name("orders")->where("id",input("payId"))->find();

                Db::name("cards")
                    ->where("shopid",$order['shopid'])
                    ->where("state",1)
                    ->limit($order['num'])
                    ->update(array(
                        "orderid"=>$order['id'],
                        "state"=>0,
                    ));

                $cards = Db::name("cards")->where("orderid",$order['id'])->select();
                $card = "";
                for ($i=0;$i<sizeof($cards);$i++){
                    $card.=$cards[$i]['content']."\r\n";
                }

                Db::name("orders")->where("id",$order['id'])->update(array("cards"=>$card));
            }

        }else{
            echo "error";
        }

    }



    public function getOrderByQQ(){
        $qq = input("qq");
        if (!$qq){
            return $this->getReturn(-1,"请输入联系方式");
        }
        $db = Db::name("orders")
            ->where("qq",$qq)
            ->where("state",1)
            ->order("id","desc")
            ->limit(10)
            ->select();

        for ($i=0;$i<sizeof($db);$i++){
            $db[$i]['date']=date("Y-m-d H:i:s",$db[$i]['date']);
        }
        if (sizeof($db)>0){
            return $this->getReturn(1,"成功",$db);

        }else{
            return $this->getReturn(-1,"查询不到相关订单");

        }
    }

    public function getOrderById(){
        $id = input("id");
        if (!$id){
            return $this->getReturn(-1,"id错误");
        }

        $sign = input("sign");

        if (!$sign){
            return $this->getReturn(-1,"sign错误");
        }


        $key = Db::name("setting")->where("vkey","pass")->find();

        $osign = md5($id.$key['vvalue']);
        if ($sign!=$osign){
            return $this->getReturn(-1,"sign错误");
        }




        $db = Db::name("orders")
            ->where("id",$id)
            ->where("state",1)
            ->find();

        if ($db){
            return $this->getReturn(1,$db['shopname'],$db['cards']);
        }else{
            return $this->getReturn(-1,"订单不存在");
        }

    }



    public function clgq(){
        print_r(time()-360);
        $row = Db::name("orders")->where("date<=".(time()-360))->where("state",0)->select();
        print_r($row);
        //return;
        for ($i=0;$i<sizeof($row);$i++){
            Db::name("orders")->where("id",$row[$i]['id'])->update(
                array("state"=>-1)
            );
            Db::name("shop")->where("id",$row[$i]['shopid'])->setInc("kucun",$row[$i]['num']);
        }
        return json($this->getReturn(1,"成功",sizeof($row)));
    }
}
