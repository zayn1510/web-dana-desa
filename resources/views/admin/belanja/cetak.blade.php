<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fonts.css') }}" media="screen, print" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/print.css') }}" media="screen, print" />
    <title>Laporan Data RAB</title>
</head>
<style>
</style>

<body>
    <table width="100%">
        <tr>
            <td width="10%" align="left"><img src={{ $data->foto }} width="75px" height="75px"></td>
            <td width="100%" align="center">
                <h3>LAPORAN RENCANA ANGGARAN BELANJA<br><br>PEMERINTAHAN DESA KAKUNAWE</h3>
                <h3>Tahun Anggaran {{ $data->tahun_anggaran }}</h3>
            </td>
            <td width="10%" align="right"></td>
        </tr>
    </table>
    <hr>

    <div class="border-laporan">


    </div>
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">Kode Rekening</th>
                <th rowspan="2">Uraian</th>
                <th colspan="3">Output</th>

            </tr>
            <tr>
                <th>Volume</th>
                <th>Satuan</th>
                <th>Anggaran</th>
            </tr>
        </thead>
        <tbody>
            @php
                $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
                $currencycode = 'IDR';
            @endphp
            @foreach ($data->rak as $item)
                @php
                    $sub_bidang = $item['sub_bidang'];
                @endphp
                <tr class="text-center">
                    <td><b>{{ $item['kode_bidang'] }}</b></td>
                    <td><b>{{ $item['bidang'] }}</b></td>
                    <td></td>
                    <td></td>
                    <td>{{ str_replace(',00', '', $formatter->formatCurrency($item['total'], $currencycode)) }}</td>
                </tr>
                @foreach ($sub_bidang as $sb)
                    @php
                        $kegiatans = $sb['kegiatan'];
                    @endphp
                    <tr class="text-center">
                        <td><b>{{ $item['kode_bidang'] }}.{{ $sb['kode_sub_bidang'] }} </b></td>
                        <td><b>{{ $sb['sub_bidang'] }}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach ($kegiatans as $kegiatan)
                        @php
                            $str = explode(' ', $kegiatan['volume']);

                        @endphp
                        <tr class="text-center">
                            <td>{{ $item['kode_bidang'] }}.{{ $sb['kode_sub_bidang'] }}.{{ $kegiatan['kode_kegiatan'] }}
                            </td>
                            <td><b>{{ $kegiatan['kegiatan'] }}</b></td>
                            <td>{{ $str[0] }}</td>
                            <td>{{ $str[1] }}</td>
                            <td>{{ str_replace(',00', '', $formatter->formatCurrency($kegiatan['pagu'], $currencycode)) }}
                            </td>
                        </tr>

                        @foreach ($data->rab as $rab)
                            @if ($rab['id_anggaran'] == $kegiatan['id_anggaran'])
                                <tr class="text-center">
                                    <td><b>{{ $rab['kode_kelompok'] }}</b>
                                    </td>
                                    <td><b>{{ $rab['kelompok'] }}</b></td>
                                    <td colspan="2"></td>
                                    <td></td>
                                </tr>

                                @isset($rab['jenis'])
                                    @foreach ($rab['jenis'] as $jenis)
                                        @isset($jenis['objek'])
                                            <tr class="text-center">
                                                <td>{{ $rab['kode_kelompok'] }}.{{ $jenis['kode_jenis'] }}
                                                </td>
                                                <td>{{ $jenis['jenis'] }}</td>
                                                <td colspan="3"></td>

                                            </tr>
                                            @foreach ($jenis['objek'] as $objek)
                                                @php
                                                    $str = explode(' ', $objek['jumlah']);

                                                @endphp
                                                <tr class="text-center">
                                                    <td>{{ $rab['kode_kelompok'] }}.{{ $jenis['kode_jenis'] }}.{{ $objek['kode_objek'] }}
                                                    </td>
                                                    <td>{{ $objek['objek'] }}</td>
                                                    <td>{{ $str[0] }}</td>
                                                    <td>{{ $str[1] }}</td>
                                                    <td>
                                                        {{ str_replace(',00', '', $formatter->formatCurrency($objek['harga'], $currencycode)) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    @endforeach
                                @endisset
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div class="container">
        <div class="row">
            <div class="kotak-ttd">
                <p>Setujui Oleh</p>
                <p><b>Kepala Desa</b></p>
                <p class="space"></p>
                <p><b>{{ $data->perangkat['nama_kepala_desa'] }}</b></p>
            </div>
        </div>
        <div class="row">
            <div class="kotak-ttd">
                <p>Setujui Oleh</p>
                <p><b>Sekretaris Desa</b></p>
                <p class="space"></p>
                <p><b>{{ $data->perangkat['nama_sekretaris_desa'] }}</b></p>
            </div>

        </div>

        <script>
            window.print();

            window.addEventListener('afterprint', function() {
                // Navigate back to the previous page
                window.history.back();
            });
        </script>

</body>

</html>
