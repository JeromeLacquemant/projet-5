$(document).ready(function(){

    $(".modal-trigger").leanModal();

    $(".see_comment").click(function(){
        var id = $(this).attr("id");
        $.post("see_comment.php",{id:id},function(){
            $("#commentaire_"+id).hide();
        });
    });

    $(".delete_comment").click(function(){
        var id = $(this).attr("id");
        $.post("delete_comment.php",{id:id},function(){
                $("#commentaire_"+id).hide();
        });
    });

});