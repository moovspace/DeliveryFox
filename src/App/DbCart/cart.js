function ErrorProductImage(it)
{
	// console.log(it);
	it.src = '/media/img/food.png';
}

function CartUrl(url, divid)
{
	let promise = fetch(url).then((res) => res.text());
	promise.then((txt) => {
		let el = document.getElementById(divid);
		el.innerHTML = txt;
	});
}

function deleteProduct(hash)
{
	let host = document.location.host;
	let url = 'http://' + host + '/src/App/DbCart/cart.php?delete_product=' + hash;
	console.log(hash, host, url);
	CartUrl(url, 'cart-hover');

	loadCartProductsQuantity();
}

function loadCartProducts()
{
	let host = document.location.host;
	let url = 'http://' + host + '/src/App/DbCart/cart.php';
	// console.log(hash, host, url);
	CartUrl(url, 'cart-hover');
}

function loadCartProductsQuantity()
{
	let host = document.location.host;
	let url = 'http://' + host + '/src/App/DbCart/cart-quantity.php';
	// console.log(hash, host, url);
	CartUrl(url, 'cart-product-quantity');
}

function CloseCart(){
	let btn = document.querySelectorAll(".add-to-cart");
	btn.forEach((i) => {
		i.addEventListener('click', (e) => {
			document.getElementById("shopping-cart").style.display = 'none';
		});
	});
}

loadCartProducts();
loadCartProductsQuantity();
CloseCart();