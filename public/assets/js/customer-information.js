const selectPayment = (paymentMethod) => { // Fungsi untuk memilih metode pembayaran
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]'); // Ambil semua input payment method
    paymentMethods.forEach((element) => { // Loop setiap payment method
        element.parentElement.style.backgroundColor = "#F1F2F6"; // Set background color default
        element.parentElement.style.color = "#353535"; // Set text color default
        element.checked = false; // Uncheck semua radio button
        if (element.value === paymentMethod) { // Jika value sama dengan paymentMethod yang dipilih
            element.checked = true; // Check radio button
            element.parentElement.style.backgroundColor = "#FF801A"; // Set background color aktif
            element.parentElement.style.color = "#FFFFFF"; // Set text color aktif
        }
    });
};

document.addEventListener('DOMContentLoaded', () => { // Event listener saat DOM sudah loaded
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]'); // Ambil semua input payment method
    paymentMethods.forEach((element) => { // Loop setiap payment method
        element.addEventListener('click', () => { // Tambahkan event listener click
            selectPayment(element.value); // Panggil selectPayment dengan value element
        });
    });
});


document.addEventListener("DOMContentLoaded", function () { // Event listener saat DOM sudah loaded
    // Ambil data cart dari localStorage
    const cartData = JSON.parse(localStorage.getItem("cart")) || []; // Parse data cart dari localStorage, default empty array jika tidak ada

    // Filter produk berdasarkan ID di cartData
    const cartItems = document.querySelectorAll(".cart-item"); // Ambil semua elemen dengan class cart-item
    cartItems.forEach((item) => { // Loop setiap item cart
        const productId = item.dataset.id; // Ambil ID produk dari data attribute

        // Cari produk di cartData
        const cartProduct = cartData.find((cart) => cart.id === productId); // Cari produk di cartData berdasarkan ID

        if (!cartProduct) { // Jika produk tidak ada di cart
            // Jika produk tidak ada di cart, hapus
            item.remove(); // Hapus elemen item dari DOM
        } else { // Jika produk ada di cart
            // Jika ada, update quantity dan notes
            const qtyElement = item.querySelector("#qty"); // Ambil elemen quantity
            const notesInput = item.querySelector("#notes"); // Ambil input notes

            if (qtyElement) qtyElement.textContent = 'x' + cartProduct.qty; // Update quantity dengan prefix 'x' jika elemen ada
            if (notesInput) notesInput.value = cartProduct.notes; // Update notes jika input ada
        }
    });

    // Hitung total setelah elemen yang tidak ada dihapus
    calculateTotal(); // Panggil fungsi calculateTotal
});

function calculateTotal() { // Fungsi untuk menghitung total harga
    const cartItems = document.querySelectorAll(".cart-item"); // Ambil semua elemen cart-item
    let total = 0; // Inisialisasi total dengan 0
    cartItems.forEach(cartItem => { // Loop setiap cart item
        const priceElement = cartItem.querySelector('p[id="price"]'); // Ambil elemen price
        const price = parseInt(priceElement.textContent.replace(/[^0-9]/g, ''), 10); // Parse harga dari text, hapus semua karakter non-numeric
        const qtyElement = cartItem.querySelector('#qty'); // Ambil elemen quantity
        const qty = parseInt(qtyElement.textContent.replace(/[^0-9]/g, ''), 10); // Parse quantity dari text, hapus semua karakter non-numeric
        total += price * qty; // Tambahkan price * qty ke total
    });
    document.getElementById('totalAmount').textContent = `Rp ${total.toLocaleString('id-ID')}`; // Update total amount dengan format Rupiah Indonesia
}

const paymentForm = document.getElementById('Form'); // Ambil form dengan ID Form
const cartData = document.getElementById('cart-data'); // Ambil input hidden dengan ID cart-data

paymentForm.addEventListener('submit', (event) => { // Event listener saat form di-submit
    event.preventDefault(); // Prevent default form submission

    // Validasi table_number
    const tableNumberInput = document.getElementById('table_number'); // Ambil input table_number
    if (tableNumberInput) { // Jika input ditemukan
        const tableNumber = tableNumberInput.value.trim(); // Ambil value dan trim whitespace
        if (!tableNumber) { // Jika kosong
            alert('Please enter a table number'); // Tampilkan alert
            tableNumberInput.focus(); // Focus ke input
            return; // Stop execution
        }
        // Cek apakah value adalah angka
        if (!/^\d+$/.test(tableNumber)) { // Jika bukan angka
            alert('Table number must be a valid number'); // Tampilkan alert
            tableNumberInput.focus(); // Focus ke input
            tableNumberInput.select(); // Select text di input
            return; // Stop execution
        }
        // Cek apakah angka >= 1
        const tableNum = parseInt(tableNumber, 10); // Parse ke integer
        if (isNaN(tableNum) || tableNum < 1) { // Jika bukan angka atau kurang dari 1
            alert('Table number must be at least 1'); // Tampilkan alert
            tableNumberInput.focus(); // Focus ke input
            tableNumberInput.select(); // Select text di input
            return; // Stop execution
        }
        // Set value yang sudah divalidasi kembali ke input
        tableNumberInput.value = tableNum; // Set value dengan integer yang sudah divalidasi
    }

    const cart = JSON.parse(localStorage.getItem("cart")) || []; // Parse data cart dari localStorage
    if (!cart || cart.length === 0) { // Jika cart kosong
        alert('Your cart is empty'); // Tampilkan alert
        return; // Stop execution
    }

    cartData.value = JSON.stringify(cart); // Set value cart-data dengan JSON string dari cart

    paymentForm.submit(); // Submit form

    localStorage.removeItem("cart"); // Hapus cart dari localStorage setelah submit
});
