function getData()
{
    $.ajax({
        url: baseURI + 'dashboard',
        method: 'get',
        dataType: 'json',
        error: function(xhr, status, error) {
            var data = 'Please refresh this page.. ' + '(status code: ' + xhr.status + ')';
            Toast.fire({type:'error', icon:'error', title: '', text: data});
        },
        success: function(response){
            $('#totalDocument').html(`<div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Dokumen</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">${response.totalDocument}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-newspaper fa-2x text-primary"></i>
                </div>
            </div>`);
            $('#totalAccount').html(`<div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Akun</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">${response.totalAccount}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-info"></i>
                </div>
            </div>`);
            $('#totalCategories').html(`<div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Kategori</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">${response.countCategories}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-folder fa-2x text-danger"></i>
                </div>
            </div>`);

            $('#lastLogin').text(response.loginInformation.timestamp.indonesianDate());
            $('#userAgent').text(response.loginInformation.browser + " on " + response.loginInformation.platform);
            $('#lastIp').text(response.loginInformation.ip_address);

            var ctx = document.getElementById('docClassificationChart').getContext('2d');
            var docClassificationChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels:response.docClassification.classification,
                    datasets: [{
                        data: Object.values(response.docClassification.total),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });

            var ctx2 = document.getElementById('docCategoriesChart').getContext('2d');
            var docCategoriesChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: response.docCategories.categories,
                    datasets: [{
                        data: Object.values(response.docCategories.total),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: false,
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.chart.data.labels[context.dataIndex] || '';
                                    return label + ': ' + context.raw;
                                }
                            }
                        }
                    }
                },
                y: {
                    ticks: {
                        // forces step size to be 5 units
                        stepSize: 10
                    }
                }
            });
        }
    });
}

getData();