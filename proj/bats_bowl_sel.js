$(document).ready(function(){
    var inn1;
    // console.log("running");
    if(!$("span").hasClass("scre2")){
        inn1=1;
    }
    else{
        inn1=2;
    }
    var tt=3;
    var str;
    var blr;

    var team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];

    function findIndex(x){
        for(i=0;i<8;i++){
            if(team[i]==x){
                return i+1;
            }
        }
    }
    var t1=$(".tm")[0].innerHTML;
    var t2=$(".tm")[1].innerHTML;

    t1=findIndex(t1);
    t2=findIndex(t2);

    $(".bts_sel1").click(function(){
        console.log(inn1);
        var nonstr=$(".bt .ch")[0].innerHTML;
        console.log(nonstr);
        $.post("bats_bowl_sel.php",{
            t1:t1,t2:t2,inn:inn1,str:nonstr,i:1,ab:1
        }).done(function(data){
            $(".bts").html(data);
            $(".bts2").hide("slow",function(){$(".bwls").show("slow")});
        });
    });

    $(".bts_sel2").click(function(){

        str=$(".bt .ch")[0].innerHTML;
        console.log(str);

        $.post("bats_bowl_sel.php",{
            t1:t1,t2:t2,inn:inn1,str:str,i:0,ab:1
        }).done(function(data){
            $.post("bats_bowl_sel.php",{
                t1:t1,t2:t2,inn:inn1,str:"",i:2,ab:0
                }).done(function(data1){
                    $(".sss").html(data1);
            });
            $(".bts").html(data);
            $(".bts_sel2").hide("slow",function(){$(".bts_sel1").show("slow")});

        });
    });



});
