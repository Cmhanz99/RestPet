// Analytics Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts
    initCharts();

    // Event listeners for tab switching
    document.querySelectorAll('.chart-tabs').forEach(tabGroup => {
        tabGroup.querySelectorAll('.chart-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all siblings
                tabGroup.querySelectorAll('.chart-tab').forEach(t => {
                    t.classList.remove('active');
                });
                // Add active class to clicked tab
                this.classList.add('active');

                // Update chart based on selected tab
                const chartId = tabGroup.getAttribute('data-chart');

                if (chartId === 'revenue-chart') {
                    updateRevenueChart(this.getAttribute('data-period'));
                } else if (chartId === 'distribution-chart') {
                    updateDistributionChart(this.getAttribute('data-type'));
                }
            });
        });
    });

    // Time period dropdown change handler
    document.getElementById('time-period').addEventListener('change', function() {
        const value = this.value;
        const dateFrom = document.getElementById('date-from');
        const dateTo = document.getElementById('date-to');

        if (value === 'last30days') {
            // Set dates for last 30 days
            const today = new Date();
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(today.getDate() - 30);

            dateFrom.value = formatDate(thirtyDaysAgo);
            dateTo.value = formatDate(today);
        } else if (value === 'last90days') {
            // Set dates for last 90 days
            const today = new Date();
            const ninetyDaysAgo = new Date();
            ninetyDaysAgo.setDate(today.getDate() - 90);

            dateFrom.value = formatDate(ninetyDaysAgo);
            dateTo.value = formatDate(today);
        } else if (value === 'thisyear') {
            // Set dates for this year
            const today = new Date();
            const firstDayOfYear = new Date(today.getFullYear(), 0, 1);

            dateFrom.value = formatDate(firstDayOfYear);
            dateTo.value = formatDate(today);
        }
        // If 'custom' is selected, user can manually set dates
    });

    // Apply button click handler
    document.querySelector('.apply-btn').addEventListener('click', function() {
        // In a real application, this would fetch data from the database
        // For now, we'll update the charts with new random data
        reloadAllCharts();

        // Show a notification
        alert('Filters applied! In a real implementation, this would fetch data from the database.');
    });

    // Export button click handler
    document.querySelector('.export-btn').addEventListener('click', function() {
        alert('Export functionality will be implemented with backend integration');
    });
});

// Chart instances
let revenueChart;
let distributionChart;

// Sample data - In a real application, this would come from the database
const chartData = {
    // Weekly revenue data
    weekRevenue: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        revenue: [3200, 4500, 3800, 5500],
        bookings: [12, 15, 10, 18]
    },
    // Monthly revenue data
    monthRevenue: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        revenue: [15000, 18000, 21000, 24500, 22000, 25000],
        bookings: [35, 40, 45, 48, 42, 50]
    },
    // Quarterly revenue data
    quarterRevenue: {
        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        revenue: [54000, 72000, 81000, 93000],
        bookings: [120, 150, 180, 200]
    },
    // Property distribution data by revenue
    revenueDistribution: {
        labels: ['Paradise Garden', 'Ilog Dagat', 'Forest View', 'Sea View', 'Other'],
        data: [12000, 1200, 8000, 2500, 800]
    },
    // Property distribution data by bookings
    bookingsDistribution: {
        labels: ['Paradise Garden', 'Ilog Dagat', 'Forest View', 'Sea View', 'Other'],
        data: [20, 5, 15, 8, 3]
    }
};

// Initialize charts
function initCharts() {
    // Revenue & Bookings Chart
    const revenueCtx = document.getElementById('revenue-chart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: chartData.weekRevenue.labels,
            datasets: [
                {
                    label: 'Revenue (₱)',
                    data: chartData.weekRevenue.revenue,
                    borderColor: '#4d94ff',
                    backgroundColor: 'rgba(77, 148, 255, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y'
                },
                {
                    label: 'Bookings',
                    data: chartData.weekRevenue.bookings,
                    borderColor: '#2ec7a3',
                    backgroundColor: 'rgba(46, 199, 163, 0.1)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Revenue (₱)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    },
                    title: {
                        display: true,
                        text: 'Bookings'
                    }
                }
            }
        }
    });

    // Property Distribution Chart
    const distributionCtx = document.getElementById('distribution-chart').getContext('2d');
    distributionChart = new Chart(distributionCtx, {
        type: 'doughnut',
        data: {
            labels: chartData.revenueDistribution.labels,
            datasets: [{
                data: chartData.revenueDistribution.data,
                backgroundColor: [
                    '#4d94ff',
                    '#2ec7a3',
                    '#8c76d9',
                    '#ff9849',
                    '#ff6b6b'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Revenue Distribution by Property'
                }
            }
        }
    });
}

// Update Revenue Chart based on selected period
function updateRevenueChart(period) {
    let data;
    let title;

    switch(period) {
        case 'month':
            data = chartData.monthRevenue;
            title = 'Monthly Revenue & Bookings';
            break;
        case 'quarter':
            data = chartData.quarterRevenue;
            title = 'Quarterly Revenue & Bookings';
            break;
        default: // week
            data = chartData.weekRevenue;
            title = 'Weekly Revenue & Bookings';
    }

    revenueChart.data.labels = data.labels;
    revenueChart.data.datasets[0].data = data.revenue;
    revenueChart.data.datasets[1].data = data.bookings;
    revenueChart.options.plugins.title = {
        display: true,
        text: title
    };
    revenueChart.update();
}

// Update Distribution Chart based on selected type
function updateDistributionChart(type) {
    let data;
    let title;

    if (type === 'bookings') {
        data = chartData.bookingsDistribution;
        title = 'Bookings Distribution by Property';
    } else { // revenue
        data = chartData.revenueDistribution;
        title = 'Revenue Distribution by Property';
    }

    distributionChart.data.labels = data.labels;
    distributionChart.data.datasets[0].data = data.data;
    distributionChart.options.plugins.title = {
        display: true,
        text: title
    };
    distributionChart.update();
}

// Helper function to format date as YYYY-MM-DD
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// Generate random data for chart refresh
function generateRandomData(min, max, count) {
    return Array.from({length: count}, () => Math.floor(Math.random() * (max - min + 1)) + min);
}

// Reload all charts with new random data (for demonstration)
function reloadAllCharts() {
    // Generate new random data
    chartData.weekRevenue.revenue = generateRandomData(2000, 6000, 4);
    chartData.weekRevenue.bookings = generateRandomData(8, 20, 4);

    chartData.monthRevenue.revenue = generateRandomData(14000, 28000, 6);
    chartData.monthRevenue.bookings = generateRandomData(30, 55, 6);

    chartData.quarterRevenue.revenue = generateRandomData(50000, 100000, 4);
    chartData.quarterRevenue.bookings = generateRandomData(100, 220, 4);

    chartData.revenueDistribution.data = generateRandomData(1000, 15000, 5);
    chartData.bookingsDistribution.data = generateRandomData(3, 25, 5);

    // Find active tabs
    const activeRevenueTab = document.querySelector('[data-chart="revenue-chart"] .chart-tab.active');
    const activeDistributionTab = document.querySelector('[data-chart="distribution-chart"] .chart-tab.active');

    // Update charts based on active tabs
    updateRevenueChart(activeRevenueTab.getAttribute('data-period'));
    updateDistributionChart(activeDistributionTab.getAttribute('data-type'));
}

// Logout function (will be implemented with backend integration)
function logout() {
    if(confirm('Are you sure you want to logout?')){
        window.location.href = '/login';
    }

}
