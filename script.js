let cart = [];

let totalAmount = 0.00;

 

function addToCart(productName, price) {

    cart.push({ name: productName, price: price });

    totalAmount += price;

 

    // Update cart summary

    document.getElementById('cartItems').innerHTML = '';

    cart.forEach(item => {

        const li = document.createElement('li');

        li.textContent = `${item.name} - ${item.price}`;

        document.getElementById('cartItems').appendChild(li);

    });

 

    // Update total amount

    document.getElementById('totalAmount').textContent = totalAmount;

}

 

function goToCheckout() {

    localStorage.setItem('cart', JSON.stringify(cart));

    localStorage.setItem('totalAmount', totalAmount);

    window.location.href = 'checkout.html';

}

 