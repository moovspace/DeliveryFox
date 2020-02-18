function ErrorProductImage(it)
{
	// console.log(it);
	it.src = '/media/img/food.png';
}

function CartUrl(url, divid)
{
	let promise = fetch(url).then((res) => res.text);
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
	CartUrl(url, 'cart');
}