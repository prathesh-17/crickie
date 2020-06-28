var cur_seas=2020
$(document).ready(function(){
    var team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];

    var fb,sm,toss,choice,cap1,cap2,wk1,wk2;

    cap1="";cap2="";wk1="";wk2="";

    function findIndex(x){
        for(i=0;i<8;i++){
            if(team[i]==x){
                return i+1;
            }
        }
    }
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
  if(x=="RR"){return "rgb(180,0,180)";}
  if(x=="SRH"){return "rgb(200,102,0)"}
}
var col=func($(".te1").html());
// var col=func("SRH");
$(".team_sel .team1").css({background:col});
var col=func($(".te2").html());
$(".team_sel .team2").css({background:col});

$(document).click(function(e){
    // console.log(e.target.className);
    if(e.target.className!="ch"){
        $(".choices").slideUp();
    }
});

$(".ch").click(function(){
        $(this).next().slideDown();
});

    $(".yr").click(function(){
        $(".choices").slideUp();
        // console.log($(this)[0].id);
        // console.log($(this).parent());
        $(this).parent().parent().find(".lst_y").html($(this)[0].id);
    });


    if($("div").hasClass("team_sel")){
        var fb=$(".te1")[0].innerHTML;
        var sm=$(".te2")[0].innerHTML;

        fb=findIndex(fb);
        sm=findIndex(sm);
    }
    var team1=$(".team1")[0].innerHTML;
    var team2=$(".team2")[0].innerHTML;

    team1=findIndex(team1);
    team2=findIndex(team2);

    $(".t1").parent().click(function(){
        var nm=$(this).find(".t1")[0].innerHTML;
        // console.log(nm);
        var fcnt=$($(".sel")[0]).find(".foreign").length;

        if(fcnt==4 && $(this).find("span").hasClass("foreign")){alert("MORE THAN 4 FOREIGN PLAYERS SELECTED");}
        else if($($(".sel")[0]).find(".t1s").length==11){alert("11 PLAYERS SELECTED");}
        else{
            $("body").load("toss.php",{
                 fb:fb,sm:sm,t1:team1,t2:team2,i1:1,name:nm,j:1
             });}
    });
    $(".t1s").parent().click(function(){
        var nm=$(this).find(".t1s")[0].innerHTML;
        // console.log(nm);
        $("body").load("toss.php",{
             fb:fb,sm:sm,t1:team1,t2:team2,i1:2,name:nm,j:1
         });
    });
    $(".t2").parent().click(function(){
        var nm=$(this).find(".t2")[0].innerHTML;
        // console.log(nm);
        var fcnt=$($(".sel")[1]).find(".foreign").length;
        if(fcnt==4&& $(this).find("span").hasClass("foreign")){alert("MORE THAN 4 FOREIGN PLAYERS SELECTED");}
        else if($($(".sel")[1]).find(".t2s").length==11){alert("11 PLAYERS SELECTED");}
        else{
            $("body").load("toss.php",{
                 fb:fb,sm:sm,t1:team1,t2:team2,i1:3,name:nm,j:1
             });}
    });
    $(".t2s").parent().click(function(){
        var nm=$(this).find(".t2s")[0].innerHTML;
        // console.log(nm);
        $("body").load("toss.php",{
             fb:fb,sm:sm,t1:team1,t2:team2,i1:4,name:nm,j:1
        });
    });

    if($($(".sel")[0]).find(".t1s").length==11&&$($(".sel")[1]).find(".t2s").length==11){
        $(".btn").show("slow");
    }
    else{
        $(".btn").css({display:"none"});
    }




    $(".btn").click(function(){
        console.log(fb+" "+sm+" "+team1+" "+team2);
        $("body").load("toss.php",{
            fb:fb,sm:sm,t1:team1,t2:team2,i1:5,name:"",j:2
        });
    });

    $(".btn1").click(function(){


        cap1=$(".team_sel .year .lst_y")[0].innerHTML;
        wk1=$(".team_sel .year1 .lst_y")[0].innerHTML;
        cap2=$(".team_sel .year2 .lst_y")[0].innerHTML;
        wk2=$(".team_sel .year3 .lst_y")[0].innerHTML;
        console.log(cap1+" "+cap2+" "+wk1+" "+wk2);
        $("body").load("toss.php",{
           fb:fb,sm:sm,t1:team1,t2:team2,i1:5,name:"",j:3,cap1:cap1,cap2:cap2,wk1:wk1,wk2:wk2,yr:cur_seas
        });
    });

    $(".btn2").click(function(){
        $.redirect("scorecard_adm.php",{
                fb:fb,sm:sm,inn:1,rns:0,ovrs:0,blls:0,wks:0,t1:team1,t2:team2,ins:1,yr:cur_seas
        },"POST");
    });

    $(".fb1").click(function(){

        fb=$(".year .yr")[0].innerHTML;
        sm=$(".year .yr")[1].innerHTML;
        toss=$(".year .lst_y").html();
        choice=$(".year1 .lst_y").html();
        toss=findIndex(toss);
        // console.log(toss+fb+sm);
        $.post("toss_ins.php",{t1:team1,t2:team2,toss:toss,ch:choice}).done(function(data){
            console.log(data);
            toss=$(".year .lst_y").html();
            if(choice=="BAT"){
                if(fb!=toss){
                    sm=fb;
                    fb=toss;
                }
            }
            else{
                if(sm!=toss){
                    fb=sm;
                    sm=toss;
                }
            }
            console.log(fb+" "+sm+" "+toss+" "+choice);

            fb=findIndex(fb);
            sm=findIndex(sm);
            console.log(fb+" "+sm+" "+team1+" "+team2);
            $("body").load("toss.php",{
                     fb:fb,sm:sm,t1:team1,t2:team2,i1:0,name:"",j:1
            });
        });


    });


});
