<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('lang.account has not been activated') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading">{{ trans('lang.notification') }}</h4>
            <p>{{ trans('lang.active.header') }}.</p>
            <hr>
            <div class="d-flex align-items-center justify-content-center">
                <p class="mb-0">{{ trans('lang.active.content') }}</p>
                <form action="{{ route('company.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Đăng xuất</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
