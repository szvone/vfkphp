<?php
namespace app\admin\controller;

use think\Db;
use think\facade\Session;

class Index
{
    public function getReturn($code = 1,$msg = "成功",$data = null){
        return array("code"=>$code,"msg"=>$msg,"data"=>$data);
    }

    public function addShoptype(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        

        $name = input("name");
        $row = Db::name("shoptype")->insert(array(
            "name"=>$name
        ));
        return $this->getReturn();
    }
    public function delShoptype(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        

        $row = Db::name("shoptype")->where("id",input("id"))->delete();

        return $this->getReturn();
    }
    public function getShoptype(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        

        $row = Db::name("shoptype")->select();
        return $this->getReturn(0,"成功",$row);
    }
    public function editShoptype(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        

        $row = Db::name("shoptype")->where("id",input("id"))->update(array(input("key")=>input("value")));


        Db::name("shop")->where("typeid",input("id"))->update(array("typename"=>input("value")));
        return $this->getReturn(1,"成功",$row);
    }



    public function addShop(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        

        $row = Db::name("shop")->insert(array(
            "typeid"=>input("shoptype"),
            "typename"=>input("typename"),
            "shopname"=>input("shopname"),
            "shoptext"=>input("shoptext"),
            "xiaoliang"=>0,
            "kucun"=>0,
            "money"=>input("money"),
            "state"=>1
        ));
        return $this->getReturn();
    }
    public function delShop(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        

        $row = Db::name("shop")->where("id",input("id"))->delete();
        Db::name("cards")->where("shopid",input("id"))->delete();

        return $this->getReturn();
    }
    public function getShop(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        
        $page = input("page");
        $size = input("limit");
        $row = Db::name("shop");
        if (input("page")){
            $row = $row->page($page,$size);
        }

        if (input("type")){
            $row = $row->where("typeid",input("type"));
        }
        $count = $row->count();
        $row = $row->select();


        return array("code"=>0,"msg"=>"成功","data"=>$row,"count"=>$count);
    }
    public function getShopByid(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        
        $row = Db::name("shop")->where("id",input("id"))->find();
        return $this->getReturn(1,"成功",$row);
    }
    public function editShop(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        
        $row = Db::name("shop")->where("id",input("id"))->update(array(
            "typeid"=>input("shoptype"),
            "shopname"=>input("shopname"),
            "shoptext"=>input("shoptext"),
            "money"=>input("money"),
            "xiaoliang"=>input("xiaoliang"),
        ));

        return $this->getReturn(1,"成功",$row);
    }
    public function setShopstate(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        
        $row = Db::name("shop")->where("id",input("id"))->update(array(
            "state"=>input("state")
        ));
        return $this->getReturn(1,"成功",$row);
    }

    public function addKm(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        

        $sz = explode("\n",input("kms"));
        $sum=0;
        for ($i=0;$i<sizeof($sz);$i++){
            if ($sz[$i]==""){
                continue;
            }
            $sum+= Db::name("cards")->insert(array(
                "content"=>$sz[$i],
                "state"=>1,
                "shopid"=>input("shopid"),
                "updatetime"=>time(),
                "selltime"=>0,
                "orderid"=>-1
            ));
        }
        Db::name("shop")
            ->where("id",input("shopid"))
            ->setInc("kucun",$sum);


        return $this->getReturn(1,"成功添加".$sum."张卡密");
    }
    public function delKm(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        

        $row = Db::name("cards")->where("id",input("id"))->delete();
        Db::name("shop")->where("id",input("shopid"))->setDec("kucun",1);
        return $this->getReturn();
    }
    public function getKm(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        
        $page = input("page");
        $size = input("limit");
        $row = Db::name("cards");
        if (input("page")){
            $row = $row->page($page,$size);
        }


        if (input("state")!=""){
            $row = $row->where("state",input("state"));
        }
        if (input("shopid")){
            $row = $row->where("shopid",input("shopid"));
        }
        $count = $row->count();
        $row = $row->order("id","desc")->select();


        return array("code"=>0,"msg"=>"成功","data"=>$row,"count"=>$count);
    }
    public function editKm(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }


        $row = Db::name("cards")->where("id",input("id"))->update(array(input("key")=>input("value")));
        return $this->getReturn(1,"成功",$row);
    }

    public function dcKm(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        
        $shopid = input("id");
        $size = input("num");


        $row = Db::name("cards")
            ->where("shopid",$shopid)
            ->where("state","1")
            ->limit(0,$size)
            ->select()
        ;

        $res = "";
        for ($i=0;$i<sizeof($row);$i++){

            Db::name("cards")->where("id",$row[$i]['id'])->delete();
            Db::name("shop")->where("id",$shopid)->setDec("kucun",1);

            $res.=$row[$i]['content']."\r\n";
        }

        return json(array("code"=>1,"msg"=>"成功","data"=>$res));
    }




    public function getOrder(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        
        $page = input("page");
        $size = input("limit");
        $row = Db::name("orders");
        if (input("page")){
            $row = $row->page($page,$size);
        }


        if (input("state")!=""){
            $row = $row->where("state",input("state"));
        }
        if (input("shopid")){
            $row = $row->where("shopid",input("shopid"));
        }
        if (input("qq")){
            $row = $row->where("qq",input("qq"));
        }
        $count = $row->count();
        $row = $row->order("id","desc")->select();


        return array("code"=>0,"msg"=>"成功","data"=>$row,"count"=>$count);
    }






    public function getSetting(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        
        $array = array();

        $res = Db::name("setting")->where("vkey","name")->find();
        $array['name']=$res['vvalue'];


        $res = Db::name("setting")->where("vkey","gg")->find();
        $array['gg']=$res['vvalue'];


        $res = Db::name("setting")->where("vkey","user")->find();
        $array['user']=$res['vvalue'];
        $res = Db::name("setting")->where("vkey","pass")->find();
        $array['pass']=$res['vvalue'];

        $res = Db::name("setting")->where("vkey","vmq")->find();
        $array['vmq']=$res['vvalue'];

        return json($this->getReturn(1,"成功",$array));


    }
    public function saveSetting(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        
        $res = Db::name("setting")->where("vkey","name")->update(array("vvalue"=>input("name")));
        $res = Db::name("setting")->where("vkey","gg")->update(array("vvalue"=>input("gg")));
        $res = Db::name("setting")->where("vkey","user")->update(array("vvalue"=>input("user")));
        $res = Db::name("setting")->where("vkey","pass")->update(array("vvalue"=>input("pass")));
        $res = Db::name("setting")->where("vkey","vmq")->update(array("vvalue"=>input("vmq")));

        return $this->getReturn();
    }


    public function getMain(){
        if (!Session::has("admin")){
            return json($this->getReturn(-1,"没有登录"));
        }
        

        $today = strtotime(date("Y-m-d",time()));
        $todayOrder = Db::name("orders")->where("date >".$today)->where("state",1)->count();
        $todayMoney = Db::name("orders")->where("date >".$today)->where("state",1)->sum("money");
        $cardcount = Db::name("cards")->where("state",1)->count();
        $allOrder = Db::name("orders")->where("state",1)->count();
        $allMoney = Db::name("orders")->where("state",1)->sum("money");
        $shopcount = Db::name("shop")->count();
        return $this->getReturn(1,"成功",array(
            "todayOrder"=>$todayOrder,
            "todayMoney"=>$todayMoney,
            "cardcount"=>$cardcount,
            "allOrder"=>$allOrder,
            "allMoney"=>$allMoney,
            "shopcount"=>$shopcount
        ));
    }

}
