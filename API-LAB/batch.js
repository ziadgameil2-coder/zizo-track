const addBtn = document.getElementById('addProduct');
const sendBtn = document.getElementById('sendBatch');
const productContainer = document.getElementById('productInputs');
const resultDiv = document.getElementById('result');

// إضافة row جديدة
addBtn.addEventListener('click', () => {
    const row = document.createElement('div');
    row.className = 'productRow';
    const newId = productContainer.querySelectorAll('.productRow').length + 1;
    row.innerHTML = `
        <input type="text" class="product_name" placeholder="Product Name">
        <input type="number" class="price" placeholder="Price">
        <input type="hidden" class="id" value="${newId}">
    `;
    productContainer.appendChild(row);
});

// إرسال كل المنتجات
sendBtn.addEventListener('click', () => {
    const products = [];
    const rows = document.querySelectorAll('.productRow');
    rows.forEach(row => {
        const name = row.querySelector('.product_name').value;
        const price = row.querySelector('.price').value;
        const id = row.querySelector('.id').value;
        products.push({ id: id, product_name: name, price: price });
    });

    fetch('batch_session.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(products)
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        resultDiv.innerHTML = '';
        data.forEach(item => {
            const div = document.createElement('div');
            div.innerHTML = `
                <p><strong>ID:</strong> ${item.id}</p>
                <p><strong>Status:</strong> ${item.status}</p>
                <p><strong>Message:</strong> ${item.message}</p>
            `;
            div.style.border = '1px solid white';
            div.style.padding = '5px';
            div.style.margin = '5px 0';
            resultDiv.appendChild(div);
        });
    })
    .catch(err => console.log(err));
});