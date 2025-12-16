



    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1c68da, #1d83ff);
            color: #fff;
        }

        .error-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 50px 40px;
            border-radius: 16px;
            text-align: center;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .error-code {
            font-size: 110px;
            font-weight: 800;
            line-height: 1;
            margin: 0;
        }

        .error-title {
            font-size: 26px;
            margin: 10px 0;
        }

        .error-text {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .btn-home {
            display: inline-block;
            padding: 12px 28px;
            border-radius: 30px;
            background: #ffffff;
            color: #1c68da;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .btn-home:hover {
            background: #f1f1f1;
            transform: translateY(-2px);
        }
    </style>

<main>

    <div class="error-container">
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Oops! Page Not Found</h2>
        <p class="error-text">
            The page you’re looking for might have been removed,<br>
            renamed, or temporarily unavailable.
        </p>

        <a href="<?php echo BASE_URL; ?>" class="btn-home">Go Back Home</a>
    </div>

</main>
