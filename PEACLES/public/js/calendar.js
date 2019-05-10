$(document).ready(function(){

    $(".day").on('click',function(event){
        console.log("ici");
        $(event.target).css({
            "background-color":"red"});
        var day=$(event.target).text();
        $(event.target).attr("id","clicked");
        console.log(day);
        var month=$(".active .month").text()
        console.log(month);
        var year=$(".active .year").text();
        var date=year+"-"+month+"-"+day;
        $("#time input[type=hidden]").html(date);
        console.log($("#time input[type=hidden]").val());
        console.log(date);
        $.ajax({
            method:"post",
            url:"/show_avail",
            data:"date="+date
        }).done(function(data){
            console.log(data);
            $(".display").empty();
            if(data){
            //si resto on cancel, si user on met des radios buttons
               for(var i=0;i<data.length;i++){
                   var val=data[i];
                   var date=Date.parse(val.date);
                   console.log(date);
                   var start=Date.parse(val.start);
                   var end=Date.parse(val.end)
                   $(".display").append("<form class='res'><input type='hidden' value='"+val.id+"'><p>"+date.toString('yyyy-mm-dd')+"    "+start.toString("hh:mm:ss")+" - "+end.toString("hh:mm:ss")+"</p><input type='submit' value='X'></form>");
    
               }
            }
            else $("display").html("Nothing set");
        })
            
    });

    $("#add").on('click',function(){
        var fields=$("#time").serialize();
        //verifier que le champ caché est non vide
        $.ajax({
            method:"post",
            url:"/add_avail",
            data:fields
        }).done(function(data){
            $("#clicked").click();
            window.location.reload();
        });
        //window.location.reload apres avoir passé la date, start et end

    });
});