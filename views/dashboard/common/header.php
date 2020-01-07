<html>
    <head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="/css/floating-labels.css"> -->
        <link rel="stylesheet" href="/css/dashboard.css">
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Country <Applet></Applet></a>
            <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                <a class="nav-link" href="/auth/logout">Sign out</a>
                </li>
            </ul>
        </nav>
        <div class="container-fluid">
            <div class="row">           
                <?php include_view('dashboard/common/sidebar.php'); ?>
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">