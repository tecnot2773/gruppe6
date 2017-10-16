// Animate the element's value from x to y:
$({ someValue: 0 }).animate({ someValue: Math.floor(Math.random() * 3000) }, {
    duration: 3000,
    easing: 'swing', // can be anything
    step: function () { // called on every step
        // Update the element's text with rounded-up value:
		targetValueDaily = $('.countDaily').text()
		$('.countDaily').text("0")
        $('.countDaily').text(commaSeparateNumber(Math.round(targetValueDaily)));
		
		targetValueWeekly = $('.countWeekly').text()
		$('.countWeekly').text("0")
        $('.countWeekly').text(commaSeparateNumber(Math.round(targetValueWeekly)));
		
		targetValueMonthly = $('.countMonthly').text()
		$('.countMonthly').text("0")
        $('.countMonthly').text(commaSeparateNumber(Math.round(targetValueMonthly)));
		
		targetValueYearly = $('.countYearly').text()
		$('.countYearly').text("0")
        $('.countYearly').text(commaSeparateNumber(Math.round(targetValueYearly)));
    }
});

function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }
    return val;
}