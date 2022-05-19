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
    Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> untuk melakukan verifikasi lebih lanjut.
    <br><br>
    Have a great day !
    ',
];
