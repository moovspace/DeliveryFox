// Default image
function imgError(it){
	// console.log(it);
	it.src = '/media/img/user.jpg';
}
function logoError(it){
	// console.log(it);
	it.src = '/media/img/logo.png';
}
function Close(it){
	it.parentNode.style.display = "none";
}
function OpenAddAttributes(){
	let el = document.getElementById('box-fixed').style.display = 'inherit';
}
function OpenEditAttributes(){
	let el = document.getElementById('box-fixed-edit').style.display = 'inherit';
}
function OpenEditVariant(it){
	let id = it.dataset.id;
	let el = document.getElementById('box-fixed-edit-variant').style.display = 'inherit';
}