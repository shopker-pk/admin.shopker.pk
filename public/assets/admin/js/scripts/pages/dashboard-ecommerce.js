// Area chart
$(window).on("load", function(){
    $('#recent-buyers').perfectScrollbar({
        wheelPropagation: true
    });

    /* Monthly total_sales */
    Morris.Bar.prototype.fillForSeries = function(i){
      var color;
      return "0-#fff-#f00:20-#000";
    };

    //Ajax For Monthly Sales
    $.ajax({
        url : document.location.href.split('dashboard')[0].toString()+'dashboard/monthly-sales',
        method : 'GET',
        success:function(response){
            json_data = $.parseJSON(response);

            if(json_data.ERROR == 'FALSE'){
                monthly_sales.setData(json_data.DATA);
            }
        }
    });

    monthly_sales = Morris.Bar({
        element: 'monthly-sales',
        data: [],
        xkey: 'month',
        ykeys: ['sale'],
        labels: ['Sales'],
        barGap: 4,
        barSizeRatio: 0.3,
        gridTextColor: '#bfbfbf',
        gridLineColor: '#E4E7ED',
        numLines: 5,
        gridtextSize: 14,
        resize: true,
        barColors: ['#00B5B8'],
        hideHover: 'auto',
    });
});