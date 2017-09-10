if (typeof $ === "function") {
	$(document).ready(function () {
		// Ctrl + Enter 提交评论表单
		$('#comment_form').on('keydown', function (event) {
			if (event.ctrlKey && window.event.keyCode == 13) {
				$('#comment_form #comment_submit').click();
			};
		});

		// 代码可编辑
		var controls = document.getElementsByTagName('pre');
		for (var i = 0; i < controls.length; i++) {
			controls[i].spellcheck = false;
			controls[i].setAttribute("contenteditable", "true")
		};
		var controls = document.getElementsByTagName('code');
		for (var i = 0; i < controls.length; i++) {
			controls[i].spellcheck = false;
			controls[i].setAttribute("contenteditable", "true");
		};

		//控制台彩蛋
		//console.clear();
		console.log("%c", ([
			"background:url('http://www.tamersunion.org/wp-content/uploads/logo_tamersunion_v4_small.png') no-repeat",
			"padding: 25px 130px 30px 130px",
			"line-height: 70px"
		]).join('; '));;
	});
}