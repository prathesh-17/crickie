 $("document").ready(function(){
    var ss,ro=0;
    var lb=0;var nb=0;var wd=0;
    var bls=0;
    var lock=0;
    var total=3;
    var nbb=0;
    var score=$("div span");
    var run=parseInt($(".scre")[0].innerHTML);
    var wkt=parseInt($(".scre")[2].innerHTML);
    var ch=0;
    var overs=parseInt($(".scre1")[0].innerHTML);
    var balls=parseInt($(".scre1")[2].innerHTML);
    var fldr="",strk="",out="",nxtb="";
    var bwlr,blst,ovr,mdn,rn,wk;
    var fb,t1,sm,t2,ins=2,inn=1;
    var wo="";
    var oob=0;
    if($("div").hasClass("striker")){
        var srun=parseInt($(".striker span")[1].innerHTML);
        var sball=$(".striker span")[2].innerHTML;
        sball=parseInt(sball.substring(1,sball.length-1));
        // console.log(srun+" "+sball);
    }
    var l=0;

    var team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];

    function findIndex(x){
        for(i=0;i<8;i++){
            if(team[i]==x){
                return i+1;
            }
        }
    }
    if($("span").hasClass("draw")||$("span").hasClass("tm_won")){
        $(".comp").css({display:"none"});
    }
    if(run==0&&wkt==0&&overs==0&&balls==0&&!$("div").hasClass("striker")){
        // console.log("running");
        $(".bts2").parent().show("slow");
        $(".bts2").css({display:"inline-block"});

        // $(".bts_sel2").css({display:""});
    }

    if(run==0&&wkt==0&&overs==0&&balls==0 && $("div").hasClass("striker") &&  !$("div").hasClass("nonstriker")){
        // console.log("running");
        $(".bts2").parent().show("slow");
        $(".bts2").css({display:"inline-block"});

        $(".bts_sel2").css({display:"none"});
        $(".bts_sel1").css({display:"block"});
    }

    if(run==0&&wkt==0&&overs==0&&balls==0&& $("div").hasClass("striker") && $("div").hasClass("nonstriker") ){
        if(!$("span").hasClass("bowler")){
            $(".bwls").css({display:"inline-block"});
        }
    }

    sm=$(".sm")[0].innerHTML;
    fb=$(".fb")[0].innerHTML;



    t1=$(".tm")[0].innerHTML;
    t2=$(".tm")[1].innerHTML;

    t1=findIndex(t1);
    t2=findIndex(t2);
    fb=findIndex(fb);
    sm=findIndex(sm);

    if($("span").hasClass("scre2")){
            inn=2;
    }
    console.log("inn:"+inn);

    if(inn==1&&(overs==total || wkt==10)){
        $.redirect("scorecard_adm.php",{fb:fb,sm:sm,inn:2,t1:t1,t2:t2,ins:1},"POST");
    }

    var k=2;
    function add_to_bowl(o,m,r,w){

        console.log(k+" "+o+" "+m+" "+r+" "+w+" ");
        if(k==2){
            $(".bwlr").load("bowling.php",{t1:t1,t2:t2,inn:inn,blr:"",tot:total,k:2,ovr:o,mdn:m,rn:r,wk:w},colorr);
        }
        if(k==0){
            $(".bwlr").load("bowling.php",{
            t1:t1,t2:t2,inn:inn,blr:"",tot:total,q:0,ovr:0,mdn:0,rn:0,wk:0
            },function(data1){
                console.log(data1+"k="+k);
                if(overs!=total){
                    $(".abc").slideDown("slow");
                    $(".bwls").css({display:"block"});
                    $.post("next.php",{t1:t1,t2:t2,inn:inn,i:2}).done(function(data){
                        $(".ss").html(data);
                    });
                }
                else{
                    if(inn==1){$.redirect("scorecard_adm.php",{fb:fb,sm:sm,inn:2,t1:t1,t2:t2,ins:1},"POST");}
                    else{
                        $(".comp").css({display:"none"});
                        $(".complete").css({display:"block"});
                    }
                }
                colorr();
            });
        }

    }

    var j=0;
    function add_to_bat(){
        // console.log(j+" ");//+inn+" "+out+" "+strk+" "+nxtb+" "+srun+" "+sball+" "+wo+" "+oob+" ");
        var ooo=$(".scre1")[0].innerHTML+$(".scre1")[1].innerHTML+$(".scre1")[2].innerHTML;
        ooo=parseFloat(ooo);
        if(j==2&&wd==0){
            if(balls==5){
                ooo=ooo+0.5;
            }
            else{
                ooo=ooo+0.1;
            }

        }
        $.post("batting.php",{
            t1:t1,t2:t2,inn:inn,j:j,runs:srun,balls:sball,fldr:fldr,out:out,strk:strk,nxtb:nxtb,wo:wo,oob:oob,k:l,rn:run,ov:ooo
        }).done(function(data){
            // console.log(data+"j="+j);
            $(".bts").html(data);
            if(j==2){
                add_sq();
            }
            colorr();
        });
        l=0;
    }


    console.log($("span").hasClass("draw")||$("span").hasClass("tm_won"));
    if($("span").hasClass("draw")||$("span").hasClass("tm_won")){
        k=3;
        add_to_bowl(ovr,mdn,rn,wk);
        $(".complete").css({display:"block"});
    }

    // console.log(run+" "+balls+" "+overs+" "+wkt+" ");
    function add_sq(){

        if($("span").hasClass("scre2")){
                inn=2;
        }
        console.log(fb+" "+sm);
         $.post("score_update.php",{
            t1:t1,t2:t2,fb:fb,sm:sm,inn:inn,rns:run,ovrs:overs,blls:balls,wks:wkt
        }).done(function(data){
            $(".score").html(data);
        });
    }

    function swap(){
        l=1;
        j=5;
        add_to_bat();

    }
    // $(".swap").click(function(){
    //     swap();
    // });

    function add_run_to_s(x){
        if(x==1||x==3){
            l=1;
        }
        else{
            l=0;
        }
        srun=parseInt($(".striker span")[1].innerHTML)+x;
        sball=$(".striker span")[2].innerHTML;
        sball=parseInt(sball.substring(1,sball.length-1));
        sball=sball+1;
        // console.log(sball);

        j=0;
        add_to_bat();
    }
    $(".bwl_sel").click(function(){
        blr=$(".blll .ch")[0].innerHTML;
        console.log(blr);
        if(overs!=0){
            swap();
        }
        $(".bwlr").load("bowling.php",{
        t1:t1,t2:t2,inn:inn,blr:blr,tot:total,k:1,ovr:0,mdn:0,rn:0,wk:0},
        function(){
            $(".abc").hide("slow");
            $(".bwls").css({display:"none"});
                if($("span").hasClass("bl_stat")){
                bwlr=$(".bwlr span")[1].innerHTML;
                blst=bwlr.split("-");
                ovr=parseFloat(blst[0]);
                mdn=parseInt(blst[1]);
                rn=parseInt(blst[2]);
                wk=parseInt(blst[3]);
                colorr();
            }
        });
    });

    if($("span").hasClass("bl_stat")){
        bwlr=$(".bwlr span")[1].innerHTML;
        blst=bwlr.split("-");
        ovr=parseFloat(blst[0]);
        mdn=parseInt(blst[1]);
        rn=parseInt(blst[2]);
        wk=parseInt(blst[3]);
    }

    function add_bowler(x,y,w){

        wk=wk+w;
        rn=rn+y;
        if(x==1){
            ovr=ovr+0.1;
        }
        var ov=(Math.ceil(ovr)-ovr);
        ov=Math.round(ov*10)/10;
        if(ov==0.4){
            ovr=Math.ceil(ovr);

        }
        k=2;
        add_to_bowl(ovr,mdn,rn,wk);


    }



    function over(){
        if(balls==5){
            balls=0;
            overs++;
            if(wkt!=10){
                k=0;
                add_to_bowl();
            }        // $(".comp").css({display:"none"});
        }
        else{
            balls++;
        }
        if(inn==2){
            var in1=parseInt($(".scre2")[0].innerHTML);
            if(run>in1){
                $(".comp").css({display:"none"});
                $(".complete").css({display:"block"});
            }
        }
    }
    function add_run(x){
        run=run+x;
    }
    function add_wicket(){
            wkt++;

    }

    $("div .runs").click(function(){
      if(lock==0){
        lock=1;
        var num=parseInt($(this).html());
        add_run(num);

        add_run_to_s(num);
        l=0;
        add_bowler(1,num,0);
        over();
        add_sq();
        lock=0;
    }
    });
    var ot=0;
    $(".wkt1").click(function(){
            $(".wi1").css({display:"none"});
            ot=1;
            add_run_to_s(0);
            add_wicket();
            lock=0;
            console.log(wkt+" ");
            wo=$(this)[0].innerHTML;
            if(wo="St"){wo="STUMPED";}
            else if(wo="Bo"){wo="B";}
            else{wo="LBW";}
            if(wkt!=10){
                $(".nxtbt").parent().slideDown("slow");
                $(".nxtbt").css({display:"inline-block"});
                $.post("next.php",{t1:t1,t2:t2,inn:inn,i:1}).done(function(data){
                    $(".nxt").html(data);
                });
            }
            else{
                // add_sq();
                wk_10();
            }

    });
    $(".catch").click(function(){
            add_run_to_s(0);
            $(".wi1").css({display:"none"});
            $(".catcher").parent().show("slow");
            $(".catcher").css({display:"block"});

            add_wicket();
            ot=1;
            wo="CATCH";

    });
    $(".catcher input[type=button]").click(function(){
            // $(".abc").hide("slow")
            $(".catcher").css({display:"none"});
            fldr=$(".fc .ch")[0].innerHTML;
            if(wkt!=10){

                $(".nxtbt").css({display:"inline-block"});
                $.post("next.php",{t1:t1,t2:t2,inn:inn,i:1}).done(function(data){
                    $(".nxt").html(data);
                });
            }
            else{
                // add_sq();
                wk_10();
            }
    });


    $(".ro").click(function(){
            $(".wi1").css({display:"none"});
            $(".runout").parent().show("slow");
            $(".runout").css({display:"block"});
            $.post("next.php",{t1:t1,t2:t2,inn:inn,i:3}).done(function(data){
                   $($(".runout .fk")[0]).html(data);
            });
            add_wicket();
            ro=1;

            // $('select[name="rnscr"]').find('option')[0].hidden=false;
    });
    $(".runout input[type=button]").click(function(){

            $(".runout").css({display:"none"});
            fldr=$(".runout .fc .fs .ch").html();
            out=$(".runout .fk .fs .ch").html();
            strk=$(".runout .fk .fr .ch").html();
            var num=parseInt($(".runout .fc .fr .ch").html());

            if(wd==1){
                add_run(num+1);
                if(nb==1){
                    add_run_to_s(num);
                    nb=0;
                }

            }
            else if(lb==1){
                add_run(num);
            }
            else{
                add_run_to_s(num);
                add_run(num);

            }
            if(wkt!=10){
                console.log("running");
                $(".nxtbt").css({display:"block"});
                $.post("next.php",{t1:t1,t2:t2,inn:inn,i:1}).done(function(data){
                    $(".nxt").html(data);
                });
            }
            else{
                // add_sq();
                wk_10();
            }
            lock=0;
    });
    $(".nxtbt input[type=button]").click(function(){
            if(wd==1||lb==1||ro==1){
                var num=parseInt($(".runout .fc .fr .ch").html());
            }
            $(".abc").slideUp("slow")
            $(".nxtbt").css({display:"none"});
            nxtb=$('.nxt .ch').html();
            // console.log(nxtb);
            // $('select[name="nxt"]')[0].value="";
            if(wd==1){
                add_bowler(0,num+1,0);
            }
            else if(lb==1){
                add_bowler(1,0,0);
            }
            else if(ro==1){
                add_bowler(1,num,0);
                ro=0;
            }
            else if(ot==1){

                add_bowler(1,0,1);
                ot=0;
            }
            j=2;
            oob=wkt+2;
            add_to_bat();
            if(wd==0){
                over();
            }
            else{
                wd=0;
            }
            lock=0;

    });
    function wk_10(){
            if(wd==1||lb==1||ro==1){
                var num=parseInt($(".runout .fc .fr .ch").html());
            }
            nxtb="";
            // console.log(nxtb);
            if(wd==1){
                console.log(num);
                add_bowler(0,num+1,0);
            }
            else if(lb==1){
                add_bowler(1,0,0);
            }
            else if(ro==1){
                add_bowler(1,num,0);
                ro=0;
            }
            else if(ot==1){

                add_bowler(1,0,1);
                ot=0;
            }
            j=2;
            oob=wkt+2;
            add_to_bat();
            lock=0;
             if(wd==0){
                over();
            }
            else{

                    wd=0;

            }
            if(inn==1){
                $.redirect("scorecard_adm.php",{fb:fb,sm:sm,inn:2,t1:t1,t2:t2,ins:1},"POST");
            }
            else{
                $(".comp").css({display:"none"});
                $(".complete").css({display:"block"});
            }

    }
    $("div .wicket").click(function(){
        if(lock==0){
            lock=1;
            $(".wi1").css({display:"inline-block"});
            // add_run_to_s(0);
        }
    });

    $(".run2").click(function(){
                var num=parseInt($(this).html());
                add_run(num);
                add_run_to_s(0);
                $(this).parent().css({display:"none"});
                if(num==1||num==3){
                    swap();
                }
                over();
                add_bowler(1,0,0);
                add_sq();
                lock=0;
    });
    $(".run3").click(function(){
                var num=parseInt($(this).html());
                add_run(num);
                add_run_to_s(0);
                if(num==1||num==3){
                    swap();
                }
                $(this).parent().css({display:"none"});
                over();
                add_bowler(1,0,0);
                add_sq();
                lock=0;
    });

    $(".wkt3").click(function(){
            $(".runout").parent().slideDown("slow");
            $(".runout").css({display:"block"});
             $.post("next.php",{t1:t1,t2:t2,inn:inn,i:3}).done(function(data){
                   $($(".runout .fk")[0]).html(data);
            });
            $(this).parent().css({display:"none"});
            add_wicket();

            // $('select[name="rnscr"]').find('option')[0].hidden=true;
            // $('select[name="rnscr"]')[0].value="";
            if(nbb==1){wd=1;nb=1;nbb=0;}
            else{lb=1;}
    });

    $("div .extras").click(function(){
        var lb=0;
        if(lock==0){
            lock=1;
            $(this).next().css({display:"inline-block"});
        }
    });

    $(".run").click(function(){
                var num=parseInt($(this).html());
                add_run(num+1);
                if(num==1||num==3){
                    swap();
                }
                $(this).parent().css({display:"none"});
                lock=0;
                add_bowler(0,num+1,0);
                add_sq();
            });
    $(".wkt2").click(function(){
            $(".runout").parent().slideDown("slow");
            $(".runout").css({display:"block"});
             $.post("next.php",{t1:t1,t2:t2,inn:inn,i:3}).done(function(data){
                   $($(".runout .fk")[0]).html(data);
            });
            $(this).parent().css({display:"none"});
            add_wicket();
            // $('select[name="rnscr"]').find('option')[0].hidden=false;

            wd=1;
    });
    $(".extraw").click(function(){
        if(lock==0){
            lock=1;
            $(this).next().css({display:"inline-block"});
             var s=$(this).next().find(".run");
        }
    });


    $(".run4").click(function(){
                var num=parseInt($(this).html());
                add_run(num+1);
                add_run_to_s(num);
                $(this).parent().css({display:"none"});
                add_bowler(0,num+1,0);
                lock=0;
                add_sq();
    });

    $(".wkt").click(function(){
                add_wicket();
                $(this).parent().css({display:"none"});
                $(".runout").parent().slideDown("slow");
                $(".runout").css({display:"block"});
                $.post("next.php",{t1:t1,t2:t2,inn:inn,i:3}).done(function(data){
                   $($(".runout .fk")[0]).html(data);
                });
                // $('select[name="rnscr"]').find('option')[0].hidden=false;
                wd=1;
                nb=1;
     });

    $(".run1").click(function(){
                    add_run(parseInt($(this).html())+1);
                    $(".ext1").css({display:"none"});
                    add_run_to_s(0);
                    add_bowler(0,1,0);
                    lock=0;
                    add_sq();
    });
    $(".extrs").click(function(){
                    $(this).parent().css({display:"none"});
                    $(".ext1").css({display:"inline-block"});
                    nbb=1;
    });
    $(".extran").click(function(){
        if(lock==0){
            lock=1;
            $(this).next().css({display:"inline-block"});
        }

    });

});

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
        $(this).parent().parent().find(".ch").html($(this)[0].id);
    });

colorr();
function colorr(){
  var col=func1($(".score1 span")[0].innerHTML);
  console.log(col);
  $(".striker").css({background:col});
  $(".nonstriker").css({background:col});
  var col=func1($(".score2 span")[0].innerHTML);
  $(".bowle").css({background:col});
}
