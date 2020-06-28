function func(x){
  if(x=="CSK"){return "linear-gradient(to right,rgba(255,215,0,1.0),rgba(255,215,0,0.6))";}
  if(x=="DC"){return "linear-gradient(to right,rgba(0,191,255,1.0),rgba(0,0,139,1.0))";}
  if(x=="KXIP"){return "linear-gradient(to right,rgba(220,20,60,1.0),rgba(200,200,200,1.0))";}
  if(x=="KKR"){return "linear-gradient(to right,rgba(38,0,77,1.0),rgba(38,0,77,0.7))";}
  if(x=="MI"){return "linear-gradient(to right,rgba(0,0,139,1.0),rgba(0,0,139,0.7))";}
  if(x=="RCB"){return "linear-gradient(to right,rgba(220,20,60,1.0),rgba(220,20,60,0.7))";}
  if(x=="RR"){return "linear-gradient(to right,rgba(255,0,255,1.0),rgba(0,0,139,0.7))";}
  if(x=="SRH"){return "linear-gradient(to right,rgba(255,102,0,1.0),rgba(10,10,10,1.0))";}
}

function func1(x){
  if(x=="CSK"){return "rgb(255,215,0)";}
  if(x=="DC"){return "rgb(0,191,255)";}
  if(x=="KXIP"){return "rgb(220,20,0)";}
  if(x=="KKR"){return "rgb(38,0,77)";}
  if(x=="MI"){return "rgb(0,0,139)";}
  if(x=="RCB"){return "rgb(220,20,60)";}
  if(x=="RR"){return "rgb(150,0,150)";}
  if(x=="SRH"){return "rgb(200,102,0)"}
}

$(".l_inf").css({display:"block"});
$(".s_info").css({display:"none"});
$(".sc_inf").css({display:"none"});

$(".info").click(function(){
    $(".l_inf").css({display:"none"});
    $(".s_info").css({display:"block"});
    $(".sc_inf").css({display:"none"});
});
$(".live").click(function(){
    $(".l_inf").css({display:"block"});
    $(".s_info").css({display:"none"});
    $(".sc_inf").css({display:"none"});
});
$(".score").click(function(){
    $(".l_inf").css({display:"none"});
    $(".s_info").css({display:"none"});
    $(".sc_inf").css({display:"block"});
});

$(".squad").css({display:"none"});
$(".inf").css({display:"block"});

var t1=$(".st_sel .team")[0].innerHTML;
var t2=$(".st_sel .team")[1].innerHTML;

$(".st_sel .team").click(function(){
    $(".squad").css({display:"block"});
    $(".inf").css({display:"none"});

    $("."+t1).css({display:"none"});
    $("."+t2).css({display:"none"});
    var col=func1($(this).html());
    $("."+$(this).html()).css({display:"block"});
    // console.log(col);
    // $(".squad").css({background:col});
});

var col1=func1($(".l_inf .play .team1").html());
var col2=func1($(".l_inf .play .team2").html());
$(".l_inf .play .team1").css({background:col1});
$(".l_inf .play .team2").css({background:col2});

$(".st_sel .team").each(function(){
    var grad=func($(this).html());
    // console.log(grad);
    $(this).css({background:grad});
});

if(!$("div").hasClass("score2")){
  var col=func($(".score1 .team").html());
  // console.log(col);
  $(".btsmn").css({background:col});
}
else{
  var col=func1($(".score2 .team").html());
  // var col=func1("SRH");
  // console.log(col);
  $(".btsmn .player").css({background:col});
  var col=func1($(".score1 .team").html());
  $(".bwlr .player").css({background:col});
}

// $(".st .team").click(function(){
//     $("."+t1).css({display:"none"});
//     $("."+t2).css({display:"none"});
//     $("."+$(this).html()).css({display:"block"});
// });

$(".back").click(function(){
    $(".squad").css({display:"none"});
    $(".inf").css({display:"block"});
});
$(".player").click(function(){
        // console.log($(this)[0].id);
        $.redirect("player.php",{
            name:$(this)[0].id
        },"GET");
});

if($("div").hasClass("inn1")){
    $(".inn_sc").css({display:"none"});
    $(".inn_sc1").css({display:"block"});
}
$(".inn1").click(function(){
    var f=1
    if($(".inn_sc")[0].style.display=="none" && $(".inn_sc1")[0].style.display=="block"){
        $(".inn_sc1").css({display:"none"});
        f=0;
    }
    if(($(".inn_sc")[0].style.display=="block" || ($(".inn_sc")[0].style.display=="none" && $(".inn_sc1")[0].style.display=="none"))&& f==1){
        $(".inn_sc").css({display:"none"});
        $(".inn_sc1").css({display:"block"});
    }

});
$(".inn").click(function(){
    var f=1;
    if($(".inn_sc1")[0].style.display=="none" && $(".inn_sc")[0].style.display=="block"){
        $(".inn_sc").css({display:"none"});
        f=0;
    }
    if(($(".inn_sc1")[0].style.display=="block" || ($(".inn_sc")[0].style.display=="none" && $(".inn_sc1")[0].style.display=="none"))&& f==1){
        $(".inn_sc").css({display:"block"});
        $(".inn_sc1").css({display:"none"});
    }

});



var col=func($(".inn .team").html())
// var col=func("RR");
$(".inn").css({background:col});


if($("div").hasClass("inn1")){
  var col=func($(".inn1 .team").html())
  $(".inn1").css({background:col});
}
