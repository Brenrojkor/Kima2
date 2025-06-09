am5.ready(function () {
    // --- Gráfico: Distribución por Categorías ---
    var rootCategories = am5.Root.new("categoriesChart");
    rootCategories.setThemes([am5themes_Animated.new(rootCategories)]);

    var chartCategories = rootCategories.container.children.push(
        am5percent.PieChart.new(rootCategories, {
            layout: rootCategories.verticalLayout
        })
    );

    var seriesCategories = chartCategories.series.push(
        am5percent.PieSeries.new(rootCategories, {
            valueField: "value",
            categoryField: "category"
        })
    );

    seriesCategories.data.setAll([
        { category: "Cosméticos", value: 50 },
        { category: "Equipo Médico", value: 30 },
        { category: "Químicos", value: 15 },
        { category: "Otros", value: 5 }
    ]);

    seriesCategories.slices.template.setAll({
        tooltipText: "{category}: {valuePercentTotal.formatNumber('0.0')}% ({value})"
    });

    seriesCategories.labels.template.setAll({
        text: "{category}"
    });

    chartCategories.appear(1000, 100);

    // --- Otro Gráfico (por ejemplo: Clientes con Más Trabajos Abiertos) ---
    var rootClients = am5.Root.new("topClientsChart");
    rootClients.setThemes([am5themes_Animated.new(rootClients)]);

    var chartClients = rootClients.container.children.push(
        am5xy.XYChart.new(rootClients, {
            layout: rootClients.verticalLayout
        })
    );

    var xAxisClients = chartClients.xAxes.push(
        am5xy.ValueAxis.new(rootClients, {
            renderer: am5xy.AxisRendererX.new(rootClients, {})
        })
    );

    var yAxisClients = chartClients.yAxes.push(
        am5xy.CategoryAxis.new(rootClients, {
            categoryField: "client",
            renderer: am5xy.AxisRendererY.new(rootClients, {})
        })
    );

    var seriesClients = chartClients.series.push(
        am5xy.ColumnSeries.new(rootClients, {
            name: "Trabajos Abiertos",
            xAxis: xAxisClients,
            yAxis: yAxisClients,
            valueXField: "count",
            categoryYField: "client",
            tooltip: am5.Tooltip.new(rootClients, {
                labelText: "{client}: {valueX} trabajos abiertos"
            })
        })
    );

    seriesClients.data.setAll([
        { client: "Cliente A", count: 12 },
        { client: "Cliente B", count: 10 },
        { client: "Cliente C", count: 8 },
        { client: "Cliente D", count: 7 },
        { client: "Cliente E", count: 5 }
    ]);

    yAxisClients.data.setAll([
        { client: "Cliente A", count: 12 },
        { client: "Cliente B", count: 10 },
        { client: "Cliente C", count: 8 },
        { client: "Cliente D", count: 7 },
        { client: "Cliente E", count: 5 }
    ]);

    chartClients.appear(1000, 100);

    document.addEventListener("DOMContentLoaded", function () {
        // Simulación de datos (deberían venir del backend según el usuario logueado)
        const assignedProjects = [
            {
                ticket: "T-123",
                name: "Proyecto Cosméticos",
                client: "Cliente A",
                category: "Cosméticos",
                status: "En Proceso",
                link: "/tickets/123"
            },
            {
                ticket: "T-124",
                name: "Certificación Médica",
                client: "Cliente B",
                category: "Equipo Médico",
                status: "Completo",
                link: "/tickets/124"
            },
            {
                ticket: "T-125",
                name: "Registro Químico",
                client: "Cliente C",
                category: "Químicos",
                status: "Pendiente",
                link: "/tickets/125"
            },
            {
                ticket: "T-126",
                name: "Revisión de Documentos",
                client: "Cliente D",
                category: "Otros",
                status: "En Proceso",
                link: "/tickets/126"
            },
        ];

        const tableBody = document.getElementById("assignedProjectsTable");

        // Renderizar las filas
        assignedProjects.forEach((project) => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${project.ticket}</td>
                <td>${project.name}</td>
                <td>${project.client}</td>
                <td>${project.category}</td>
                <td>
                    <span class="badge ${project.status === "Completo"
                    ? "badge-light-success"
                    : project.status === "Pendiente"
                        ? "badge-light-warning"
                        : "badge-light-primary"
                }">${project.status}</span>
                </td>
                <td class="text-end">
                    <a href="${project.link}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                        <i class="fas fa-eye fs-4 text-gray-700"></i>

                    </a>
                </td>
            `;

            tableBody.appendChild(row);
        });
    });

    // Array to hold notes (this can be replaced with a server-side call)
    let notes = [
        { title: 'Actualización en proceso de aprobación', content: 'El cliente "ABC Corp" necesita revisar el documento actualizado para el registro de producto.' },
        { title: 'Proyecto con retraso', content: 'El abogado no ha entregado la documentacion para el proyecto cosmetico, llamar mañana' },
        { title: 'Próximos vencimientos', content: 'Renovación de permisos para "DEF Inc." vence el 15 de diciembre.' }
    ];

    // Function to render notes
    function renderNotes() {
        const notesList = document.getElementById("notesList");
        notesList.innerHTML = '';
        notes.forEach((note, index) => {
            const noteElement = document.createElement('div');
            noteElement.classList.add('d-flex', 'align-items-start', 'mb-4'); // Reduce margen inferior
            noteElement.innerHTML = `
            <i class="ki-duotone ki-information fs-5 text-primary me-2"></i> <!-- Reduce tamaño del icono principal -->
            <div class="d-flex flex-column w-100">
                <span class="fw-bold text-gray-700 fs-6">${note.title}</span>
                <span class="text-gray-500 fs-7">${note.content}</span>
                <div class="d-flex mt-1 justify-content-end">
                    <!-- Edit Icon -->
                    <button class="btn btn-icon btn-light btn-xs me-1" 
                        style="border-radius: 50%; border: 1px solid #e5e5e5; width: 24px; height: 24px;" 
                        onclick="editNote(${index})" title="Editar">
                        <i class="fas fa-pencil-alt text-gray-600 fs-6"></i>
                    </button>
                    <!-- Delete Icon -->
                    <button class="btn btn-icon btn-light btn-xs" 
                        style="border-radius: 50%; border: 1px solid #e5e5e5; width: 24px; height: 24px;" 
                        onclick="deleteNote(${index})" title="Eliminar">
                        <i class="fas fa-trash-alt text-gray-600 fs-6"></i>
                    </button>
                </div>
            </div>
        `;
            notesList.appendChild(noteElement);
        });
    }



    // Add note function
    document.getElementById('addNoteForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const noteTitle = document.getElementById('noteTitle').value;
        const noteContent = document.getElementById('noteContent').value;

        // Add new note
        notes.push({ title: noteTitle, content: noteContent });
        renderNotes();

        // Reset the form and close the modal
        document.getElementById('noteTitle').value = '';
        document.getElementById('noteContent').value = '';
        $('#kt_modal_add_note').modal('hide');
    });

    // Edit note function
    function editNote(index) {
        const note = notes[index];
        document.getElementById('noteTitle').value = note.title;
        document.getElementById('noteContent').value = note.content;

        // Remove the note and allow editing
        notes.splice(index, 1);
        renderNotes();

        // Open modal
        $('#kt_modal_add_note').modal('show');
    }

    // Delete note function
    function deleteNote(index) {
        notes.splice(index, 1);
        renderNotes();
    }

    // Initial render
    renderNotes();

});

am5.ready(function () {
    // Crear instancia de amCharts
    var root = am5.Root.new("mixedChart");

    // Tema animado
    root.setThemes([am5themes_Animated.new(root)]);

    // Crear el gráfico combinado
    var chart = root.container.children.push(
        am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "pan",
            wheelY: "zoom"
        })
    );

    // Crear los ejes
    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
        categoryField: "category",
        renderer: am5xy.AxisRendererX.new(root, { minGridDistance: 30 })
    }));

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
    }));

    // Agregar las series
    var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
        name: "Proyectos Pendientes",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "pendientes",
        categoryField: "category",
        tooltip: am5.Tooltip.new(root, { labelText: "{category}: {valueY}" })
    }));

    var series2 = chart.series.push(am5xy.LineSeries.new(root, {
        name: "Proyectos Completados",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "completados",
        categoryField: "category",
        stroke: am5.color(0x2dbe77),
        tooltip: am5.Tooltip.new(root, { labelText: "{category}: {valueY}" })
    }));

    // Datos de ejemplo
    var data = [
        { category: "Cliente A", pendientes: 4, completados: 7 },
        { category: "Cliente B", pendientes: 3, completados: 5 },
        { category: "Cliente C", pendientes: 5, completados: 2 },
        { category: "Cliente D", pendientes: 2, completados: 6 }
    ];

    series1.data.setAll(data);
    series2.data.setAll(data);

    // Aparecer el gráfico
    chart.appear(1000, 100);
});
