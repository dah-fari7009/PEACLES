$(document).ready(function(){
$(document).on("click","#search-result a",function(req,res){
    console.log($(event.target).attr("href"))
    window.location.replace($(event.target).attr("href"))
})

$(".option").click(function(event){
    $("#search").html($(event).target.text());
})

/*$("#search").autocomplete({
    source:function(request,response){

    }
})*/

$("#search").on({
    keyup:function(event){
    if($("#search").val()){
        console.log("yasss")
        $.ajax({
            method:"post",
            url:"/complete",
            dataType:"json",
            data:$(event.target).serialize()
        }).done(function(data){
            console.log(data);
            if(data){
                console.log("Je suis ici")
                $("#search-result").empty();
                //here remove all the previous searches
                $.each(data[0],function(index,val){
                    $("#search-result").append("<span class='option'>"+val.cuisine+"</span>");
                });
                $.each(data[1],function(index,val){
                    //console.log(tab);
                    /*if(index==0) $("#search-result").append("<p> Specialties : </p>")
                    else if(index==1) $("#search-result").append("<p>  Names : </p>")
                    else if(index==2) $("#search-result").append("<p> Adresses : </p>")
                    $.each(tab,function(index,val){*/
                        console.log(val);
                    $("#search-result").append("<p><a href='/profile?searched="+val.username+"&id="+val.id+"' class='link'>"+val.username+"</a></p>");
               
                    /*} )*/
                } );
                $("#search-result").show();
                console.log($("#search-result").html());
                    
                //data:table de pseudo ou noms et prénoms, maybe tableau d'objets json resultats de la requete
            }
            //add alert here
            else window.location.reload()
        })
    }
    else{
        console.log("noooo")
        $("#search-result").empty();
    } 
},
focusout:function(){
    window.setTimeout(function(){
        $("#search-result").hide();
    },1000)  
},
focusin:function(){
    if($("#search").val()) $("#search-result").show();
}

});
});


    