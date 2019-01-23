/**
 * Mikhmon Pink theme for Highcharts JS
 * @author Laksamadi Guko
 */

Highcharts.theme = {
	colors: ["#20a8d8", "#f86c6b"],
	chart: {
		backgroundColor: 'rgb(255, 230, 241)',
		borderColor: 'rgb(255, 230, 241)',
		borderWidth: 1,
		className: 'light-cart',
		plotBackgroundColor: 'rgb(255, 230, 241)',
		plotBorderColor: '#F670AD',
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
		gridLineColor: '#F670AD',
		gridLineWidth: 1,
		labels: {
			style: {
				color: '#3E3E3E'
			}
		},

		lineColor: '#F670AD',
		tickColor: '#F670AD',
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
		gridLineColor: '#F670AD',
		labels: {
			style: {
				color: '#3E3E3E'
			}
		},
		lineColor: '#F670AD',
		minorTickInterval: null,
		tickColor: '#F670AD',
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
		backgroundColor: 'rgb(253, 223, 237, 0.75)',
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