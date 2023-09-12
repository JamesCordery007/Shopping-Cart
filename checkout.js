document.addEventListener('DOMContentLoaded', () => {
    // Retrieve cart data from localStorage
    const savedCart = JSON.parse(localStorage.getItem('cart'));
    const savedTotalAmount = localStorage.getItem('totalAmount');

    // Update checkout page with cart data
    if (savedCart) {
        savedCart.forEach(item => {
            const li = document.createElement('li');
            li.textContent = `${item.name} - £${item.price}`;
            document.getElementById('checkoutCart').appendChild(li);
        });
    }

    // Update total amount
    if (savedTotalAmount) {
        document.getElementById('checkoutTotalAmount').textContent = savedTotalAmount;
    }
});

function addToOrder() {
    // Gather shipping information
    const name = document.getElementById('name').value;
    const address1 = document.getElementById('address1').value;
    const address2 = document.getElementById('address2').value;
    const town = document.getElementById('town').value;
    const county = document.getElementById('county').value;
    const postcode = document.getElementById('postcode').value;

    // Calculate the total amount from the cart
    const savedTotalAmount = localStorage.getItem('totalAmount');

    if (savedTotalAmount) {
        document.getElementById('checkoutTotalAmount').textContent = savedTotalAmount;
    }

    // Enable the "Buy Now" button
    document.getElementById('buyNowButton').removeAttribute('disabled');
}

function buyNow() {
    // Gather shipping information
    const name = document.getElementById('name').value;
    const address1 = document.getElementById('address1').value;
    const address2 = document.getElementById('address2').value;
    const town = document.getElementById('town').value;
    const county = document.getElementById('county').value;
    const postcode = document.getElementById('postcode').value;

    // Calculate the total amount from the cart
    const savedTotalAmount = localStorage.getItem('totalAmount');

    // Prepare data to send to the PHP script
    const formData = new FormData();
    formData.append('name', name);
    formData.append('address1', address1);
    formData.append('address2', address2);
    formData.append('town', town);
    formData.append('county', county);
    formData.append('postcode', postcode);
    formData.append('totalAmount', savedTotalAmount);

    // Send data to the PHP script using fetch
    fetch('payment.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .then(data => {
            // Handle the response from the PHP script
            console.log(data);
            // Redirect to the URL received from the post request
           // window.location.href = data; // Assuming the URL is returned as a response
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
