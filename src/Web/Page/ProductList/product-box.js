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
	var first = 0;

	pr.forEach((p) => {

		console.log("Set product: ", p);

		if(p.error != 1)
		{
			if(p.parent == 0)
			{
				// Add product to #black-hole
				document.getElementById("pr-id").dataset.id = p.id;
				document.getElementById("pr-img").src = '/media/product/' + p.id + '.jpg';
				document.getElementById("pr-name").innerHTML = p.name;
				document.getElementById("pr-desc").innerHTML = p.about;
				document.getElementById("pr-price").innerHTML = p.price;

				// Load attr
				LoadAttributes(p.rf_attr);
				LoadAddons(p.addon_category);

				html = html + '<div class="size-btn size-btn-active" data-id="'+p.id+'"> ' + p.size + ' </div>';

			}else{
				html = html + '<div class="size-btn" data-id="'+p.id+'"> ' + p.size + ' </div>';
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

	var html1 = '<select class="size-btn" id="pr-attr">';
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

	if(pr.length == 0)
	{
		document.getElementById("hide-addon-title").innerHTML = '';
	}

	pr.forEach((p) => {

		let price = p.price;
		if(p.on_sale)
		{
			if(parseFloat(p.price_sale) < parseFloat(p.price))
			{
				price = p.price_sale;
			}
		}

		html1 = html1 + '<div class="addon-btn" data-id="'+p.id+'"> <div class="title">';
		html1 = html1 + '<name>'+p.name+'</name> <price>'+price+'</price> </div>';
		html1 = html1 + '<div class="buttons">';
		html1 = html1 + '<span class="minus" onclick="MinusAddon(this)" data-price="'+price+'"> <i class="fas fa-minus"></i> </span>';
		html1 = html1 + '<span class="quantity">0</span>';
		html1 = html1 + '<span class="plus" onclick="PlusAddon(this)" data-price="'+price+'"> <i class="fas fa-plus"></i> </span>';
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

		var obj = {};
		promise.then((json) => {
			console.log(json);

			SetProductAttr(json);
		});
	}
}

function LoadAddons(id)
{
	const url = 'http://' + document.location.host + '/src/Web/Page/ProductList/get-product-addon.php?id=' + id;

	if(id > 0){
		let promise = fetch(url).then((res) => {
			return res.json();
		});

		var obj = {};
		promise.then((json) => {
			console.log(json);

			SetProductAddons(json);
		});
	}
}

function GetProductPrice()
{
	return document.getElementById("pr-price").innerHTML;
}

function SetProductPrice(price)
{
	document.getElementById("pr-price").innerHTML = price;
}

function PlusAddon(it){
	let n = it.parentNode.childNodes[1];
	let q = parseInt(n.innerHTML);
	var price = parseFloat(it.dataset.price).toFixed(2);
	q++;
	var pr_price = parseFloat(GetProductPrice()).toFixed(2);
	pr_price = parseFloat(pr_price) + parseFloat(price);
	SetProductPrice(parseFloat(pr_price).toFixed(2));
	console.log(q, price);
	n.innerHTML = q;
}

function MinusAddon(it){
	let n = it.parentNode.childNodes[1];
	let q = parseInt(n.innerHTML);
	var price = parseFloat(it.dataset.price).toFixed(2);
	q--;
	if(q < 0){
		q = 0;
	}else{
		let pr_price = GetProductPrice();
		pr_price = parseFloat(pr_price) - parseFloat(price);
		SetProductPrice(parseFloat(pr_price).toFixed(2));
	}
	console.log(q, price);
	n.innerHTML = q;
}