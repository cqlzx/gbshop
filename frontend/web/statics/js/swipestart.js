var bullets = document.getElementById('position').getElementsByTagName('li');
var banner = Swipe(document.getElementById('mySwipe'), {
	auto: 1000,
	continuous: true,
	disableScroll:false,
	callback: function(pos) {
		var i = bullets.length;
		while (i--) {
		  bullets[i].className = ' ';
		}
		bullets[pos].className = 'cur';
	}
});

var bullets1 = document.getElementById('position1').getElementsByTagName('li');
var banner1 = Swipe(document.getElementById('navSwipe'), {

	continuous: true,
	disableScroll:false,
	callback: function(pos) {
		var i = bullets1.length;
		while (i--) {
		  bullets1[i].className = ' ';
		}
		bullets1[pos].className = 'cur';
	}
});