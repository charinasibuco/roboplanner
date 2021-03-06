/*
var flag_template= "<div class='panel-heading'>"+
    "<h4 class='panel-title {{ color }}-flag'>"+
        "<a data-toggle='collapse' data-parent='.{{ color }}-panel' href='#{{ color }}-flag-{{ key }}'>"+
        "<div class='row'>"+
            "<div class='col-md-1'>"+
            "<span class='fa-stack'>"+
                "<span class='fa-stack-1x rank'>"+
                "<strong>#{{ rank }}</strong>"+
            "</span>"+
            "</span>"+
        "</div>"+
        "<div class='col-md-1 wealth-score-title'>{{ wealthScore }}</div>"+
        "<div class='col-md-10'>{{ description }}</div>"+
    "</div></a></h4></div>";

var flag = Vue.extend({
    props: ['color','key','rank','wealthScore','description'],
    template: flag_template
});

Vue.component('flag', flag);

new Vue({
    el: ".flag-panel"
})



*/

$(document).ready(function(){
    $(".flag-consequences").hide();
    $(".flag-main").click(function(){
        $(this).next(".flag-consequences").toggle("fast");
        if($(this).find('.fa').hasClass('fa-caret-down')){
            $(this).find('.fa').removeClass('fa-caret-down');
            $(this).find('.fa').addClass('fa-caret-up');
        }else{
                $(this).find('.fa').removeClass('fa-caret-up');
                $(this).find('.fa').addClass('fa-caret-down');
        }
    });
});
