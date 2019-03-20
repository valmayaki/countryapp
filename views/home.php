<html>
    <head>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <section>
            <div class="content">
                <div class="form-container">
                    <form action="/auth/login" method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"/>
                        </div>
                        <button type="submit">Login</button>
                    </form>
                </div>
            </div>
        </section>
        <script src="/js/app.js"></script>
    </body>
</html>