<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Link</title>
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
                    <p><strong>Hi,</strong></p>
                    <p>Thank you for registering on our application. Your account was created successfully, please
                        click the Verify link below to verify your email address. The link is valid for the next
                        30
                        minutes.
                        <br>
                        <br>
                        <a href="<?= $link ?>">
                            <?= $link ?>
                        </a>
                    </p>
                    <p><strong>Note:</strong>
                        <br>
                        Some feature may not available until you verify email address.
                    </p>
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