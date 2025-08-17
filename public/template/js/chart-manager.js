// Chart Manager untuk Statistik PPLP
class ChartManager {
    constructor() {
        this.chartInstances = {};
        this.defaultConfig();
    }

    defaultConfig() {
        if (typeof Chart !== "undefined") {
            Chart.defaults.font.family =
                'Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
            Chart.defaults.color = "#858796";
        }
    }

    ensureNumber(value) {
        return isNaN(parseInt(value)) ? 0 : parseInt(value);
    }

    destroyAllCharts() {
        Object.values(this.chartInstances).forEach((chart) => {
            if (chart && typeof chart.destroy === "function") {
                try {
                    chart.destroy();
                } catch (error) {
                    console.warn("Error destroying chart:", error);
                }
            }
        });
        this.chartInstances = {};
    }

    createPieChart(elementId, labels, data, colors, title = "") {
        const element = document.getElementById(elementId);
        if (!element || !Array.isArray(data) || data.length === 0) return null;

        // Destroy existing chart if exists
        if (this.chartInstances[elementId]) {
            this.chartInstances[elementId].destroy();
        }

        this.chartInstances[elementId] = new Chart(element, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [
                    {
                        data: data.map((val) => this.ensureNumber(val)),
                        backgroundColor: colors,
                        borderWidth: 2,
                        borderColor: "#fff",
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return (
                                    context.label +
                                    ": " +
                                    context.parsed +
                                    " orang"
                                );
                            },
                        },
                    },
                    title: {
                        display: !!title,
                        text: title,
                    },
                },
            },
        });

        return this.chartInstances[elementId];
    }

    createDoughnutChart(elementId, labels, data, colors, title = "") {
        const element = document.getElementById(elementId);
        if (!element || !Array.isArray(data) || data.length === 0) return null;

        if (this.chartInstances[elementId]) {
            this.chartInstances[elementId].destroy();
        }

        this.chartInstances[elementId] = new Chart(element, {
            type: "doughnut",
            data: {
                labels: labels,
                datasets: [
                    {
                        data: data.map((val) => this.ensureNumber(val)),
                        backgroundColor: colors,
                        borderWidth: 3,
                        borderColor: "#fff",
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: "70%",
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return (
                                    context.label +
                                    ": " +
                                    context.parsed +
                                    " orang"
                                );
                            },
                        },
                    },
                    title: {
                        display: !!title,
                        text: title,
                    },
                },
            },
        });

        return this.chartInstances[elementId];
    }

    createBarChart(
        elementId,
        labels,
        data,
        colors,
        labelSuffix = "",
        horizontal = false
    ) {
        const element = document.getElementById(elementId);
        if (!element || !Array.isArray(data) || data.length === 0) return null;

        if (this.chartInstances[elementId]) {
            this.chartInstances[elementId].destroy();
        }

        const config = {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        data: data.map((val) => this.ensureNumber(val)),
                        backgroundColor: colors,
                        borderRadius: 5,
                        borderSkipped: false,
                        borderWidth: 1,
                        borderColor: Array.isArray(colors) ? colors : [colors],
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return (
                                    context.label +
                                    ": " +
                                    context.parsed +
                                    " " +
                                    labelSuffix
                                );
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return Number.isInteger(value) ? value : "";
                            },
                        },
                    },
                },
            },
        };

        if (horizontal) {
            config.options.indexAxis = "y";
            config.options.scales = {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return Number.isInteger(value) ? value : "";
                        },
                    },
                },
            };
        }

        this.chartInstances[elementId] = new Chart(element, config);
        return this.chartInstances[elementId];
    }

    createLineChart(elementId, labels, data, label = "Data") {
        const element = document.getElementById(elementId);
        if (!element || !Array.isArray(data) || data.length === 0) return null;

        if (this.chartInstances[elementId]) {
            this.chartInstances[elementId].destroy();
        }

        this.chartInstances[elementId] = new Chart(element, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: label,
                        data: data.map((val) => this.ensureNumber(val)),
                        borderColor: "#4e73df",
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        tension: 0.3,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: "#4e73df",
                        pointBorderColor: "#fff",
                        pointBorderWidth: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return label + ": " + context.parsed.y;
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return Number.isInteger(value) ? value : "";
                            },
                        },
                    },
                },
            },
        });

        return this.chartInstances[elementId];
    }

    initAllCharts(data) {
        try {
            // Destroy existing charts first
            this.destroyAllCharts();

            // Chart Jenis Kelamin
            this.createPieChart(
                "chartJenisKelamin",
                ["Pria", "Wanita"],
                [data.atlitPria, data.atlitWanita],
                ["#4e73df", "#1cc88a"]
            );

            // Chart Status Atlit
            this.createPieChart(
                "chartStatusAtlit",
                ["Aktif", "Tidak Aktif"],
                [data.atlitAktif, data.atlitTidakAktif],
                ["#1cc88a", "#e74a3b"]
            );

            // Chart Kelompok Umur
            this.createDoughnutChart(
                "chartKelompokUmur",
                ["≤17 tahun", "18-25 tahun", "≥26 tahun"],
                [data.umur17Kebawah, data.umur18_25, data.umur26Keatas],
                ["#f6c23e", "#1cc88a", "#36b9cc"]
            );

            // Chart Medali
            this.createBarChart(
                "chartMedali",
                ["Emas", "Perak", "Perunggu"],
                [data.prestasiEmas, data.prestasiPerak, data.prestasiPerunggu],
                ["#f6c23e", "#858796", "#36b9cc"],
                "medali"
            );

            // Chart Tingkat Kejuaraan
            this.createBarChart(
                "chartTingkatKejuaraan",
                ["Internasional", "Nasional", "Provinsi", "Regional", "Daerah"],
                [
                    data.prestasiInternasional,
                    data.prestasiNasional,
                    data.prestasiProvinsi,
                    data.prestasiRegional,
                    data.prestasiDaerah,
                ],
                ["#e74a3b", "#f6c23e", "#36b9cc", "#858796", "#6c757d"],
                "prestasi"
            );

            // Chart Tren Prestasi
            if (data.prestasiPerTahun && data.prestasiPerTahun.length > 0) {
                const trenLabels = data.prestasiPerTahun.map(
                    (item) => item.tahun
                );
                const trenData = data.prestasiPerTahun.map(
                    (item) => item.jumlah
                );
                this.createLineChart(
                    "chartTrenPrestasi",
                    trenLabels,
                    trenData,
                    "Jumlah Prestasi"
                );
            }

            // Chart Prestasi per Cabor
            if (data.prestasiPerCabor && data.prestasiPerCabor.length > 0) {
                const caborLabels = data.prestasiPerCabor.map(
                    (item) => item.nama
                );
                const caborData = data.prestasiPerCabor.map(
                    (item) => item.jumlah
                );

                // Check if there's actual data
                if (caborData.some((val) => val > 0)) {
                    this.createBarChart(
                        "chartPrestasiCabor",
                        caborLabels,
                        caborData,
                        "rgba(78, 115, 223, 0.8)",
                        "prestasi",
                        true // horizontal
                    );
                }
            }
        } catch (error) {
            console.error("Error initializing charts:", error);
        }
    }
}

// Global instance
window.chartManager = new ChartManager();
