$(function(){
  $("#ih_imglist").height($("#c_list").height()*0.75);
  $("#special_list").height($("#c_list").height()*0.25-1);
  $(".slideBox").slide({mainCell:".bd ul",effect:"leftLoop",autoPlay:true,easing:"easeOutElastic",delayTime:700});
  $(".sp_left div").mouseover(function(){
    var curid=$(this).attr("id");
    $(this).parent().parent().find("div").removeClass("cur_one_level");
    $(this).addClass("cur_one_level");
    $(this).parent().parent().parent().next().children("ul").hide().end().find("."+curid).show();
  })
})