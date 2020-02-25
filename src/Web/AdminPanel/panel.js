// Default image
function imgError(it){
	// console.log(it);
	it.src = '/media/img/user.jpg';
}
function logoError(it){
	// console.log(it);
	it.src = '/media/img/logo.png';
}
function SetProductImage(it){
	let f = it.files[0];
	console.log(f);
	let el = document.getElementById('product-image');
	el.src = URL.createObjectURL(f);
}
function imgErrorProduct(it){
	// console.log(it);
	it.src = '/media/img/food.png';
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
function OpenOrderSearch(it){
	// let id = it.dataset.id;
	let el = document.getElementById('box-fixed').style.display = 'inherit';
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
	let onaddon = document.getElementById('edit-cat-addon')

	console.log("Category id " , catid.value);

	let host = window.location.hostname;
	console.log("Host: ", host);

	// Fetch here
	let url = 'http://' + host + '/src/Web/AdminPanel/Api/get-category.php?category=' + catid.value;

	ApiGet(url).then((data) => {

		console.log(data);

		name.value = data.name;
		slug.value = data.slug;
		visible.value = data.visible;
		onaddon.value = data.on_addon;
	});
}

// GET request
async function ApiGet(url = 'http://jsonplaceholder.typicode.com/users'){
	let response = await fetch(url)
	.catch((error) => {
		console.error('Error get:', error);
	});
	console.log(response);
	return await response.json();
}

// POST request
async function ApiPost(url = 'https://jsonplaceholder.typicode.com/posts/1', form_id = "form"){
	// Get form data, files
	const formData = new FormData(document.getElementById(form_id));
	// Send data
	let response = await fetch(url, {
		method: 'POST',
		body: formData
	})
	.catch((error) => {
		console.error('Error post formData:', error);
	});

	return await response.json();
}