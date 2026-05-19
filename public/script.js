// Initialize Lucide icons
lucide.createIcons();

// Elements
const kegiatanSelector = document.getElementById('kegiatan-selector');
const valTarget = document.getElementById('val-target');
const valSubmit = document.getElementById('val-submit');
const valApprove = document.getElementById('val-approve');
const valProgress = document.getElementById('val-progress');

let regionalChartInstance = null;
let performanceChartInstance = null; // We'll keep the line chart static or use dummy data for now, but update the bar chart dynamically.

const regionalCtx = document.getElementById('regionalChart')?.getContext('2d');
if (regionalCtx) {
    regionalChartInstance = new Chart(regionalCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Progres (%)',
                data: [],
                backgroundColor: function(context) {
                    const value = context.dataset.data[context.dataIndex];
                    return value < 50 ? '#ba1a1a' : '#10b981'; // Warning color for low progress
                },
                borderRadius: 6,
                barThickness: 12
            }]
        },
        options: {
            indexAxis: 'y', // Horizontal bar chart
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const isPercentage = window.barChartView !== 'quantity';
                            return isPercentage ? `Progres: ${context.parsed.x}%` : `Capaian: ${context.parsed.x} Dokumen`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    // max: 100, akan diset dinamis
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { family: 'Poppins', size: 10 } }
                },
                y: {
                    grid: { display: false },
                    ticks: { font: { family: 'Poppins', size: 10 } }
                }
            }
        }
    });
}

// Performance Line Chart Datasets (Dummy for visual)
const kabKotaNames = ['Kerinci', 'Merangin', 'Sarolangun', 'Batanghari', 'Muaro Jambi', 'Tanjung Jabung Barat', 'Tanjung Jabung Timur', 'Bungo', 'Tebo', 'Kota Jambi', 'Kota Sungai Penuh'];
const kabKotaColors = ['#006c49', '#10b981', '#0ea5e9', '#3b82f6', '#6366f1', '#8b5cf6', '#d946ef', '#f43f5e', '#f59e0b', '#84cc16', '#14b8a6'];

const datasetsProvinsi = [
    { label: 'Submissions', data: [65, 71, 68, 76, 87, 85, 94, 92, 102, 101, 102, 110], borderColor: '#006c49', borderWidth: 2, pointRadius: 0, tension: 0.4, fill: false },
    { label: 'Target', data: [44, 48, 52, 54, 56, 58, 58, 62, 68, 65, 66, 71], borderColor: '#10b981', borderWidth: 2, borderDash: [4, 4], pointRadius: 0, tension: 0.4, fill: false }
];

const datasetsKabKota = kabKotaNames.map((name, index) => {
    const startVal = 5 + index * 2;
    const data = [startVal];
    let currentVal = startVal;
    for (let i = 1; i < 12; i++) {
        currentVal += 5 + (index % 4) + Math.floor(Math.random() * 4);
        data.push(currentVal);
    }
    return { label: name, data: data, borderColor: kabKotaColors[index], borderWidth: 2, pointRadius: 0, tension: 0.4, fill: false };
});

const perfCtx = document.getElementById('performanceChart')?.getContext('2d');
if (perfCtx) {
    performanceChartInstance = new Chart(perfCtx, {
        type: 'line',
        data: { labels: [], datasets: [] }, // Will be updated dynamically
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom', labels: { font: { family: 'Poppins', size: 10 }, usePointStyle: true, boxWidth: 8 } },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Capaian: ${context.parsed.y}%`;
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { family: 'Poppins', size: 10 }, color: '#6c7a71' } },
                y: { min: 0, max: 100, ticks: { stepSize: 20, font: { family: 'Poppins', size: 10 }, color: '#6c7a71', callback: function(value) { return value + '%' } }, grid: { color: '#f1f5f9' } }
            }
        }
    });

    const toggleGroup = document.querySelector('.performance-curve .toggle-group');
    if (toggleGroup) {
        toggleGroup.style.display = 'flex'; // Ensure toggle is visible
    }

    document.querySelectorAll('.performance-curve .toggle-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('.performance-curve .toggle-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            const type = this.innerText.trim();
            if (performanceChartInstance && window.chartLabels) {
                if (type === 'Provinsi' && window.chartDatasetsProvinsi) {
                    performanceChartInstance.data.datasets = window.chartDatasetsProvinsi;
                } else if (type === 'Kab/Kota' && window.chartDatasetsKabKota) {
                    performanceChartInstance.data.datasets = window.chartDatasetsKabKota;
                }
                performanceChartInstance.update();
            }
        });
    });
}

