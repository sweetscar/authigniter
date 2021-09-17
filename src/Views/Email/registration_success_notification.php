<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success Notification</title>
    <style>
        table {
            width: 100%;
            padding: 0;
        }

        table td {
            padding: 0;
        }

        .mail-header {
            background-color: brown;
            padding: 50px 15px 50px 15px;
            text-align: center;
        }

        .mail-header h2,
        .mail-header p {
            color: whitesmoke;
        }

        .mail-header div,
        .mail-header small {
            color: whitesmoke;
            margin: 0;
        }

        .mail-body {
            background-color: whitesmoke;
            padding: 30px 15px 30px 15px;
        }

        .mail-footer {
            background-color: lightgray;
            padding: 15px 15px 15px 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>
                <div class="mail-header">
                    <h2>AuthIgniter</h2>
                    <p>Authentication &amp; Authorization Library For CodeIgniter 4</p>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="mail-body">
                    <h3><strong>Hi <?= $user->email ?>,</strong></h3>
                    <h3>Thank you for registering your account</h3>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="mail-footer">
                    <div>Build with love by Rizky Kurniawan</div>
                    <br>
                    <small>www.rizkykurniawan.id</small>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>