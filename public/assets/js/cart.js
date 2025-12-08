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

            if (qtyElement) qtyElement.textContent = cartProduct.qty; // Update quantity jika elemen ada
            if (notesInput) notesInput.value = cartProduct.notes; // Update notes jika input ada
        }
    });

    // Hitung total setelah elemen yang tidak ada dihapus
    calculateTotal(); // Panggil fungsi calculateTotal
});

function calculateTotal() { // Fungsi untuk menghitung total harga
    const prices = document.querySelectorAll('p[id="price"]'); // Ambil semua elemen price
    let total = 0; // Inisialisasi total dengan 0
    prices.forEach(priceElement => { // Loop setiap price element
        const price = parseInt(priceElement.textContent.replace(/[^0-9]/g, ''), 10); // Parse harga dari text, hapus semua karakter non-numeric
        const qty = parseInt(priceElement.closest('.flex').querySelector('#qty').textContent, 10); // Ambil quantity dari elemen terdekat dengan class flex
        total += price * qty; // Tambahkan price * qty ke total
    });
    document.getElementById('totalAmount').textContent = `Rp ${total.toLocaleString('id-ID')}`; // Update total amount dengan format Rupiah Indonesia
}

