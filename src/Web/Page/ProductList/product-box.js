function AddToCartProduct(it)
{
	let id = it.dataset.id;
	var addons = [];
	let addonJson = '';
	let attr = 0;
	let el = document.getElementById("pr-attr-id");
	if(el != null)
	{
		attr = el.value;
	}

	console.log("Add to cart: ", id, attr);

	let all = document.querySelectorAll(".addon-btn");

	all.forEach((a) => {
		let aid = parseInt(a.dataset.id);
		let quantity = parseInt(a.childNodes[1].childNodes[1].innerHTML);

		if(aid > 0 && quantity > 0)
		{
			addons.push({ id: aid, quantity: quantity });
		}

		addonJson = JSON.stringify(addons);
		console.log("Addons add to cart: ", addonJson);
	});

	// Send to cart
	// ?add_product_id=17&add_product_quantity=1&add_product_attr=0&addons=[{"id":2,"quantity":2},{"id":17,"quantity":1}]

	// Close popup
}

function ShowAddToCart(id)
{
	let el = document.getElementById("black-hole");

	console.log("Cart product: ", id, el);

	// Load product id
	LoadProduct(id);

	// Show all
	el.style.display = 'inherit';
}

function SetProduct(pr)
{
	var html = '';

	pr.forEach((p) => {

		console.log("Set product: ", p);

		if(p.error != 1)
		{
			let price = p.price
			if(p.on_sale > 0)
			{
				if(p.price_sale < p.price)
				{
					price = p.price_sale;
				}
			}

			if(p.parent == 0)
			{
				// Add product to #black-hole
				document.getElementById("pr-id").dataset.id = p.id;
				document.getElementById("pr-img").src = '/media/product/' + p.id + '.jpg';
				document.getElementById("pr-name").innerHTML = p.name;
				document.getElementById("pr-desc").innerHTML = p.about;
				document.getElementById("pr-price").innerHTML = p.price;
				document.getElementById("pr-price").dataset.price = p.price;

				// Load attr
				LoadAttributes(p.rf_attr);
				// Load addons
				LoadAddons(p.addon_category);

				// Default price
				document.getElementById("pr-price").dataset.price = price;
				document.getElementById("product-quantity-count").innerHTML = 1;

				html = html + '<div class="size-btn size-btn-active" onclick="SetProductSize(this)" data-id="'+p.id+'" data-rf_attr="'+p.rf_attr+'" data-addon="'+p.addon_category+'" data-price="' + price + '"> ' + price + ' <curr> PLN </curr> ' + p.size + ' </div>';

			}else{
				html = html + '<div class="size-btn" onclick="SetProductSize(this)" data-id="'+p.id+'" data-rf_attr="'+p.rf_attr+'" data-addon="'+p.addon_category+'" data-price="' + price + '"> ' + price + ' <curr> PLN </curr> ' + p.size + ' </div>';
			}
		}else{
			// Add size variants
			document.getElementById("black-hole").style.display = 'none';
		}
	});

	document.getElementById("pr-size").innerHTML =  html;
}

function SetProductAttr(pr)
{
	console.log("Attr: ", pr);

	var html1 = '<select id="pr-attr-id">';
	pr.forEach((p) => {
		html1 = html1 + '<option value="'+p.id+'">'+p.name+'</option>';
		console.log(p);
	});
	html1 = html1 + '</select>';

	document.getElementById("pr-attr").innerHTML = html1;
}

function SetProductAddons(pr)
{
	console.log("Addon: ", pr);

	var html1 = '';

	pr.forEach((p) => {

		let price = p.price;
		if(p.on_sale)
		{
			if(parseFloat(p.price_sale) < parseFloat(p.price))
			{
				price = p.price_sale;
			}
		}

		html1 = html1 + '<div class="addon-btn" data-id="'+p.id+'" data-price="'+price+'">';
		html1 = html1 + '<div class="title"> <name>'+p.name+'</name> <price>'+price+'</price> </div>';
		html1 = html1 + '<div class="buttons">';
		html1 = html1 + '<span class="minus" onclick="MinusAddon(this)" data-quantity="'+p.addon_quantity+'" data-price="'+price+'"> <i class="fas fa-minus"></i> </span>';
		html1 = html1 + '<span class="quantity">0</span>';
		html1 = html1 + '<span class="plus" onclick="PlusAddon(this)" data-quantity="'+p.addon_quantity+'" data-price="'+price+'"> <i class="fas fa-plus"></i> </span>';
		html1 = html1 + '</div>';
		html1 = html1 + '</div>';
	});

	document.getElementById("pr-addons").innerHTML = html1;
}

