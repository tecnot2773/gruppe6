var station_id = document.getElementById('station_id')[0].innerHTML;
alert(station_id);
var weeklyChart = document.getElementById('weeklyChart').getContext('2d');
var monthlyChart = document.getElementById('monthlyChart').getContext('2d');
var option = {
  legend: {
  display: false},
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    yAxes: [{
      stacked: true,
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
      data: [12, 19, 3, 17, 6, 3, 7],
      backgroundColor: "rgba(153,51,255,0.4)"
    }]
  }
  
});
var monthlyChart = new Chart(monthlyChart, {
  type: 'line',
  options: option,
  data: {
    labels: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul'],
    datasets: [{
      label: 'apples',
      data: [12, 19, 3, 17, 6, 3, 7],
      backgroundColor: "rgba(153,51,255,0.4)"
    }]
  }
  
});
