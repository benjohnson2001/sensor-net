function init() {
	initHost('R1');
	initHost('R2');
	initHost('R3');
	initHost('R4');
}

var seriesOptions = [
	{ strokeStyle: 'rgba(255, 0, 0, 1)', fillStyle: 'rgba(255, 0, 0, 0.1)', lineWidth: 3 },
	{ strokeStyle: 'rgba(0, 255, 0, 1)', fillStyle: 'rgba(0, 255, 0, 0.1)', lineWidth: 3 },
	{ strokeStyle: 'rgba(0, 0, 255, 1)', fillStyle: 'rgba(0, 0, 255, 0.1)', lineWidth: 3 },
	{ strokeStyle: 'rgba(255, 255, 0, 1)', fillStyle: 'rgba(255, 255, 0, 0.1)', lineWidth: 3 }
];

var val1;
var val2;
var val3;
var val4;

$.ajaxSetup({cache: false});

setInterval(function() {

	jQuery.get('data_processing/val1.dat', function(data1) {
		val1=data1;
	});

	jQuery.get('data_processing/val2.dat', function(data2) {
		val2=data2;
	});

	jQuery.get('data_processing/val3.dat', function(data3) {
		val3=data3;
	});

	jQuery.get('data_processing/val4.dat', function(data4) {
		val4=data4;
	});

},500);

var ct = 0;

function initHost(cpu_id) {
 
// initialize an empty timeseries for each CPU
var cpuDataSets = [new TimeSeries(), new TimeSeries(), new TimeSeries(), new TimeSeries()];

var now = new Date().getTime();

// build the timeline
var timeline = new SmoothieChart({ fps: 20, millisPerPixel: 300, grid: { strokeStyle: '#555555', lineWidth: 1, millisPerLine: 30000, verticalSections: 5}, minValue: -1, maxValue: 1, maxDataSetLength: 2000 });

for (var t = now - 1000 * 50; t <= now; t += 1000) {
	add_value(t, cpuDataSets, cpu_id);
}

// simulate a new set of readings being taken from each CPU
setInterval(function() {
	add_value(new Date().getTime(), cpuDataSets, cpu_id);
}, 1000);

timeline.addTimeSeries(cpuDataSets[ct], seriesOptions[ct]);

timeline.streamTo(document.getElementById(cpu_id), 1000);

ct = ct + 1;

}

function add_value(time, dataSets, id) {

	for (var i = 0; i < dataSets.length; i++) {
	
		if (id == 'R1')
			dataSets[i].append(time, val1);
			
		if (id == 'R2')
			dataSets[i].append(time, val2);
			
		if (id == 'R3')
			dataSets[i].append(time, val3);
			
		if (id == 'R4' ) 
			dataSets[i].append(time, val4);
	}
}
