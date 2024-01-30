
$(function(){
    var base_url =    window.location.origin+window.location.pathname;
    var pathArray = base_url.split( '/' );
    var protocol = pathArray[0];
    var symbol = pathArray[3];
    var host = pathArray[2];
    var url = protocol + '//' + host + '/'+ symbol + '/index.php/load_graph';
    var nta_url = protocol + '//' + host + '/'+ symbol + '/index.php/load_nta_graph';
    //live urls
    var url_live = protocol + '//' + host + '/'+ symbol + '/load_graph';
    var nta_url_live = protocol + '//' + host + '/'+ symbol + '/load_nta_graph';
    console.log(url);
      
    $.ajax({
        url: url_live,
        type: "GET",
        success: function(data){ 
               var months = JSON.parse(data);
                console.log(months[0]);
               var ctx = document.getElementById("revenue_chart").getContext("2d");
               var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
               var gradientFill = ctx.createLinearGradient(500, 0, 100, 0);
               gradientFill.addColorStop(0, "#f39c12");
               gradientFill.addColorStop(1, "#e91e63");

               var chartData = {
                   labels:JSON.parse(months[0]),
                   datasets: [
                       {
                           label: "PROFIT",
                           backgroundColor: gradientFill,
                           hoverBackgroundColor: gradientFill,
                           //data: [30, 25, 50, 30, 50, 35, 60],
                           data: JSON.parse(months[1]),
                           pointBorderWidth: 1,
                           pointRadius: 0,
                           pointHitRadius: 30,
                           pointHoverBackgroundColor: gradientFill,
                           pointHoverBorderColor: '#ffe8f0',
                           pointHoverBorderWidth: 5,
                           pointHoverRadius: 6
                       }
                   ],
               };
               var chartOptions = {
                   responsive: true,
                   maintainAspectRatio: false,
                   showScale: false,
           
                   elements: {
                       line: {
                           tension: 0
                       },
                   },
                   scales: {
                       xAxes: [{
                           display: false,
                           gridLines: false,
                           scaleLabel: {
                               display: true,
                           }
                       }],
                       yAxes: [{
                           display: false,
                           gridLines: false,
                           scaleLabel: {
                               display: true,
                           },
                           ticks: {
                               beginAtZero: true
                           }
                       }]
                   },
                   layout: {
                       padding: {
                           left: 0,
                           right: 0,
                           top: 10,
                           bottom: 0
                       }
                   },
                   legend: {display: false}
               };
               new Chart(ctx, {type: 'line', data: chartData, options: chartOptions});

            //    sortByMonth(months);
      
            //    console.log(dataCollection);
            //      var new  = JSON.parse(months[0]);
            //    function sortByMonth(arr) {
            //      var month = ["January", "February", "March", "April", "May", "June",
            //                  "July", "August", "September", "October", "November", "December"];
            //      arr.sort(function(a, b){
            //          return month.indexOf(a.new)
            //               - month.indexOf(b.new);
            //      });
            //    }
        }
    });

    $.ajax({
        url: nta_url_live,
        type: "GET",
        success: function(data){ 
               var amounts = JSON.parse(data);
                console.log(amounts[1]);
                var ctx = document.getElementById("sales_chart_1").getContext("2d");
                var sales_chart = new Chart(ctx, {
                    type: 'bar', 
                    data: {
                        labels: JSON.parse(amounts[3]),
                        datasets: [
                            {
                                label: "NTA Leval 4",
                                data: JSON.parse(amounts[0]),
                                borderColor: 'rgba(117,54,230,0.9)',
                                backgroundColor: 'rgba(117,54,230,0.9)',
                                pointBackgroundColor: 'rgba(117,54,230,0.9)',
                                pointBorderColor: 'rgba(117,54,230,0.9)',
                                borderWidth: 1,
                                pointBorderWidth: 1,
                                pointRadius: 0,
                                pointHitRadius: 30,
                            },{
                                label: "NTA Leval 5",
                                data: JSON.parse(amounts[1]),
                                backgroundColor: 'rgba(255,64,129, 0.7)',
                                borderColor: 'rgba(255,64,129, 0.7)',
                                pointBackgroundColor: 'rgba(255,64,129, 0.7)',
                                pointBorderColor: 'rgba(255,64,129, 0.7)',
                                borderWidth: 1,
                                pointBorderWidth: 1,
                                pointRadius: 0,
                                pointHitRadius: 30,
                            },{
                                label: "NTA Leval 6",
                                data: JSON.parse(amounts[2]),
                                borderColor: 'rgba(104,218,221,1)',
                                backgroundColor: 'rgba(104,218,221,1)',
                                pointBackgroundColor: 'rgba(104,218,221,1)',
                                pointBorderColor: 'rgba(104,218,221,1)',
                                borderWidth: 1,
                                pointBorderWidth: 1,
                                pointRadius: 0,
                                pointHitRadius: 30,
                            },{
                                label: "NTA Leval 7",
                                data: JSON.parse(amounts[3]),
                                borderColor: 'rgba(104,218,221,1)',
                                backgroundColor: 'rgba(104,218,221,1)',
                                pointBackgroundColor: 'rgba(104,218,221,1)',
                                pointBorderColor: 'rgba(104,218,221,1)',
                                borderWidth: 1,
                                pointBorderWidth: 1,
                                pointRadius: 0,
                                pointHitRadius: 30,
                            },{
                                label: "NTA Leval 8",
                                data: JSON.parse(amounts[4]),
                                borderColor: 'rgba(104,218,221,1)',
                                backgroundColor: 'rgba(104,218,221,1)',
                                pointBackgroundColor: 'rgba(104,218,221,1)',
                                pointBorderColor: 'rgba(104,218,221,1)',
                                borderWidth: 1,
                                pointBorderWidth: 1,
                                pointRadius: 0,
                                pointHitRadius: 30,
                            },
                        ],
                    }, 
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        showScale: false,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                },
                                barPercentage: 0.7,
                                categoryPercentage: 0.5
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorder: false,
                                },
                            }]
                        },
                        legend: {
                            labels: {
                                boxWidth: 12
                            }
                        },
                    }
                });
            
        }
    });

    $('.easypie').each(function(){
        $(this).easyPieChart({
          trackColor: $(this).attr('data-trackColor') || '#f2f2f2',
          scaleColor: false,
        });
    }); 
   
    
   
    sales_data = {
        1 : {
          data: [
            [20, 18, 40, 50, 35, 24, 40],
            [28, 48, 40, 35, 70, 33, 32],
            [64, 54, 60, 65, 52, 85, 48],
          ],
          labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        },
        2 : {
          data: [
              [50, 30, 25, 33, 28, 34, 45, 30, 55, 28, 42, 54],
              [45, 35, 28, 64, 40, 30, 32, 60, 50, 29, 33, 48],
              [54, 62, 35, 80, 40, 85, 42, 30, 41, 73, 68, 57],
          ],
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        },
        3 : {
          data: [
            [50, 30, 25, 33, 28, 34, 45, 30, 55, 28, 42, 54],
            [45, 35, 28, 64, 40, 30, 32, 60, 50, 29, 33, 48],
            [54, 62, 35, 80, 40, 85, 42, 30, 41, 73, 68, 57],
          ],
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        },
    };
    $('#sales_tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        alert('nipooo')
        var id = $(this).attr('data-id');
        if(id && +id in sales_data) {
            sales_chart.data.labels = sales_data[id].labels;
            var datasets = sales_chart.data.datasets;
            $.each(datasets,function(index,value) {
                datasets[index].data = sales_data[id].data[index];
            });
        }
        sales_chart.update();
    });


    // Map
    

    var dataCollection = [
        { values: { Month: { displayValue: "August" }, Sum: "10" } },
        { values: { Month: { displayValue: "February" }, Sum: "25" } },
        { values: { Month: { displayValue: "July" }, Sum: "35" } }
      ];
      
      sortByMonth(dataCollection);
      
      console.log(dataCollection);
      
      function sortByMonth(arr) {
        var months = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"];
        arr.sort(function(a, b){
            return months.indexOf(a.values.Month.displayValue)
                 - months.indexOf(b.values.Month.displayValue);
        });
      }

});
