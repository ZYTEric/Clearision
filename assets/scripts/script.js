if (typeof $ === "function") {
	$(document).ready(function () {
		// Ctrl + Enter 提交评论表单
		$('#comment_form').on('keydown', function (event) {
			if (event.ctrlKey && window.event.keyCode == 13) {
				$('#comment_form #comment_submit').click();
			}
		});
		
        (function(){
    		// 代码可编辑
    		var controls = document.getElementsByTagName('pre');
    		for (var i = 0; i < controls.length; i++) {
    			controls[i].spellcheck = false;
    			controls[i].setAttribute("contenteditable", "true");
    		}
        })();
		(function(){
    		var controls = document.getElementsByTagName('code');
    		for (var i = 0; i < controls.length; i++) {
    			controls[i].spellcheck = false;
    			controls[i].setAttribute("contenteditable", "true");
    		}
		})();
	});
}

var clrs_setCookie = function(name,value)
{
    var Days = 3;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape(value) + ";path=/;expires=" + exp.toGMTString();
};

function clrs_pagebg(id){
    clrs_setCookie('clrs_opbg_des', id);
    document.body.style.backgroundImage="url('" + resourceUIR + "/wp-content/uploads/background"+id+".jpg')";
}