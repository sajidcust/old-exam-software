<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=
        "width=device-width, initial-scale=1.0">
  
    <title>Pie Chart</title>
</head>
  
<body>
    <div class="flex-center position-ref full-height">
       <div class="content">
          <div align="center">
               //Charts will print here appending this div
               <div id="draw-charts"></div>
               <div id="chart_div"></div>
          </div>
          <form action="{{ route('charts.print') }}" method="post" enctype="multipart/form-data">
             @csrf
             //input with type hidden
            <input type="hidden" name="pieData" id="chartInputData">
            <input type="hidden" name="barData" id="chartInputDataBar">
            <input type="submit" value="Print Chart">
          </form>
//LOADING JQUERY CDN 
<script src="https://code.jquery.com/jquery-3.5.1.js"
 integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
 crossorigin="anonymous"></script>
//LOADING GOOGLE CDN
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type="text/javascript">


    $(function(){
                    //ARRAY OF DATA
        let weekOne = [
          ['GILGIT', 1000, 400, 200],
          ['GHIZER', 1170, 460, 250],
          ['NAGAR', 660, 1120, 300],
          ['HUNZA', 1030, 540, 350]
        ];

        //FINAL ARRAY OF ARRAYS WILL BE USED TO PRINT CHARTS
        let weeksData = [weekOne];
        //LOOPING THROUGH ARRAYS
        for(let r =0; r<weeksData.length; r++){
           //APPENDING DIVS SO WE CAN HAVE CHART ON EACH DIV
           $("#chart_div").append("<div id='chart_div"+r+"'></div>");
               google.charts.load('current',{
                       callback: function(){
                          var data = new google.visualization.DataTable();
                         //ADDING COLUMN WITH DEFINING TYPE OF CONTENT
                          data.addColumn('string','Districts');
                          data.addColumn('number','Pass');
                          data.addColumn('number','Promoted');
                          data.addColumn('number','Fail');
                           //ADDING DATA TO GOOGLE CHART
                          data.addRows(weeksData[r]);
                          //SETTING TITLE WIDTH AND HEIGHT OF CHARTS
                          var options = {
                              title:"Printing Charts In Loop",
                              width:800,
                              height:500
                            };

              let chart_div = document.getElementById("chart_div"+r);
              let chart = new google.visualization.ColumnChart(chart_div);
           google.visualization.events.addListener(chart,'ready',function(){
           //DISPLAYING CHARTS AS IMAGES
           chart_div.innerHTML = '<img src="'+chart.getImageURI() +'">';
                });

           chart.draw(data,options);
           },
           packages: ['corechart']
         })
        }


        //Setting chart data to Input
        setTimeout(function(){
             let chartsData = $("#chart_div").html();
             $("#chartInputDataBar").val(chartsData);
        },1000);
    });

                $(function(){
                    //ARRAY OF DATA
                    let weekOne = [
                                      ['PASS', 65],
                                      ['PROMOTED', 30],
                                      ['FAIL', 5]
                                    ];
                    //FINAL ARRAY OF ARRAYS WILL BE USED TO PRINT CHARTS
                    let weeksData = [weekOne];
                    //LOOPING THROUGH ARRAYS
                    for(let r =0; r<weeksData.length; r++){
                       //APPENDING DIVS SO WE CAN HAVE CHART ON EACH DIV
                       $("#draw-charts").append("<div id='draw-charts"+r+"'></div>");
                           google.charts.load('current',{
                                   callback: function(){
                                      var data = new google.visualization.DataTable();
                                     //ADDING COLUMN WITH DEFINING TYPE OF CONTENT
                                      data.addColumn('string','Days');
                                      data.addColumn('number','Income');
                                       //ADDING DATA TO GOOGLE CHART
                                      data.addRows(weeksData[r]);
                                      //SETTING TITLE WIDTH AND HEIGHT OF CHARTS
                                      var options = {
                                          title:"Printing Charts In Loop",
                                          width:800,
                                          height:500,
                                          is3D:true
                                        };
                          let chart_div = document.getElementById("draw-charts"+r);
                          let chart = new google.visualization.PieChart(chart_div);
                       google.visualization.events.addListener(chart,'ready',function(){
                       //DISPLAYING CHARTS AS IMAGES
                       chart_div.innerHTML = '<img src="'+chart.getImageURI() +'">';
                            });

                       chart.draw(data,options);
                       },
                       packages: ['corechart']
                     })
                    }


                    //Setting chart data to Input
                    setTimeout(function(){
                         let chartsData = $("#draw-charts").html();
                         $("#chartInputData").val(chartsData);
                    },1000);
                });
</script>
</div>
</div>
</body>
  
</html>