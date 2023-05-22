<div class="flex flex-col justify-center">
    <div>
        <h2 class="text-center text-xl font-bold text-gray-600">HOS-XP Master</h2>
        <div class="overflow-auto flex justify-center w-full py-4 px-4">
            <div id="chartContainer" class="w-full lg:w-[1024px] h-[480px] text-sm"></div>
        </div>
        <div class="overflow-auto flex justify-center w-full py-4 px-4 mt-4">
            <div id="chartContainer2" class="w-full lg:w-[1024px] h-[480px] text-sm"></div>
        </div>
        <div class="overflow-auto flex justify-center w-full py-4 px-4 mt-4">
            <div id="chartContainer3" class="w-full lg:w-[1024px] h-[480px] text-sm"></div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('js/canvasjs.min.js') }}"></script>
    <script>
        window.onload = function () {
            const cpu_url = '{{ route('cpu.data') }}';
            const mem_url = '{{ route('mem.data') }}';
            const mem_avg = '{{ route('serv.stat') }}';
            const cli_url = '{{ route('serv.cli') }}';
            const disk_url = '{{ route('serv.disk') }}';

            async function getData(url) {
                const res = await axios.get(url);
                return res;
            }

            var yValue1 = 0; 
            var yValue2 = 0;

            var cpuDataPoints = [];
            var memDataPoints = [];
            var pgDataPoints = [];
            var pgbDataPoints = [];
            var diskDataPoints = [];
            var updateInterval = 300000;
            var data;

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                legend: {
                    cursor:"pointer",
                    verticalAlign: "top",
                    fontSize: 16,
                    fontColor: "dimGrey",
                    itemclick : toggleDataSeries
	            },
                title:{
                    text: "Every 5 minutes Average CPU & Memory Use",
                    fontSize: 20
                },
                axisX:{
		            title: "Time",
                    valueFormatString: "HH:mm น."
	            },
                axisY: {
                    title: "Percentage",
                    suffix: "%",
                    includeZero: true
                },
                data: [
                    {
                        type: "spline",
                        color: "#16a34a",
                        name: "CPU Utilization",
                        connectNullData: true,
                        xValueType: "dateTime",
                        showInLegend: true,
                        xValueFormatString: "HH:mm น.",
                        yValueFormatString: "#,##0.##\"%\"",
                        dataPoints: cpuDataPoints
                    },
                    {
                        type: "spline",
                        color: "#dc2626",
                        name: "Memory Utilization",
                        connectNullData: true,
                        showInLegend: true,
                        xValueType: "dateTime",
                        xValueFormatString: "HH:mm น.",
                        yValueFormatString: "#,##0.##\"%\"",
                        dataPoints: memDataPoints
                    },
                ]
            });

            var chart2 = new CanvasJS.Chart("chartContainer2", {
                zoomEnabled: true,
                animationEnabled: true,
                legend: {
                    cursor:"pointer",
                    verticalAlign: "top",
                    fontSize: 16,
                    fontColor: "dimGrey",
                    itemclick : toggleDataSeries
	            },
                title:{
                    text: "Client Connect",
                    fontSize: 20,
                },
                axisX:{
		            title: "Time",
                    valueFormatString: "HH:mm น."
	            },
                axisY: {
                    title: "Number of Clients",
                    suffix: "",
                    includeZero: true
                },
                data: [
                    {
                        type: "splineArea",
                        lineThickness: 3,
                        color: '#818cf8',
                        name: "Postgres Client",
                        connectNullData: true,
                        xValueType: "dateTime",
                        showInLegend: true,
                        xValueFormatString: "HH:mm น.",
                        yValueFormatString: "#,##0.##\" Client\"",
                        dataPoints: pgDataPoints
                    },
                    {
                        type: "splineArea",
                        lineThickness: 3,
                        name: "pgBouncer Client",
                        color: "#f472b6",
                        connectNullData: true,
                        showInLegend: true,
                        xValueType: "dateTime",
                        xValueFormatString: "HH:mm น.",
                        yValueFormatString: "#,##0.##\" Client\"",
                        dataPoints: pgbDataPoints
                    }
                ]
            });

            var chart3 = new CanvasJS.Chart("chartContainer3", {
                animationEnabled: true,
                title: {
                    text: "Data Storage",
                    fontSize: 20
                },
                data: [{
                    type: "pie",
                    showInLegend: true,
		            toolTipContent: "{name}: <strong>{y}</strong>",
                    startAngle: 240,
                    yValueFormatString: "##0.00\" GB\"",
                    indexLabel: "{label} {y} ",
                    dataPoints: diskDataPoints,
                }]
            });

            function addData(data, dataPoints) {
                for (var i = 0; i < data.length; i++) {
                    dataPoints.push({
                        x: new Date(data[i].date),
                        y: parseInt(data[i].val)
                    });
                }
               // console.log(dataPoints);
               // chart.render();
            }

            function toggleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
            /*
            data = getData(cpu_url);
            data.then((res) => { addData(res.data, cpuDataPoints) })

            data = getData(mem_url);
            data.then((res) => { addData(res.data, memDataPoints) })
            //addData(data);

            /*axios.get(url).then((response) => {
                addData(response.data)
            })
            .catch((error) => {
            // handle errors
            });
            */
            /*setInterval(function(){updateChart()}, updateInterval);
            */

            function updateChart() {
                data = getData(cpu_url);
                data.then((res) => { 
                    addData(res.data, cpuDataPoints);
                        data2 = getData(mem_url);

                        data2.then((res) => { 
                            addData(res.data, memDataPoints) 
                            chart.render();
                        });
                })

                data = getData(mem_avg);
                data.then((res) => { 
                    chart.options.data[0].legendText = "To day Average CPU " + parseFloat(res.data.cpu).toFixed(2) +' %'; 
                    chart.options.data[1].legendText = "To day Average Memory " + parseFloat(res.data.mem).toFixed(2) +' %'; 
                    chart.render();
                });

                data = getData(cli_url);
                data.then((res) => {
                    addData(res.data.pg5432, pgDataPoints)
                    addData(res.data.pg6432, pgbDataPoints)
                    chart2.render();
                })

                data = getData(disk_url);
                data.then((res) => {
                    diskDataPoints.push({
                        name: 'Used',
                        color: "#fcd34d",
                        y: (parseInt(res.data.used)/1024)
                    });
                    diskDataPoints.push({
                        name: 'Available',
                        color: "#6ee7b7",
                        y: (parseInt(res.data.avl)/1024)
                    });
                    //addData(res.data, diskDataPoints)
                    chart3.render();
                })
                /*data =  getData(cpu_url);
                console.log(data);                
                //data.then((res) => { addData(res.data, cpuDataPoints) })





                chart.options.data[1].legendText = "To day Average Memory 555" + yValue2 +' %';
                chart.options.data[0].legendText = "To day Average CPU" + yValue1;
                console.log(cpuDataPoints);*/
                
            }   

            updateChart();

            setInterval(function(){
                location.reload();
            }, updateInterval);
            
        }    
    </script>
    @endpush
</div>
