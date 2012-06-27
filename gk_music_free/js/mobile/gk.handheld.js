function setCookie(c_name, value, expire) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expire);
	document.cookie=c_name+ "=" +escape(value) + ((expire==null) ? "" : ";expires=" + exdate.toUTCString());
}