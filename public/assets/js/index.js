let cartCountElement = document.querySelector("#cart-count"); // Ambil elemen untuk menampilkan jumlah item di cart

// Inisialisasi Swiper setelah DOM ready
document.addEventListener('DOMContentLoaded', function () { // Event listener saat DOM sudah loaded
    // Inisialisasi Swiper untuk Categories
    if (document.querySelector('.categoriesSwiper')) { // Jika elemen categoriesSwiper ditemukan
        const categoriesSwiper = new Swiper('.categoriesSwiper', { // Inisialisasi Swiper untuk categories slider
            slidesPerView: "auto", // Set jumlah slide yang terlihat otomatis
            spaceBetween: 20, // Set jarak antar slide 20px
            freeMode: true, // Enable free mode untuk smooth scrolling tanpa snap
            freeModeMomentum: true, // Enable momentum untuk smooth scrolling
            freeModeMomentumRatio: 0.5, // Set ratio momentum (0.5 = lebih smooth)
            freeModeSticky: false, // Disable sticky untuk smooth scrolling
            speed: 300, // Set kecepatan transisi menjadi 300ms untuk smooth animation
            touchRatio: 1, // Set touch ratio menjadi 1 untuk responsive touch
            grabCursor: true, // Tampilkan cursor grab saat hover
            resistance: true, // Enable resistance saat scroll di ujung
            resistanceRatio: 0.85, // Set resistance ratio untuk feel yang lebih natural
            mousewheel: { // Enable mousewheel untuk scroll dengan mouse
                enabled: true, // Enable mousewheel
                forceToAxis: true, // Force scroll ke axis horizontal
            },
            keyboard: { // Enable keyboard navigation
                enabled: true, // Enable keyboard
                onlyInViewport: true, // Hanya aktif saat dalam viewport
            },
        });
    }

    // Inisialisasi Swiper untuk Favorites
    if (document.querySelector('.favoritesSwiper')) { // Jika elemen favoritesSwiper ditemukan
        const favoritesSwiper = new Swiper('.favoritesSwiper', { // Inisialisasi Swiper untuk favorites slider
            slidesPerView: "auto", // Set jumlah slide yang terlihat otomatis
            spaceBetween: 20, // Set jarak antar slide 20px
            freeMode: true, // Enable free mode untuk smooth scrolling tanpa snap
            freeModeMomentum: true, // Enable momentum untuk smooth scrolling
            freeModeMomentumRatio: 0.5, // Set ratio momentum (0.5 = lebih smooth)
            freeModeSticky: false, // Disable sticky untuk smooth scrolling
            speed: 300, // Set kecepatan transisi menjadi 300ms untuk smooth animation
            touchRatio: 1, // Set touch ratio menjadi 1 untuk responsive touch
            grabCursor: true, // Tampilkan cursor grab saat hover
            resistance: true, // Enable resistance saat scroll di ujung
            resistanceRatio: 0.85, // Set resistance ratio untuk feel yang lebih natural
            mousewheel: { // Enable mousewheel untuk scroll dengan mouse
                enabled: true, // Enable mousewheel
                forceToAxis: true, // Force scroll ke axis horizontal
            },
            keyboard: { // Enable keyboard navigation
                enabled: true, // Enable keyboard
                onlyInViewport: true, // Hanya aktif saat dalam viewport
            },
        });
    }
});

const addToCart = (id) => { // Fungsi untuk menambahkan item ke cart
    event.preventDefault(); // Prevent default behavior

    const cart = JSON.parse(localStorage.getItem("cart")) || []; // Parse data cart dari localStorage, default empty array jika tidak ada
    const itemIndex = cart.findIndex(item => item.id === id); // Cari index item di cart berdasarkan ID
    if (itemIndex > -1) { // Jika item sudah ada di cart
        cart[itemIndex].qty += 1; // Tambahkan quantity +1
    } else { // Jika item belum ada di cart
        cart.push({ id, qty: 1, notes: "" }); // Tambahkan item baru dengan qty 1 dan notes kosong
    }
    localStorage.setItem("cart", JSON.stringify(cart)); // Simpan cart ke localStorage
    updateDisplay(); // Update tampilan cart count
    updateCartItems(); // Update item-item di cart
}

const removeFromCart = (id) => { // Fungsi untuk menghapus item dari cart
    const cart = JSON.parse(localStorage.getItem("cart")) || []; // Parse data cart dari localStorage
    const newCart = cart.filter(item => item.id !== id); // Filter cart, hapus item dengan ID yang sesuai
    localStorage.setItem("cart", JSON.stringify(newCart)); // Simpan cart baru ke localStorage
    updateDisplay(); // Update tampilan cart count
    updateCartItems(); // Update item-item di cart
}

