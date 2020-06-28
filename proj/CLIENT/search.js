$("body").show("slow",function(){

    $('.search-box input[type="text"]').on("keyup input", function(){

        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.post("backend-search.php", {term: inputVal}).done(function(data){

                resultDropdown.html(data);
                resultDropdown.slideDown("slow");
            });
        } else{
            resultDropdown.empty();
            resultDropdown.css({display:"none"});
        }
    });
    $(".player").click(function(){
        // console.log($(this)[0].id);
        $.redirect("player.php",{
            name:$(this)[0].id
        },"GET");
    });
});
