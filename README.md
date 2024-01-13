# VatanSoft Case



## DB Yapısı Hk.

Mesajları ayrı, mesaj gönderim raporlarını ayrı tabloda tuttum. Çünkü:
Projeye gerçek bir API eklenirse müşterinin atmak istediği mesaj API'a iletildiğinde herhangi bir hata(örn. API'a anlık erişilememesi) olursa 2.kez SMS'in gönderilmesi denenebilir. Bu durumda 2 rapor oluşabilir.
Örn. 1.rapor => başarısız(api cevabı tutulması için message_reports tablosunda api_response sütunu açtım)
2. rapor => başarılı şeklinde olabilir.

Tam tablo yapıları için database/migrations klasörüne bakılabilir.

## DB Kurulum
.env dosyası içinden veritabanı konfigürasyonunu ayarlayın.
Komutu proje dizininde çalıştırın:

    php artisan migrate

## Jobs Dosyası
app/Jobs/MessageSending.php dosyasıdır.
İşleyişi:
Öncelikle müşteri eğer 500+ sms gönderirse, 500. smsten sonrasını sadece db'ye kaydedip api gönderimi olmayacak(status=0) şekilde db'ye kaydetmiştim.
Bu iş dosyası içinde veritabanında statusu 0, yani bekliyor durumundaki smsler öncelik sırasına göre getirilip, sms API'ına gönderimi yapılır.


## Unit Test Örneği

tests/Unit/CheckMessageTest.php dosyasıdır.

## Swagger Dokümanı

http://localhost:8000/api/documentation adresinden erişilebilir. Controller dosyaları içinde yazılmıştır.

![enter image description here](https://i.hizliresim.com/ksfgnpk.jpg)