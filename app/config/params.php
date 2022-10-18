<?php

return [
    'adminEmail' => 'admin@example.com',
    
    'mailFeedback' => '<table>

    <br>
    Hi Kakak, Selamat ya!
    <br>
    </table>
    <br>
    Kakak telah menyelesaikan semua proses rekrutmen ISH dan dinyatakan diterima bekerja.  
    Mohon kesediaan Kakak untuk mengisi umpan balik terlampir dan waktu pengisian cukup +/- 3 menit.
    <br>
    Silahkan di klik link berikut<br>https://bit.ly/survey-rekrutISH
    <br>
    <br>
    Masukan Kakak sangat membantu kami untuk senantiasa memberikan pelayanan terbaik.
    <br>
    <br>
    Terimakasih atas partisipasinya 
    <br>
    <br>
    Salam,  
    <br>
    <br>
    <b>
    Tim Project Management ISH
    </b>',

    'mailLog' => '<table>

    <br>
    Hi Kaha, Informasi Approve Hiring!
    <br>
    </table>
    <br>
        <tr>
        <td valign="top">Nama</td>
        <td valign="top">:</td>
        <td valign="top">{fullname}</td>
        </tr>
        <tr>
        <td valign="top">Jabatan</td>
        <td valign="top">:</td>
        <td valign="top">{jabatan}</td>
        </tr>
        <tr>
        <td valign="top">Area</td>
        <td valign="top">:</td>
        <td valign="top">{area}</td>
        </tr>
    <br>
    <br>
    <br>
    Terimakasih
    <br>',

    'mailChangerequest' => '<table>

    Semangat Pagi,,
    <br>
    Anda mendapatkan permintaan Approval Perubahan Data Bank dari <span style="text-transform: uppercase;"><b>{fullname}</b></span> dengan rincian sebagai berikut :

    <br>
    <br>
    <table>
    <tr>
    <td valign="top">Nama Pekerja</td>
    <td valign="top">:</td>
    <td valign="top">{fullname}</td>
    </tr>
    <tr>
    <td valign="top">Perner</td>
    <td valign="top">:</td>
    <td valign="top">{perner}</td>
    </tr>
    <tr>
    <td valign="top">Nama Project</td>
    <td valign="top">:</td>
    <td valign="top">{layanan}</td>
    </tr>
    <tr>
    <td valign="top">Area</td>
    <td valign="top">:</td>
    <td valign="top">{area}</td>
    </tr>
    <tr>
    <td valign="top">Jabatan</td>
    <td valign="top">:</td>
    <td valign="top">{jabatan}</td>
    </tr>
    <tr>
    </table>
    <br>
    <br>
    <b>
    Tim Project Management ISH
    </b>',

    'mailChangerequest' => '<table>

    Semangat Pagi,,
    <br>
    Anda mendapatkan permintaan Approval Perubahan Data Bank dari <span style="text-transform: uppercase;"><b>{fullname}</b></span> dengan rincian sebagai berikut :

    <br>
    <br>
    <table>
    <tr>
    <td valign="top">Nama Pekerja</td>
    <td valign="top">:</td>
    <td valign="top">{fullname}</td>
    </tr>
    <tr>
    <td valign="top">Perner</td>
    <td valign="top">:</td>
    <td valign="top">{perner}</td>
    </tr>
    <tr>
    <td valign="top">Nama Project</td>
    <td valign="top">:</td>
    <td valign="top">{layanan}</td>
    </tr>
    <tr>
    <td valign="top">Area</td>
    <td valign="top">:</td>
    <td valign="top">{area}</td>
    </tr>
    <tr>
    <td valign="top">Jabatan</td>
    <td valign="top">:</td>
    <td valign="top">{jabatan}</td>
    </tr>
    <tr>
    </table>
    <br>
    <br>
    Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> untuk melakukan verifikasi lebih lanjut.
    <br><br>
    Have a great day !
    ',

    'mailChangeschema1' =>
    '
    <table>
    Semangat Pagi,
    Anda mendapatkan permintaan "Change Hiring - Perubahan Nomor JO" dari <span style="text-transform: uppercase;"><b>{creator}</b></span> dengan rincian sebagai berikut :
    <br>
    <table>
    <tr>    
        <td valign="top">Nama Pekerja</td>
        <td valign="top">:</td>
        <td valign="top">{fullname}</td>
    </tr>
    <tr>    
        <td valign="top">Perner</td>
        <td valign="top">:</td>
        <td valign="top">{perner}</td>
    </tr>
    <tr>    
        <td valign="top">Nomor JO</td>
        <td valign="top">:</td>
        <td valign="top">{recruitreqid}</td>
    </tr>
    <tr>    
        <td valign="top">Nama Project</td>
        <td valign="top">:</td>
        <td valign="top">{project}</td>
    </tr>
    <tr>    
        <td valign="top">Area</td>
        <td valign="top">:</td>
        <td valign="top">{area}</td>
    </tr>
    <tr>    
        <td valign="top">Jabatan</td>
        <td valign="top">:</td>
        <td valign="top">{jabatan}</td>
    </tr>
    <tr>    
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{level}</td>
    </tr>
    <br>Diubah Menjadi<br>
    <tr>    
        <td valign="top">Nama Pekerja</td>
        <td valign="top">:</td>
        <td valign="top">{fullname}</td>
    </tr>
    <tr>    
        <td valign="top">Perner</td>
        <td valign="top">:</td>
        <td valign="top">{perner}</td>
    </tr>
    <tr>    
        <td valign="top">Nomor JO</td>
        <td valign="top">:</td>
        <td valign="top">{recruitreqid}</td>
    </tr>
    <tr>    
        <td valign="top">Nama Project</td>
        <td valign="top">:</td>
        <td valign="top">{project}</td>
    </tr>
    <tr>    
        <td valign="top">Area</td>
        <td valign="top">:</td>
        <td valign="top">{area}</td>
    </tr>
    <tr>    
        <td valign="top">Jabatan</td>
        <td valign="top">:</td>
        <td valign="top">{jabatan}</td>
    </tr>
    <tr>    
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{level}</td>
    </tr>
    <br>
    <tr>    
        <td valign="top">Alasan</td>
        <td valign="top">:</td>
        <td valign="top">{reason}</td>
    </tr>

    Silakan masuk ke link gojobs.id sub menu Change Hiring untuk melakukan verifikasi lebih lanjut.
    Have a great day !
    ',
    
    'mailChangeschema2' =>
    '
    <table>
    Semangat Pagi,
    Anda mendapatkan permintaan "Change Hiring - Tukar JO" dari <span style="text-transform: uppercase;"><b>{creator}</b></span> dengan rincian sebagai berikut :
    <br>
    <table>
    <tr>    
        <td valign="top">Nama Pekerja</td>
        <td valign="top">:</td>
        <td valign="top">{fullname}</td>
    </tr>
    <tr>    
        <td valign="top">Perner</td>
        <td valign="top">:</td>
        <td valign="top">{perner}</td>
    </tr>
    <tr>    
        <td valign="top">Nomor JO</td>
        <td valign="top">:</td>
        <td valign="top">{recruitreqid}</td>
    </tr>
    <tr>    
        <td valign="top">Nama Project</td>
        <td valign="top">:</td>
        <td valign="top">{project}</td>
    </tr>
    <tr>    
        <td valign="top">Area</td>
        <td valign="top">:</td>
        <td valign="top">{area}</td>
    </tr>
    <tr>    
        <td valign="top">Jabatan</td>
        <td valign="top">:</td>
        <td valign="top">{jabatan}</td>
    </tr>
    <tr>    
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{level}</td>
    </tr>
    <br>Diubah Menjadi<br>
    <tr>    
        <td valign="top">Nama Pekerja</td>
        <td valign="top">:</td>
        <td valign="top">{fullname}</td>
    </tr>
    <tr>    
        <td valign="top">Perner</td>
        <td valign="top">:</td>
        <td valign="top">{perner}</td>
    </tr>
    <tr>    
        <td valign="top">Nomor JO</td>
        <td valign="top">:</td>
        <td valign="top">{recruitreqid}</td>
    </tr>
    <tr>    
        <td valign="top">Nama Project</td>
        <td valign="top">:</td>
        <td valign="top">{project}</td>
    </tr>
    <tr>    
        <td valign="top">Area</td>
        <td valign="top">:</td>
        <td valign="top">{area}</td>
    </tr>
    <tr>    
        <td valign="top">Jabatan</td>
        <td valign="top">:</td>
        <td valign="top">{jabatan}</td>
    </tr>
    <tr>    
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{level}</td>
    </tr>
    <br>
    <tr>    
        <td valign="top">Alasan</td>
        <td valign="top">:</td>
        <td valign="top">{reason}</td>
    </tr>

    Silakan masuk ke link gojobs.id sub menu Change Hiring untuk melakukan verifikasi lebih lanjut.
    Have a great day !
    ',
    
    'mailChangeschema3' =>
    '
    <table>
    Semangat Pagi,
    Anda mendapatkan permintaan "Change Hiring - Perubahan Tanggal Hiring" dari <span style="text-transform: uppercase;"><b>{creator}</b></span> dengan rincian sebagai berikut :
    <br>
    <table>
    <tr>    
        <td valign="top">Nama Pekerja</td>
        <td valign="top">:</td>
        <td valign="top">{fullname}</td>
    </tr>
    <tr>    
        <td valign="top">Perner</td>
        <td valign="top">:</td>
        <td valign="top">{perner}</td>
    </tr>
    <tr>    
        <td valign="top">Nomor JO</td>
        <td valign="top">:</td>
        <td valign="top">{recruitreqid}</td>
    </tr>
    <tr>    
        <td valign="top">Nama Project</td>
        <td valign="top">:</td>
        <td valign="top">{project}</td>
    </tr>
    <tr>    
        <td valign="top">Area</td>
        <td valign="top">:</td>
        <td valign="top">{area}</td>
    </tr>
    <tr>    
        <td valign="top">Jabatan</td>
        <td valign="top">:</td>
        <td valign="top">{jabatan}</td>
    </tr>
    <tr>    
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{level}</td>
    </tr>
    <tr>    
        <td valign="top">Tanggal Hiring</td>
        <td valign="top">:</td>
        <td valign="top">{hiringdate}</td>
    </tr>
    <tr>    
        <td valign="top">Tanggal Hiring (Pergantian)</td>
        <td valign="top">:</td>
        <td valign="top">{newhiringdate}</td>
    </tr>
    <tr>    
        <td valign="top">Periode Kontrak</td>
        <td valign="top">:</td>
        <td valign="top">{contractperiode}</td>
    </tr>

    <br>
    <tr>    
        <td valign="top">Alasan</td>
        <td valign="top">:</td>
        <td valign="top">{reason}</td>
    </tr>

    Silakan masuk ke link gojobs.id sub menu Change Hiring untuk melakukan verifikasi lebih lanjut.
    Have a great day !
    ',
    
    'mailChangeschema4' =>
    '
    <table>
    Semangat Pagi,
    Anda mendapatkan permintaan "Change Hiring - Perubahan Periode Kontrak" dari <span style="text-transform: uppercase;"><b>{creator}</b></span> dengan rincian sebagai berikut :
    <br>
    <table>
    <tr>    
        <td valign="top">Nama Pekerja</td>
        <td valign="top">:</td>
        <td valign="top">{fullname}</td>
    </tr>
    <tr>    
        <td valign="top">Perner</td>
        <td valign="top">:</td>
        <td valign="top">{perner}</td>
    </tr>
    <tr>    
        <td valign="top">Nomor JO</td>
        <td valign="top">:</td>
        <td valign="top">{recruitreqid}</td>
    </tr>
    <tr>    
        <td valign="top">Nama Project</td>
        <td valign="top">:</td>
        <td valign="top">{project}</td>
    </tr>
    <tr>    
        <td valign="top">Area</td>
        <td valign="top">:</td>
        <td valign="top">{area}</td>
    </tr>
    <tr>    
        <td valign="top">Jabatan</td>
        <td valign="top">:</td>
        <td valign="top">{jabatan}</td>
    </tr>
    <tr>    
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{level}</td>
    </tr>
    <tr>    
        <td valign="top">Tanggal Hiring</td>
        <td valign="top">:</td>
        <td valign="top">{hiringdate}</td>
    </tr>
    <tr>    
    <td valign="top">Periode Kontrak</td>
    <td valign="top">:</td>
    <td valign="top">{contractperiode}</td>
    </tr>
    <tr>    
        <td valign="top">Periode Kontrak (Pergantian)</td>
        <td valign="top">:</td>
        <td valign="top">{newcontractperiode}</td>
    </tr>

    <br>
    <tr>    
        <td valign="top">Alasan</td>
        <td valign="top">:</td>
        <td valign="top">{reason}</td>
    </tr>

    Silakan masuk ke link gojobs.id sub menu Change Hiring untuk melakukan verifikasi lebih lanjut.
    Have a great day !
    ',
];
