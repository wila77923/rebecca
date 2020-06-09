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
 * 如各模組(m)下有以下檔案Main.html、Header.html、Left.html、Footer.html會以各模組的為優先，
 * 不存在該檔案時才以預設模組(COM)下的檔案優先。
 * 
 * 
 */
include_once('./lib/TemplatePower/class.TemplatePower.inc.php');


//預設module、ctrler、view
$defaultDispatcher = array(
"m"     => "p",
"c"     => "index",
"v"     => "index"
);
//目前module、ctrler、view
$currentDispatcher = array(
"m"     => (isset($_GET["m"])) ? $_GET["m"]: $defaultDispatcher["m"],
"c"     => (isset($_GET["c"])) ? $_GET["c"]: $defaultDispatcher["c"],
"v"     => (isset($_GET["v"])) ? $_GET["v"]: $defaultDispatcher["v"]
);

$frontCtrl=array(
    'Portal_company', 'Portal_factotyTrend','Portal_factotyTrend'
);
if(in_array($currentDispatcher["c"],$frontCtrl)){
        //樣板路徑
        $modulePath = ($currentDispatcher["m"] != null) ? "./".$currentDispatcher["m"]: ".";
        $tmpFilepath = array(
            "Main"          => $modulePath."/Portal_main.html",
            "Header"        => $modulePath."/Portal_header.html",
            "Content"       => $modulePath."/".$currentDispatcher["c"].".html",
            "Footer"        => $modulePath."/Portal_footer.html",
        );
        //当c=Portal_factotyTrend的模板路径
        if ($currentDispatcher["c"]=="Portal_factotyTrend"){
            $tmpFilepath = array(
                "Main"          => $modulePath."/Portal_main.html",
                "Header"        => $modulePath."/Portal_header.html",
                "Left"      => $modulePath."/Portal_left.html",
                "Content"       => $modulePath."/".$currentDispatcher["c"].".html",
                "Footer"        => $modulePath."/Portal_footer.html",
            );
        }
        //處理by module優先的樣板路徑
        if(!file_exists($tmpFilepath["Main"])) $tmpFilepath["Main"] = "./p/Portal_main.html";
        if(!file_exists($tmpFilepath["Header"])) $tmpFilepath["Header"] = "./p/Portal_header.html";
        //当c=Portal_factotyTrend时加入left模板路径
        if($currentDispatcher['c']=="Portal_factotyTrend"){
            if(!file_exists($tmpFilepath["Left"])) $tmpFilepath["Left"] = "./p/Portal_left.html";
        }
        if(!file_exists($tmpFilepath["Footer"])) $tmpFilepath["Footer"] = "./p/Portal_footer.html";

        $Template =  new TemplatePower($tmpFilepath["Main"]);
        $Template -> assignInclude("Header", $tmpFilepath["Header"]);

        //引入Content
        $Template -> assignInclude("Content", $tmpFilepath["Content"]);
        //当c=Portal_factotyTrend时引入left模板
        if($currentDispatcher['c']=="Portal_factotyTrend"){
            $Template -> assignInclude("Left", $tmpFilepath["Left"]);
        }
        $Template -> assignInclude("Footer", $tmpFilepath["Footer"]);
        $Template -> prepare();
//    }
}else{
    //樣板路徑
    $modulePath = ($currentDispatcher["m"] != null) ? "./".$currentDispatcher["m"]: ".";
    $tmpFilepath = array(
        "Main"          => $modulePath."/Main.html",
        "Header"        => $modulePath."/Header.html",
        "Left"         => $modulePath."/Left.html",
        "Content"       => $modulePath."/".$currentDispatcher["c"].".html",
        "Footer"        => $modulePath."/Footer.html",
    );
    //處理by module優先的樣板路徑
    if(!file_exists($tmpFilepath["Main"])) $tmpFilepath["Main"] = "./p/Main.html";
    if(!file_exists($tmpFilepath["Header"])) $tmpFilepath["Header"] = "./p/Header.html";
    if(!file_exists($tmpFilepath["Left"])) $tmpFilepath["Left"] = "./p/Left.html";
    if(!file_exists($tmpFilepath["Footer"])) $tmpFilepath["Footer"] = "./p/Footer.html";

    $Template =  new TemplatePower($tmpFilepath["Main"]);
    $Template -> assignInclude("Header", $tmpFilepath["Header"]);

    //引入Left
    $Template -> assignInclude("Left", $tmpFilepath["Left"]);

    //引入Content
    $Template -> assignInclude("Content", $tmpFilepath["Content"]);

    $Template -> assignInclude("Footer", $tmpFilepath["Footer"]);
    $Template -> prepare();
}
//處理Content
$Template -> newBlock($currentDispatcher["v"]);

$Template -> printToScreen();
