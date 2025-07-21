<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                /* Ensures colors are rendered in print */
                print-color-adjust: exact;
                /* Ensures colors are rendered in print */
            }

            table th,
            table td {
                border: 1px solid black !important;
                /* Ensures table borders appear in print */
            }
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif; margin: auto; padding: 0;" onload="window.print()">

    <div
        style="padding: 30px 15px; background-color: #1F1B2D; background-image: url('{{ asset('web/images/pdf_images/hero-bg 2 (1).svg') }}'); background-size: cover; background-position: center;">
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
            <div style="padding-left: 50px; color: white;">
                <img src="{{ asset('web/images/pdf_images/logo.svg') }}" style="height: 100px; width: 200px;"
                    alt="Logo">
                <h4 style="margin: 0; padding: 0;">Invoice #</h4>
                <p style="margin: 0; padding: 0;">{{ $invoiceData['invoice_number'] }}</p>
                <h4 style="margin: 0; padding: 0; margin-top: 20px;">Date:</h4>
                <p style="margin: 0; padding: 0;">{{ $invoiceData['date'] }}</p>
            </div>
            <div style="padding-left: 50px; padding-right: 70px; color: white;">
                <h1 style="color: #FD5631;">INVOICE</h1>
                <h4 style="margin: 0; padding: 0;">Invoice to:</h4>
                <p style="margin: 0; padding: 0;">{{ $invoiceData['customer_name'] }}</p>
                <h4 style="margin: 20px 0 0 0; padding: 0;">Invoice from:</h4>
                <p style="margin: 0; padding: 0;">{{ $invoiceData['invoice_from'] }}</p>
            </div>
        </div>
    </div>

    <div style="padding: 30px; height: 300px;">
        <table style="width: 100%; border-collapse: collapse; border-bottom: 1px solid black;">
            <thead>
                <tr>
                    <th style="font-size: 16px; color: #FD5631; padding: 10px; text-align: left;">Sr.#</th>
                    <th style="font-size: 16px; color: #FD5631; padding: 10px; text-align: left;">Plan Type</th>
                    <th style="font-size: 16px; color: #FD5631; padding: 10px; text-align: left;">Subscription Date</th>
                    <th style="font-size: 16px; color: #FD5631; padding: 10px; text-align: left;">Status</th>
                    <th style="font-size: 16px; color: #FD5631; padding: 10px; text-align: left;">Amount</th>
                </tr>
            </thead>
            <tbody>

                <tr style="border-top: 1px solid #979797; border-bottom: 1px solid black;">
                    <td style="font-size: 12px; padding: 10px; text-align: left;">1</td>
                    <td style="font-size: 12px; padding: 10px; text-align: left;">{{ $invoiceData['plan'] }}</td>
                    <td style="font-size: 12px; padding: 10px; text-align: left;">{{ $invoiceData['invoice_date'] }}
                    </td>
                    <td style="font-size: 12px; padding: 10px; text-align: left;">{{ $invoiceData['status'] }}</td>
                    <td style="font-size: 12px; padding: 10px; text-align: left;"><strong>
                            {{ $invoiceData['amount'] == 'Free' ? $invoiceData['amount'] : 'PKR ' . $invoiceData['amount'] }}</strong>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div style="padding: 20px;">
        <div style="border-bottom: 2px solid black; padding-bottom: 30px;">
            <h2 style="margin-bottom: 30px;">Thank You For Your Business</h2>
        </div>
    </div>

    <div style="margin: auto; text-align: center; width: 100%;">
        <div
            style="background-image: url('{{ asset('web/images/pdf_images/hero-bg 3.svg') }}'); background-size: cover; padding: 30px 0; width: 90%; margin: 0 auto;">
            <div style="text-align: right;">
                <h2 style="color: #FD5631;">Total Amount</h2>
                <h3 style="color: black;">
                    {{ $invoiceData['amount'] == 'Free' ? $invoiceData['amount'] : 'PKR ' . $invoiceData['amount'] }}
                </h3>
            </div>
        </div>
    </div>

</body>

</html>