function increaseQuantity(id) { // Fungsi untuk menambah quantity item
    const cart = JSON.parse(localStorage.getItem("cart")) || []; // Parse data cart dari localStorage
    const itemIndex = cart.findIndex(item => item.id === id); // Cari index item di cart
    if (itemIndex > -1) { // Jika item ditemukan
        cart[itemIndex].qty += 1; // Tambahkan quantity +1
    }
    localStorage.setItem("cart", JSON.stringify(cart)); // Simpan cart ke localStorage

    const qtyElement = document.querySelector(`[data-id="${id}"]#qty`); // Ambil elemen quantity berdasarkan ID
    if (qtyElement) { // Jika elemen ditemukan
        let qty = parseInt(qtyElement.textContent, 10); // Parse quantity dari text
        qtyElement.textContent = qty + 1; // Update quantity di DOM
    }

    calculateTotal(); // Hitung ulang total
}

function decreaseQuantity(id) { // Fungsi untuk mengurangi quantity item
    const cart = JSON.parse(localStorage.getItem("cart")) || []; // Parse data cart dari localStorage
    const itemIndex = cart.findIndex(item => item.id === id); // Cari index item di cart
    if (itemIndex > -1) { // Jika item ditemukan
        if (cart[itemIndex].qty > 1) { // Jika quantity > 1
            cart[itemIndex].qty -= 1; // Kurangi quantity -1
        } else { // Jika quantity = 1
            cart.splice(itemIndex, 1); // Hapus item dari cart
        }
    }
    localStorage.setItem("cart", JSON.stringify(cart)); // Simpan cart ke localStorage

    const qtyElement = document.querySelector(`[data-id="${id}"]#qty`); // Ambil elemen quantity berdasarkan ID
    if (qtyElement) { // Jika elemen ditemukan
        let qty = parseInt(qtyElement.textContent, 10); // Parse quantity dari text
        if (qty > 1) { // Jika quantity > 1
            qtyElement.textContent = qty - 1; // Update quantity di DOM
        } else { // Jika quantity = 1
            qtyElement.closest('.flex.gap-4.flex-col').remove(); // Hapus elemen dari DOM
        }
    }

    calculateTotal(); // Hitung ulang total
}
function deleteItem(element) { // Fungsi untuk menghapus item dari cart
    const cartItem = element.closest('.cart-item'); // Ambil elemen cart-item terdekat
    if (cartItem) { // Jika elemen ditemukan
        const id = cartItem.dataset.id; // Ambil ID dari data attribute
        const cart = JSON.parse(localStorage.getItem("cart")) || []; // Parse data cart dari localStorage
        const itemIndex = cart.findIndex(item => item.id === id); // Cari index item di cart
        if (itemIndex > -1) { // Jika item ditemukan
            cart.splice(itemIndex, 1); // Hapus item dari cart
        }
        localStorage.setItem("cart", JSON.stringify(cart)); // Simpan cart ke localStorage
        cartItem.remove(); // Hapus elemen dari DOM
    }

    calculateTotal(); // Hitung ulang total
}

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

const getCart = () => { // Fungsi untuk mendapatkan data cart
    const cart = JSON.parse(localStorage.getItem("cart")) || []; // Parse data cart dari localStorage, default empty array jika tidak ada
    return cart; // Kembalikan cart
}

const updateDisplay = () => { // Fungsi untuk update tampilan cart count
    const cart = getCart(); // Ambil data cart
    if (cartCountElement) { // Jika elemen cart count ada
        cartCountElement.textContent = cart.reduce((total, item) => total + item.qty, 0); // Hitung total quantity semua item dan update text
    }
}

const updateCartItems = () => { // Fungsi untuk update item-item di cart
    const cart = getCart(); // Ambil data cart

    cart.forEach(item => { // Loop setiap item di cart
        const qtyElement = document.querySelector(`[data-id="${item.id}"]#qty`); // Ambil elemen quantity berdasarkan ID
        const notesElement = document.querySelector(`[data-id="${item.id}"]#notes`); // Ambil elemen notes berdasarkan ID
        if (qtyElement) { // Jika elemen quantity ditemukan
            qtyElement.textContent = item.qty; // Update quantity di DOM
        }
        if (notesElement) { // Jika elemen notes ditemukan
            notesElement.value = item.notes; // Update notes di DOM
        }
    });

    calculateTotal(); // Hitung ulang total
}

document.addEventListener('DOMContentLoaded', () => { // Event listener saat DOM sudah loaded
    updateDisplay(); // Update tampilan cart count
    updateCartItems(); // Update item-item di cart
});

document.querySelectorAll('input[name="notes"]').forEach(element => { // Ambil semua input notes dan loop
    element.addEventListener('input', event => { // Tambahkan event listener input
        const cart = getCart(); // Ambil data cart
        const itemIndex = cart.findIndex(item => item.id === event.target.closest('[data-id]').dataset.id); // Cari index item berdasarkan ID dari elemen terdekat
        if (itemIndex > -1) { // Jika item ditemukan
            cart[itemIndex].notes = event.target.value; // Update notes item dengan value dari input
            localStorage.setItem("cart", JSON.stringify(cart)); // Simpan cart ke localStorage
        }
    });
});

