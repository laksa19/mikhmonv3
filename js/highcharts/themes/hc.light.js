/**
 * Mikhmon Light theme for Highcharts JS
 * @author Laksamadi Guko
 */

Highcharts.theme = {
	colors: ["#20a8d8", "#f86c6b"],
	chart: {
		backgroundColor: '#FFFFFF',
		borderColor: 'FFFFFF',
		borderWidth: 1,
		className: 'light-cart',
		plotBackgroundColor: '#FFFFFF',
		plotBorderColor: '#c1c1c1',
		plotBorderWidth: 1,
		height: '300px'
	},
	title: {
		style: {
			color: '#3E3E3E',
			font: 'bold 14px "Trebuchet MS", Verdana, sans-serif, Roboto,"Seggoe UI"'
		}
	},
	subtitle: {
		style: {
			color: '#3E3E3E',
			font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
		}
	},
	xAxis: {
		gridLineColor: '#c1c1c1',
		gridLineWidth: 1,
		labels: {
			style: {
				color: '#3E3E3E'
			}
		},

		lineColor: '#c1c1c1',
		tickColor: '#c1c1c1',
		title: {
			style: {
				color: '#3E3E3E',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'bold 16px "Trebuchet MS", Verdana, sans-serif, Roboto,"Seggoe UI"'

			}
		}
	},
	yAxis: {
		gridLineColor: '#c1c1c1',
		labels: {
			style: {
				color: '#3E3E3E'
			}
		},
		lineColor: '#c1c1c1',
		minorTickInterval: null,
		tickColor: '#c1c1c1',
		tickWidth: 1,
		title: {
			style: {
				color: '#3E3E3E',
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
		backgroundColor: 'rgba(254, 254, 254, 0.75)',
		style: {
			color: '#3E3E3E'
		}
	},
	legend: {
		itemStyle: {
			font: '9pt Trebuchet MS, Verdana, sans-serif',
			color: '#3E3E3E'
		},
		itemHoverStyle: {
			color: '#20a8d8'
		},
		itemHiddenStyle: {
			color: '#E9EBEE'
		}
	},
	credits: {
		enabled: 0,
	}

};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);