var cur_seas=2020;

$(document).ready(function(){


    var team1;
    var team2;
    var t1,t2;
    var teams;
    var i;
    var f;
    var j=0;
    var team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];
    // console.log(j);
    // $($(".mtch")[1]).find(".host")[0].innerHTML="";

    function findIndex(x){
        for(i=0;i<8;i++){
            if(team[i]==x){
                return i+1;
            }
        }
    }

    $(".live").parent().click(function(){
                teams=$(this).parent().parent().find(".match");
                t1=teams[0].innerHTML
                t2=teams[1].innerHTML;
                t1=findIndex(t1);
                t2=findIndex(t2);
                console.log(t1+" "+t2);
                $.redirect("toss.php",{
                    fb:0,sm:0,j:j,t1:t1,t2:t2,i1:0,yr:cur_seas
                },"POST");
    });

    $(".host").parent().click(function(){
            teams=$(this).parent().find(".match");
            team1=teams[0].innerHTML;
            team2=teams[1].innerHTML;
            team1=findIndex(team1);
            team2=findIndex(team2);
            console.log(team1+" vs "+team2);
            console.log("HI");
            $.redirect("toss.php",{
                fb:0,sm:0,j:j,t1:team1,t2:team2,i1:0,yr:cur_seas
            },"POST");

    });
});
