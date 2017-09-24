/**
 * Created by Owner on 6/28/2016.
 */

var highcharts_income = {
    chart: {
        zoomType: "xy",
        width: 1000,
        height: 750,
        type: 'column',
       /* animation: false,*/
        enableMouseTracking: false
    },

    title: {
        text: 'Illustrative Plan Chart'
    },
    scrollbar: {
        enabled: true
    },
    xAxis: {
        categories: $categories,
        max: 30
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Income'
        },
        /*scrollbar: {
            enabled: true
        },*/
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        //align: 'right',
        //x: -30,
       // verticalAlign: 'top',
        //y: 25,
        //floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: false,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
            /*series:{
                states:{
                    hover:{
                        enabled:false
                    }
                }
            }*/
        }
    },
    series: $series,
};

$( document ).ready(function() {

    interval = 0
    $("#chart-container-income").highcharts(highcharts_income);
    $('.idealsteps-nav').click(function(){
        if(interval == 0){
            console.time('area');
            $("#chart-container-income").highcharts(highcharts_income);
            console.timeEnd('area');
            interval = 1;
        }
    });


});


