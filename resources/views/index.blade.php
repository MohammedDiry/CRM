@extends('layouts.app1')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Leads</p>
                                <h4 class="card-title">{{ number_format($leadCount) }}</h4>
                                <!-- عرض عدد العملاء المحتملين -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Clients</p>
                                <h4 class="card-title">{{ number_format($clientCount) }}</h4> <!-- عرض عدد العملاء -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Expenses</p>
                                <h4 class="card-title">${{ number_format($expenseTotal, 2) }}</h4>
                                <!-- عرض إجمالي المصاريف -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Projects</p>
                                <h4 class="card-title">{{ number_format($projectCount) }}</h4> <!-- عرض عدد المشاريع -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Expenses</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="pieChart" style="width: 50%; height: 50%"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Lead-to-Customer Conversion</div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="multipleBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('contentScript')
    <script>
        $(document).ready(function() {
            var pieChartCanvas = document.getElementById("pieChart");
            var multipleBarChartCanvas = document.getElementById("multipleBarChart");

            if (pieChartCanvas && multipleBarChartCanvas) {
                var pieChart = pieChartCanvas.getContext("2d");
                var multipleBarChart = multipleBarChartCanvas.getContext("2d");

                // جلب بيانات المصاريف حسب الفئة لهذا الشهر
                var expenseData = @json($expensesByCategory);
                var expenseLabels = Object.keys(expenseData);
                var expenseValues = Object.values(expenseData);

                // مخطط الدائرة (Pie Chart) - المصاريف الشهرية
                var myPieChart = new Chart(pieChart, {
                    type: "pie",
                    data: {
                        datasets: [{
                            data: expenseValues,
                            backgroundColor: ["#59d05d", "#f3545d", "#fdaf4b", "#3366cc",
                                "#990099"],
                            borderWidth: 0,
                        }],
                        labels: expenseLabels,
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            position: "bottom"
                        },
                        title: {
                            display: true,
                            text: "Expenses by Category (This Month)"
                        },
                    },
                });

                // بيانات تحويل العملاء المحتملين لكل شهر من السنة لكل حالة
                var leadsStats = @json($formattedLeadsStats);

                // إعداد بيانات المخطط - وضع قيم `0` للأشهر التي لا تحتوي على بيانات
                var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                var wonData = new Array(12).fill(0);
                var contactedData = new Array(12).fill(0);
                var lostData = new Array(12).fill(0);

                Object.keys(leadsStats).forEach(function(month) {
                    wonData[parseInt(month) - 1] = leadsStats[month].won;
                    contactedData[parseInt(month) - 1] = leadsStats[month].contacted;
                    lostData[parseInt(month) - 1] = leadsStats[month].lost;
                });

                // مخطط الأعمدة (Bar Chart) - تحويل العملاء شهريًا لكل حالة
                var myMultipleBarChart = new Chart(multipleBarChart, {
                    type: "bar",
                    data: {
                        labels: months,
                        datasets: [{
                                label: "Won",
                                backgroundColor: "#59d05d",
                                borderColor: "#59d05d",
                                data: wonData,
                            },
                            {
                                label: "Contacted",
                                backgroundColor: "#fdaf4b",
                                borderColor: "#fdaf4b",
                                data: contactedData,
                            },
                            {
                                label: "Lost",
                                backgroundColor: "#f3545d",
                                borderColor: "#f3545d",
                                data: lostData,
                            }
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            position: "bottom"
                        },
                        title: {
                            display: true,
                            text: "Leads Status Per Month (This Year)"
                        },
                        tooltips: {
                            mode: "index",
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    },
                });

            } else {
                console.warn("One or more canvas elements are missing!");
            }
        });
    </script>
@endsection