// Fetch Backend Data for Dashboard
async function loadDashboardData() {
    if (!kegiatanSelector) return; // Not on dashboard page

    try {
        // Fetch list of kegiatan
        const actRes = await fetch('/api/kegiatan');
        const activities = await actRes.json();
        
        kegiatanSelector.innerHTML = '';
        activities.forEach(act => {
            const option = document.createElement('option');
            option.value = act.id_kegiatan;
            option.text = act.nama_kegiatan;
            option.dataset.deadline = act.tanggal_deadline;
            kegiatanSelector.appendChild(option);
        });

        // Add event listener to update charts when selection changes
        kegiatanSelector.addEventListener('change', fetchProgressData);

        // Fetch progress for the initially selected activity
        if (activities.length > 0) {
            fetchProgressData();
        }

    } catch (err) {
        console.error("Gagal memuat data dari server:", err);
        kegiatanSelector.innerHTML = '<option value="">Gagal memuat data</option>';
    }
}

async function fetchProgressData() {
    const id_kegiatan = kegiatanSelector.value;
    if (!id_kegiatan) return;

    // Show Loading Effect
    if (valTarget) valTarget.innerText = "Memuat...";
    if (valSubmit) valSubmit.innerText = "Memuat...";
    if (valApprove) valApprove.innerText = "Memuat...";
    if (valProgress) valProgress.innerText = "Memuat...";

    // Update Days Badge Dynamically
    const selectedOption = kegiatanSelector.options[kegiatanSelector.selectedIndex];
    const deadlineDateStr = selectedOption.dataset.deadline;
    const daysBadgeContainer = document.getElementById('days-badge-container');
    const daysBadgeText = document.getElementById('days-badge-text');

    if (daysBadgeContainer && daysBadgeText) {
        if (deadlineDateStr && deadlineDateStr !== 'null') {
            const deadlineDate = new Date(deadlineDateStr);
            const today = new Date();
            const timeDiff = deadlineDate.getTime() - today.getTime();
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            daysBadgeText.innerHTML = `Sisa Hari: <strong>${daysDiff}</strong>`;
            
            // Remove previous classes & inline styles
            daysBadgeContainer.className = 'days-badge';
            daysBadgeContainer.style.backgroundColor = '';
            daysBadgeContainer.style.color = '';
            const icon = daysBadgeContainer.querySelector('i');
            if(icon) icon.style.color = '';

            if (daysDiff < 8) {
                daysBadgeContainer.style.backgroundColor = '#fee2e2'; // Red light
                daysBadgeContainer.style.color = '#b91c1c';
                if(icon) icon.style.color = '#b91c1c';
            } else if (daysDiff <= 20) {
                daysBadgeContainer.style.backgroundColor = '#fef3c7'; // Yellow light
                daysBadgeContainer.style.color = '#b45309';
                if(icon) icon.style.color = '#b45309';
            } else {
                daysBadgeContainer.style.backgroundColor = '#d1fae5'; // Green light
                daysBadgeContainer.style.color = '#047857';
                if(icon) icon.style.color = '#047857';
            }
        } else {
            daysBadgeText.innerHTML = `Sisa Hari: <strong>-</strong>`;
            daysBadgeContainer.style.backgroundColor = '';
            daysBadgeContainer.style.color = '';
            const icon = daysBadgeContainer.querySelector('i');
            if(icon) icon.style.color = '';
        }
    }

    try {
        const progRes = await fetch(`/api/progress/${id_kegiatan}`);
        const data = await progRes.json();

        // Update KPIs
        if (valTarget) valTarget.innerText = data.summary.total_target.toLocaleString('id-ID');
        if (valSubmit) valSubmit.innerText = data.summary.total_submit.toLocaleString('id-ID');
        if (valApprove) valApprove.innerText = data.summary.total_approved.toLocaleString('id-ID');
        if (valProgress) valProgress.innerText = data.summary.overall_progress + '%';

        // Update Bar Chart
        if (regionalChartInstance) {
            window.regionalDataRaw = data.regional;
            if (!window.barChartView) window.barChartView = 'percentage';
            updateBarChart();
        }

        // Fetch and Update Line Chart (History)
        const historyRes = await fetch(`/api/progress-history/${id_kegiatan}`);
        const historyDataRaw = await historyRes.json();
        
        if (performanceChartInstance) {
            if (historyDataRaw.length > 0) {
            const formatLabel = (h) => {
                const d = new Date(h.tanggal_update + 'Z');
                return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' }) + ' ' + d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            };

            const historyData = historyDataRaw.sort((a,b) => new Date(a.tanggal_update+'Z') - new Date(b.tanggal_update+'Z'));
            const allLabelsMap = new Map();
            historyData.forEach(h => {
                const label = formatLabel(h);
                if (!allLabelsMap.has(label)) allLabelsMap.set(label, label);
            });
            const labels = Array.from(allLabelsMap.values());

            let currentProvProgress = 0;
            const dataProvinsi = labels.map(label => {
                const record = [...historyData].reverse().find(h => h.id_kabkota === null && formatLabel(h) === label);
                if (record) currentProvProgress = record.progress_percentage;
                return currentProvProgress;
            });

            const dsProvinsi = [{
                label: 'Realisasi Provinsi',
                data: dataProvinsi,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#10b981',
                pointRadius: 4,
                tension: 0.3,
                fill: true
            }];

            const dsKabKota = [];
            const kabKotaColors = ['#006c49', '#10b981', '#0ea5e9', '#3b82f6', '#6366f1', '#8b5cf6', '#d946ef', '#f43f5e', '#f59e0b', '#84cc16', '#14b8a6'];
            let colorIndex = 0;
            const kabKotaNames = [...new Set(historyData.filter(h => h.id_kabkota !== null && h.nama_kabkota).map(h => h.nama_kabkota))];
            
            kabKotaNames.forEach(nama_kk => {
                let currentKKProgress = 0;
                const dataKK = labels.map(label => {
                    const record = [...historyData].reverse().find(h => h.nama_kabkota === nama_kk && formatLabel(h) === label);
                    if (record) currentKKProgress = record.progress_percentage;
                    return currentKKProgress;
                });
                
                dsKabKota.push({
                    label: nama_kk,
                    data: dataKK,
                    borderColor: kabKotaColors[colorIndex % kabKotaColors.length],
                    borderWidth: 2,
                    pointRadius: 3,
                    tension: 0.3,
                    fill: false
                });
                colorIndex++;
            });

            window.chartDatasetsProvinsi = dsProvinsi;
            window.chartDatasetsKabKota = dsKabKota.length > 0 ? dsKabKota : dsProvinsi; // fallback if no kabkota data yet
            window.chartLabels = labels;

            const activeToggle = document.querySelector('.performance-curve .toggle-btn.active');
            const showKabKota = activeToggle && activeToggle.innerText.trim() === 'Kab/Kota';

            performanceChartInstance.data.labels = labels;
            performanceChartInstance.data.datasets = showKabKota ? window.chartDatasetsKabKota : window.chartDatasetsProvinsi;
            performanceChartInstance.update();
            } else {
                window.chartDatasetsProvinsi = [];
                window.chartDatasetsKabKota = [];
                window.chartLabels = [];
                performanceChartInstance.data.labels = [];
                performanceChartInstance.data.datasets = [];
                performanceChartInstance.update();
            }
        }

    } catch (err) {
        console.error("Gagal memuat progres:", err);
    }
}

function updateBarChart() {
    if (!regionalChartInstance || !window.regionalDataRaw) return;
    const isPercentage = window.barChartView !== 'quantity';
    
    regionalChartInstance.data.labels = window.regionalDataRaw.map(r => r.nama_kabkota);
    regionalChartInstance.data.datasets[0].data = window.regionalDataRaw.map(r => {
        return isPercentage ? r.progress_percentage : ((r.submit || 0) + (r.approved || 0));
    });
    
    // Update bar colors: if percentage, red for < 50%. If quantity, green.
    regionalChartInstance.data.datasets[0].backgroundColor = function(context) {
        if (isPercentage) {
            return context.dataset.data[context.dataIndex] < 50 ? '#ba1a1a' : '#10b981';
        } else {
            return '#10b981'; // solid color for quantities
        }
    };
    
    if (isPercentage) {
        regionalChartInstance.options.scales.x.max = 100;
        regionalChartInstance.data.datasets[0].label = 'Progres (%)';
    } else {
        regionalChartInstance.options.scales.x.max = null; // Auto scale for raw numbers
        regionalChartInstance.data.datasets[0].label = 'Kuantitas (Dokumen)';
    }
    regionalChartInstance.update();
}

// Event Listeners for Bar Chart Toggle
document.querySelectorAll('#toggle-bar .toggle-btn').forEach(button => {
    button.addEventListener('click', function () {
        document.querySelectorAll('#toggle-bar .toggle-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        window.barChartView = this.getAttribute('data-view');
        updateBarChart();
    });
});

// Init
loadDashboardData();