'use strict';

function validEmail(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}

function PlaceholderUp(it){
	console.log("onload: ", it.value);
	console.log(it.parentNode.childNodes[3].classList.add("placeholder-up"));
}

function PlaceholderUpOnload(it){
	console.log("onload: ", it.value);
	if(it.value.length > 0){
		console.log(it.parentNode.childNodes[3].classList.add("placeholder-up"));
	}
}

function Placeholder(it){
	if(it.value.length == 0){
		console.log(it.parentNode.childNodes[3].classList.remove("placeholder-up"));
	}
}

function IsEmail(it){
	console.log("Changed ", it);
	if(it.value.length >= 1){
		if(validEmail(it.value)){
			it.classList.remove("error-border-color");
			let el = document.getElementById("error-email").innerHTML = '';
		}else{
			it.classList.add("error-border-color");
			let error = it.dataset.error;
			let el = document.getElementById("error-email").innerHTML = '<span class="error-color">' + error + '</span>';
		}
	}
}

function IsPass(it){
	console.log("Changed ", it);
	if(it.value.length >= 6){
		it.classList.remove("error-border-color");
		let el = document.getElementById("error-pass").innerHTML = '';
	}else{
		it.classList.add("error-border-color");
		let error = it.dataset.error;
		let el = document.getElementById("error-pass").innerHTML = '<span class="error-color">' + error + '</span>';
	}
}

function Lang(it){
	console.log("Change lang ", it);
	let lang = it.dataset.lang;
	let loc = window.location.pathname + '?lang='+ lang;
	window.location = loc;
}

function ShowError(err)
{
	let el = document.getElementById("error-form").innerHTML = err;
}

// ShowError('<span style="color: #f00"> Error username!!! </span>');

// When window loaded
window.onload = function () {

	// Test POST email
	let it = document.getElementById('email');
	PlaceholderUpOnload(it);
	IsEmail(it);

	// elem.addEventListener("click", showTagName, true);

	// Get('https://jsonplaceholder.typicode.com/users').then((data) => {
	// 	console.log(data) // JSON data parsed by `response.json()` call
	// })

}

// ['click','ontouchstart'].forEach( evt =>
//     element.addEventListener(evt, dosomething(), false)
// );