// Product with variants
function LoadProduct(id)
{
	const url = 'http://' + document.location.host + '/src/Web/Page/ProductList/get-product.php?id=' + id;

	console.log("Url: ", url);

	let promise = fetch(url).then((res) => {
		return res.json();
	});

	promise.then((json) => {
		console.log(json);

		SetProduct(json);
	});
}

function LoadAttributes(id)
{
	const url = 'http://' + document.location.host + '/src/Web/Page/ProductList/get-product-attr.php?id=' + id;

	if(id > 0){
		let promise = fetch(url).then((res) => {
			return res.json();
		});

		promise.then((json) => {
			console.log(json);

			SetProductAttr(json);
		});
	}else{
		document.getElementById("pr-attr").innerHTML = '';
	}
}

function LoadAddons(id)
{
	const url = 'http://' + document.location.host + '/src/Web/Page/ProductList/get-product-addon.php?id=' + id;

	if(id > 0){
		let promise = fetch(url).then((res) => {
			return res.json();
		});

		promise.then((json) => {
			console.log("Addons load: ", json);

			SetProductAddons(json);
		});
	}
	else
	{
		document.getElementById("pr-addons").innerHTML = '<notify> Produkt bez dodatków. </notify>';
	}
}

function GetProductPrice()
{
	return document.getElementById("pr-price").dataset.price;
}

function SetProductPrice(price)
{
	document.getElementById("pr-price").innerHTML = price;
}

function SetProductId(id)
{
	document.getElementById("pr-id").dataset.id = id;
}

function PlusAddon(it){
	let n = it.parentNode.childNodes[1];
	let q = parseInt(n.innerHTML);
	let qty = parseInt(it.dataset.quantity); // Max addon quantity
	if(q < qty){
		q++;
	}
	if(q < 0)
	{
		q = 0;
	}
	n.innerHTML = q;

	CountProductPrice();
}

function MinusAddon(it){
	let n = it.parentNode.childNodes[1];
	let q = parseInt(n.innerHTML);
	let qty = parseInt(it.dataset.quantity); // Max addon quantity
	q--;
	if(q < 0)
	{
		q = 0;
	}
	n.innerHTML = q;

	CountProductPrice();
}

function SetProductSize(it)
{
	RemoveClass();
	it.classList.add("size-btn-active");

	var id = it.dataset.id;
	var rf_attr = it.dataset.rf_attr;
	var addon_category = it.dataset.addon;
	var price = parseFloat(it.dataset.price).toFixed(2);
	document.getElementById("pr-price").dataset.price = price;
	console.log("Set product: ", id, price, addon_category);
	SetProductPrice(parseFloat(price).toFixed(2));
	SetProductId(id);

	if(addon_category == 0)
	{
		document.getElementById("pr-addons").innerHTML = '<notify> Produkt bez dodatków. </notify>';
	}

	LoadAttributes(rf_attr);
	LoadAddons(addon_category);
}

function RemoveClass(){
	let l =  document.querySelectorAll(".size-btn");
	l.forEach((i) => {
		console.log(i);
		i.classList.remove("size-btn-active");
	});
}

function MinusProduct(it){
	let n = document.getElementById("product-quantity-count");
	let q = parseInt(n.innerHTML);
	console.log(q);
	q--;
	if(q <= 1){
		q = 1;
	}
	n.innerHTML = q;

	CountProductPrice();
}

function PlusProduct(it){
	let n = document.getElementById("product-quantity-count");
	let q = parseInt(n.innerHTML);
	console.log(q);
	q++;
	if(q <= 1){
		q = 1;
	}
	n.innerHTML = q;

	CountProductPrice();
}

function CountProductPrice()
{
	let pr_price = document.getElementById("pr-price").dataset.price;
	let pr_quantity = document.getElementById("product-quantity-count").innerHTML;
	let cost = parseFloat(pr_price) * parseFloat(pr_quantity);

	console.log("Product price: ", pr_price);
	console.log("Product quantity: ", pr_quantity);
	console.log("Product cost: ", parseFloat(cost).toFixed(2));

	let addons =  document.querySelectorAll(".addon-btn");
	addons.forEach((a) => {
		let price = a.dataset.price;
		let qty = a.getElementsByClassName("quantity")[0].innerHTML;

		if(qty != 0)
		{
			let addon_cost = (parseInt(qty) * parseFloat(price)) * pr_quantity;

			console.log("Addon cost::: ", addon_cost);

			cost = parseFloat(cost) + parseFloat(addon_cost);
		}
	});

	console.log("Product cost with addons: ", parseFloat(cost).toFixed(2));

	SetProductPrice(parseFloat(cost).toFixed(2));
}