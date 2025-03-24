<h1 style="margin-top:98px">Welcome back <b><?php echo $_SESSION['adminusername']; ?></b></h1>

<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Monthly Revenue (<?php echo date('Y'); ?>)</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Revenue by Category</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">Sales Trend (Last 7 Days)</h5>
                </div>
                <div class="card-body">
                    <canvas id="weeklyChart" width="400" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Fetch monthly revenue data
$monthlyData = [];
$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
$currentYear = date('Y');

for ($i = 1; $i <= 12; $i++) {
    $month = sprintf('%02d', $i);
    $sql = "SELECT SUM(amount) as total FROM orders WHERE YEAR(orderDate) = '$currentYear' AND MONTH(orderDate) = '$month' AND orderStatus = '4'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $monthlyData[] = $row['total'] ? $row['total'] : 0;
}

// Fetch category revenue data
$sql = "SELECT c.categorieName, SUM(o.amount) as categoryRevenue 
        FROM orders o 
        JOIN orderitems oi ON o.orderId = oi.orderId 
        JOIN products p ON oi.productId = p.productId 
        JOIN categories c ON p.productCategorieId = c.categorieId 
        WHERE o.orderStatus = '4'
        GROUP BY c.categorieId 
        ORDER BY categoryRevenue DESC 
        LIMIT 5";
$result = mysqli_query($conn, $sql);
$categoryLabels = [];
$categoryData = [];
while($row = mysqli_fetch_assoc($result)) {
    $categoryLabels[] = $row['categorieName'];
    $categoryData[] = $row['categoryRevenue'];
}

// Fetch last 7 days revenue
$weeklyData = [];
$weeklyLabels = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $sql = "SELECT SUM(amount) as daily FROM orders WHERE DATE(orderDate) = '$date' AND orderStatus = '4'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $weeklyData[] = $row['daily'] ? $row['daily'] : 0;
    $weeklyLabels[] = date('M d', strtotime("-$i days"));
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Monthly Revenue (PHP)',
                data: <?php echo json_encode($monthlyData); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value;
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });

    // Category Revenue Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($categoryLabels); ?>,
            datasets: [{
                data: <?php echo json_encode($categoryData); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            return label + ': ₱' + value;
                        }
                    }
                }
            }
        }
    });

    // Weekly Revenue Chart
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    const weeklyChart = new Chart(weeklyCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($weeklyLabels); ?>,
            datasets: [{
                label: 'Daily Revenue (PHP)',
                data: <?php echo json_encode($weeklyData); ?>,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value;
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });
});
</script>