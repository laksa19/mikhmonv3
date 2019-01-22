/**
 * Mikhmon Dark theme for Highcharts JS
 * @author Laksamadi Guko
 */

Highcharts.theme = {
	colors: ["#20a8d8", "#f86c6b"],
	chart: {
		backgroundColor: '#3a4149',
		borderColor: '#3a4149',
		borderWidth: 1,
		className: 'dark-chart',
		plotBackgroundColor: '#3a4149',
		plotBorderColor: '#2f353a',
		plotBorderWidth: 1,
		height: '300px'
	},
	title: {
		style: {
			color: '#f3f4f5',
			font: 'bold 14px "Trebuchet MS", Verdana, sans-serif, Roboto,"Seggoe UI"'
		}
	},
	subtitle: {
		style: {
			color: '#f3f4f5',
			font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
		}
	},
	xAxis: {
		gridLineColor: '#2f353a',
		gridLineWidth: 1,
		labels: {
			style: {
				color: '#f3f4f5'
			}
		},
		lineColor: '#2f353a',
		tickColor: '#2f353a',
		title: {
			style: {
				color: '#f3f4f5',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'bold 16px "Trebuchet MS", Verdana, sans-serif, Roboto,"Seggoe UI"'

			}
		}
	},
	yAxis: {
		gridLineColor: '#2f353a',
		labels: {
			style: {
				color: '#f3f4f5'
			}
		},
		lineColor: '#2f353a',
		minorTickInterval: null,
		tickColor: '#2f353a',
		tickWidth: 1,
		title: {
			style: {
				color: '#f3f4f5',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'bold 16px "Trebuchet MS", Verdana, sans-serif, Roboto,"Seggoe UI"'
			}
		}
	},
	plotOptions: {
		series: {
			fillOpacity: 0.1
		}
	},
	tooltip: {
		backgroundColor: 'rgba(58, 65, 73, 0.75)',
		style: {
			color: '#f3f4f5'
		}
	},
	legend: {
		itemStyle: {
			font: '9pt Trebuchet MS, Verdana, sans-serif',
			color: '#f3f4f5'
		},
		itemHoverStyle: {
			color: '#20a8d8'
		},
		itemHiddenStyle: {
			color: '#2F353A'
		}
	},
	credits: {
		enabled: 0,
	}

};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);