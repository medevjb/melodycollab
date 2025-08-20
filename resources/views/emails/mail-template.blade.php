<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1), -2px 2px 5px rgba(0, 0, 0, 0.1), 2px -2px 5px rgba(0, 0, 0, 0.1), -2px -2px 5px rgba(0, 0, 0, 0.1);
        }
        p {
            color: #004d40;
        }
        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        .message-box {
            background-color: #f9f9f9;
            padding: 10px 15px;
            border-left: 4px;
            border-radius: 4px;
            color: #555;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Hello Admin,</p>
        <p>You have received a message from a user.</p>
        <hr>
        <p><strong>Name:</strong> {!! $formData['name'] !!}</p>
        <p><strong>Email:</strong> {!! $formData['email'] !!}</p>
        <p><strong>Message:</strong></p>
        <div class="message-box">
            {!! $formData['message'] !!}
        </div>
        <hr>
        {{-- <p class="text-right">Thank you!</p> --}}
    </div>
</body>
</html>
