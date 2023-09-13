// Deklarasi variabel jumlahNotifikasi sebelumnya dan idTerakhir
var jumlahNotifikasiSebelumnya = sessionStorage.getItem('jumlahNotifikasiSebelumnya') || 0;
var idTerakhir = sessionStorage.getItem('idTerakhir') || '';
var message = sessionStorage.getItem('message') || '[]';
message = JSON.parse(message);

async function getNotifications() {
  try {
    // Tambahkan query parameter dengan idTerakhir
    // var url = 'https://api.example.com/notifications?id=' + idTerakhir;
    const API_URL = 'http://localhost/php8/rekrutmen-djt/notifications?notifiable_id=';
    var url = API_URL + idTerakhir;
    var response = await fetch(url);
    var notifications = await response.json();
    if(notifications.length > 0)
    {
      var jumlahNotifikasiBaru = notifications.length;
    
      // Tambahkan jumlah notifikasi baru dengan jumlah notifikasi sebelumnya
      var jumlahNotifikasi = jumlahNotifikasiSebelumnya + jumlahNotifikasiBaru;

      notifications.forEach(function(value) {
        message.push(value);
      });
      
      // Dapatkan id terakhir dari array notifikasi
      idTerakhir = notifications[notifications.length - 1].notifiable_id;
      
      // Lakukan sesuatu dengan data notifikasi yang diambil dari API
      console.log('Jumlah notifikasi: ' + jumlahNotifikasi);
      console.log('ID terakhir: ' + idTerakhir);
      
      // Update variabel jumlahNotifikasiSebelumnya dengan jumlah notifikasi saat ini
      jumlahNotifikasiSebelumnya = jumlahNotifikasi;
  
      sessionStorage.setItem('jumlahNotifikasiSebelumnya', jumlahNotifikasiSebelumnya);
      sessionStorage.setItem('idTerakhir', idTerakhir);
      var messageString = JSON.stringify(message);
      sessionStorage.setItem('message', messageString);

      // $('.badge-notif').text(jumlahNotifikasiSebelumnya);
    }
    $('.badge-notif').text(jumlahNotifikasiSebelumnya);
  } catch (error) {
    // Tangani kesalahan yang terjadi saat mengambil data dari API
    console.log(error);
  }
}

