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
function OpenEditCategory(it){
	let el = document.getElementById('box-fixed-edit').style.display = 'inherit';

	// Hidden catid
	let catid = document.getElementById('catid')
	catid.value = it.dataset.id;

	// Select
	let name = document.getElementById('edit-cat-name')
	let slug = document.getElementById('edit-cat-slug')
	let visible = document.getElementById('edit-cat-visible')

	// Fetch here

	// Set name
	name.value = '';
	// Set slug
	slug.value = '';
	// Set select option
	visible.value = 0;
}