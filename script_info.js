var checkbox1 = $('#c1');
checkbox1.click(function(){
	
	if (checkbox1.is(':checked')) {
		for(var i=1; i<document.querySelectorAll('.protiv input').length; i++){
			var id = document.querySelectorAll('.protiv input')[i].id;
			document.getElementById(id).disabled = true;
			document.getElementById(id).checked = false
		}
    }
    else {
		for(var i=1; i<document.querySelectorAll('.protiv input').length; i++){
			var id = document.querySelectorAll('.protiv input')[i].id;
			document.getElementById(id).disabled = false;
		}
    }
});

var check1 = $('#i1');
check1.click(function(){
	if (check1.is(':checked')) {
		for(var i=1; i<document.querySelectorAll('.invent input').length; i++){
			var id = document.querySelectorAll('.invent input')[i].id;
			document.getElementById(id).disabled = true;
			document.getElementById(id).checked = false
		}
    }
    else {
		for(var i=1; i<document.querySelectorAll('.invent input').length; i++){
			var id = document.querySelectorAll('.invent input')[i].id;
			document.getElementById(id).disabled = false;
		}
    }
});

var checkb1 = $('#d1');
checkb1.click(function(){
	if (checkb1.is(':checked')) {
		for(var i=1; i<document.querySelectorAll('.disease input').length; i++){
			var id = document.querySelectorAll('.disease input')[i].id;
			document.getElementById(id).disabled = true;
			document.getElementById(id).checked = false
		}
    }
    else {
		for(var i=1; i<document.querySelectorAll('.invent input').length; i++){
			var id = document.querySelectorAll('.invent input')[i].id;
			document.getElementById(id).disabled = false;
		}
    }
});


height.onblur = function() {
    var height = document.getElementById('height').value;
	if(height<1.4 || height>2.5) {
		document.getElementById('height').style.border="1px solid #FF0000";
		document.getElementById('err_h').style.visibility="visible";
		$('#save').hide();
	}
	else{
		document.getElementById('height').style.border="1px solid #C4C4C4";
		document.getElementById('err_h').style.visibility="hidden";
		$('#save').show();
	}
};

weight.onblur = function() {
    var weight = document.getElementById('weight').value;
	if(weight<30 || weight>200) {
		document.getElementById('weight').style.border="1px solid #FF0000";
		document.getElementById('err_w').style.visibility="visible";
		$('#save').hide();
	}
	else{
		document.getElementById('weight').style.border="1px solid #C4C4C4";
		document.getElementById('err_w').style.visibility="hidden";
		$('#save').show();
	}
};
