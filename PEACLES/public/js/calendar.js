function required(fields){//Checks whether every field was filled
    var correct=true;
    $.each(fields,function (index){
        var field=$(this);
        console.log(field.val())
        if($.trim(field.val())==""){
            field.css({
                borderColor:'red',
                color:'black',
            });
            
            /*var errfield=$("#err"+field.attr("name"));
            errfield.html("This field is required");
            errfield.css({
                display:"inline",
            })*/
            correct=false;
        }
        else{
            field.css({
                borderColor:'black',
                borderRadius:'12%'
            });
        }
        console.log(field.val())
    });
    return correct;
}

function appendToTable(res){
    $("#table_res tbody").append("<tr style=\"border-bottom:solid 1px black\"><td><form class=\"res\"><input type=\"hidden\" name=\"id\" value=\""+res.id+"\"><input type=\"text\" value=\""+res.date+"\" name=\"date\"><br><input type=\"text\" value=\""+res.start+"\" name=\"start\"><input type=\"text\" value=\""+res.end+"\" name=\"end\">"+((res.resto)?"<input type='submit' value='X' class=\"sub_res\">":"")+"</form> </td> </tr>");
               
}

$(document).ready(function(){

    $(".day").on('click',function(event){
        event.preventDefault();
        console.log("ici");
        $(event.target).css({
            "background-color":"red"});
        var day=$(event.target).text();
        //$(event.target).attr("id","clicked");
        console.log(day);
        var month=$(".active .month").text()
        console.log(month);
        var year=$(".active .year").text();
        var date=year+"-"+month+"-"+day;
        $("#time input[type=hidden]").val(date);
        console.log($("#time input[type=hidden]").val());
        console.log(date);
        $.post({
            url:"/show_avail",
            data:"date="+date
        }).done(function(data){
            console.log(data);
            //$(".display").empty();
            if(data){
                $("#table_res tbody").empty();
                $.each(data,function(res,value){
                    console.log(value);
                    appendToTable(value);
                })
                console.log("ici");
            }
            //else $("display").html("Nothing set");
        })
            
    });

    $(document).on("submit",".res",function(event){
        event.preventDefault();
        console.log("laaaaaasa");
        var data=$(event.target).serialize();
        console.log(data);
        $.post({
            url:"/rm_avail",
            data:data
        }).done(function(data){
            console.log($(event.target));
            $(event.target).parents("tr").remove();
        })
    })

    $("#time").submit(function(event){
        event.preventDefault();
        var correct=required($("#time input"));
        if(correct){
            var fields=$("#time").serialize();
            console.log(fields);
            //verifier que le champ caché est non vide
            $.post({
                url:"/add_avail",
                data:fields
            }).done(function(res){
                if(res){
                    appendToTable(res);
                }
                //$("#clicked").click();
                //window.location.reload();
            });
            //window.location.reload apres avoir passé la date, start et end

        }

    });

    
});