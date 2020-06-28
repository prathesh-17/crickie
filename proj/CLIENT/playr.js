var tot_seas=13;
var i;
if(document.title){
for(i=0;i<tot_seas;i++){
        if( $("div").hasClass(""+(2008+i)) ){
            $("."+(2008+i)).css({display:"none"});
        }
        var yr=$(".lst_y").html();
        $("."+yr).css({display:"block"});
}

// $(".year")[0].innerHTML=$(".year")[0].innerHTML+"<option value=\""+(2008+i)+"\" selected=\"selected\">"+(2008+i)+"</option>";

// $("."+(2008+i)).css({display:"block"});
$(document).click(function(e){
    // console.log(e.target);
    if(e.target.innerHTML!="CHANGE"){
        $(".choices").slideUp();
    }
});

$("document").ready(function(){


    // $("select[name='year_sel']").change(function(){
    //     var yr=$(this)[0].value;
    //     for(i=0;i<tot_seas;i++){
    //         $("."+(2008+i)).css({display:"none"});
    //     }
    //     $("."+yr).css({display:"block"});
    // });

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

    $(".p_inf").css({display:"block"});
    $(".seas_inf").css({display:"none"});
    $(".stat_inf").css({display:"none"});

    $(".info").click(function(){
      if($(".seas_inf")[0].style.display=="block"){
        $(".seas_inf").slideUp("fast",function(){
            $(".p_inf").show("slow",dis);
        });
      }
      else{
        $(".stat_inf").slideUp("fast",function(){
            $(".p_inf").show("slow",dis);
        });
      }
      function dis(){
        $(".p_inf")[0].style.display="block";
      }
    });
    $(".season").click(function(){
      if($(".p_inf")[0].style.display=="block"){
        $(".p_inf").hide("fast",function(){
            $(".seas_inf").slideDown("fast",dis);
        });
      }
      else{
        $(".stat_inf").slideUp("fast",function(){
            $(".seas_inf").slideDown("slow",dis);
        });
      }
      function dis(){
        $(".seas_inf")[0].style.display="block";
      }
  });
    $(".stats").click(function(){
     if($(".p_inf")[0].style.display=="block"){
        $(".p_inf").hide("fast",function(){
            $(".stat_inf").slideDown("fast",dis);
        });
      }
      else{
        $(".seas_inf").slideUp("fast",function(){
            $(".stat_inf").slideDown("fast",dis);
        });
      }
      function dis(){
        $(".stat_inf")[0].style.display="block";
      }
  });


    $(".bat_stat").css({display:"block"});
    $(".bwl_stat").css({display:"none"});
    $(".fld_stat").css({display:"none"});

    $(".batting").click(function(){
     if($(".bwl_stat")[0].style.display=="block"){
        $(".bwl_stat").hide("fast",function(){
            $(".bat_stat").show("slow",dis);
        });
      }
      else{
        $(".fld_stat").hide("fast",function(){
            $(".bat_stat").show("slow",dis);
        });
      }
      function dis(){
        $(".bat_stat")[0].style.display="block";
      }
    });
    $(".bowling").click(function(){
     if($(".bat_stat")[0].style.display=="block"){
        $(".bat_stat").hide("fast",function(){
            $(".bwl_stat").show("slow",dis);
        });
      }
      else{
        $(".fld_stat").hide("fast",function(){
            $(".bwl_stat").show("slow",dis);
        });
      }
      function dis(){
        $(".bwl_stat")[0].style.display="block";
      }
    });
    $(".fielding").click(function(){
     if($(".bwl_stat")[0].style.display=="block"){
        $(".bwl_stat").hide("fast",function(){
            $(".fld_stat").show("slow",dis);
        });
      }
      else{
        $(".bat_stat").hide("fast",function(){
            $(".fld_stat").show("slow",dis);
        });
      }
      function dis(){
        $(".fld_stat")[0].style.display="block";
      }    });




});

}
