// JavaScript
function ScrollTop(val = 0){
	window.scrollTo({ top: val, behavior: 'smooth' });
}

function ScrollToId(id = "top"){
	var el = document.getElementById(id);
	window.scrollTo({ top: el.offsetTop, behavior: 'smooth' });
}

function Event(id, cb, type = "click") {
	var el = document.getElementById(id);
	el.addEventListener(type, cb, false);
}

async function GetHttp(url = 'https://jsonplaceholder.typicode.com/users'){
	let response = await fetch(url)
	.catch((error) => {
		console.error('Error get:', error);
	});

	return await response.json();
}

async function PostFormData(url = 'https://jsonplaceholder.typicode.com/posts/1', formData){
	let response = await fetch(url, {
		method: 'PUT',
		body: formData
	})
	.catch((error) => {
		console.error('Error post formData:', error);
	});

	return await response.json();
}

async function PostData(url = 'https://jsonplaceholder.typicode.com/posts', data = {}) {
	// Default options are marked with *
	const response = await fetch(url, {
		method: 'POST', // *GET, POST, PUT, DELETE, etc.
		mode: 'cors', // no-cors, *cors, same-origin
		headers: {
		'Content-Type': 'application/json'
		// 'Content-Type': 'application/x-www-form-urlencoded',
		},
		// credentials: 'include', // include, *same-origin, omit
		// cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
		// redirect: 'follow', // manual, *follow, error
		// referrerPolicy: 'no-referrer', // no-referrer, *client
		body: JSON.stringify(data) // body data type must match "Content-Type" header
	}).catch((error) => {
		console.error('Error post formData:', error);
	});

	return await response.json(); // parses JSON response into native JavaScript objects
}

function GetInputFiles(id = "#input")
{
	let el = document.querySelector(id);
	el.addEventListener("change", SendFiles, false);

	function SendFiles(){
		let f = el.files;

		console.log("Files ... " + f);

		for (var i = 0; i < f.length; i++) {
			console.log(f[i]);
			console.log(f[i].name);

			let blob = window.URL.createObjectURL(f[i]);
			console.log(blob);

			// var img = document.createElement("img");
			var img = new Image();
			img.src = blob;
			// Set image size and width
			img.width = 256;
			img.height = 256;

			document.body.appendChild(img);
		}
	}
}

(function (){
	// Javascript here
})();

window.onload = function(){
	/*
	Event("bottom", function (){ alert("Js click event"); ScrollToId("box") }, "click");

	GetInputFiles()

	// GET
	GetHttp('https://jsonplaceholder.typicode.com/users').then((data) => {
		console.log(data) // JSON data parsed by `response.json()` call
	})

	// POST
	PostData('https://jsonplaceholder.typicode.com/posts', { mydata: 42 }).then((data) => {
		console.log(data) // JSON data parsed by `response.json()` call
	})

	// let fd = new FormData($("#form")[0]); // form files
	let fd = new FormData()
	fd.append("title", "Hello world")

	// POST FORM
	PostFormData(url = 'https://jsonplaceholder.typicode.com/posts/1', fd).then((data) => {
		console.log(data)
	})
	*/
}

/* JQUERY HERE */
function ScrollTo(id = "#id"){
	$('html, body').animate({ scrollTop: $(id).offset().top}, 3000);
}

// $(document).ready(function(){
// 	/* jQuery here */
// });

$(function() {
	// jq
	$("body").on("click", "#bottom", function(e){
		alert("jQuery event");
	});
});