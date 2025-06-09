"use strict"; var KTAppChat = function () { var e = function (e) { var t = e.querySelector('[data-kt-element="messages"]'), n = e.querySelector('[data-kt-element="input"]'); if (0 !== n.value.length) { var o, a = t.querySelector('[data-kt-element="template-out"]'), l = t.querySelector('[data-kt-element="template-in"]'); (o = a.cloneNode(!0)).classList.remove("d-none"), o.querySelector('[data-kt-element="message-text"]').innerText = n.value, n.value = "", t.appendChild(o), t.scrollTop = t.scrollHeight, setTimeout((function () { (o = l.cloneNode(!0)).classList.remove("d-none"), o.querySelector('[data-kt-element="message-text"]').innerText = "Thank you for your awesome support!", t.appendChild(o), t.scrollTop = t.scrollHeight }), 2e3) } }; return { init: function (t) { !function (t) { t && (KTUtil.on(t, '[data-kt-element="input"]', "keydown", (function (n) { if (13 == n.keyCode) return e(t), n.preventDefault(), !1 })), KTUtil.on(t, '[data-kt-element="send"]', "click", (function (n) { e(t) }))) }(t) } } }(); KTUtil.onDOMContentLoaded((function () { KTAppChat.init(document.querySelector("#kt_chat_messenger")), KTAppChat.init(document.querySelector("#kt_drawer_chat_messenger")) }));

am5.ready(function () {
    var root = am5.Root.new("topClientsChart");
    root.setThemes([am5themes_Animated.new(root)]);

    var chart = root.container.children.push(
        am5xy.XYChart.new(root, { layout: root.verticalLayout })
    );

    var xAxis = chart.xAxes.push(
        am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererX.new(root, {})
        })
    );

    var yAxis = chart.yAxes.push(
        am5xy.CategoryAxis.new(root, {
            categoryField: "client",
            renderer: am5xy.AxisRendererY.new(root, {})
        })
    );

    var series = chart.series.push(
        am5xy.ColumnSeries.new(root, {
            name: "Trabajos Abiertos",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "count",
            categoryYField: "client",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{client}: {valueX} trabajos abiertos"
            })
        })
    );

    series.columns.template.setAll({
        cornerRadiusTL: 5,
        cornerRadiusTR: 5
    });

    var data = [
        { client: "Cliente A", count: 12 },
        { client: "Cliente B", count: 10 },
        { client: "Cliente C", count: 8 },
        { client: "Cliente D", count: 7 },
        { client: "Cliente E", count: 5 }
    ];

    series.data.setAll(data);
    yAxis.data.setAll(data);
    chart.appear(1000, 100);
});
