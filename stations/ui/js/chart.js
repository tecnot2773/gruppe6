var ctx = document.getElementById('myChart').getContext('2d');

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

var myChart = new Chart(ctx, {
  type: 'line',
  options: option,
  data: {
    labels: ['Mon', 'Die', 'Mit', 'Don', 'Fre', 'Sam', 'Son'],
    datasets: [{
      label: 'apples',
      data: [12, 19, 3, 17, 6, 3, 7],
      backgroundColor: "rgba(153,255,51,0.4)"
    }]
  }
  
});
