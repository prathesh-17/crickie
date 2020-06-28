var team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];

function findIndex(x){
    for(i=0;i<8;i++){
        if(team[i]==x){
               return i+1;
        }
    }
}

$("document").ready(function(){

    $(".live_mtchs").css({display:"block"});
    $(".upcoming_mtchs").css({display:"none"});
    $(".comp_mtchs").css({display:"none"});
    $(".seas_det").css({display:"none"});

    $(".live").click(function(){

        if($(".upcoming_mtchs")[0].style.display=="block"){
          $(".upcoming_mtchs").slideUp("fast",ch);
        }
        if($(".comp_mtchs")[0].style.display=="block"){
          $(".comp_mtchs").slideUp("fast",ch);
        }
        if($(".seas_det")[0].style.display=="block"){
          $(".seas_det").slideUp("fast",ch);
        }
        function ch(){
          $(".live_mtchs").slideDown("fast",dis);
        }
        function dis(){
          $(".live_mtchs").css({display:"block"});
        }
    });
    $(".upcoming").click(function(){
        if($(".live_mtchs")[0].style.display=="block"){
          $(".live_mtchs").slideUp("fast",ch);
        }
        if($(".comp_mtchs")[0].style.display=="block"){
          $(".comp_mtchs").slideUp("fast",ch);
        }
        if($(".seas_det")[0].style.display=="block"){
          $(".seas_det").slideUp("fast",ch);
        }
        function ch(){
          $(".upcoming_mtchs").slideDown("fast",dis);
        }
        function dis(){
          $(".upcoming_mtchs").css({display:"block"});
        }
    });
    $(".recent").click(function(){
        if($(".upcoming_mtchs")[0].style.display=="block"){
          $(".upcoming_mtchs").slideUp("fast",ch);
        }
        if($(".live_mtchs")[0].style.display=="block"){
          $(".live_mtchs").slideUp("fast",ch);
        }
        if($(".seas_det")[0].style.display=="block"){
          $(".seas_det").slideUp("fast",ch);
        }
        function ch(){
          $(".comp_mtchs").slideDown("fast",dis);
        }
        function dis(){
          $(".comp_mtchs").css({display:"block"});
        }
    });
   $(".det").click(function(){
        if($(".upcoming_mtchs")[0].style.display=="block"){
          $(".upcoming_mtchs").slideUp("fast",ch);
        }
        if($(".comp_mtchs")[0].style.display=="block"){
          $(".comp_mtchs").slideUp("fast",ch);
        }
        if($(".live_mtchs")[0].style.display=="block"){
          $(".live_mtchs").slideUp("fast",ch);
        }
        function ch(){
          $(".seas_det").slideDown("fast",dis);
        }
        function dis(){
          $(".seas_det").css({display:"block"});
        }
        $(".pts_tab").css({display:"block"});
        $(".org_cap").css({display:"none"});
        $(".purp_cap").css({display:"none"});
    });
   $(".pt").click(function(){
        if($(".org_cap")[0].style.display=="block"){
          $(".org_cap").fadeOut("fast",ch);
        }
        if($(".purp_cap")[0].style.display=="block"){
          $(".purp_cap").fadeOut("fast",ch);
        }
        function ch(){
          $(".pts_tab").fadeIn("slow",dis);
        }
        function dis(){
          $(".pts_tab").css({display:"block"});
        }
  });
   $(".orc").click(function(){
        if($(".pts_tab")[0].style.display=="block"){
          $(".pts_tab").fadeOut("fast",ch);
        }
        if($(".purp_cap")[0].style.display=="block"){
          $(".purp_cap").fadeOut("fast",ch);
        }
        function ch(){
          $(".org_cap").fadeIn("slow",dis);
        }
        function dis(){
          $(".org_cap").css({display:"block"});
        }
    });
   $(".prc").click(function(){
        if($(".org_cap")[0].style.display=="block"){
          $(".org_cap").fadeOut("fast",ch);
        }
        if($(".pts_tab")[0].style.display=="block"){
          $(".pts_tab").fadeOut("fast",ch);
        }
        function ch(){
          $(".purp_cap").fadeIn("slow",dis);
        }
        function dis(){
          $(".purp_cap").css({display:"block"});
        }
  });
  $(".FRANCHISE").click(function(){
        // console.log($(this)[0].id);
        $.redirect("team.php",{
            t:parseInt($(this)[0].id)
        },"GET");
  });
  $("img").click(function(){
    $("body").fadeOut("slow",function(){
      $.redirect("search-form.php");
    });
  });
  $(".upcoming_match").click(function(){
    var t1=$(this).find("div")[1].innerHTML.split(" vs ")[0];
    var t2=$(this).find("div")[1].innerHTML.split(" vs ")[1];
    t1=findIndex(t1);
    t2=findIndex(t2);
    $.redirect("score.php",{t1:t1,t2:t2,fb:t1,sm:t2,st:0},"POST");
  });
  $(".live_mtch").click(function(){
    var t1=$(this).find("div")[1].innerHTML.split(" vs ")[0];
    var t2=$(this).find("div")[1].innerHTML.split(" vs ")[1];
    var fb=$(this).find("span")[0].innerHTML;
    t1=findIndex(t1);
    t2=findIndex(t2);
    fb=findIndex(fb);
    if(fb==t1){sm=t2;}else{sm=t1;}
    console.log(t1+" "+t2+" "+fb+" "+sm);
    $.redirect("score.php",{t1:t1,t2:t2,fb:fb,sm:sm,st:1},"POST");
  });

  $(".comp_mtch").click(function(){
    var t1=$(this).find("div")[1].innerHTML.split(" vs ")[0];
    var t2=$(this).find("div")[1].innerHTML.split(" vs ")[1];
    var fb=$(this).find(".score1 span")[0].innerHTML;
    t1=findIndex(t1);
    t2=findIndex(t2);
    fb=findIndex(fb);
    if(fb==t1){sm=t2;}else{sm=t1;}
    console.log(t1+" "+t2+" "+fb+" "+sm);
    $.redirect("score.php",{t1:t1,t2:t2,fb:fb,sm:sm,st:2},"POST");
  });

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

// function func1(x){
//   if(x=="CSK"){return "rgb(255,215,0)";}
//   if(x=="DC"){return "rgb(0,191,255)";}
//   if(x=="KXIP"){return "rgb(220,20,60)";}
//   if(x=="KKR"){return "rgb(38,0,77)";}
//   if(x=="MI"){return "rgb(0,0,139)";}
//   if(x=="RCB"){return "rgb(220,20,60);"}
//   if(x=="RR"){return "rgb(255,0,255)";}
//   if(x=="SRH"){return "rgb(255,102,0)"}
// }

$(".comp_mtch").each(function(){
  var grad=func($(this).find(".team").html());
  $(this).css({background:grad});

});
$(".pts_tab table tr td:nth-child(1)").each(function(){

    var col=func($(this).html());

    $(this).parent().css({background:col});
});
$(".live_mtch").each(function(){
  if($(this).find("span").hasClass("team2")){
    $(".live_mtch .score1").css({left:"0"});
    var grad=func($(this).find(".team2").html());
  }
  else{
    var grad=func($(this).find(".team1").html());
  }
  // console.log(grad);
  $(this).css({background:grad});
});

$(".player").click(function(){
        console.log($(this)[0].id);
        $.redirect("player.php",{
            name:$(this)[0].id
        },"GET");
});
