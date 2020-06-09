<?php
/**
 *說明
 *index.php?m=ne&c=index&v=index
 *參數
 *m 代表模組，亦是資料夾名稱
 *c 代表控制器，亦是檔案名稱
 *v 代表視界，亦是區塊名稱
 * 
 *規則1：
 * 如各模組(m)下有以下檔案Main.html、Header.html、LinksLeft.html、LinksRight.html、Footer.html會以各模組的為優先，
 * 不存在該檔案時才以預設模組(COM)下的檔案優先。
 * 
 * 
 */
include_once('./lib/TemplatePower/class.TemplatePower.inc.php');


//預設module、ctrler、view
$defaultDispatcher = array(
"m"     => null,
"c"     => "index",
"v"     => "index"
);
//目前module、ctrler、view
$currentDispatcher = array(
"m"     => (isset($_GET["m"])) ? $_GET["m"]: $defaultDispatcher["m"],
"c"     => (isset($_GET["c"])) ? $_GET["c"]: $defaultDispatcher["c"],
"v"     => (isset($_GET["v"])) ? $_GET["v"]: $defaultDispatcher["v"]
);

$frontCtrl=array(//新版前台页面无左侧导航栏
    // 'news', 'info','dynamic'
);

if (in_array($currentDispatcher['c'],$frontCtrl)){
    //樣板路徑(默认left模板路径为newLeft)
    $modulePath = ($currentDispatcher["m"] != null) ? "./".$currentDispatcher["m"]: ".";
    $tmpFilepath = array(
        "Main"          => $modulePath."/Main.html",
        "Header"        => $modulePath."/Header.html",
        "Left"           => $modulePath."/newsLeft.html",
        "Content"       => $modulePath."/".$currentDispatcher["c"].".html",
        "Footer"        => $modulePath."/Footer.html",
    );
    //樣板路徑(m==null && c==info 时模板路径为infoLeft)
    if($currentDispatcher["m"] == null && $currentDispatcher['c']=='info'){
        $tmpFilepath = array(
            "Main"          => $modulePath."/Main.html",
            "Header"        => $modulePath."/Header.html",
            "Left"         => $modulePath."/infoLeft.html",
            "Content"       => $modulePath."/".$currentDispatcher["c"].".html",
            "Footer"        => $modulePath."/Footer.html",
        );
    }else if ($currentDispatcher["m"] == null && $currentDispatcher['c']=='dynamic'){
        $tmpFilepath = array(
            "Main"          => $modulePath."/Main.html",
            "Header"        => $modulePath."/Header.html",
            "Left"         => $modulePath."/dynamicLeft.html",
            "Content"       => $modulePath."/".$currentDispatcher["c"].".html",
            "Footer"        => $modulePath."/Footer.html",
        );
    }
    //處理by module優先的樣板路徑
    if(!file_exists($tmpFilepath["Main"])) $tmpFilepath["Main"] = "./Main.html";
    if(!file_exists($tmpFilepath["Header"])) $tmpFilepath["Header"] = "./Header.html";
    //c==news 时，引入newsLeft.html；c==info 时，引入 infoLeft.html
    if($currentDispatcher["m"] == null && $currentDispatcher['c']=='news'){
        if(!file_exists($tmpFilepath["Left"])) $tmpFilepath["Left"] = "./newsLeft.html";
    }else{
        if(!file_exists($tmpFilepath["Left"])) $tmpFilepath["Left"] = "./infoLeft.html";
    }
    if(!file_exists($tmpFilepath["Footer"])) $tmpFilepath["Footer"] = "./Footer.html";


    $Template =  new TemplatePower($tmpFilepath["Main"]);
    $Template -> assignInclude("Header", $tmpFilepath["Header"]);

    //引入Content
    $Template -> assignInclude("Content", $tmpFilepath["Content"]);
    $Template -> assignInclude("Left", $tmpFilepath["Left"]);
    $Template -> assignInclude("Footer", $tmpFilepath["Footer"]);
    $Template -> prepare();
}else{
    //樣板路徑
    $modulePath = ($currentDispatcher["m"] != null) ? "./".$currentDispatcher["m"]: ".";
    $tmpFilepath = array(
        "Main"          => $modulePath."/Main.html",
        "Header"        => $modulePath."/Header.html",
        "Right"         => $modulePath."/Right.html",
        "Content"       => $modulePath."/".$currentDispatcher["c"].".html",
        "Footer"        => $modulePath."/Footer.html",
    );

    //處理by module優先的樣板路徑
    if(!file_exists($tmpFilepath["Main"])) $tmpFilepath["Main"] = "./Main.html";
    if(!file_exists($tmpFilepath["Header"])) $tmpFilepath["Header"] = "./Header.html";
    if(!file_exists($tmpFilepath["Right"])) $tmpFilepath["Right"] = "./Right.html";
    if(!file_exists($tmpFilepath["Footer"])) $tmpFilepath["Footer"] = "./Footer.html";

    $Template =  new TemplatePower($tmpFilepath["Main"]);
    $Template -> assignInclude("Header", $tmpFilepath["Header"]);

    //引入Right
    //$_GET[''m"]!=null时，不引入Right.html
    //$_GET[''c"]=="home"时，引入Right.html
    // if($currentDispatcher['m']!=null || $currentDispatcher['c']=='home'){
    //     $Template -> assignInclude("Right", $tmpFilepath["Right"]);
    // }
    //引入Content
    $Template -> assignInclude("Content", $tmpFilepath["Content"]);

    $Template -> assignInclude("Footer", $tmpFilepath["Footer"]);
    $Template -> prepare();
}
    //處理Content
    $Template -> newBlock($currentDispatcher["v"]);

    $Template -> printToScreen();
