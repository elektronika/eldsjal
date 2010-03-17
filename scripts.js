window.setInterval("jQuery.get('/json/keepalive/'+Math.random())", 5 * 60 * 1000);

function confirmSubmit(message){
	var agree=confirm(message);
	if (agree)
		return true;
	else
		return false ;
}

function checkPersonnr(nr) {
	this.valid=false;
	if(!nr.match(/^(\d{2})(\d{2})(\d{2})\-(\d{4})$/)) { return false; }
	this.now=new Date(); this.nowFullYear=this.now.getFullYear()+""; this.nowCentury=this.nowFullYear.substring(0,2); this.nowShortYear=this.nowFullYear.substring(2,4);
	this.year=RegExp.$1; this.month=RegExp.$2; this.day=RegExp.$3; this.controldigits=RegExp.$4;
	this.fullYear=(this.year*1<=this.nowShortYear*1)?(this.nowCentury+this.year)*1:((this.nowCentury*1-1)+this.year)*1;
	var months = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
	if(this.fullYear%400==0||this.fullYear%4==0&&this.fullYear%100!=0){ months[1]=29; }
	if(this.month*1<1||this.month*1>12||this.day*1<1||this.day*1>months[this.month*1-1]){ return false; }
	this.alldigits=this.year+this.month+this.day+this.controldigits;
	var nn="";
	for(var n=0;n<this.alldigits.length;n++){ nn+=((((n+1)%2)+1)*this.alldigits.substring(n,n+1)); }
	this.checksum=0;
	for(var n=0;n<nn.length;n++){ this.checksum+=nn.substring(n,n+1)*1; }
	this.valid=(this.checksum%10==0)?true:false;
	this.sex=parseInt(this.controldigits.substring(2,3))%2;
	return this.valid;
}

function ValidateAccountRegister() {
	if (document.register.username.value.length<2){
		alert("Ditt anv&auml;ndarnamn m&aring;ste inneh&aring;lla fler &auml;n 2 tecken.\n\nPr&ouml;va igen!");
		document.register.username.focus();
		return;
	}
	if (document.register.password.value.length<3){
		alert("Ditt l&ouml;senord m&aring;ste inneh&aring;lla fler &auml;n 3 tecken.\n\nPr&ouml;va igen!");
		document.register.password.focus();
		return;
	}
	if (!document.register.toa.checked) {
		alert("Du m&aring;ste godk&auml;nna avtalet om PUL!");
		return;
	}
	if (!document.register.member.checked) {
		alert("Du m&aring;ste godk&auml;nna medlemsskap i f&ouml;reningen eldsj&auml;l!");
		return;
	}
	if (!document.register.cookies.checked) {
		alert("Du m&aring;ste godk&auml;nna att cookies anv&auml;nds!");
		return;
	}
	if (document.register.region.value == 0){
		alert("Du m&aring;ste v&auml;lja region!");
		return;
	}
	document.register.submit();
}

function ValidateInfo() {
	personnr =
	document.forms['register2'].elements['born_year'][document.forms['register2'].elements['born_year'].selectedIndex].value.substr(2) + 
	document.forms['register2'].elements['born_month'][document.forms['register2'].elements['born_month'].selectedIndex].value + 
	document.forms['register2'].elements['born_date'][document.forms['register2'].elements['born_date'].selectedIndex].value +
	"-" +
	document.forms['register2'].elements['fourlast'].value;

	if (!checkPersonnr(personnr)){
		alert("Du m&aring;ste ange ett korrekt personnummer.\n\nPr&ouml;va igen!");
		return false;
	}

	if (document.register2.first_name.value.length<2){
		alert("Du m&aring;ste ange ditt f&ouml;rnamn.\n\nPr&ouml;va igen!");
		document.register2.first_name.focus();
		return false;
	}
	if (document.register2.last_name.value.length<2){
		alert("Du m&aring;ste ange ditt efternamn.\n\nPr&ouml;va igen!");
		document.register2.last_name.focus();
		return false;
	}
	if (document.register2.email.value == ''){
		alert("Du m&aring;ste ange din email\n\Pr&ouml;va igen!");
		document.register2.email.focus();
		return false;
	}
	if (document.register2.howInform.value == ''){
		alert("Du m&aring;ste ange hur du kom i kontakt med Eldsj&auml;l!");
		document.register2.howInform.focus();
		return false;
	}			
	document.register2.submit();
}

function ValidatePresentation() {
	if (document.collect3.presentation.value.length<50){
		alert("En längre presentation än så kan du skriva, försök igen!");
		document.collect3.presentation.focus();
		return false;
	}
	document.collect3.submit();
}

function isNumeric(str,message) {
	if (str != str.replace(/[^\d]*/gi,"")) {
		alert(message);
		document.register2.icq.value = "";
	}
	return;
}