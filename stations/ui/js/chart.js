function httpGet(theUrl)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    return xmlHttp.responseText;
}

var station_id = document.getElementById('station_id').innerHTML;
var weeklyChart = document.getElementById('weeklyChart').getContext('2d');
var monthlyChart = document.getElementById('monthlyChart').getContext('2d');
var option = {
  legend: {
  display: false},
  responsive: true,
  scaleBeginAtZero: true,
  maintainAspectRatio: false,
  scales: {
    yAxes: [{
		stacked: true,
		ticks: {
				beginAtZero:true
		}
      gridLines: {
        display: true,
        color: "rgba(255,99,132,0.2)"
      }
    }],
    xAxes: [{
      gridLines: {
        display: false
      }
    }]
  }
};
var weeklyChart = new Chart(weeklyChart, {
  type: 'line',
  options: option,
  data: {
    labels: ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'],
    datasets: [{
      label: 'apples',
      data: JSON.parse("[" + httpGet("https://gruppe6.torutec.eu/stations/PrintDetails.php?type=weekChart&station=" + station_id) + "]"),
      backgroundColor: "rgba(153,51,255,0.4)"
    }]
  }
  
});
var monthlyChart = new Chart(monthlyChart, {
  type: 'line',
  options: option,
  data: {
    labels: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
    datasets: [{
      label: 'apples',
      data: JSON.parse("[" + httpGet("https://gruppe6.torutec.eu/stations/PrintDetails.php?type=yearChartChart&station=" + station_id) + "]"),
      backgroundColor: "rgba(153,51,255,0.4)"
    }]
  }
  
});
