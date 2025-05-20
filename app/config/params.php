<?php

return [
    'adminEmail' => 'admin@example.com',

    'mailSignUp' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Dear {fullname},</p>
                                        <p style="margin-bottom:2px; color:#7E8299">We need to make sure that this is you and not misused by unauthorized parties.</p>
                                        <p style="margin-bottom:2px; color:#7E8299">This is your Verification Code :</p>
                                        <h1 style="margin-bottom:2px; color:#7E8299">{token}</h1>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/site/" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Login</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'mailForgotPassword' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Dear User,</p>
                                        <p style="margin-bottom:2px; color:#7E8299">We need to make sure that this is you and not misused by unauthorized parties.</p>
                                        <p style="margin-bottom:2px; color:#7E8299">This is your Password Reset Token :</p>
                                        <h1 style="margin-bottom:2px; color:#7E8299">{token}</h1>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/site/" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Change Password</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'mailFeedback' => '
        <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hi {fullname}, Selamat ya!,</p>
                                        <p style="margin-bottom:2px; color:#7E8299">Kakak telah menyelesaikan semua proses rekrutmen ISH dan dinyatakan diterima bekerja. Mohon kesediaan Kakak untuk mengisi umpan balik terlampir dan waktu pengisian cukup +/- 3 menit.</p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan di klik link berikut :</p>
                                    </div>
                                    <a href="https://bit.ly/survey-rekrutISH" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link Survey</a>
                                    <div style="font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:9px; color:#181C32; font-size: 18px; font-weight:600">Masukan Kakak sangat membantu kami untuk senantiasa memberikan pelayanan terbaik.</p>
                                    </div>
                                    <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#5E6278">Salam,</p>
                                        <p style="margin-bottom:2px; color:#181C32; font-size: 15px; font-weight:600">PT Infomedia Solusi Humanika (ISH)</p>
                                        <p style="margin-bottom:2px; color:#5E6278">HR Recruitment</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'mailFailedHiring' => '
        <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Hi {fullname}, Selamat ya!,</p>
                                        <p style="margin-bottom:2px; color:#7E8299">Kami Tim Rekrutmen PT Infomedia Solusi Humanika (ISH) mengucapkan terima kasih atas lamaran yang kamu pilih dan setelah kami review mohon maaf anda dinyatakan <b>BELUM SESUAI KUALIFIKASI YANG KAMI BUTUHKAN</b> untuk {jabatan} dengan Informasi detail sebagai berikut:</p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan di klik link berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nama</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{fullname}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">No Jo</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{nojo}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{layanan}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{area}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Skill layanan</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{skill_layanan}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Payroll Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{payroll_area}</td>
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
                                            </table>
                                        </p>
                                    </div>
                                    <a href="https://bit.ly/survey-rekrutISH" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link Survey</a>
                                    <div style="font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:9px; color:#181C32; font-size: 18px; font-weight:600">Masukan Kakak sangat membantu kami untuk senantiasa memberikan pelayanan terbaik.</p>
                                    </div>
                                    <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#5E6278">Salam,</p>
                                        <p style="margin-bottom:2px; color:#181C32; font-size: 15px; font-weight:600">PT Infomedia Solusi Humanika (ISH)</p>
                                        <p style="margin-bottom:2px; color:#5E6278">HR Recruitment</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'approvalHiring' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Anda mendapatkan permintaan Approval Hiring untuk :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nama</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{fullname}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">No Jo</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{nojo}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{layanan}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{area}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Skill layanan</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{skill_layanan}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Payroll Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{payroll_area}</td>
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
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan klik link berikut untuk melakukan verifikasi lebih lanjut:</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/hiring" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'notificationJoDone' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Permintaan Recruitment sudah terpenuhi untuk rincian sebagai berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">No Jo</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{nojo}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{personal_area}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{area}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Skill layanan</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{skill_layanan}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Payroll Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{payroll_area}</td>
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
                                            </table>
                                        </p>
                                        <div style="background: #F9F9F9; border-radius: 12px; padding:20px 15px; margin-bottom: 10px;">
                                            <p style="margin-bottom:2px; color:#181C32;">Berikut Daftar Pekerjanya:<br>{list_worker}</p>
                                        </div>
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'approvalData' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Anda mendapatkan permintaan Approval Perubahan Data dari
                                        <span style="text-transform: uppercase;">
                                            <b>{creator}</b>
                                        </span>
                                        dengan rincian sebagai berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nama</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{fullname}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Perner</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{perner}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area/ Nama Project</td>
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
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan klik link berikut untuk melakukan verifikasi lebih lanjut:</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/chagerequestdata" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'approvalDataBank' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Anda mendapatkan permintaan Approval Perubahan Data Bank dari
                                        <span style="text-transform: uppercase;">
                                            <b>{creator}</b>
                                        </span>
                                        dengan rincian sebagai berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nama</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{fullname}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Perner</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{perner}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area/ Nama Project</td>
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
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan klik link berikut untuk melakukan verifikasi lebih lanjut:</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/chagerequestdatabank" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'approvalDataBank2' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Anda mendapatkan permintaan Approval Perubahan Data Bank dari
                                        <span style="text-transform: uppercase;">
                                            <b>{creator}</b>
                                        </span>
                                        dengan rincian sebagai berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nama</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{fullname}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Perner</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{perner}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area/ Nama Project</td>
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
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan klik link berikut untuk melakukan verifikasi lebih lanjut:</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/chagerequestdatabank" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'approvalResign' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Anda mendapatkan permintaan Approval "Resign Pekerja" dari
                                        <span style="text-transform: uppercase;">
                                            <b>{creator}</b>
                                        </span>
                                        dengan rincian sebagai berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nama</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{fullname}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Perner</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{perner}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area/ Nama Project</td>
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
                                                <td valign="top">Alasan Resign</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{reason}</td>
                                                </tr>
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan klik link berikut untuk melakukan verifikasi lebih lanjut:</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/chagerequestresign" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'approvalHoldJob' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Anda mendapatkan permintaan Approval "Hold Joborder" dengan rincian sebagai berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nojo</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{nojo}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area/ Nama Project</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{client}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{area}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Jabatan</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{job}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Due Date JO Sebelumnya</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{scheme_date_old}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Start Hold JO</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{scheme_date_start}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">End Hold JO</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{scheme_date_end}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Alasan Stop</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{reason}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Keterangan</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{remarks}</td>
                                                </tr>
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan klik link berikut untuk melakukan verifikasi lebih lanjut:</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/request-hold-job" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'notificationReOpenJob' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Berikut adalah informasi Re Open terkait "Hold Joborder" dengan rincian :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nojo</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{nojo}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area/ Nama Project</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{client}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Area</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{area}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Jabatan</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{job}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Due Date JO Sebelumnya</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{scheme_date_old}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Due Date JO Revisi</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{scheme_date_end}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Alasan Stop</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{reason}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Keterangan</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{remarks}</td>
                                                </tr>
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan klik link berikut untuk melakukan verifikasi lebih lanjut:</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/request-hold-job" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'approvalStopJo' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Anda mendapatkan permintaan Approval "STOP JO" dengan rincian sebagai berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nojo</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{nojo}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area/ Nama Project</td>
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
                                                <td valign="top">Jumlah Kebutuhan Sebelumnya</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{old_jumlah}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Jumlah Stop Pemenuhan Pekerja</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{jumlah}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Alasan Stop</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{reason}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Keterangan</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{remarks}</td>
                                                </tr>
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan klik link berikut untuk melakukan verifikasi lebih lanjut:</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/chagerequestjo" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'approvalCancelJoin' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Anda mendapatkan permintaan Approval "Cancel Join Pekerja" dari
                                        <span style="text-transform: uppercase;">
                                            <b>{creator}</b>
                                        </span>
                                        dengan rincian sebagai berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nama</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{fullname}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Perner</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{perner}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area/ Nama Project</td>
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
                                                <td valign="top">Alasan Cancel Join</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{reason}</td>
                                                </tr>
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan klik link berikut untuk melakukan verifikasi lebih lanjut:</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/changecanceljoin" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'confirmationCancelJoin' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="text-align:start;margin-bottom:9px; color:#181C32; font-size: 14px; font-weight:600">Semangat Pagi,<br>
                                        Anda mendapatkan permintaan "Cancel Join Pekerja" dan Hapus Perner dari
                                        <span style="text-transform: uppercase;">
                                            <b>{creator}</b>
                                        </span>
                                        dengan rincian sebagai berikut :</p>
                                        <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                            <table style="text-align:start;">
                                                <tr>
                                                <td valign="top">Nama</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{fullname}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Perner</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{perner}</td>
                                                </tr>
                                                <tr>
                                                <td valign="top">Personal Area/ Nama Project</td>
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
                                                <td valign="top">Alasan Cancel Join</td>
                                                <td valign="top">:</td>
                                                <td valign="top">{reason}</td>
                                                </tr>
                                            </table>
                                        </p>
                                        <p style="margin-bottom:2px; color:#7E8299">Silahkan di klik link berikut Sub Menu Cancel Join untuk melakukan (confirmation) dan menghapus perner di SAP, untuk melakukan verifikasi lebih lanjut :</p>
                                    </div>
                                    <a href="https://gojobs.id/rekrut/changecanceljoin" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Link</a>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <p style="margin-bottom:2px; color:#7E8299">Thanks, Have a Great Day!</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'notificationApplyJob' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                            <p style="margin-bottom:9px; color:#181C32; font-size: 18px; font-weight:600">Hallo Kakak {fullname},</p>
                                            <p style="margin-bottom:2px; color:#5E6278">Kami Tim Rekrutmen PT Infomedia Solusi Humanika (ISH) mengucapkan terima kasih atas lamaran yang kamu pilih, pengisian data diri dan dokumen Profiling Tahap 1 telah kami terima dengan Informasi detail sebagai berikut:</p>
                                        </div>
                                        <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                            <p style="margin-bottom:2px; color:#5E6278">Nama Lengkap:
                                            <span style="color:#50cd89; font-weight: 600"> {fullname}</span>
                                            <p style="margin-bottom:2px; color:#5E6278">Layanan:
                                            <span style="color:#50cd89; font-weight: 600"> {layanan}</span>
                                            <p style="margin-bottom:2px; color:#5E6278">Jabatan:
                                            <span style="color:#50cd89; font-weight: 600"> {jabatan}</span>
                                            <p style="margin-bottom:2px; color:#5E6278">Status:
                                            <span style="color:#50cd89; font-weight: 600"> Lamaran Telah diterima Profiling Tahap 1</span>
                                        </div>

                                        <div style="background: #F9F9F9; border-radius: 12px; padding:20px 15px;">
                                            <p style="margin-bottom:2px; color:#7E8299">Data kamu sedang kami review dan mohon menunggu untuk kami informasikan proses selanjutnya. Terima Kasih.</p>
                                        </div>
                                        <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif; margin-top: 20px;">
                                            <p style="margin-bottom:2px; color:#5E6278">Salam,</p>
                                            <p style="margin-bottom:0px; color:#181C32; font-size: 14px; font-weight:600">PT Infomedia Solusi Humanika (ISH)</p>
                                            <p style="margin-bottom:2px; color:#5E6278">HR Recruitment</p>
                                            <p style="font-size: 10px; text-align:start; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">Kami memastikan data anda hanya digunakan untuk kepentingan proses rekrutasi (penerimaan karyawan) di Perusahaan kami dan seluruh tahapan seleksi tidak ada pungutan biaya seperserpun.</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'recruitmentProcessOnline' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                            <p style="margin-bottom:2px; color:#5E6278">Nomor Undangan:
                                            <span style="color:#50cd89; font-weight: 600"> {invitation_number}</span>
                                            <p style="margin-bottom:9px; color:#181C32; font-size: 18px; font-weight:600">Hallo Kakak {fullname},</p>
                                            <p style="margin-bottom:2px; color:#5E6278">PT Infomedia Solusi Humanika (ISH) mengucapkan selamat kepada anda yang telah lulus seleksi dokumen untuk posisi pekerjaan posisi "{jabatan}", dan lokasi kerja di "{area}"</p>
                                        </div>
                                        <p style="text-align:start; color:#181C32; font-size: 15px; font-weight: 600; margin-bottom:13px">Selanjutnya anda diminta untuk mengerjakan psikotest online dengan panduan sebagi berikut:</p>
                                        <div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px; margin-bottom:8px">
                                            <ol style="text-align:start; font-size: 13px; font-weight: 500; font-family:Arial,Helvetica,sans-serif; color:#5E6278;" type="1">
                                                <li>Psikotes online dikerjakan menggunakan ponsel pintar, pastikan jaringan akses internet bagus dan paket data tersedia</li>
                                                <li>Waktu pengerjaan psikotes adalah 30 menit sehingga pastikan anda bebas dari gangguan selama mengerjakan psikotes</li>
                                                <li>Untuk memulai psikotes online, silahkan klik http://app.hipotest.com</li>
                                                <li>Selanjutnya anda diminta untuk melakukan Registrasi & Login sesuai dengan ketentuan pada website tersebut</li>
                                                <li>Untuk memulai Tes, masukkan kode token: <span style="color:#15c; font-weight: 600"> {token}</span></li>
                                                <li>Anda diminta untuk mengerjakan seluruh rangkaian psikotes.</li>
                                            </ol> 
                                        </div>
                                        <div style="background: #F9F9F9; border-radius: 12px; padding:20px 15px; margin-bottom: 10px;">
                                            <p style="margin-bottom:2px; color:#7E8299">Perhatian: Pengerjaan psikotes ini WAJIB DISELESAIKAN sebelum (H+2 dari Tanggal Pengajuan) dan pukul 24.00. Selamat Mengerjakan..</p>
                                        </div>
                                        <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif; margin-top: 20px;">
                                            <p style="margin-bottom:2px; color:#5E6278">Salam,</p>
                                            <p style="margin-bottom:0px; color:#181C32; font-size: 14px; font-weight:600">PT Infomedia Solusi Humanika (ISH)</p>
                                            <p style="margin-bottom:2px; color:#5E6278">HR Recruitment</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'recruitmentProcessOffline' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                            <p style="margin-bottom:2px; color:#5E6278">Nomor Undangan:
                                            <span style="color:#50cd89; font-weight: 600"> {invitation_number}</span>
                                            <p style="margin-bottom:9px; color:#181C32; font-size: 18px; font-weight:600">Hallo Kakak {fullname},</p>
                                            <p style="margin-bottom:2px; color:#5E6278">PT Infomedia Solusi Humanika (ISH) mengundang anda untuk {invitation_for} pekerjaan posisi "{jabatan}", pada:</p>
                                            <p style="text-align:start;margin-bottom:2px; color:#7E8299">
                                                <table style="text-align:start;">
                                                    <tr>
                                                    <td valign="top">Hari</td>
                                                    <td valign="top">:</td>
                                                    <td valign="top">{date}</td>
                                                    </tr>
                                                    <tr>
                                                    <td valign="top">Pukul</td>
                                                    <td valign="top">:</td>
                                                    <td valign="top">{time}</td>
                                                    </tr>
                                                    <tr>
                                                    <td valign="top">Bertemu</td>
                                                    <td valign="top">:</td>
                                                    <td valign="top">{pic}</td>
                                                    </tr>
                                                    <tr>
                                                    <td valign="top">Alamat</td>
                                                    <td valign="top">:</td>
                                                    <td valign="top">{address}</td>
                                                    </tr>
                                                    <tr>
                                                    <td valign="top">Ruangan</td>
                                                    <td valign="top">:</td>
                                                    <td valign="top">{room}</td>
                                                    </tr>
                                                    <tr>
                                                    <td valign="top">Lantai</td>
                                                    <td valign="top">:</td>
                                                    <td valign="top">{floor}</td>
                                                    </tr>
                                                </table>
                                            </p>
                                        </div>
                                        <div style="background: #F9F9F9; border-radius: 12px; padding:20px 15px; margin-bottom: 10px; text-align:start;">
                                            <ol style="text-align:start; font-size: 13px; font-weight: 500; font-family:Arial,Helvetica,sans-serif; color:#5E6278;" type="1">
                                                <li>Note: Dgn Menggunakan Pakaian Formal Rapih ( No Jeans ) dan Membawa CV dan Lamaran Kerja Lengkapnya.</li>
                                                <li>Konfirmasi dengan sms ke no: {pic_number}<br> {pic_data}</li>
                                            </ol>
                                        </div>
                                        <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif; margin-top: 20px;">
                                            <p style="margin-bottom:2px; color:#5E6278">Salam,</p>
                                            <p style="margin-bottom:0px; color:#181C32; font-size: 14px; font-weight:600">PT Infomedia Solusi Humanika (ISH)</p>
                                            <p style="margin-bottom:2px; color:#5E6278">HR Recruitment</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',

    'recruitmentUserInterview' => '
    <div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
        <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
        <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:40px 20px; width:100%;">
            <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 650px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                <div style="text-align:center; margin:0 60px 34px 60px">
                                    <div style="margin-bottom: 10px">
                                        <a href="https://ish.co.id" rel="noopener" target="_blank">
                                            <img alt="ISH" src="https://gojobs.id/rekrut/images/logo-ish-new.png" style="height: 35px" />
                                        </a>
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <img alt="Gojobs" src="https://gojobs.id/rekrut/images/logo-gojobs-color.png" style="height: 50px" />
                                    </div>
                                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                        <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                            <p style="margin-bottom:9px; color:#181C32; font-size: 18px; font-weight:600">Hallo Kakak {fullname},</p>
                                            <p style="margin-bottom:2px; color:#5E6278">PT Infomedia Solusi Humanika (ISH) ingin menginformasikan bahwa anda lolos tahap seleksi Interview dan Psikotest untuk posisi "{jabatan}".</p>
                                        </div>
                                        <div style="background: #F9F9F9; border-radius: 12px; padding:20px 15px; margin-bottom: 10px;">
                                            <p style="margin-bottom:2px; color:#7E8299">Sebelumnya mohon untuk melengkapi data {data} pada sistem kami dengan melakukan login pada http://gojobs.id/</p>
                                        </div>
                                        <div style="text-align:start; font-size: 13px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif; margin-top: 20px;">
                                            <p style="margin-bottom:2px; color:#5E6278">Salam,</p>
                                            <p style="margin-bottom:0px; color:#181C32; font-size: 14px; font-weight:600">PT Infomedia Solusi Humanika (ISH)</p>
                                            <p style="margin-bottom:2px; color:#5E6278">HR Recruitment</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
                                <p>&copy; Copyright Infomedia Solusi Humanika.
                                <a href="https://ish.co.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>&nbsp;</p>
                                <p style="font-size: 10px; padding:0 15px; text-align:center; font-weight: 300; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">--You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ',


    // for change hiring
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
        <td valign="top">{oldrecruitreqid}</td>
    </tr>
    <tr>    
        <td valign="top">Nama Project</td>
        <td valign="top">:</td>
        <td valign="top">{layanan}</td>
    </tr>
    <tr>    
        <td valign="top">Skill Layanan</td>
        <td valign="top">:</td>
        <td valign="top">{skill}</td>
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
    </table>
    <br>Diubah Menjadi<br>
    <table>
    <tr>    
        <td valign="top">Nomor JO</td>
        <td valign="top">:</td>
        <td valign="top">{recruitreqid}</td>
    </tr>
    <tr>    
        <td valign="top">Nama Project</td>
        <td valign="top">:</td>
        <td valign="top">{newlayanan}</td>
    </tr>
    <tr>    
        <td valign="top">Skill Layanan</td>
        <td valign="top">:</td>
        <td valign="top">{newskill}</td>
    </tr>
    <tr>    
        <td valign="top">Area</td>
        <td valign="top">:</td>
        <td valign="top">{newarea}</td>
    </tr>
    <tr>    
        <td valign="top">Jabatan</td>
        <td valign="top">:</td>
        <td valign="top">{newjabatan}</td>
    </tr>
    <br>
    <tr>    
        <td valign="top">Alasan</td>
        <td valign="top">:</td>
        <td valign="top">{reason}</td>
    </tr>
    </table>

    Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> Change Request sub menu Change Hiring untuk melakukan verifikasi lebih lanjut.
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
        <td valign="top">{oldrecruitreqid}</td>
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
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{level}</td>
    </tr>
    </table>
    <br>Diubah Menjadi<br>
    <table>
    <tr>    
        <td valign="top">Nama Pekerja</td>
        <td valign="top">:</td>
        <td valign="top">{newfullname}</td>
    </tr>
    <tr>    
        <td valign="top">Perner</td>
        <td valign="top">:</td>
        <td valign="top">{newperner}</td>
    </tr>
    <tr>    
        <td valign="top">Nomor JO</td>
        <td valign="top">:</td>
        <td valign="top">{recruitreqid}</td>
    </tr>
    <tr>    
        <td valign="top">Nama Project</td>
        <td valign="top">:</td>
        <td valign="top">{newlayanan}</td>
    </tr>
    <tr>    
        <td valign="top">Area</td>
        <td valign="top">:</td>
        <td valign="top">{newarea}</td>
    </tr>
    <tr>    
        <td valign="top">Jabatan</td>
        <td valign="top">:</td>
        <td valign="top">{newjabatan}</td>
    </tr>
    <tr>    
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{newlevel}</td>
    </tr>
    <br>
    <tr>    
        <td valign="top">Alasan</td>
        <td valign="top">:</td>
        <td valign="top">{reason}</td>
    </tr>
    </table>

    Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> sub menu Change Hiring untuk melakukan verifikasi lebih lanjut.
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
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{level}</td>
    </tr>
    <tr>    
        <td valign="top">Periode Kontrak</td>
        <td valign="top">:</td>
        <td valign="top">{contractperiode}</td>
    </tr>
    <tr>    
        <td valign="top">Tanggal Hiring</td>
        <td valign="top">:</td>
        <td valign="top">{hiringdate}</td>
    </tr>    
    </table>
    <br>Diubah Menjadi<br>
    <table>
    <tr>    
        <td valign="top">Tanggal Hiring (Pergantian)</td>
        <td valign="top">:</td>
        <td valign="top">{newhiringdate}</td>
    </tr>
    <br>
    <tr>    
        <td valign="top">Alasan</td>
        <td valign="top">:</td>
        <td valign="top">{reason}</td>
    </tr>
    </table>

    Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> sub menu Change Hiring untuk melakukan verifikasi lebih lanjut.
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
        <td valign="top">Level</td>
        <td valign="top">:</td>
        <td valign="top">{level}</td>
    </tr>
    <tr>    
    <td valign="top">Periode Kontrak</td>
    <td valign="top">:</td>
    <td valign="top">{oldawalkontrak} - {oldakhirkontrak}</td>
    </tr>
    </table>
    <br>Diubah Menjadi<br>
    <table>
    <tr>    
        <td valign="top">Periode Kontrak (Pergantian)</td>
        <td valign="top">:</td>
        <td valign="top">{awalkontrak} - {akhirkontrak}</td>
    </tr>
    <br>
    <tr>    
        <td valign="top">Alasan</td>
        <td valign="top">:</td>
        <td valign="top">{reason}</td>
    </tr>
    </table>

    Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> sub menu Change Hiring untuk melakukan verifikasi lebih lanjut.
    Have a great day !
    ',
];
