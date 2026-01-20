document.addEventListener('DOMContentLoaded', () => {
    
    // Fungsi untuk menangani pengiriman formulir
    const handleFormSubmission = (formId, messageId, serviceName) => {
        const form = document.getElementById(formId);
        const messageElement = document.getElementById(messageId);

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Sembunyikan pesan sebelumnya
            messageElement.style.visibility = 'hidden';
            messageElement.classList.remove('success', 'error');

            const formData = new FormData(form);
            const nomorHP = formData.get('nomor');
            let nominalAtauPaket = formData.get('nominal') || formData.get('paket');

            // Validasi sederhana: pastikan nomor HP terisi
            if (!nomorHP || !nominalAtauPaket) {
                showMessage(messageElement, `⚠️ Mohon lengkapi semua data untuk ${serviceName}.`, 'error');
                return;
            }

            // Simulasi proses transaksi
            messageElement.innerHTML = `⏳ Memproses transaksi ${serviceName} ke nomor **${nomorHP}**...`;
            messageElement.style.visibility = 'visible';
            messageElement.classList.add('info');


            setTimeout(() => {
                // Simulasi sukses/gagal (misalnya: jika nomor diakhiri 00, dianggap gagal)
                if (nomorHP.endsWith('00')) {
                    showMessage(messageElement, `❌ Transaksi ${serviceName} ${nominalAtauPaket} ke nomor ${nomorHP} **Gagal**. Saldo tidak mencukupi.`, 'error');
                } else {
                    showMessage(messageElement, `✅ Transaksi ${serviceName} **${nominalAtauPaket}** ke nomor **${nomorHP}** berhasil!`, 'success');
                    form.reset(); // Kosongkan formulir setelah sukses
                }
            }, 2000); // Tunda 2 detik untuk simulasi loading
        });
    };

    // Fungsi untuk menampilkan pesan
    const showMessage = (element, text, type) => {
        element.innerHTML = text;
        element.style.visibility = 'visible';
        
        // Atur warna pesan berdasarkan tipe
        if (type === 'success') {
            element.style.backgroundColor = '#d4edda'; // Hijau muda
            element.style.color = '#155724'; // Hijau tua
        } else if (type === 'error') {
            element.style.backgroundColor = '#f8d7da'; // Merah muda
            element.style.color = '#721c24'; // Merah tua
        } else if (type === 'info') {
            element.style.backgroundColor = '#cce5ff'; // Biru muda
            element.style.color = '#004085'; // Biru tua
        }
    };

    // Terapkan fungsi ke formulir Pulsa
    handleFormSubmission('pulsa-form', 'pulsa-message', 'Pulsa');

    // Terapkan fungsi ke formulir Data
    handleFormSubmission('data-form', 'data-message', 'Paket Data');
});
