var cur_seas=2020;
var tot_seas=13;
var team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];

function findIndex(x){
    for(i=0;i<8;i++){
        if(team[i]==x){
               return i+1;
        }
    }
}

var t=document.title;
console.log(t);
t=findIndex(t);

$(document).click(function(e){
    // console.log(e.target);
    if(e.target.innerHTML!="CHANGE"){
        $(".choices").slideUp();
    }
});

$(".ch").click(function(){
        $(".choices").slideDown();
});
$(".yr").click(function(){
        for(i=0;i<tot_seas;i++){
            $("."+(2008+i)).css({display:"none"});
        }
        $("."+$(this)[0].id).css({display:"block"});
        $(".choices").slideUp();
        $(".lst_y").html($(this)[0].id);
});

$.post("pl_team_ins.php",{t:t,yr:cur_seas}).done(function(data){$(".playerss").html(data);});

$(".schedule").css({display:"block"});
$(".result").css({display:"none"});
$(".players").css({display:"none"});
$(".stats").css({display:"none"});

$(".sch").click(function(){
    $(".schedule").css({display:"block"});
    $(".result").css({display:"none"});
    $(".players").css({display:"none"});
    $(".stats").css({display:"none"});
});

$(".res").click(function(){
    $(".schedule").css({display:"none"});
    $(".result").css({display:"block"});
    $(".players").css({display:"none"});
    $(".stats").css({display:"none"});
});

$(".plyrs").click(function(){
    $(".schedule").css({display:"none"});
    $(".result").css({display:"none"});
    $(".players").css({display:"block"});
    $(".stats").css({display:"none"});
});

$(".st").click(function(){
    $(".schedule").css({display:"none"});
    $(".result").css({display:"none"});
    $(".players").css({display:"none"});
    $(".stats").css({display:"block"});
});

$("select[name='year']").change(function(){
    var yr=$("select[name='year']")[0].value;
    $.post("pl_team_ins.php",{t:t,yr:yr}).done(function(data){$(".playerss").html(data);});
});

$(".stat").css({display:"none"});
$(".back").css({display:"none"});
$(".back").click(function(){
        $(".batting").css({display:"block"});
        $(".bowling").css({display:"block"});
        $(".back").css({display:"none"});
        $(".stat").css({display:"none"});
        $(".Title").css({display:"block"});
});

$(".bt").click(function(){
    var bt=$(this)[0].id;
    $.post("stats.php",{t:t,vr:bt,b:0}).done(function(data){
        $(".stat").fadeOut("fast",function(){
          $(".stat").html(data);
          $(".stat").fadeIn("slow");
        });
        // $(".back").css({display:"block"});
        $(".stat").css({display:"block"});
        $(".Title").css({display:"none"});
    });

});

$(".bl").click(function(){
    var bl=$(this)[0].id;
    // console.log(bl);
    $.post("stats.php",{t:t,vr:bl,b:1}).done(function(data){
        $(".stat").fadeOut("fast",function(){
          $(".stat").html(data);
          $(".stat").fadeIn("slow");
        });
        // $(".back").css({display:"block"});
        $(".stat").css({display:"block"});
        $(".Title").css({display:"none"});
    });
});

$(".player").click(function(){
        console.log($(this)[0].id);
        $.redirect("player.php",{
            name:$(this)[0].id
        },"GET");
});

function func(x){
  if(x=="CSK"){return "linear-gradient(to right,rgba(255,215,0,1.0),rgba(255,215,0,0.6)";}
  if(x=="DC"){return "linear-gradient(to right,rgba(0,191,255,1.0),rgba(0,0,139,1.0)";}
  if(x=="KXIP"){return "linear-gradient(to right,rgba(220,20,60,1.0),rgba(200,200,200,1.0)";}
  if(x=="KKR"){return "linear-gradient(to right,rgba(38,0,77,1.0),rgba(38,0,77,0.7)";}
  if(x=="MI"){return "linear-gradient(to right,rgba(0,0,139,1.0),rgba(0,0,139,0.7)";}
  if(x=="RCB"){return "linear-gradient(to right,rgba(220,20,60,1.0),rgba(220,20,60,0.7)";}
  if(x=="RR"){return "linear-gradient(to right,rgba(255,0,255,1.0),rgba(0,0,139,0.7)";}
  if(x=="SRH"){return "linear-gradient(to right,rgba(255,102,0,1.0),rgba(10,10,10,1.0)";}
}

$(".comp_mtch").each(function(){
  var grad=func($(this).find(".team").html());
  // console.log(grad);
  $(this).css({background:grad});

});

$(".live_mtch").each(function(){
  if($(this).find("span").hasClass("team2")){
    $(".live_mtch .score1").css({left:"0"});
    var grad=func($(this).find(".team2").html());
  }
  else{
    var grad=func($(this).find(".team1").html());
  }
  console.log(grad);
  $(this).css({background:grad});
});

$(".batting").css({display:"block"});
$(".bowling").css({display:"none"});

$(".bt1").click(function(){
  $(".bowling").slideUp("slow",function(){
    $(".batting").slideDown("slow",dis);
  });
  function dis(){
    $(".batting").css({display:"block"});
  }
});

$(".bt2").click(function(){
  $(".batting").slideUp("slow",function(){
    $(".bowling").slideDown("slow",dis);
  });
  function dis(){
    $(".bowling").css({display:"block"});
  }
});
